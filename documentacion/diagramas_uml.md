# Diagramas UML

Representaciones en formato Mermaid para visualizar las piezas construidas y planificadas.

## 1. Diagrama de contexto
```mermaid
flowchart LR
    subgraph Usuarios
        SA[Super Admin]
        AD[Admin]
        SUP[Supervisor]
        EMP[Empleado]
    end

    SA -->|Filament Panel| Panel
    AD -->|Filament Panel| Panel
    SUP -->|Filament Panel| Panel
    EMP -->|Filament Panel| Panel

    Panel -->|CRUD| Productos[(Productos)]
    Panel -->|CRUD| Categorias[(Categorías)]
    Panel -->|Movimientos| Inventario[(Transacciones)]
    Panel -->|Gestión| Usuarios[(Usuarios/Roles)]
    Panel -->|Reportes| Exportes[(Excel / PDF)]
```

## 2. Diagrama de clases
```mermaid
classDiagram
    class User {
        +id: int
        +name: string
        +email: string
        +password: string
        +roles(): Collection
        +inventoryTransactions(): HasMany
    }

    class Role {
        +id: int
        +name: string
        +guard_name: string
    }

    class Category {
        +id: int
        +name: string
        +description: text
        +is_active: bool
        +products(): HasMany
    }

    class Product {
        +id: int
        +name: string
        +description: text
        +price: decimal
        +stock: int
        +category_id: int
        +inventoryTransactions(): HasMany
    }

    class InventoryTransaction {
        +id: int
        +type: enum
        +quantity: int
        +unit_price: decimal
        +transaction_date: datetime
        +product_id: int
        +user_id: int
    }

    User --> "*" Role : belongsToMany
    Role --> "*" User : belongsToMany
    Category --> "*" Product : hasMany
    Product --> "*" InventoryTransaction : hasMany
    User --> "*" InventoryTransaction : hasMany
```

## 3. Secuencia – Registro de una salida de inventario
```mermaid
sequenceDiagram
    actor U as Usuario (Admin/Empleado)
    participant P as Panel Filament
    participant F as InventoryTransactionResource
    participant M as InventoryTransaction (Model)
    participant PR as Product (Model)

    U->>P: Accede al recurso "Movimientos"
    P->>F: Solicita formulario de salida
    F->>U: Muestra formulario (producto, cantidad, motivo)
    U->>F: Envía datos
    F->>M: Crea registro type='salida'
    M->>PR: reduce stock disponible
    PR-->>M: stock actualizado
    M-->>F: Transacción guardada
    F-->>P: Refresca tabla y dispara notificación
    P-->>U: Confirma salida y muestra nuevo stock
```

## 4. Diagrama de estados – Producto
```mermaid
stateDiagram-v2
    [*] --> Disponible
    Disponible --> BajoStock : stock < umbral
    BajoStock --> Critico : stock <= minimo
    Critico --> SinStock : stock == 0
    SinStock --> Abastecido : nueva entrada
    Abastecido --> Disponible
```

Estos diagramas deben actualizarse al incorporar nuevos módulos o relaciones.
