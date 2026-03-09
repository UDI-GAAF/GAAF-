# Arquitectura lógica y reglas del dominio

Resumen técnico de cómo está organizado el proyecto, qué responsabilidades tiene cada módulo y cuáles son las reglas de negocio vigentes.

## 1. Capas y paquetes
- **Laravel 12**: base MVC; controladores/Livewire en Filament.
- **Filament 5**: maneja panel, formularios y tablas. `app/Filament/Admin/*` contiene recursos, páginas y widgets.
- **Spatie Permission + Filament Shield**: gobiernan roles, permisos y políticas en recursos.
- **Maatwebsite Excel / DomPDF**: habilitan exportes a XLSX/PDF y reportes custom.

## 2. Modelos principales
| Modelo | Atributos clave | Relaciones |
| --- | --- | --- |
| `User` | `name`, `email`, `password` | `belongsToMany(Role)`, `hasMany(InventoryTransaction)` |
| `Role` (Spatie) | `name`, `guard_name` | `belongsToMany(Permission)`, `belongsToMany(User)` |
| `Category` | `name`, `description`, `is_active` | `hasMany(Product)` |
| `Product` | `name`, `description`, `price`, `stock`, `provider_id`, `category_id` | `belongsTo(Category)`, `hasMany(InventoryTransaction)` |
| `InventoryTransaction` | `type (entrada/salida)`, `quantity`, `unit_price`, `reference`, `transaction_date` | `belongsTo(Product)`, `belongsTo(User)` |

> Los campos exactos de `Category`, `Product` e `InventoryTransaction` se ajustarán durante el desarrollo, pero su eje es el descrito.

## 3. Jerarquía de roles
Definida en `App\Helpers\RoleHierarchy` para determinar qué usuarios puede ver/editar cada actor.

Orden (más poder → menos poder):
1. `super_admin`
2. `admin`
3. `supervisor`
4. `empleado`

Reglas activas:
- `super_admin` ve y edita todo.
- Cualquier otro rol solo ve usuarios con nivel inferior y su propio registro.
- La asignación de roles en el formulario de usuarios se restringe a los disponibles según jerarquía.

## 4. Recursos Filament
- `UserResource`: formularios (nombre, correo, password, roles) + tabla con badges por rol y filtros. La query se filtra por jerarquía.
- Recursos pendientes: `CategoryResource`, `ProductResource`, `InventoryTransactionResource` y reportes específicos.

## 5. Reglas de inventario (planeadas)
1. Cada entrada suma `quantity` al campo `stock` del producto.
2. Cada salida resta y verifica que el stock no quede negativo (se bloquea o se notifica).
3. Las transacciones guardan `user_id` (quién ejecuta) y `reference` (proveedor/cliente/nota).
4. Los reportes cruzan `product_id`, `category_id` y rangos de fechas para generar KPIs.

## 6. Variables y configuración clave
- `.env` gobierna base de datos, colas y `APP_URL`.
- `config/permission.php`: guarda caché/prefix para roles (Spatie).
- `config/excel.php` y `config/dompdf.php`: tuning de memoria, delimitadores, fuentes para reportes.
- `bootstrap/providers.php`: registro del `AdminPanelProvider`.

## 7. Flujo general del sistema
1. Usuario inicia sesión y entra al panel `/admin`.
2. Filament verifica permisos mediante Shield y muestra solo la navegación permitida.
3. Recursos CRUD manipulan modelos Eloquent; las reglas específicas se implementan en:
   - Policies (si aplica).
   - Métodos `form()`, `table()` y `getEloquentQuery()` en los `Resource`.
   - Observers/Actions para actualizar stock automáticamente.
4. Los reportes reutilizan las tablas de Filament con acciones de exportación (Excel/PDF).

## 8. Consideraciones futuras
- Integrar auditoría (Spatie Activity Log o similar).
- Sincronizar notificaciones (correo/slack) para stock crítico.
- Implementar colas/cron para reportes periódicos.

Esta guía sirve como mapa técnico para nuevos desarrolladores o revisores del proyecto.
