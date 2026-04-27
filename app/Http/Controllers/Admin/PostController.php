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
        $payload = $this->persistedData($data);
        $payload['slug'] = $this->makeUniqueSlug($payload['title']);
        $payload['published_at'] = $this->resolvePublishedAt($payload['status'], $data['published_at'] ?? null);
        $payload['user_id'] = $request->user()->id;

        Post::create($payload);

        return redirect()->route('admin.posts.index')->with('status', __('Publicación creada correctamente.'));
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
        $payload = $this->persistedData($data);
        $payload['slug'] = $post->getRawOriginal('title') === $data['title_es']
            ? $post->slug
            : $this->makeUniqueSlug($payload['title'], $post->id);
        $payload['published_at'] = $this->resolvePublishedAt($payload['status'], $data['published_at'] ?? null);

        $post->update($payload);

        return redirect()->route('admin.posts.index')->with('status', __('Publicación actualizada.'));
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->with('status', __('Publicación eliminada.'));
    }

    private function validatedData(Request $request, ?Post $post = null): array
    {
        return $request->validate([
            'title_es' => ['required', 'string', 'max:160'],
            'title_en' => ['required', 'string', 'max:160'],
            'excerpt_es' => ['required', 'string', 'max:320'],
            'excerpt_en' => ['required', 'string', 'max:320'],
            'content_es' => ['required', 'string', 'min:40'],
            'content_en' => ['required', 'string', 'min:40'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'published_at' => ['nullable', 'date'],
        ]);
    }

    private function persistedData(array $data): array
    {
        return [
            'title' => $data['title_es'],
            'excerpt' => $data['excerpt_es'],
            'content' => $data['content_es'],
            'status' => $data['status'],
            'translations' => [
                'es' => [
                    'title' => $data['title_es'],
                    'excerpt' => $data['excerpt_es'],
                    'content' => $data['content_es'],
                ],
                'en' => [
                    'title' => $data['title_en'],
                    'excerpt' => $data['excerpt_en'],
                    'content' => $data['content_en'],
                ],
            ],
        ];
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