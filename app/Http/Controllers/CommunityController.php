<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CommunityController extends Controller
{
    public function index(): View
    {
        $posts = Post::query()
            ->with(['author', 'category', 'tags'])
            ->withCount(['comments', 'reactions'])
            ->where('status', 'published')
            ->where(function ($query): void {
                $query->whereNull('published_at')->orWhere('published_at', '<=', now());
            })
            ->latest('published_at')
            ->latest()
            ->paginate(12);

        return view('community.index', compact('posts'));
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
            $tag = Tag::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
            $post->tags()->syncWithoutDetaching([$tag->id]);
        }

        return redirect()->route('posts.show', $post)->with('status', 'Gönderin yayımlandı.');
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
