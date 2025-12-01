# Plan de Aprendizaje: Sistema de Gestión de Inventario (MVC PHP Puro)

Este documento detalla el plan paso a paso para construir una aplicación web completa utilizando PHP nativo (sin frameworks), patrón MVC, MySQL y la plantilla AdminLTE 3.

**Objetivo:** Crear un "Sistema de Gestión de Inventario" (Mini-ERP) para practicar autenticación, CRUDs, gestión de base de datos y consumo de APIs.

---

## 1. Definición del Proyecto
**Nombre:** `InventoryManager`
**Descripción:** Sistema para gestionar productos, proveedores y ventas de una pequeña empresa.
**Tecnologías:**
*   **Backend:** PHP 8.x (Puro, POO)
*   **Base de Datos:** MySQL / MariaDB
*   **Frontend:** HTML5, AdminLTE 3 (Bootstrap 4/5)
*   **Arquitectura:** MVC (Modelo-Vista-Controlador)

---

## 2. Diseño de la Base de Datos
Para un sistema robusto y escalable, utilizaremos un esquema relacional normalizado.

### Diagrama Entidad-Relación (Simplificado)
*   **users**: Usuarios del sistema (Admin, Vendedor).
*   **categories**: Categorías de productos.
*   **products**: Inventario real.
*   **suppliers**: Proveedores de productos.
*   **sales**: Cabecera de ventas/pedidos.
*   **sale_details**: Detalle de productos por venta.

### Script SQL Sugerido (Schema)
```sql
CREATE DATABASE inventory_system;
USE inventory_system;

-- Tabla de Usuarios (Para autenticación)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- Hash bcrypt
    role ENUM('admin', 'staff') DEFAULT 'staff',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Categorías
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Proveedores
CREATE TABLE suppliers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(100) NOT NULL,
    contact_email VARCHAR(100),
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Productos
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    supplier_id INT,
    code VARCHAR(50) UNIQUE NOT NULL, -- Código de barras o SKU
    name VARCHAR(150) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    stock INT DEFAULT 0,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id),
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id)
);

-- Tabla de Ventas (Cabecera)
CREATE TABLE sales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total DECIMAL(10, 2) NOT NULL,
    sale_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Detalle de Ventas
CREATE TABLE sale_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sale_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL, -- Precio al momento de la venta
    FOREIGN KEY (sale_id) REFERENCES sales(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);
```

---

## 3. Estructura de Carpetas (MVC)
Organizaremos el código para separar la lógica (PHP) de la presentación (HTML).

```text
/php-mvc-practice
├── app/
│   ├── config/             # Configuración de DB y constantes
│   │   └── db.php
│   ├── controllers/        # Lógica de control
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   └── ProductController.php
│   ├── models/             # Interacción con la BD
│   │   ├── User.php
│   │   └── Product.php
│   ├── views/              # Plantillas HTML (AdminLTE)
│   │   ├── layouts/        # Header, Footer, Sidebar
│   │   ├── auth/           # Login
│   │   └── products/       # Listados y formularios
│   └── core/               # Clases base del "Framework" propio
│       ├── Controller.php
│       ├── Model.php
│       └── Router.php      # Enrutador simple
├── public/                 # Única carpeta accesible desde el navegador
│   ├── assets/             # CSS, JS, Imágenes (AdminLTE files)
│   ├── index.php           # Punto de entrada único (Front Controller)
│   └── .htaccess           # Redirección de URLs a index.php
└── .env                    # (Opcional) Variables de entorno
```

---

## 4. Hoja de Ruta (Paso a Paso)

### Fase 1: Configuración Inicial
1.  Crear la estructura de carpetas.
2.  Configurar el servidor local (XAMPP/Laragon o PHP built-in server).
3.  Crear el archivo `.htaccess` para redirigir todo el tráfico a `public/index.php`.
4.  Crear la clase de conexión a Base de Datos (`Database.php`) usando PDO.

### Fase 2: El "Core" MVC
1.  **Router**: Crear un sistema simple que lea la URL (ej: `/products/index`) y llame al controlador adecuado.
2.  **Controller Base**: Clase padre para cargar modelos y vistas.
3.  **Model Base**: Clase padre con métodos genéricos (`getAll`, `getById`, `save`, `delete`).

### Fase 3: Integración de AdminLTE
1.  Descargar AdminLTE.
2.  Separar el HTML en "Layouts" (`header.php`, `sidebar.php`, `footer.php`).
3.  Crear una vista maestra que incluya estos fragmentos.
4.  Renderizar la página de "Dashboard" vacía desde un `DashboardController`.

### Fase 4: Autenticación (Login)
1.  Crear `users` en la base de datos (insertar un admin manualmente).
2.  Crear `AuthController` y la vista de Login (AdminLTE tiene una plantilla lista).
3.  Implementar lógica de Login:
    *   Recibir POST.
    *   Buscar usuario por email.
    *   Verificar password (`password_verify`).
    *   Guardar datos en `$_SESSION`.
4.  Proteger rutas: Crear un Middleware o verificación en el constructor de los controladores para redirigir si no hay sesión.

### Fase 5: Módulo CRUD (Productos)
1.  **Listar**: Crear `ProductModel` y `ProductController` para mostrar la tabla de productos (DataTables de AdminLTE).
2.  **Crear**: Formulario para agregar productos.
3.  **Editar/Eliminar**: Lógica para modificar y borrar registros.

### Fase 6: Consumo de API (Bonus)
1.  Simular una necesidad externa: "Obtener tipo de cambio del dólar" o "Obtener datos de usuarios dummy".
2.  Usar `curl` o `file_get_contents` en PHP para traer datos JSON de una API pública (ej: `jsonplaceholder.typicode.com`).
3.  Mostrar esos datos en una vista del Dashboard.

---

## Siguientes Pasos
¿Te parece bien este plan? Si estás de acuerdo, comenzaremos con la **Fase 1: Configuración Inicial y Base de Datos**.
