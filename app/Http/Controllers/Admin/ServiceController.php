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
        $payload = $this->persistedData($data);
        $payload['slug'] = $this->makeUniqueSlug($payload['title']);

        Service::create($payload);

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
        $payload = $this->persistedData($data);
        $payload['slug'] = $service->getRawOriginal('title') === $data['title_es']
            ? $service->slug
            : $this->makeUniqueSlug($payload['title'], $service->id);

        $service->update($payload);

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
            'title_es' => ['required', 'string', 'max:160'],
            'title_en' => ['required', 'string', 'max:160'],
            'excerpt_es' => ['required', 'string', 'max:320'],
            'excerpt_en' => ['required', 'string', 'max:320'],
            'description_es' => ['required', 'string', 'min:40'],
            'description_en' => ['required', 'string', 'min:40'],
            'deliverables_es' => ['required', 'string'],
            'deliverables_en' => ['required', 'string'],
            'details_es' => ['required', 'string'],
            'details_en' => ['required', 'string'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
        ]);
    }

    private function persistedData(array $data): array
    {
        $deliverablesEs = $this->linesToArray($data['deliverables_es']);
        $deliverablesEn = $this->linesToArray($data['deliverables_en']);
        $detailsEs = $this->linesToArray($data['details_es']);
        $detailsEn = $this->linesToArray($data['details_en']);

        return [
            'title' => $data['title_es'],
            'excerpt' => $data['excerpt_es'],
            'description' => $data['description_es'],
            'deliverables' => $deliverablesEs,
            'details' => $detailsEs,
            'status' => $data['status'],
            'sort_order' => $data['sort_order'],
            'translations' => [
                'es' => [
                    'title' => $data['title_es'],
                    'excerpt' => $data['excerpt_es'],
                    'description' => $data['description_es'],
                    'deliverables' => $deliverablesEs,
                    'details' => $detailsEs,
                ],
                'en' => [
                    'title' => $data['title_en'],
                    'excerpt' => $data['excerpt_en'],
                    'description' => $data['description_en'],
                    'deliverables' => $deliverablesEn,
                    'details' => $detailsEn,
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