<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    public function index(): View
    {
        $courses = Course::query()
            ->orderBy('sort_order')
            ->orderBy('title')
            ->paginate(10);

        return view('admin.courses.index', [
            'courses' => $courses,
        ]);
    }

    public function create(): View
    {
        return view('admin.courses.create', [
            'course' => new Course([
                'status' => 'published',
                'sort_order' => 0,
            ]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $payload = $this->persistedData($data);
        $payload['slug'] = $this->makeUniqueSlug($payload['title']);

        Course::create($payload);

        return redirect()->route('admin.courses.index')->with('status', 'Curso creado correctamente.');
    }

    public function edit(Course $course): View
    {
        return view('admin.courses.edit', [
            'course' => $course,
        ]);
    }

    public function update(Request $request, Course $course): RedirectResponse
    {
        $data = $this->validatedData($request);
        $payload = $this->persistedData($data);
        $payload['slug'] = $course->getRawOriginal('title') === $data['title_es']
            ? $course->slug
            : $this->makeUniqueSlug($payload['title'], $course->id);

        $course->update($payload);

        return redirect()->route('admin.courses.index')->with('status', 'Curso actualizado.');
    }

    public function destroy(Course $course): RedirectResponse
    {
        $course->delete();

        return redirect()->route('admin.courses.index')->with('status', 'Curso eliminado.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title_es' => ['required', 'string', 'max:160'],
            'title_en' => ['required', 'string', 'max:160'],
            'excerpt_es' => ['required', 'string', 'max:320'],
            'excerpt_en' => ['required', 'string', 'max:320'],
            'description_es' => ['required', 'string', 'min:40'],
            'description_en' => ['required', 'string', 'min:40'],
            'audience_es' => ['required', 'string', 'max:190'],
            'audience_en' => ['required', 'string', 'max:190'],
            'duration_es' => ['required', 'string', 'max:120'],
            'duration_en' => ['required', 'string', 'max:120'],
            'topics_es' => ['required', 'string'],
            'topics_en' => ['required', 'string'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
        ]);
    }

    private function persistedData(array $data): array
    {
        $topicsEs = $this->linesToArray($data['topics_es']);
        $topicsEn = $this->linesToArray($data['topics_en']);

        return [
            'title' => $data['title_es'],
            'excerpt' => $data['excerpt_es'],
            'description' => $data['description_es'],
            'audience' => $data['audience_es'],
            'duration' => $data['duration_es'],
            'topics' => $topicsEs,
            'status' => $data['status'],
            'sort_order' => $data['sort_order'],
            'translations' => [
                'es' => [
                    'title' => $data['title_es'],
                    'excerpt' => $data['excerpt_es'],
                    'description' => $data['description_es'],
                    'audience' => $data['audience_es'],
                    'duration' => $data['duration_es'],
                    'topics' => $topicsEs,
                ],
                'en' => [
                    'title' => $data['title_en'],
                    'excerpt' => $data['excerpt_en'],
                    'description' => $data['description_en'],
                    'audience' => $data['audience_en'],
                    'duration' => $data['duration_en'],
                    'topics' => $topicsEn,
                ],
            ],
        ];
    }

    private function linesToArray(?string $value): array
    {
        return collect(preg_split('/\r\n|\r|\n/', (string) $value))
            ->map(fn ($line) => trim((string) $line))
            ->filter()
            ->values()
            ->all();
    }

    private function makeUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        $baseSlug = $baseSlug !== '' ? $baseSlug : 'course';
        $slug = $baseSlug;
        $counter = 2;

        while (Course::query()
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->where('slug', $slug)
            ->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}