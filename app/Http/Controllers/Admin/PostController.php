<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::query()
            ->with('author')
            ->latest()
            ->paginate(10);

        return view('admin.posts.index', [
            'posts' => $posts,
        ]);
    }

    public function create(): View
    {
        return view('admin.posts.create', [
            'post' => new Post([
                'status' => 'draft',
            ]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['slug'] = $this->makeUniqueSlug($data['title']);
        $data['published_at'] = $this->resolvePublishedAt($data['status'], $data['published_at'] ?? null);
        $data['user_id'] = $request->user()->id;

        Post::create($data);

        return redirect()->route('admin.posts.index')->with('status', 'Publicacion creada correctamente.');
    }

    public function edit(Post $post): View
    {
        return view('admin.posts.edit', [
            'post' => $post,
        ]);
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $data = $this->validatedData($request, $post);
        $data['slug'] = $post->title === $data['title']
            ? $post->slug
            : $this->makeUniqueSlug($data['title'], $post->id);
        $data['published_at'] = $this->resolvePublishedAt($data['status'], $data['published_at'] ?? null);

        $post->update($data);

        return redirect()->route('admin.posts.index')->with('status', 'Publicacion actualizada.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('status', 'Publicacion eliminada.');
    }

    private function validatedData(Request $request, ?Post $post = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'excerpt' => ['required', 'string', 'max:320'],
            'content' => ['required', 'string', 'min:40'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'published_at' => ['nullable', 'date'],
        ]);
    }

    private function makeUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        $baseSlug = $baseSlug !== '' ? $baseSlug : 'insight';
        $slug = $baseSlug;
        $counter = 2;

        while (Post::query()
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->where('slug', $slug)
            ->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    private function resolvePublishedAt(string $status, mixed $publishedAt): ?Carbon
    {
        if ($status !== 'published') {
            return null;
        }

        return $publishedAt ? Carbon::parse($publishedAt) : now();
    }
}