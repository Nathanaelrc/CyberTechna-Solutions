<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Post;
use App\Models\Service;
use App\Services\CyberNewsService;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(CyberNewsService $newsService): View
    {
        $content = $this->siteNarrative();
        $news = $newsService->getLatestNews(3);

        return view('pages.home', [
            'metrics' => $content['metrics'],
            'serviceHighlights' => $this->publishedServices(4),
            'methodSteps' => array_slice($content['methodSteps'], 0, 3),
            'coursesCatalog' => $this->publishedCourses(3),
            'latestPosts' => $this->latestPosts(),
            'cyberNews' => $news,
        ]);
    }

    public function services(): View
    {
        $content = $this->siteNarrative();

        return view('pages.services', [
            'services' => $this->publishedServices(),
            'auditBenefits' => $content['auditBenefits'],
            'pentestScopes' => $content['pentestScopes'],
        ]);
    }

    public function service(Service $service): View
    {
        abort_if($service->status !== 'published' && ! request()->user()?->is_admin, 404);

        return view('pages.service', [
            'service' => $service,
            'relatedServices' => Service::query()
                ->where('status', 'published')
                ->whereKeyNot($service->id)
                ->orderBy('sort_order')
                ->take(3)
                ->get(),
        ]);
    }

    public function method(): View
    {
        $content = $this->siteNarrative();

        return view('pages.method', [
            'methodSteps' => $content['methodSteps'],
            'methodPrinciples' => $content['methodPrinciples'],
            'methodArtifacts' => $content['methodArtifacts'],
        ]);
    }

    public function courses(): View
    {
        $content = $this->siteNarrative();

        return view('pages.courses', [
            'courses' => $this->publishedCourses(),
            'courseFormats' => $content['courseFormats'],
        ]);
    }

    public function course(Course $course): View
    {
        abort_if($course->status !== 'published' && ! request()->user()?->is_admin, 404);

        return view('pages.course', [
            'course' => $course,
            'relatedCourses' => Course::query()
                ->where('status', 'published')
                ->whereKeyNot($course->id)
                ->orderBy('sort_order')
                ->take(3)
                ->get(),
        ]);
    }

    public function contact(): View
    {
        $content = $this->siteNarrative();

        return view('pages.contact', [
            'serviceHighlights' => $this->publishedServices(),
            'contactReasons' => $content['contactReasons'],
        ]);
    }

    public function show(Post $post): View
    {
        abort_if($post->status !== 'published' && ! request()->user()?->is_admin, 404);

        return view('pages.post', [
            'post' => $post,
        ]);
    }

    private function latestPosts()
    {
        return Post::query()
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->take(3)
            ->get();
    }

    private function publishedServices(?int $limit = null)
    {
        return Service::query()
            ->where('status', 'published')
            ->orderBy('sort_order')
            ->when($limit !== null, fn ($query) => $query->limit($limit))
            ->get();
    }

    private function publishedCourses(?int $limit = null)
    {
        return Course::query()
            ->where('status', 'published')
            ->orderBy('sort_order')
            ->when($limit !== null, fn ($query) => $query->limit($limit))
            ->get();
    }

    private function siteNarrative(): array
    {
        return [
            'metrics' => [
                ['value' => '72h', 'label' => __('para iniciar auditorías críticas')],
                ['value' => '24/7', 'label' => __('acompañamiento para incidentes prioritarios')],
                ['value' => '1:1', 'label' => __('transferencia técnica con tu equipo')],
            ],
            'auditBenefits' => [
                __('Claridad sobre qué riesgos son reales y cuáles son solo ruido.'),
                __('Priorización ejecutable para que el equipo no se disperse.'),
                __('Evidencia útil tanto para dirección como para tecnología.'),
                __('Transferencia de criterio para que el aprendizaje quede instalado.'),
            ],
            'pentestScopes' => [
                [
                    'title' => __('Aplicaciones web y APIs'),
                    'summary' => __('Validamos fallos de autenticación, autorización, exposición de datos, inyecciones y errores de negocio.'),
                ],
                [
                    'title' => __('Infraestructura interna'),
                    'summary' => __('Analizamos movimiento lateral, privilegios, servicios inseguros y superficies que facilitan escalamiento.'),
                ],
                [
                    'title' => __('Perímetro y activos expuestos'),
                    'summary' => __('Revisamos lo que Internet puede ver y atacar: VPN, portales, correo, subdominios y configuraciones públicas.'),
                ],
            ],
            'methodSteps' => [
                [
                    'title' => __('Descubrimiento y contexto'),
                    'summary' => __('Entendemos activos, prioridades del negocio, amenazas más probables y restricciones del entorno antes de ejecutar.'),
                    'outputs' => [
                        __('Levantamiento de alcance y activos críticos'),
                        __('Mapa inicial de riesgo y dependencias'),
                    ],
                ],
                [
                    'title' => __('Evaluación técnica'),
                    'summary' => __('Auditamos o probamos de forma ofensiva el alcance acordado para convertir observaciones en evidencia concreta.'),
                    'outputs' => [
                        __('Hallazgos técnicos reproducibles'),
                        __('Impacto vinculado a procesos y datos del negocio'),
                    ],
                ],
                [
                    'title' => __('Priorización y plan'),
                    'summary' => __('No dejamos una lista plana de vulnerabilidades: ordenamos por impacto, urgencia y costo de corrección.'),
                    'outputs' => [
                        __('Roadmap por quick wins y acciones estructurales'),
                        __('Resumen ejecutivo y técnico'),
                    ],
                ],
                [
                    'title' => __('Transferencia y seguimiento'),
                    'summary' => __('Acompañamos sesiones de cierre, aclaramos hallazgos y damos contexto para que el equipo ejecute con autonomía.'),
                    'outputs' => [
                        __('Workshop de cierre con equipos clave'),
                        __('Seguimiento opcional y revalidación'),
                    ],
                ],
            ],
            'methodPrinciples' => [
                __('Trabajamos con evidencia primero y opiniones después.'),
                __('Priorizamos por impacto de negocio, no solo por severidad CVSS.'),
                __('Adaptamos el lenguaje para dirección, TI y desarrollo sin perder rigor.'),
                __('Buscamos dejar criterio técnico instalado en el cliente.'),
            ],
            'methodArtifacts' => [
                __('Resumen ejecutivo para decisión y presupuesto'),
                __('Reporte técnico detallado con evidencia'),
                __('Matriz de priorización y plan de remediación'),
                __('Sesión de transferencia con responsables del alcance'),
            ],
            'courseFormats' => [
                [
                    'title' => __('Bootcamps intensivos'),
                    'summary' => __('Jornadas concentradas para acelerar conocimiento en equipos técnicos y no técnicos.'),
                ],
                [
                    'title' => __('Programas por niveles'),
                    'summary' => __('Rutas introductorias, intermedias y avanzadas alineadas al rol del participante.'),
                ],
                [
                    'title' => __('Laboratorios y simulaciones'),
                    'summary' => __('Prácticas guiadas para llevar conceptos a escenarios reales y reforzar criterio operativo.'),
                ],
            ],
            'contactReasons' => [
                __('Quieres una auditoría para entender brechas antes de una certificación, cliente o comité.'),
                __('Necesitas pentesting de una aplicación, API, red interna o activo expuesto.'),
                __('Buscas cursos a medida para equipos técnicos, ejecutivos o usuarios finales.'),
                __('Necesitas acompañamiento continuo para remediación, hardening o incidentes.'),
            ],
        ];
    }
}