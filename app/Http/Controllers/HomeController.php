<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Post;
use App\Models\Service;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $content = $this->siteNarrative();

        return view('pages.home', [
            'metrics' => $content['metrics'],
            'serviceHighlights' => $this->publishedServices(4),
            'methodSteps' => array_slice($content['methodSteps'], 0, 3),
            'coursesCatalog' => $this->publishedCourses(3),
            'latestPosts' => $this->latestPosts(),
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
                ['value' => '72h', 'label' => 'para iniciar auditorias criticas'],
                ['value' => '24/7', 'label' => 'acompanamiento para incidentes prioritarios'],
                ['value' => '1:1', 'label' => 'transferencia tecnica con tu equipo'],
            ],
            'auditBenefits' => [
                'Claridad sobre que riesgos son reales y cuales son solo ruido.',
                'Priorizacion ejecutable para que el equipo no se disperse.',
                'Evidencia util tanto para direccion como para tecnologia.',
                'Transferencia de criterio para que el aprendizaje quede instalado.',
            ],
            'pentestScopes' => [
                [
                    'title' => 'Aplicaciones web y APIs',
                    'summary' => 'Validamos fallos de autenticacion, autorizacion, exposicion de datos, inyecciones y errores de negocio.',
                ],
                [
                    'title' => 'Infraestructura interna',
                    'summary' => 'Analizamos movimiento lateral, privilegios, servicios inseguros y superficies que facilitan escalamiento.',
                ],
                [
                    'title' => 'Perimetro y activos expuestos',
                    'summary' => 'Revisamos lo que Internet puede ver y atacar: VPN, portales, correo, subdominios y configuraciones publicas.',
                ],
            ],
            'methodSteps' => [
                [
                    'title' => 'Descubrimiento y contexto',
                    'summary' => 'Entendemos activos, prioridades del negocio, amenazas mas probables y restricciones del entorno antes de ejecutar.',
                    'outputs' => [
                        'Levantamiento de alcance y activos criticos',
                        'Mapa inicial de riesgo y dependencias',
                    ],
                ],
                [
                    'title' => 'Evaluacion tecnica',
                    'summary' => 'Auditamos o probamos de forma ofensiva el alcance acordado para convertir observaciones en evidencia concreta.',
                    'outputs' => [
                        'Hallazgos tecnicos reproducibles',
                        'Impacto vinculado a procesos y datos del negocio',
                    ],
                ],
                [
                    'title' => 'Priorizacion y plan',
                    'summary' => 'No dejamos una lista plana de vulnerabilidades: ordenamos por impacto, urgencia y costo de correccion.',
                    'outputs' => [
                        'Roadmap por quick wins y acciones estructurales',
                        'Resumen ejecutivo y tecnico',
                    ],
                ],
                [
                    'title' => 'Transferencia y seguimiento',
                    'summary' => 'Acompanamos sesiones de cierre, aclaramos hallazgos y damos contexto para que el equipo ejecute con autonomia.',
                    'outputs' => [
                        'Workshop de cierre con equipos clave',
                        'Seguimiento opcional y revalidacion',
                    ],
                ],
            ],
            'methodPrinciples' => [
                'Trabajamos con evidencia primero y opiniones despues.',
                'Priorizamos por impacto de negocio, no solo por severidad CVSS.',
                'Adaptamos el lenguaje para direccion, TI y desarrollo sin perder rigor.',
                'Buscamos dejar criterio tecnico instalado en el cliente.',
            ],
            'methodArtifacts' => [
                'Resumen ejecutivo para decision y presupuesto',
                'Reporte tecnico detallado con evidencia',
                'Matriz de priorizacion y plan de remediacion',
                'Sesion de transferencia con responsables del alcance',
            ],
            'courseFormats' => [
                [
                    'title' => 'Bootcamps intensivos',
                    'summary' => 'Jornadas concentradas para acelerar conocimiento en equipos tecnicos y no tecnicos.',
                ],
                [
                    'title' => 'Programas por niveles',
                    'summary' => 'Rutas introductorias, intermedias y avanzadas alineadas al rol del participante.',
                ],
                [
                    'title' => 'Laboratorios y simulaciones',
                    'summary' => 'Practicas guiadas para llevar conceptos a escenarios reales y reforzar criterio operativo.',
                ],
            ],
            'contactReasons' => [
                'Quieres una auditoria para entender brechas antes de una certificacion, cliente o comite.',
                'Necesitas pentesting de una aplicacion, API, red interna o activo expuesto.',
                'Buscas cursos a medida para equipos tecnicos, ejecutivos o usuarios finales.',
                'Necesitas acompanamiento continuo para remediacion, hardening o incidentes.',
            ],
        ];
    }
}