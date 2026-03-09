# GAAF UDI – Sistema de Gestión de Inventarios

Aplicación construida sobre **Laravel 12** y **Filament 5** para administrar productos, categorías, inventario (entradas/salidas) y usuarios con roles jerarquizados. El objetivo es ofrecer un panel moderno, seguro y listo para exportar reportes en Excel/PDF.

## Stack clave
- PHP 8.2+, Laravel 12, Livewire 3/4.
- Filament 5 (panel administrativo, tablas, formularios).
- Spatie Permission + Filament Shield (roles/permisos).
- Laravel Excel & DomPDF (exportes a XLSX/PDF).

## Funcionalidades implementadas
- Panel Filament configurado (`/admin`) con login protegido.
- Jerarquía de usuarios: cada rol solo visualiza/edita registros permitidos.
- Paquetes de exportación instalados para futuros reportes.
- Base de modelos y migraciones para Productos, Categorías e Inventario.

## Próximos módulos
Consulta el archivo [`PLAN_DE_TRABAJO.md`](PLAN_DE_TRABAJO.md) para ver el estado actual del roadmap (dashboard, reportes, UX, seeders, etc.).

## Cómo empezar (resumen)
1. Clona este repositorio y replica el `.env` según el entorno.
2. Ejecuta `composer install` y `npm install`.
3. Corre `php artisan key:generate` y configura la base de datos.
4. Aplica migraciones (`php artisan migrate`) y, si es necesario, seeds personalizados.
5. Lanza los servicios de desarrollo con `npm run dev` + `php artisan serve`.

> La guía completa “paso a paso” está en `documentacion/guia_instalacion.md`.

## Documentación
Toda la documentación viva se centraliza en la carpeta [`documentacion/`](documentacion):

| Archivo | Descripción |
| --- | --- |
| `guia_instalacion.md` | Instrucciones detalladas para clonar, configurar y ejecutar el proyecto desde cero. |
| `arquitectura_logica.md` | Explica modelos, relaciones, jerarquías de roles y decisiones técnicas. |
| `diagramas_uml.md` | Diagramas UML (Mermaid) de contexto, clases y flujos clave. |

## Contribuciones y soporte
- Revisa `PLAN_DE_TRABAJO.md` antes de abrir nuevas funcionalidades.
- Ejecuta las pruebas/lints pertinentes antes de subir cambios.

---

Desarrollado por el equipo GAAF UDI para centralizar la operación de inventarios con trazabilidad, permisos granulares y reportes auditables.
