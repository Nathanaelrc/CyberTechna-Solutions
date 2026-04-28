# CyberTechna Solutions

Sitio corporativo desarrollado con Laravel 13, Bootstrap 5 y Docker para ofrecer servicios de ciberseguridad. Incluye landing comercial, formulario de contacto, autenticacion del propietario y panel privado para publicar insights y revisar mensajes entrantes.

## Incluye

- Landing page para CyberTechna Solutions con servicios de auditoria, pentesting, formacion y acompanamiento continuo.
- Login reservado al propietario y dashboard privado.
- CRUD de publicaciones para compartir novedades, articulos o casos.
- Bandeja de mensajes recibidos desde el formulario de contacto.
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

- Email: `owner@cybertechna.local`
- Password: `ChangeMe2026`

Antes de publicar en produccion, cambia al menos:

- `ADMIN_PASSWORD`
- `DB_PASSWORD`
- `DB_ROOT_PASSWORD`
- `APP_DEBUG`
- `APP_URL`
- `FORCE_HTTPS`
- `SESSION_SECURE_COOKIE`

## Comandos utiles

```bash
docker compose up --build
docker compose down
docker compose exec app php artisan migrate --force
docker compose exec app php artisan db:seed --force
docker compose exec app php artisan test
```

## Estructura funcional

- `routes/web.php`: rutas publicas, login y panel privado.
- `app/Http/Controllers`: controladores para home, auth, mensajes y administracion.
- `resources/views/pages`: landing y detalle de publicaciones.
- `resources/views/admin`: dashboard, publicaciones y mensajes.
- `docker/php`: runtime PHP-FPM y entrypoint del contenedor.
- `docker/nginx`: configuracion del servidor web y del puerto publico.

## Notas de despliegue

- El contenedor instala dependencias Composer al iniciar, genera la clave de Laravel si falta, corre migraciones y siembra el usuario propietario.
- El proyecto usa Bootstrap por CDN, asi que no requiere Node.js para compilar assets.
- Si vas a publicarlo detras de un dominio con SSL, ajusta `APP_URL` a la URL final `https://...`, activa `FORCE_HTTPS=true` y `SESSION_SECURE_COOKIE=true` en `.env`.
- Si el certificado termina en un proxy o balanceador delante de Laravel, deja `TRUSTED_PROXIES` configurado y asegurate de reenviar `X-Forwarded-Proto`, `X-Forwarded-Host` y `X-Forwarded-Port`.
