<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = Service::query()
            ->orderBy('sort_order')
            ->orderBy('title')
            ->paginate(10);

        return view('admin.services.index', [
            'services' => $services,
        ]);
    }

    public function create(): View
    {
        return view('admin.services.create', [
            'service' => new Service([
                'status' => 'published',
                'sort_order' => 0,
            ]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['slug'] = $this->makeUniqueSlug($data['title']);
        $data['deliverables'] = $this->linesToArray($request->input('deliverables'));
        $data['details'] = $this->linesToArray($request->input('details'));

        Service::create($data);

        return redirect()->route('admin.services.index')->with('status', 'Servicio creado correctamente.');
    }

    public function edit(Service $service): View
    {
        return view('admin.services.edit', [
            'service' => $service,
        ]);
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['slug'] = $service->title === $data['title']
            ? $service->slug
            : $this->makeUniqueSlug($data['title'], $service->id);
        $data['deliverables'] = $this->linesToArray($request->input('deliverables'));
        $data['details'] = $this->linesToArray($request->input('details'));

        $service->update($data);

        return redirect()->route('admin.services.index')->with('status', 'Servicio actualizado.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();

        return redirect()->route('admin.services.index')->with('status', 'Servicio eliminado.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:160'],
            'excerpt' => ['required', 'string', 'max:320'],
            'description' => ['required', 'string', 'min:40'],
            'deliverables' => ['nullable', 'string'],
            'details' => ['nullable', 'string'],
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
        $baseSlug = $baseSlug !== '' ? $baseSlug : 'service';
        $slug = $baseSlug;
        $counter = 2;

        while (Service::query()
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->where('slug', $slug)
            ->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}