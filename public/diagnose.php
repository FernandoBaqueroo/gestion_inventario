<?php
// NO BORRAR - Script de diagnóstico para Railway

// Simular el entorno de index.php
session_start();

// Definir BASE_URL según el entorno
if (getenv('APP_ENV') === 'production') {
    define('BASE_URL', '/');
} else {
    define('BASE_URL', '/GestionInventario/public/');
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>🔍 Diagnóstico del Sistema</title>
    <style>
        body { font-family: monospace; padding: 20px; background: #1e1e1e; color: #d4d4d4; }
        .section { background: #2d2d2d; padding: 15px; margin: 10px 0; border-radius: 5px; border-left: 4px solid #007acc; }
        .ok { color: #4ec9b0; }
        .error { color: #f48771; }
        .warning { color: #dcdcaa; }
        h2 { color: #4fc1ff; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        td, th { padding: 8px; text-align: left; border-bottom: 1px solid #444; }
        th { color: #569cd6; }
        code { background: #1e1e1e; padding: 2px 6px; border-radius: 3px; }
    </style>
</head>
<body>
    <h1>🔍 Diagnóstico del Sistema - Railway</h1>
    
    <div class="section">
        <h2>1️⃣ Entorno</h2>
        <table>
            <tr>
                <th>Variable</th>
                <th>Valor</th>
            </tr>
            <tr>
                <td>APP_ENV</td>
                <td class="<?= getenv('APP_ENV') === 'production' ? 'ok' : 'warning' ?>">
                    <?= getenv('APP_ENV') ?: '(no definido - asumiendo local)' ?>
                </td>
            </tr>
            <tr>
                <td>BASE_URL</td>
                <td class="ok"><?= BASE_URL ?></td>
            </tr>
            <tr>
                <td>SERVER_NAME</td>
                <td><?= $_SERVER['SERVER_NAME'] ?></td>
            </tr>
            <tr>
                <td>DOCUMENT_ROOT</td>
                <td><?= $_SERVER['DOCUMENT_ROOT'] ?></td>
            </tr>
            <tr>
                <td>REQUEST_URI</td>
                <td><?= $_SERVER['REQUEST_URI'] ?></td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h2>2️⃣ Base de Datos</h2>
        <table>
            <tr>
                <th>Variable</th>
                <th>Valor</th>
            </tr>
            <tr>
                <td>DB_HOST</td>
                <td class="<?= getenv('DB_HOST') ? 'ok' : 'error' ?>">
                    <?= getenv('DB_HOST') ?: '❌ NO CONFIGURADO' ?>
                </td>
            </tr>
            <tr>
                <td>DB_NAME</td>
                <td class="<?= getenv('DB_NAME') ? 'ok' : 'error' ?>">
                    <?= getenv('DB_NAME') ?: '❌ NO CONFIGURADO' ?>
                </td>
            </tr>
            <tr>
                <td>DB_USER</td>
                <td class="<?= getenv('DB_USER') ? 'ok' : 'error' ?>">
                    <?= getenv('DB_USER') ?: '❌ NO CONFIGURADO' ?>
                </td>
            </tr>
            <tr>
                <td>DB_PASS</td>
                <td class="<?= getenv('DB_PASS') !== false ? 'ok' : 'error' ?>">
                    <?= getenv('DB_PASS') !== false ? '✅ Configurado (' . strlen(getenv('DB_PASS')) . ' caracteres)' : '❌ NO CONFIGURADO' ?>
                </td>
            </tr>
        </table>
        
        <?php
        $dbConfigured = getenv('DB_HOST') && getenv('DB_NAME') && getenv('DB_USER');
        if ($dbConfigured) {
            try {
                require_once '../app/config/db.php';
                $database = new Database();
                $conn = $database->connect();
                echo '<p class="ok">✅ Conexión a base de datos exitosa</p>';
                
                // Probar consulta
                $stmt = $conn->query("SHOW TABLES");
                $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
                echo '<p class="ok">✅ Tablas encontradas: ' . count($tables) . '</p>';
                echo '<ul>';
                foreach ($tables as $table) {
                    $count = $conn->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();
                    echo "<li>$table: $count registros</li>";
                }
                echo '</ul>';
            } catch (Exception $e) {
                echo '<p class="error">❌ Error de conexión: ' . $e->getMessage() . '</p>';
            }
        } else {
            echo '<p class="error">❌ Variables de base de datos no configuradas</p>';
        }
        ?>
    </div>

    <div class="section">
        <h2>3️⃣ Archivos del Sistema</h2>
        <?php
        $files = [
            '../app/controllers/AuthController.php',
            '../app/controllers/DashboardController.php',
            '../app/controllers/ProductController.php',
            '../app/core/Router.php',
            '../app/core/Controller.php',
            '../app/config/db.php',
            '.htaccess'
        ];
        
        echo '<ul>';
        foreach ($files as $file) {
            $exists = file_exists($file);
            $class = $exists ? 'ok' : 'error';
            $icon = $exists ? '✅' : '❌';
            echo "<li class='$class'>$icon $file</li>";
        }
        echo '</ul>';
        ?>
    </div>

    <div class="section">
        <h2>4️⃣ URLs de Prueba</h2>
        <p>Prueba estos enlaces:</p>
        <ul>
            <li><a href="<?= BASE_URL ?>" style="color: #4fc1ff;">Dashboard (<?= BASE_URL ?>)</a></li>
            <li><a href="<?= BASE_URL ?>auth/login" style="color: #4fc1ff;">Login (<?= BASE_URL ?>auth/login)</a></li>
            <li><a href="<?= BASE_URL ?>product" style="color: #4fc1ff;">Productos (<?= BASE_URL ?>product)</a></li>
        </ul>
    </div>

    <div class="section">
        <h2>5️⃣ .htaccess Activo</h2>
        <pre><?= file_exists('.htaccess') ? htmlspecialchars(file_get_contents('.htaccess')) : '❌ .htaccess no encontrado' ?></pre>
    </div>

    <div class="section">
        <h2>6️⃣ PHP Info</h2>
        <p>Versión de PHP: <strong><?= phpversion() ?></strong></p>
        <p>Extensiones cargadas: <?= implode(', ', get_loaded_extensions()) ?></p>
    </div>

    <hr>
    <p style="text-align: center; color: #888;">
        🔗 Volver a: 
        <a href="<?= BASE_URL ?>" style="color: #4fc1ff;">Inicio</a> | 
        <a href="<?= BASE_URL ?>auth/login" style="color: #4fc1ff;">Login</a>
    </p>
</body>
</html>

