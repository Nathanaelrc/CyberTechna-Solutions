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
        $data['slug'] = $this->makeUniqueSlug($data['title']);
        $data['topics'] = $this->linesToArray($request->input('topics'));

        Course::create($data);

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
        $data['slug'] = $course->title === $data['title']
            ? $course->slug
            : $this->makeUniqueSlug($data['title'], $course->id);
        $data['topics'] = $this->linesToArray($request->input('topics'));

        $course->update($data);

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
            'title' => ['required', 'string', 'max:160'],
            'excerpt' => ['required', 'string', 'max:320'],
            'description' => ['required', 'string', 'min:40'],
            'audience' => ['required', 'string', 'max:190'],
            'duration' => ['required', 'string', 'max:120'],
            'topics' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
        ]);
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