# Plan de Trabajo – Sistema de Inventario GAAF UDI
Hoja de ruta viva que consolida el análisis del stack actual, las dependencias instaladas y el avance por módulo. Las casillas marcadas (`[x]`) indican entregables ya cubiertos en el código; las pendientes (`[ ]`) siguen en ejecución.

## 0. Diagnóstico del Proyecto y Dependencias
- [x] Laravel 12 + PHP ≥ 8.2 configurados y operativos en el entorno local.
- [x] Filament 5 instalado con `AdminPanelProvider`, assets publicados y navegación básica.
- [x] Paquetes estratégicos añadidos: `spatie/laravel-permission`, `bezhansalleh/filament-shield`, `maatwebsite/excel`, `barryvdh/laravel-dompdf`.
- [ ] Revisión final de colas, cache y jobs para despliegues productivos.

## 1. Panel de Administración (CRUD y Dashboard)
- [x] Panel de administración base generado, login protegido y recursos auto-descubiertos.
- [x] Dashboard con widgets: KPIs (entradas/salidas/productos activos), últimos movimientos, categorías, stock disponible y actividad reciente.
- [x] Recursos CRUD para Productos, Categorías, Inventario y Movimientos con formularios, tablas y filtros.
- [ ] Acciones masivas y atajos (entradas/salidas) dentro de cada recurso.

## 2. Roles y Permisos
- [x] Instalación de Spatie Permission + Filament Shield y publicación de migraciones/config.
- [x] UserResource actualizado con jerarquía y restricciones (solo ve/edita roles inferiores).
- [x] Roles base configurados: `super_admin`, `admin`, `user`.
- [x] Sincronización de permisos con Shield: super_admin acceso total, admin sin gestión de usuarios/roles, user solo lectura de inventarios y reportes.

## 3. Categorías
- [x] Modelo y migración generados.
- [x] CRUD en Filament con campos nombre, descripcion, estado y relaciones con Productos.
- [ ] Filtros avanzados y métricas por categoría.

## 4. Productos
- [x] Modelo y migración scaffoldeados.
- [x] Formularios completos con relación a categorías.
- [ ] Acciones de ajuste de stock, badges por estado y filtros avanzados.

## 5. Inventario (Entradas / Salidas)
- [x] Modelo `InventoryTransaction` y migración creados.
- [x] Lógica de impacto en stock implementada (evento booted en modelo).
- [x] Módulo de inventario con búsqueda por producto, filtro por categoría y columna de categoría visible.
- [x] Movimientos con tipo Entrada, Salida y Ajuste registrables desde Inventory Transactions.
- [ ] Bitácora filtrable y alertas de stock bajo.

## 6. Reportes y Exportaciones
- [x] Dependencias de Excel y PDF instaladas y configuraciones publicadas.
- [ ] Listados con exportación directa (CSV/XLSX) y plantillas PDF.
- [ ] Automatizar alertas/exportes programados.

## 7. UI/UX
- [x] Panel responsive de Filament con navegación por permisos.
- [x] Navegación en español (labels de recursos traducidos).
- [ ] Personalización visual (branding, colores corporativos, logotipo).
- [ ] Notificaciones contextuales y alertas de stock bajo.

## 8. Entregables Transversales
- [ ] Seeder maestro (roles + usuario super_admin).
- [ ] Suite de pruebas (modelos, políticas, acciones críticas).
- [ ] Documentación funcional y técnica centralizada (ver carpeta `documentacion/`).
- [ ] Checklist de despliegue (migraciones, caches, build, workers).

Este plan se actualizará conforme se cierren los pendientes; cualquier cambio estructural debe reflejarse tanto aquí como en la documentación adjunta.
