<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InteractionController extends Controller
{
    public function comment(Request $request, Post $post): RedirectResponse
    {
        $data = $request->validate(['body' => ['required', 'string', 'min:2', 'max:3000']]);

        $post->comments()->create([
            'user_id' => $request->user()->id,
            'body' => $data['body'],
            'status' => $request->user()->hasRole('admin', 'editor') ? 'visible' : 'pending',
        ]);

        return back()->with('status', $request->user()->hasRole('admin', 'editor')
            ? 'Yorum eklendi.'
            : 'Yorumun moderasyon için gönderildi.');
    }

    public function react(Request $request, Post $post): RedirectResponse
    {
        $data = $request->validate(['reaction' => ['required', 'in:like,love,insightful,celebrate']]);

        $existing = $post->reactions()->where('user_id', $request->user()->id)->first();
        if ($existing && $existing->reaction === $data['reaction']) {
            $existing->delete();
        } else {
            $post->reactions()->updateOrCreate(
                ['user_id' => $request->user()->id],
                ['reaction' => $data['reaction']]
            );
        }

        return back();
    }

    public function bookmark(Request $request, Post $post): RedirectResponse
    {
        $bookmark = $post->bookmarks()->where('user_id', $request->user()->id)->first();
        $bookmark ? $bookmark->delete() : $post->bookmarks()->create(['user_id' => $request->user()->id]);

        return back()->with('status', $bookmark ? 'Yer işareti kaldırıldı.' : 'Gönderi kaydedildi.');
    }

    public function tag(Request $request, Post $post): RedirectResponse
    {
        abort_unless($request->user()->hasRole('admin', 'editor') || $request->user()->id === $post->user_id, 403);

        $data = $request->validate(['tag' => ['required', 'string', 'max:80']]);
        $name = trim($data['tag']);
        $tag = Tag::firstOrCreate(['slug' => Str::slug($name)], ['name' => $name]);
        $post->tags()->syncWithoutDetaching([$tag->id]);

        return back()->with('status', 'Etiket eklendi.');
    }
}
