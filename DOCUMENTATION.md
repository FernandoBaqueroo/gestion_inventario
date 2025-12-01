# 📘 Documentación Técnica - Sistema de Inventario

Este documento detalla la arquitectura, lógica de negocio y funcionamiento interno del Sistema de Gestión de Inventario. Está dirigido a desarrolladores que deseen mantener o extender la aplicación.

---

## 🏗️ Arquitectura del Sistema

El proyecto sigue estrictamente el patrón de diseño **MVC (Modelo-Vista-Controlador)** utilizando PHP nativo.

### Estructura de Directorios

```
GestionInventario/
├── app/
│   ├── controllers/    # Lógica de negocio (recibe peticiones, coordina modelos y vistas)
│   ├── core/           # Núcleo del framework (Ruteo, Base de Datos, Clase Controller base)
│   ├── models/         # Acceso a datos y reglas de negocio
│   ├── services/       # Servicios externos (APIs, Helpers complejos)
│   └── views/          # Interfaz de usuario (HTML/PHP)
├── cache/              # Almacenamiento temporal (ej. respuestas de API)
├── public/             # Punto de entrada (index.php), assets (CSS, JS, Imágenes)
└── vendor/             # Librerías de terceros (si se usa Composer)
```

### Flujo de una Petición (Request Lifecycle)

1.  **Entry Point**: Todas las peticiones son dirigidas a `public/index.php` mediante `.htaccess`.
2.  **Routing (`app/core/App.php`)**: Analiza la URL (ej. `/product/create`) para determinar:
    *   Controlador: `ProductController`
    *   Método: `create`
    *   Parámetros: `[]`
3.  **Controller**: Se instancia el controlador, se ejecutan los middlewares de autenticación (`AuthController::requireAuth()`) y se procesa la lógica.
4.  **Model**: El controlador solicita datos al modelo (`Product::getAll()`).
5.  **View**: El controlador carga una vista y le pasa los datos para ser renderizados.

---

## 🔐 Seguridad y Autenticación

### Sistema de Roles (RBAC)
La seguridad se maneja centralizadamente en `app/controllers/AuthController.php`.

*   **Middleware `requireAuth()`**: Verifica si existe una sesión activa (`$_SESSION['user_id']`). Si no, redirige al login.
*   **Middleware `requireAdmin()`**: Verifica si el usuario tiene el rol `'admin'`. Si es `'staff'`, deniega el acceso o redirige.

**Implementación en Controladores:**
```php
public function deleteAction($id) {
    // Protege la ruta para que solo admins puedan borrar
    AuthController::requireAdmin(); 
    
    $this->model->delete($id);
}
```

### Manejo de Contraseñas
Las contraseñas **nunca** se guardan en texto plano. Se utiliza el algoritmo **BCRYPT** nativo de PHP:
*   Creación: `password_hash($password, PASSWORD_BCRYPT)`
*   Verificación: `password_verify($input, $hash)`

---

## 💾 Base de Datos

El sistema utiliza MySQL con PDO para prevenir inyecciones SQL.

### Tablas Principales

1.  **`users`**:
    *   `id`: PK
    *   `username`: Unique
    *   `password`: Hash
    *   `role`: ENUM('admin', 'staff') - Define los permisos.

2.  **`products`**:
    *   `id`: PK
    *   `category_id`: FK -> categories
    *   `supplier_id`: FK -> suppliers
    *   `stock`: Cantidad actual.
    *   `image`: Ruta relativa del archivo.

3.  **`sales`**:
    *   Registro transaccional de ventas. Al crear una venta, se descuenta automáticamente el stock del producto asociado.

---

## 🌐 Integración de APIs y Servicios

El sistema consume APIs externas para enriquecer el Dashboard.

### Servicio de Divisas (`ExchangeRateService`)
Ubicación: `app/services/ExchangeRateService.php`

Este servicio obtiene el tipo de cambio actual (USD a Moneda Local).

**Características Técnicas:**
*   **Herencia**: Extiende de `ApiService` base.
*   **Caching Inteligente**: Para evitar exceder los límites de la API gratuita y mejorar la velocidad de carga, la respuesta se guarda en un archivo JSON local (`cache/api/exchange_rates.json`).
*   **TTL (Time To Live)**: El caché es válido por 6 horas. Si el archivo existe y es reciente, se lee del disco; si no, se hace la petición HTTP (cURL).

**Flujo del Servicio:**
1.  Dashboard solicita tasas.
2.  Service verifica caché.
3.  Si caché expiró -> Petición cURL a `exchangerate-api.com`.
4.  Guarda respuesta en JSON.
5.  Devuelve datos al controlador.

---

## 👤 Módulo de Usuarios

Permite al Administrador gestionar el acceso del personal.

*   **Validaciones**:
    *   No permite duplicidad de nombres de usuario.
    *   Impide que un usuario se elimine a sí mismo (para evitar quedar sin admins).
*   **Vistas Dinámicas**:
    *   El menú lateral (`sidebar.php`) oculta el enlace "Usuarios" si el rol es Staff.
    *   Las tablas de productos ocultan los botones de "Editar/Eliminar" si el rol es Staff.

---

## 📊 Dashboard y Reportes

El Dashboard (`DashboardController`) agrega datos de múltiples modelos para ofrecer una vista general.

*   **Lógica**:
    *   `Product::getLowStock(10)`: Obtiene productos con menos de 10 unidades.
    *   `Sale::getMonthSales()`: Calcula el total vendido en el mes actual.
*   **Frontend**:
    *   Usa **Chart.js** para renderizar gráficas en el cliente (`canvas` HTML5).
    *   Los datos se pasan desde PHP a JavaScript mediante inyección de variables en el footer.

---

## 🛠️ Cómo Extender el Proyecto

### Agregar un Nuevo Módulo (Ej. "Clientes")

1.  **Base de Datos**: Crear tabla `clients`.
2.  **Modelo**: Crear `app/models/Client.php` extendiendo de `Model`. Implementar CRUD.
3.  **Controlador**: Crear `app/controllers/ClientController.php`.
    *   Constructor: `AuthController::requireAuth()`.
    *   Métodos: `index()`, `create()`, `store()`, etc.
4.  **Vistas**: Crear carpeta `app/views/clients/` con `index.php`, `create.php`, etc.
5.  **Ruta**: Agregar enlace en `app/views/layouts/sidebar.php`.

---

## ⚠️ Solución de Problemas Comunes

*   **Error 404 en rutas**: Verificar que `mod_rewrite` esté activado en Apache y que el `.htaccess` en `public/` esté correcto.
*   **Permisos de Imagen**: Si las imágenes no suben, verificar permisos de escritura en `public/uploads`.
*   **Error de API**: Si el widget de divisas falla, verificar conexión a internet y permisos en carpeta `cache/`.
