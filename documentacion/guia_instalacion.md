# Guía de instalación y despliegue paso a paso

Checklist detallado para clonar el proyecto y levantarlo desde cero sin perderse en el proceso.

## 1. Requisitos previos
1. **PHP 8.2+** con extensiones `intl`, `mbstring`, `openssl`, `pdo_mysql`, `zip`, `fileinfo`.
2. **Composer 2.6+**.
3. **Node.js 18+** y **npm 9+**.
4. Servidor de base de datos MySQL/MariaDB con un esquema vacío.
5. Opcional: Redis o database queue según despliegue final.

Verifica versiones rápidamente:
```bash
php -v
composer -V
node -v && npm -v
```

## 2. Clonar el repositorio
```bash
git clone <URL_DEL_REPO> GAAF_UDI
cd GAAF_UDI
```

> Sustituye `<URL_DEL_REPO>` por la ruta real (SSH o HTTPS). Si ya tienes la carpeta, actualízala con `git pull`.

## 3. Configurar variables de entorno
1. Duplica el archivo de ejemplo:
   ```bash
   cp .env.example .env
   ```
2. Edita `.env` y actualiza al menos:
   ```dotenv
   APP_NAME="GAAF UDI"
   APP_URL=http://127.0.0.1:8000

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=gaaf_udi
   DB_USERNAME=tu_usuario
   DB_PASSWORD=tu_password

   # Opcional para colas/correos según despliegue
   QUEUE_CONNECTION=database
   MAIL_MAILER=log
   ```

## 4. Instalar dependencias
```bash
composer install
npm install
```

## 5. Clave de la aplicación y enlace de storage
```bash
php artisan key:generate
php artisan storage:link
```

## 6. Migraciones y seeders
1. Crea la base de datos (si no existe) desde tu cliente MySQL.
2. Ejecuta las migraciones:
   ```bash
   php artisan migrate
   ```
3. (Opcional) Corre seeders personalizados cuando estén disponibles:
   ```bash
   php artisan db:seed --class=DatabaseSeeder
   ```

## 7. Compilar assets y lanzar servidores
- Desarrollo en caliente:
  ```bash
  npm run dev
  php artisan serve
  ```
- Build de producción:
  ```bash
  npm run build
  php artisan optimize
  ```

## 8. Acceso al panel de administración
1. Registra un usuario manualmente (`php artisan tinker` o directamente en la DB) y asígnale el rol `super_admin`.
2. Ingresa en `http://127.0.0.1:8000/admin`.
3. Si utilizas Filament Shield, ejecuta:
   ```bash
   php artisan migrate
   php artisan shield:install admin
   php artisan shield:generate
   ```

## 9. Jobs, colas y planificador
- Para colas: `php artisan queue:work`.
- Para tareas programadas: añade `* * * * * php /ruta/al/proyecto/artisan schedule:run >> /dev/null 2>&1` al cron (Linux/Mac) o usa el Programador de tareas en Windows.

## 10. Checklist antes de desplegar
1. `php artisan config:cache && php artisan route:cache`.
2. `npm run build` y publicar assets si usas CDN.
3. Configurar permisos en `storage/` y `bootstrap/cache/`.
4. Revisar `PLAN_DE_TRABAJO.md` para validar pendientes críticos.

Con estos pasos el proyecto queda listo para usarse en local o para continuar con la subida a un servidor de pruebas.
