<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CommunityController extends Controller
{
    public function index(Request $request): View
    {
        $query = Post::query()
            ->with(['author', 'category', 'tags'])
            ->withCount([
                'comments' => fn ($query) => $query->where('status', 'visible'),
                'reactions',
            ])
            ->where('status', 'published')
            ->where(fn ($query) => $query->whereNull('published_at')->orWhere('published_at', '<=', now()));

        if ($request->filled('q')) {
            $term = trim((string) $request->query('q'));
            $query->where(function ($query) use ($term): void {
                $query->where('title', 'like', '%'.$term.'%')
                    ->orWhere('excerpt', 'like', '%'.$term.'%')
                    ->orWhere('body', 'like', '%'.$term.'%')
                    ->orWhereHas('tags', fn ($tags) => $tags->where('name', 'like', '%'.$term.'%'));
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($category) => $category->where('slug', $request->query('category')));
        }

        if ($request->query('sort') === 'popular') {
            $query->orderByDesc('views_count')->latest();
        } else {
            $query->latest('published_at')->latest();
        }

        $posts = $query->paginate(12)->withQueryString();
        $categories = Category::query()->where('is_active', true)->orderBy('sort_order')->orderBy('name')->get();
        $popularTags = Tag::query()->withCount(['posts' => fn ($query) => $query->where('status', 'published')])->orderByDesc('posts_count')->orderBy('name')->take(8)->get();
        $memberCount = User::query()->count();
        $publishedCount = Post::query()->where('status', 'published')->count();

        return view('community.index', compact('posts', 'categories', 'popularTags', 'memberCount', 'publishedCount'));
    }

    public function directory(Request $request): View
    {
        $members = User::query()->withCount(['followers', 'following', 'posts'])
            ->when($request->filled('q'), fn ($query) => $query->where('name', 'like', '%'.trim((string) $request->query('q')).'%'))
            ->latest('id')->paginate(24)->withQueryString();
        return view('community.member-directory', compact('members'));
    }

    public function profile(User $user): View
    {
        $user->loadCount(['followers', 'following']);
        $posts = $user->posts()->with(['author', 'category', 'tags'])
            ->withCount(['comments' => fn ($query) => $query->where('status', 'visible'), 'reactions'])
            ->where('status', 'published')
            ->where(fn ($query) => $query->whereNull('published_at')->orWhere('published_at', '<=', now()))
            ->latest('published_at')->paginate(10);
        $isFollowing = auth()->check() && auth()->id() !== $user->id ? auth()->user()->following()->whereKey($user->id)->exists() : false;
        $followers = $user->followers()->latest('user_follows.created_at')->take(8)->get();
        $following = $user->following()->latest('user_follows.created_at')->take(8)->get();
        return view('community.profile', compact('user', 'posts', 'isFollowing', 'followers', 'following'));
    }

    public function toggleFollow(Request $request, User $user): RedirectResponse
    {
        abort_if($request->user()->is($user), 422, 'Kendini takip edemezsin.');
        $request->user()->following()->toggle($user->id);
        return back()->with('status', $request->user()->following()->whereKey($user->id)->exists() ? $user->name.' takip edilmeye başlandı.' : $user->name.' takipten çıkarıldı.');
    }

    public function show(Post $post): View
    {
        abort_unless($post->status === 'published' || (auth()->check() && (auth()->user()->hasRole('admin', 'editor') || auth()->id() === $post->user_id)), 404);

        $post->increment('views_count');
        $post->load(['author', 'category', 'tags']);
        $comments = $post->comments()->where('status', 'visible')->with('author')->latest()->get();

        return view('community.show', compact('post', 'comments'));
    }

    public function create(): View
    {
        return view('community.create', ['categories' => Category::where('is_active', true)->orderBy('sort_order')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string', 'min:20', 'max:50000'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'tags' => ['nullable', 'string', 'max:300'],
        ]);

        $baseSlug = Str::slug($data['title']) ?: 'gonderi';
        $slug = $baseSlug;
        $suffix = 2;
        while (Post::where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.$suffix++;
        }

        $post = Post::create([
            'user_id' => $request->user()->id,
            'category_id' => $data['category_id'] ?? null,
            'title' => $data['title'],
            'slug' => $slug,
            'excerpt' => $data['excerpt'] ?? null,
            'body' => $data['body'],
            'status' => 'published',
            'published_at' => now(),
        ]);

        $tagNames = collect(explode(',', $data['tags'] ?? ''))
            ->map(fn (string $tag): string => trim($tag))
            ->filter()
            ->unique(fn (string $tag): string => mb_strtolower($tag))
            ->take(8);

        foreach ($tagNames as $name) {
            $tag = Tag::firstOrCreate(['slug' => Str::slug($name)], ['name' => $name]);
            $post->tags()->syncWithoutDetaching([$tag->id]);
        }

        return redirect()->route('posts.show', $post)->with('status', 'Gönderin yayımlandı.');
    }

    public function bookmarks(): View
    {
        $bookmarks = auth()->user()->bookmarks()->with('post.author')->latest()->paginate(20);
        return view('community.bookmarks', compact('bookmarks'));
    }

    public function pendingComments(): View
    {
        abort_unless(auth()->user()->hasRole('admin', 'editor'), 403);
        $comments = Comment::where('status', 'pending')->with(['author', 'post'])->latest()->paginate(30);
        return view('community.pending-comments', compact('comments'));
    }

    public function moderateComment(Request $request, Comment $comment): RedirectResponse
    {
        abort_unless($request->user()->hasRole('admin', 'editor'), 403);
        $data = $request->validate(['status' => ['required', 'in:visible,rejected']]);
        $comment->update(['status' => $data['status']]);

        return back()->with('status', 'Yorum moderasyonu güncellendi.');
    }

    public function members(): View
    {
        abort_unless(auth()->user()->hasRole('admin'), 403);
        return view('community.members', ['members' => User::query()->latest()->paginate(30)]);
    }

    public function updateRole(Request $request, User $user): RedirectResponse
    {
        abort_unless($request->user()->hasRole('admin'), 403);
        abort_if($request->user()->is($user), 422, 'Kendi yönetici rolünü bu ekrandan değiştiremezsin.');

        $data = $request->validate(['role' => ['required', 'in:member,author,editor,admin']]);
        $user->update(['role' => $data['role']]);

        return back()->with('status', 'Üye rolü güncellendi.');
    }
}
