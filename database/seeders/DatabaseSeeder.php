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
                'translations' => [
                    'es' => [
                        'title' => 'Auditorias de Ciberseguridad',
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
                    ],
                    'en' => [
                        'title' => 'Cybersecurity Audits',
                        'excerpt' => 'We assess posture, infrastructure, applications, and processes to explain risk with evidence and clear prioritization.',
                        'description' => 'We perform audits to turn vague concern into a clear decision map. We review controls, configurations, processes, and real exposure so you can understand where the risk is, what impact it has, and which actions should be prioritized first.',
                        'deliverables' => [
                            'Technical diagnosis with executive reading',
                            'Findings prioritized by impact and effort',
                            'Improvement roadmap with concrete actions',
                        ],
                        'details' => [
                            'Cybersecurity posture and operational maturity audit',
                            'Technical audit of infrastructure, endpoints, and cloud',
                            'Audit of web applications, APIs, and sensitive workflows',
                            'Audit of compliance and information security',
                        ],
                    ],
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
                'translations' => [
                    'es' => [
                        'title' => 'Pentesting Ofensivo',
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
                    ],
                    'en' => [
                        'title' => 'Offensive Pentesting',
                        'excerpt' => 'We simulate real attacks on applications, APIs, internal networks, and exposed assets to validate defensive controls.',
                        'description' => 'Pentesting helps confirm whether a weakness is truly exploitable. We run controlled tests over the agreed scope to measure exposure, confirm impact, and deliver evidence useful for correction and revalidation.',
                        'deliverables' => [
                            'Web, API, internal network, and perimeter tests',
                            'Executive and technical report with reproducible evidence',
                            'Closing session with validation of critical findings',
                        ],
                        'details' => [
                            'Web applications and APIs focused on OWASP and business logic',
                            'Internal network and lateral movement to validate privileges and segmentation',
                            'Perimeter and exposed assets to identify surfaces visible from the Internet',
                        ],
                    ],
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
                'translations' => [
                    'es' => [
                        'title' => 'Cursos de Ciberseguridad',
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
                    ],
                    'en' => [
                        'title' => 'Cybersecurity Courses',
                        'excerpt' => 'Training programs for technical and non-technical profiles, aimed at reducing human error and raising operational judgment.',
                        'description' => 'We design training programs according to participant level and client objective. We combine explanation, examples, exercises, and guided practice so learning does not stay theoretical but becomes better everyday decisions.',
                        'deliverables' => [
                            'Introductory, intermediate, and advanced paths',
                            'Bootcamps, workshops, and guided labs',
                            'Training aligned to role and client context',
                        ],
                        'details' => [
                            'Introduction to Cybersecurity',
                            'Information Security Fundamentals',
                            'Ethical Hacking and controlled offensive practices',
                            'Secure Coding, OWASP, and incident response',
                        ],
                    ],
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
                'translations' => [
                    'es' => [
                        'title' => 'Acompanamiento Continuo',
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
                    ],
                    'en' => [
                        'title' => 'Continuous Support',
                        'excerpt' => 'We support you with hardening, periodic reviews, remediation follow-up, and crisis rooms so security does not remain an isolated project.',
                        'description' => 'Supporting means helping sustain progress. We participate in periodic reviews, remediation prioritization, hardening, incidents, and follow-up sessions so security work keeps traction.',
                        'deliverables' => [
                            'Monthly security posture reviews',
                            'Advisory for technical governance and compliance',
                            'Support in incidents and remediation prioritization',
                        ],
                        'details' => [
                            'Tracking findings and remediation plan',
                            'Hardening and validation of critical configurations',
                            'Technical meetings and support during priority incidents',
                        ],
                    ],
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
                'translations' => [
                    'es' => [
                        'title' => 'Introduccion a la Ciberseguridad',
                        'excerpt' => 'Curso base para entender amenazas comunes, higiene digital, roles y responsabilidad compartida.',
                        'description' => 'Programa introductorio para participantes que necesitan una base clara sobre amenazas frecuentes, practicas seguras y decisiones basicas frente a incidentes, fraudes o errores cotidianos.',
                        'audience' => 'Equipos no tecnicos, nuevos ingresos y lideres de area',
                        'duration' => '4 a 6 horas',
                        'topics' => [
                            'Panorama de amenazas actuales y vectores frecuentes',
                            'Buenas practicas de acceso, correo y navegacion',
                            'Que hacer ante incidentes, sospechas o fraudes',
                        ],
                    ],
                    'en' => [
                        'title' => 'Introduction to Cybersecurity',
                        'excerpt' => 'Core course for understanding common threats, digital hygiene, roles, and shared responsibility.',
                        'description' => 'Introductory program for participants who need a clear foundation on frequent threats, safe practices, and basic decisions when facing incidents, fraud, or everyday mistakes.',
                        'audience' => 'Non-technical teams, new hires, and area leaders',
                        'duration' => '4 to 6 hours',
                        'topics' => [
                            'Current threat landscape and common vectors',
                            'Access, email, and browsing best practices',
                            'What to do in case of incidents, suspicions, or fraud',
                        ],
                    ],
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
                'translations' => [
                    'es' => [
                        'title' => 'Fundamentos de Seguridad de la Informacion',
                        'excerpt' => 'Explica confidencialidad, integridad, disponibilidad, gestion de riesgos y controles basicos aplicables al negocio.',
                        'description' => 'Curso pensado para aterrizar los principios de seguridad de la informacion a procesos reales, ayudando a entender activos, riesgos, controles y responsabilidades dentro de la organizacion.',
                        'audience' => 'Mandos medios, responsables de procesos y equipos operativos',
                        'duration' => '8 horas',
                        'topics' => [
                            'Principios de seguridad de la informacion',
                            'Clasificacion de activos y tratamiento del riesgo',
                            'Controles, politicas y responsabilidades',
                        ],
                    ],
                    'en' => [
                        'title' => 'Information Security Fundamentals',
                        'excerpt' => 'Explains confidentiality, integrity, availability, risk management, and basic controls applicable to the business.',
                        'description' => 'Course designed to bring information security principles into real processes, helping people understand assets, risks, controls, and responsibilities within the organization.',
                        'audience' => 'Middle managers, process owners, and operations teams',
                        'duration' => '8 hours',
                        'topics' => [
                            'Information security principles',
                            'Asset classification and risk treatment',
                            'Controls, policies, and responsibilities',
                        ],
                    ],
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
                'translations' => [
                    'es' => [
                        'title' => 'Ethical Hacking',
                        'excerpt' => 'Programa practico para comprender la mentalidad ofensiva, las fases de una evaluacion y los hallazgos mas frecuentes.',
                        'description' => 'Formacion tecnica orientada a comprender como se estructura una evaluacion ofensiva controlada, como se documentan hallazgos y como se traduce una prueba tecnica en acciones defensivas utiles.',
                        'audience' => 'Equipos TI, seguridad, SOC y perfiles tecnicos',
                        'duration' => '16 a 24 horas',
                        'topics' => [
                            'Reconocimiento, enumeracion y validacion de objetivos',
                            'OWASP, explotacion controlada y post-explotacion',
                            'Documentacion de evidencia y recomendaciones',
                        ],
                    ],
                    'en' => [
                        'title' => 'Ethical Hacking',
                        'excerpt' => 'Hands-on program to understand the offensive mindset, assessment phases, and most common findings.',
                        'description' => 'Technical training focused on understanding how a controlled offensive assessment is structured, how findings are documented, and how a technical test turns into useful defensive actions.',
                        'audience' => 'IT teams, security, SOC, and technical profiles',
                        'duration' => '16 to 24 hours',
                        'topics' => [
                            'Reconnaissance, enumeration, and target validation',
                            'OWASP, controlled exploitation, and post-exploitation',
                            'Evidence documentation and recommendations',
                        ],
                    ],
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
                'translations' => [
                    'es' => [
                        'title' => 'Secure Coding y OWASP',
                        'excerpt' => 'Reduce vulnerabilidades tempranas incorporando seguridad en el ciclo de desarrollo y revisando fallos comunes.',
                        'description' => 'Capacitacion para equipos de desarrollo y QA con foco en patrones inseguros recurrentes, practicas seguras de implementacion y analisis aplicado de OWASP Top 10 en aplicaciones y APIs.',
                        'audience' => 'Desarrolladores, QA y lideres tecnicos',
                        'duration' => '12 horas',
                        'topics' => [
                            'Validacion de entrada, authn/authz y manejo de secretos',
                            'OWASP Top 10 aplicado a casos reales',
                            'Patrones para prevenir errores frecuentes en codigo y APIs',
                        ],
                    ],
                    'en' => [
                        'title' => 'Secure Coding and OWASP',
                        'excerpt' => 'Reduce vulnerabilities early by incorporating security into the development cycle and reviewing common flaws.',
                        'description' => 'Training for development and QA teams focused on recurring insecure patterns, secure implementation practices, and applied analysis of OWASP Top 10 in applications and APIs.',
                        'audience' => 'Developers, QA, and technical leads',
                        'duration' => '12 hours',
                        'topics' => [
                            'Input validation, authn/authz, and secrets management',
                            'OWASP Top 10 applied to real cases',
                            'Patterns to prevent common code and API mistakes',
                        ],
                    ],
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
                'translations' => [
                    'es' => [
                        'title' => 'Respuesta a Incidentes',
                        'excerpt' => 'Entrena a los equipos en deteccion inicial, contencion, escalamiento y comunicacion frente a incidentes.',
                        'description' => 'Programa practico para equipos operativos que necesitan fortalecer deteccion inicial, toma de decisiones, coordinacion interna y flujo de escalamiento frente a incidentes reales o simulados.',
                        'audience' => 'Blue Team, operaciones, TI y responsables de continuidad',
                        'duration' => '8 a 12 horas',
                        'topics' => [
                            'Flujo de respuesta, roles y decisiones criticas',
                            'Contencion temprana, preservacion de evidencia y lecciones aprendidas',
                            'Simulaciones y coordinacion entre areas',
                        ],
                    ],
                    'en' => [
                        'title' => 'Incident Response',
                        'excerpt' => 'Train teams in initial detection, containment, escalation, and communication when incidents occur.',
                        'description' => 'Practical program for operational teams that need to strengthen initial detection, decision making, internal coordination, and escalation flow in real or simulated incidents.',
                        'audience' => 'Blue Team, operations, IT, and continuity owners',
                        'duration' => '8 to 12 hours',
                        'topics' => [
                            'Response flow, roles, and critical decisions',
                            'Early containment, evidence preservation, and lessons learned',
                            'Simulations and cross-team coordination',
                        ],
                    ],
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
                'translations' => [
                    'es' => [
                        'title' => 'Concienciacion, phishing y fraude',
                        'excerpt' => 'Curso rapido y practico para reducir error humano frente a correo malicioso, ingenieria social y suplantacion.',
                        'description' => 'Sesion enfocada en decisiones seguras bajo presion, deteccion de senales de alerta y respuesta correcta ante intentos de fraude, suplantacion o phishing dentro del trabajo cotidiano.',
                        'audience' => 'Toda la organizacion',
                        'duration' => '2 a 4 horas',
                        'topics' => [
                            'Senales de alerta en phishing y fraude',
                            'Decisiones seguras bajo presion',
                            'Escalamiento y reporte interno',
                        ],
                    ],
                    'en' => [
                        'title' => 'Awareness, Phishing, and Fraud',
                        'excerpt' => 'Fast, practical course to reduce human error against malicious email, social engineering, and impersonation.',
                        'description' => 'Session focused on making safe decisions under pressure, spotting warning signs, and responding correctly to fraud, impersonation, or phishing attempts in day-to-day work.',
                        'audience' => 'Entire organization',
                        'duration' => '2 to 4 hours',
                        'topics' => [
                            'Warning signs in phishing and fraud',
                            'Safe decisions under pressure',
                            'Internal escalation and reporting',
                        ],
                    ],
                ],
                'status' => 'published',
                'sort_order' => 6,
            ],
        ];
    }
}
