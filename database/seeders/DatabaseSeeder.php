<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate([
            'email' => env('ADMIN_EMAIL', 'admin@cybertechna.local'),
        ], [
            'name' => env('ADMIN_NAME', 'CyberTechna Owner'),
            'password' => env('ADMIN_PASSWORD', 'change-me-please'),
            'is_admin' => true,
        ]);

        foreach ($this->services() as $service) {
            Service::query()->updateOrCreate([
                'slug' => $service['slug'],
            ], $service);
        }

        foreach ($this->courses() as $course) {
            Course::query()->updateOrCreate([
                'slug' => $course['slug'],
            ], $course);
        }
    }

    private function services(): array
    {
        return [
            [
                'title' => 'Auditorias de Ciberseguridad',
                'slug' => 'auditorias-de-ciberseguridad',
                'excerpt' => 'Evaluamos postura, infraestructura, aplicaciones y procesos para explicarte el riesgo con evidencia y priorizacion clara.',
                'description' => 'Realizamos auditorias para transformar una preocupacion difusa en un mapa claro de decisiones. Revisamos controles, configuraciones, procesos y exposicion real para que puedas entender donde esta el riesgo, que impacto tiene y que acciones conviene priorizar primero.',
                'deliverables' => [
                    'Diagnostico tecnico con lectura ejecutiva',
                    'Hallazgos priorizados por impacto y esfuerzo',
                    'Roadmap de mejora con acciones concretas',
                ],
                'details' => [
                    'Auditoria de postura de ciberseguridad y madurez operativa',
                    'Auditoria tecnica de infraestructura, endpoints y nube',
                    'Auditoria de aplicaciones web, APIs y flujos sensibles',
                    'Auditoria de cumplimiento y seguridad de la informacion',
                ],
                'status' => 'published',
                'sort_order' => 1,
            ],
            [
                'title' => 'Pentesting Ofensivo',
                'slug' => 'pentesting-ofensivo',
                'excerpt' => 'Simulamos ataques reales sobre aplicaciones, APIs, redes internas y activos expuestos para validar controles defensivos.',
                'description' => 'El pentesting ayuda a confirmar si una debilidad es realmente explotable. Ejecutamos pruebas controladas sobre el alcance acordado para medir exposicion, confirmar impacto y entregar evidencia util para correccion y revalidacion.',
                'deliverables' => [
                    'Pruebas web, API, red interna y perimetro',
                    'Reporte ejecutivo y tecnico con evidencia reproducible',
                    'Sesion de cierre con validacion de hallazgos criticos',
                ],
                'details' => [
                    'Aplicaciones web y APIs con foco en OWASP y logica de negocio',
                    'Red interna y movimiento lateral para validar privilegios y segmentacion',
                    'Perimetro y activos expuestos para identificar superficies visibles desde Internet',
                ],
                'status' => 'published',
                'sort_order' => 2,
            ],
            [
                'title' => 'Cursos de Ciberseguridad',
                'slug' => 'cursos-de-ciberseguridad',
                'excerpt' => 'Programas formativos para perfiles tecnicos y no tecnicos, orientados a reducir error humano y elevar criterio operativo.',
                'description' => 'Disenamos programas de formacion segun el nivel del participante y el objetivo del cliente. Combinamos explicacion, ejemplos, ejercicios y practicas guiadas para que el aprendizaje no quede en teoria sino en mejores decisiones cotidianas.',
                'deliverables' => [
                    'Rutas introductorias, intermedias y avanzadas',
                    'Bootcamps, talleres y laboratorios guiados',
                    'Capacitacion alineada al rol y al contexto del cliente',
                ],
                'details' => [
                    'Introduccion a la Ciberseguridad',
                    'Fundamentos de Seguridad de la Informacion',
                    'Ethical Hacking y practicas ofensivas controladas',
                    'Secure Coding, OWASP y respuesta a incidentes',
                ],
                'status' => 'published',
                'sort_order' => 3,
            ],
            [
                'title' => 'Acompanamiento Continuo',
                'slug' => 'acompanamiento-continuo',
                'excerpt' => 'Te apoyamos en hardening, revisiones periodicas, seguimiento de remediaciones y mesas de crisis para que seguridad no quede como proyecto aislado.',
                'description' => 'Acompanar es ayudar a sostener el avance. Participamos en revisiones periodicas, priorizacion de remediaciones, hardening, incidentes y sesiones de seguimiento para que el trabajo de seguridad mantenga traccion.',
                'deliverables' => [
                    'Revisiones mensuales de postura de seguridad',
                    'Asesoria para gobierno tecnico y cumplimiento',
                    'Apoyo en incidentes y priorizacion de remediaciones',
                ],
                'details' => [
                    'Seguimiento de hallazgos y plan de remediacion',
                    'Hardening y validacion de configuraciones criticas',
                    'Mesas tecnicas y apoyo durante incidentes prioritarios',
                ],
                'status' => 'published',
                'sort_order' => 4,
            ],
        ];
    }

    private function courses(): array
    {
        return [
            [
                'title' => 'Introduccion a la Ciberseguridad',
                'slug' => 'introduccion-a-la-ciberseguridad',
                'excerpt' => 'Curso base para entender amenazas comunes, higiene digital, roles y responsabilidad compartida.',
                'description' => 'Programa introductorio para participantes que necesitan una base clara sobre amenazas frecuentes, practicas seguras y decisiones basicas frente a incidentes, fraudes o errores cotidianos.',
                'audience' => 'Equipos no tecnicos, nuevos ingresos y lideres de area',
                'duration' => '4 a 6 horas',
                'topics' => [
                    'Panorama de amenazas actuales y vectores frecuentes',
                    'Buenas practicas de acceso, correo y navegacion',
                    'Que hacer ante incidentes, sospechas o fraudes',
                ],
                'status' => 'published',
                'sort_order' => 1,
            ],
            [
                'title' => 'Fundamentos de Seguridad de la Informacion',
                'slug' => 'fundamentos-de-seguridad-de-la-informacion',
                'excerpt' => 'Explica confidencialidad, integridad, disponibilidad, gestion de riesgos y controles basicos aplicables al negocio.',
                'description' => 'Curso pensado para aterrizar los principios de seguridad de la informacion a procesos reales, ayudando a entender activos, riesgos, controles y responsabilidades dentro de la organizacion.',
                'audience' => 'Mandos medios, responsables de procesos y equipos operativos',
                'duration' => '8 horas',
                'topics' => [
                    'Principios de seguridad de la informacion',
                    'Clasificacion de activos y tratamiento del riesgo',
                    'Controles, politicas y responsabilidades',
                ],
                'status' => 'published',
                'sort_order' => 2,
            ],
            [
                'title' => 'Ethical Hacking',
                'slug' => 'ethical-hacking',
                'excerpt' => 'Programa practico para comprender la mentalidad ofensiva, las fases de una evaluacion y los hallazgos mas frecuentes.',
                'description' => 'Formacion tecnica orientada a comprender como se estructura una evaluacion ofensiva controlada, como se documentan hallazgos y como se traduce una prueba tecnica en acciones defensivas utiles.',
                'audience' => 'Equipos TI, seguridad, SOC y perfiles tecnicos',
                'duration' => '16 a 24 horas',
                'topics' => [
                    'Reconocimiento, enumeracion y validacion de objetivos',
                    'OWASP, explotacion controlada y post-explotacion',
                    'Documentacion de evidencia y recomendaciones',
                ],
                'status' => 'published',
                'sort_order' => 3,
            ],
            [
                'title' => 'Secure Coding y OWASP',
                'slug' => 'secure-coding-y-owasp',
                'excerpt' => 'Reduce vulnerabilidades tempranas incorporando seguridad en el ciclo de desarrollo y revisando fallos comunes.',
                'description' => 'Capacitacion para equipos de desarrollo y QA con foco en patrones inseguros recurrentes, practicas seguras de implementacion y analisis aplicado de OWASP Top 10 en aplicaciones y APIs.',
                'audience' => 'Desarrolladores, QA y lideres tecnicos',
                'duration' => '12 horas',
                'topics' => [
                    'Validacion de entrada, authn/authz y manejo de secretos',
                    'OWASP Top 10 aplicado a casos reales',
                    'Patrones para prevenir errores frecuentes en codigo y APIs',
                ],
                'status' => 'published',
                'sort_order' => 4,
            ],
            [
                'title' => 'Respuesta a Incidentes',
                'slug' => 'respuesta-a-incidentes',
                'excerpt' => 'Entrena a los equipos en deteccion inicial, contencion, escalamiento y comunicacion frente a incidentes.',
                'description' => 'Programa practico para equipos operativos que necesitan fortalecer deteccion inicial, toma de decisiones, coordinacion interna y flujo de escalamiento frente a incidentes reales o simulados.',
                'audience' => 'Blue Team, operaciones, TI y responsables de continuidad',
                'duration' => '8 a 12 horas',
                'topics' => [
                    'Flujo de respuesta, roles y decisiones criticas',
                    'Contencion temprana, preservacion de evidencia y lecciones aprendidas',
                    'Simulaciones y coordinacion entre areas',
                ],
                'status' => 'published',
                'sort_order' => 5,
            ],
            [
                'title' => 'Concienciacion, phishing y fraude',
                'slug' => 'concienciacion-phishing-y-fraude',
                'excerpt' => 'Curso rapido y practico para reducir error humano frente a correo malicioso, ingenieria social y suplantacion.',
                'description' => 'Sesion enfocada en decisiones seguras bajo presion, deteccion de senales de alerta y respuesta correcta ante intentos de fraude, suplantacion o phishing dentro del trabajo cotidiano.',
                'audience' => 'Toda la organizacion',
                'duration' => '2 a 4 horas',
                'topics' => [
                    'Senales de alerta en phishing y fraude',
                    'Decisiones seguras bajo presion',
                    'Escalamiento y reporte interno',
                ],
                'status' => 'published',
                'sort_order' => 6,
            ],
        ];
    }
}
