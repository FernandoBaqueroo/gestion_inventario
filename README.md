# 📦 Sistema de Gestión de Inventario (PHP MVC)

![PHP Badge](https://img.shields.io/badge/PHP-8.0+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL Badge](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap Badge](https://img.shields.io/badge/Bootstrap-5-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)
![AdminLTE Badge](https://img.shields.io/badge/AdminLTE-Theme-FFC107?style=for-the-badge&logo=adminlte&logoColor=black)

Un sistema robusto y moderno para el control de inventarios, ventas y gestión de personal. Desarrollado con **PHP Nativo** siguiendo el patrón de arquitectura **MVC (Modelo-Vista-Controlador)**, sin depender de frameworks pesados.

---

## ✨ Características Principales

### 📊 Dashboard Inteligente
*   Visualización de estadísticas en tiempo real.
*   **Gráficas interactivas** (Chart.js) de ventas mensuales y productos más vendidos.
*   **Widget de Divisas**: Integración con API externa para mostrar el tipo de cambio actual (USD/EUR) con sistema de caché para optimizar rendimiento.
*   Alertas automáticas de **Stock Bajo**.

### 🛡️ Seguridad y Roles (RBAC)
Sistema de permisos granular basado en roles:
*   **👑 Administrador**: Acceso total. Puede gestionar usuarios, eliminar registros y configurar el sistema.
*   **👤 Staff (Vendedor)**: Acceso restringido. Solo puede realizar ventas y ver inventario (Modo Solo Lectura).
*   Protección contra ataques XSS y SQL Injection (uso estricto de PDO).

### 📦 Gestión de Inventario
*   **Productos**: CRUD completo con subida de imágenes y gestión de stock.
*   **Categorías y Proveedores**: Organización relacional de datos.
*   Validaciones de integridad referencial (no permite borrar categorías con productos activos).

### 👥 Gestión de Usuarios
*   El administrador puede crear, editar y eliminar cuentas de acceso.
*   Distinción visual de roles mediante insignias (Badges).

---

## 🚀 Instalación y Configuración

### Prerrequisitos
*   Servidor Web (Apache/Nginx)
*   PHP 8.0 o superior
*   MySQL / MariaDB

### Pasos
1.  **Clonar el repositorio**
    ```bash
    git clone https://github.com/tu-usuario/gestion-inventario.git
    ```

2.  **Configurar la Base de Datos**
    *   Crea una base de datos llamada `inventory_system`.
    *   Importa el archivo `inventory_system.sql` ubicado en la raíz del proyecto.

3.  **Configurar conexión**
    *   Edita el archivo `app/core/Database.php` (si es necesario) para ajustar tus credenciales de MySQL.

4.  **Permisos de carpetas**
    *   Asegúrate de que las carpetas `public/uploads` y `cache/api` tengan permisos de escritura.

---

## 📖 Uso

### Credenciales por Defecto
Una vez importada la base de datos, puedes acceder con:

| Rol | Usuario | Contraseña |
| :--- | :--- | :--- |
| **Admin** | `admin` | `admin123` |
| **Staff** | `vendedor` | `123456` |

> ⚠️ **Importante**: Se recomienda cambiar estas contraseñas inmediatamente desde el panel de usuarios.

---

## 🛠️ Tecnologías Utilizadas

*   **Backend**: PHP 8 (Vanilla MVC)
*   **Frontend**: HTML5, CSS3, Bootstrap 5, AdminLTE
*   **Base de Datos**: MySQL
*   **Librerías JS**: jQuery, DataTables, Chart.js
*   **APIs**: ExchangeRate-API (para divisas)

---

## 📄 Documentación Técnica

Para entender la arquitectura interna, el flujo de datos y cómo extender el sistema, consulta la [Documentación Completa](DOCUMENTATION.md).

---

Hecho con ❤️ por Fernando Baquero (www.bbaza.dev)
