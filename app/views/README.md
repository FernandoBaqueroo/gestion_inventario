# 📚 Sistema de Vistas

## Estructura de Layouts

El sistema usa **layouts reutilizables** para evitar duplicación de código:

```
app/views/
├── layouts/
│   ├── header.php    ← <head>, navbar, sidebar
│   └── footer.php    ← Scripts, cierre de HTML
├── dashboard/
│   └── index.php     ← Vista del dashboard
├── products/
│   ├── index.php     ← Lista de productos
│   ├── create.php    ← Crear producto
│   └── edit.php      ← Editar producto
└── auth/
    └── login.php     ← Página de login
```

---

## Cómo Crear una Vista

### **Estructura Básica:**

```php
<?php require_once '../app/views/layouts/header.php'; ?>
<?php require_once '../app/views/layouts/sidebar.php'; ?>

<!-- Tu contenido aquí -->
<div class="app-content">
    <div class="container-fluid">
        <h1>Mi Página</h1>
    </div>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
```

---

## Scripts Personalizados por Página

Si tu página necesita **JavaScript específico**, usa el sistema de `$pageScripts`:

### **Ejemplo:**

```php
<!-- Tu contenido -->
<div class="app-content">
    <button id="miBoton">Haz clic</button>
</div>

<?php
// Scripts específicos de esta página
ob_start();
?>
<script>
$(document).ready(function() {
    $('#miBoton').click(function() {
        alert('¡Funciona!');
    });
});
</script>
<?php
$pageScripts = ob_get_clean();
?>

<?php require_once '../app/views/layouts/footer.php'; ?>
```

**El script se insertará automáticamente en el footer DESPUÉS de cargar jQuery y todas las librerías.**

---

## Variables Disponibles en Vistas

Las vistas reciben datos desde los controladores:

```php
// En el controlador:
$data = [
    'title' => 'Mi Título',
    'products' => $products,
    'user' => $_SESSION['username']
];
$this->view('products/index', $data);

// En la vista:
echo $title;           // "Mi Título"
foreach($products as $product) { }
echo $user;           // "admin"
```

---

## Mostrar Mensajes Flash

```php
<?php if (isset($success)): ?>
<div class="alert alert-success alert-dismissible fade show">
    <i class="bi bi-check-circle"></i> <?= htmlspecialchars($success) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if (isset($error)): ?>
<div class="alert alert-danger alert-dismissible fade show">
    <i class="bi bi-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>
```

---

## Componentes de AdminLTE Disponibles

### **Info Box:**
```html
<div class="info-box">
    <span class="info-box-icon text-bg-info">
        <i class="bi bi-box"></i>
    </span>
    <div class="info-box-content">
        <span class="info-box-text">Productos</span>
        <span class="info-box-number">150</span>
    </div>
</div>
```

### **Card:**
```html
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Título</h3>
    </div>
    <div class="card-body">
        Contenido...
    </div>
</div>
```

### **Tabla:**
```html
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Nombre</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>Producto</td>
        </tr>
    </tbody>
</table>
```

---

## Ejemplo Completo

```php
<?php require_once '../app/views/layouts/header.php'; ?>
<?php require_once '../app/views/layouts/sidebar.php'; ?>

<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="mb-0"><?= $title ?></h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        
        <?php if (isset($success)): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($success) ?>
        </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Mi Contenido</h3>
            </div>
            <div class="card-body">
                <p>Aquí va tu contenido...</p>
            </div>
        </div>

    </div>
</div>

<?php
ob_start();
?>
<script>
$(document).ready(function() {
    console.log('¡Página cargada!');
});
</script>
<?php
$pageScripts = ob_get_clean();
?>

<?php require_once '../app/views/layouts/footer.php'; ?>
```

