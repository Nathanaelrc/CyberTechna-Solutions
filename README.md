# CyberTechna Solutions

Sitio corporativo desarrollado con Laravel 13, Bootstrap 5 y Docker para ofrecer servicios de ciberseguridad. Incluye landing comercial, formulario de contacto, autenticacion del propietario y panel privado para publicar insights y revisar mensajes entrantes.

## Incluye

- Landing page para CyberTechna Solutions con servicios de auditoria, pentesting, formacion y acompanamiento continuo.
- Login reservado al propietario y dashboard privado.
- Recuperacion de contraseña desde login via enlace por correo.
- Cambio de contraseña del administrador desde el panel (`Mi contraseña`).
- CRUD de publicaciones para compartir novedades, articulos o casos.
- Bandeja de mensajes recibidos desde el formulario de contacto.
- Metadatos operativos para cursos: modalidad, proxima edicion, registro e integracion con herramientas externas.
- Base de integracion con Google Calendar y Google Meet para programar clases remotas desde el panel.
- Docker Compose con Nginx, PHP 8.5-FPM y MySQL 8.4.

## Arranque rapido

1. Levanta el stack:

	```bash
	docker compose up --build
	```

2. Abre el sitio en http://localhost:9090

3. Accede al panel privado en http://localhost:9090/login

## Credenciales iniciales del propietario

Se generan con los valores del archivo `.env`:

- Email: `m.rodriguez@cybertechnasolutions.com`
- Password: `ChangeMe2026`

## Correo y contacto (Google Workspace)

- Contacto publico del sitio: `contacto@cybertechnasolutions.com`
- Usuario admin para login privado: `m.rodriguez@cybertechnasolutions.com`

Variables recomendadas en `.env` para Google Workspace SMTP:

```env
MAIL_MAILER=smtp
MAIL_SCHEME=tls
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=contacto@cybertechnasolutions.com
MAIL_PASSWORD=TU_APP_PASSWORD_O_PASSWORD_DE_SMTP
MAIL_EHLO_DOMAIN=cybertechnasolutions.com
MAIL_FROM_ADDRESS=contacto@cybertechnasolutions.com
MAIL_FROM_NAME="CyberTechna Solutions"
MAIL_REPLY_TO_ADDRESS=contacto@cybertechnasolutions.com
MAIL_REPLY_TO_NAME="CyberTechna Solutions"
CONTACT_EMAIL=contacto@cybertechnasolutions.com

ADMIN_EMAIL=m.rodriguez@cybertechnasolutions.com
```

Si usas verificacion en dos pasos en la cuenta de Workspace/Gmail, utiliza una App Password para `MAIL_PASSWORD`.

Antes de publicar en produccion, cambia al menos:

- `ADMIN_PASSWORD`
- `DB_PASSWORD`
- `DB_ROOT_PASSWORD`
- `APP_DEBUG`
- `APP_URL`
- `FORCE_HTTPS`
- `SESSION_SECURE_COOKIE`
- `GOOGLE_CLIENT_ID`
- `GOOGLE_CLIENT_SECRET`
- `GOOGLE_REFRESH_TOKEN`
- `GOOGLE_CALENDAR_ID`

## Comandos utiles

```bash
docker compose up --build
docker compose down
docker compose exec app php artisan migrate --force
docker compose exec app php artisan db:seed --force
docker compose exec app php artisan test
docker compose exec app php artisan google-meet:test 1
docker compose exec app php artisan google-meet:test 1 --create
```

## Estructura funcional

- `routes/web.php`: rutas publicas, login y panel privado.
- `app/Http/Controllers`: controladores para home, auth, mensajes y administracion.
- `resources/views/pages`: landing y detalle de publicaciones.
- `resources/views/admin`: dashboard, publicaciones y mensajes.
- `app/Services`: integraciones reutilizables, incluyendo Google Meet.
- `docker/php`: runtime PHP-FPM y entrypoint del contenedor.
- `docker/nginx`: configuracion del servidor web y del puerto publico.

## Notas de despliegue

- El contenedor instala dependencias Composer al iniciar, genera la clave de Laravel si falta, corre migraciones y siembra el usuario propietario.
- El proyecto usa Bootstrap por CDN, asi que no requiere Node.js para compilar assets.
- Si vas a publicarlo detras de un dominio con SSL, ajusta `APP_URL` a la URL final `https://...`, activa `FORCE_HTTPS=true` y `SESSION_SECURE_COOKIE=true` en `.env`.
- Si el certificado termina en un proxy o balanceador delante de Laravel, deja `TRUSTED_PROXIES` configurado y asegurate de reenviar `X-Forwarded-Proto`, `X-Forwarded-Host` y `X-Forwarded-Port`.
- Para Google Meet, crea un OAuth client de Google, obtiene un refresh token para Calendar API y completa `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, `GOOGLE_REFRESH_TOKEN`, `GOOGLE_CALENDAR_ID` y `GOOGLE_MEET_DEFAULT_TIMEZONE`.
- Una vez configurado, desde el panel de cursos puedes generar un enlace de Meet por curso, o probar la conexion por consola con `php artisan google-meet:test {curso}`.
