-- *** INICIO DEL SCRIPT COMPLETO Y CORREGIDO ***

-- 1. CONFIGURACIÓN INICIAL DEL DUMP
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- 2. CREACIÓN Y SELECCIÓN DE LA BASE DE DATOS (SOLUCIÓN AL ERROR #1046)
DROP DATABASE IF EXISTS `inventory_system`;
CREATE DATABASE IF NOT EXISTS `inventory_system` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `inventory_system`;

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Informática', 'Informática general y accesorios', '2025-11-26 12:55:12'),
(2, 'Electrodomésticos', 'Artículos grandes y pequeños para el hogar', '2025-11-26 12:55:12'),
(3, 'Oficina y Papelería', 'Material de oficina, mobiliario y útiles de escritura', '2025-11-26 12:55:12'),
(4, 'Móviles y Telefonía', 'Smartphones, accesorios y telefonía fija', '2025-11-26 12:55:26'),
(5, 'Videojuegos y Consolas', 'Consolas, juegos y accesorios para gaming', '2025-11-26 12:55:26'),
(6, 'Audio y Sonido', 'Auriculares, altavoces y equipos de sonido', '2025-11-26 12:55:26'),
(7, 'Fotografía y Drones', 'Cámaras, lentes y drones', '2025-11-26 12:55:42'),
(8, 'Deportes y Fitness', 'Equipamiento deportivo y wearables', '2025-11-26 12:55:42'),
(9, 'Mobiliario', 'Muebles de salón, dormitorio y almacenamiento', '2025-11-26 12:55:42'),
(10, 'Herramientas', 'Herramientas manuales y eléctricas', '2025-11-26 12:59:40'),
(11, 'Jardinería', 'Utensilios y maquinaria para jardín', '2025-11-26 12:59:40'),
(12, 'Iluminación', 'Lámparas, bombillas y sistemas de iluminación inteligente', '2025-11-26 12:59:40'),
(13, 'Belleza y Cuidado Personal', 'Aparatos de cuidado personal y belleza', '2025-12-01 20:30:00'),
(14, 'Accesorios Coche', 'Accesorios y gadgets para vehículos', '2025-12-01 20:30:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `contact_email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `suppliers`
--

INSERT INTO `suppliers` (`id`, `company_name`, `contact_email`, `phone`, `created_at`) VALUES
(1, 'TechGlobal S.L.', 'contacto@techglobal.com', '555-0001', '2025-11-26 12:55:12'),
(2, 'HomeLux Distribución', 'ventas@homelux.com', '555-0002', '2025-11-26 12:55:12'),
(3, 'OfficeMax Supplies', 'info@officemax.com', '555-0003', '2025-11-26 12:55:12'),
(4, 'MobileWorld Corp', 'orders@mobileworld.net', '555-0004', '2025-11-26 12:55:26'),
(5, 'Gaming Zone S.A.', 'support@gamingzone.com', '555-0005', '2025-11-26 12:55:26'),
(6, 'SoundMaster Pro', 'contact@soundmaster.co', '555-0006', '2025-11-26 12:55:26'),
(7, 'FotoDrone Express', 'sales@fotodrone.es', '555-0007', '2025-11-26 12:55:42'),
(8, 'FitLife Equipment', 'compras@fitlife.com', '555-0008', '2025-11-26 12:55:42'),
(9, 'Muebles de Vanguardia', 'pedidos@vanguardia.es', '555-0009', '2025-11-26 12:55:42'),
(10, 'Herramientas Proff', 'profesional@herramientasproff.com', '555-0010', '2025-11-26 12:59:40'),
(11, 'GreenGarden Suministros', 'contacto@greengarden.com', '555-0011', '2025-11-26 12:59:40'),
(12, 'Luz Inteligente S.L.', 'ventas@luzinteligente.es', '555-0012', '2025-11-26 12:59:40'),
(13, 'Beauty Devices Group', 'info@beautydevices.com', '555-0013', '2025-12-01 20:30:00'),
(14, 'RoadTrip Accesorios', 'contact@roadtrip.com', '555-0014', '2025-12-01 20:30:00'),
(15, 'MultiSupplier Global', 'pedidos@multiglobal.com', '555-0015', '2025-12-01 20:30:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(150) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `category_id`, `supplier_id`, `code`, `name`, `price`, `stock`, `image`, `created_at`) VALUES
-- INFORMÁTICA (Category 1, Supplier 1)
(1, 1, 1, 'PROD001', 'Laptop HP 15 pulgadas 8GB RAM', 899.99, 11, '/GestionInventario/public/uploads/products/PROD001_1764605566.jpg', '2025-11-26 12:59:40'),
(2, 1, 1, 'PROD002', 'Mouse Logitech M185 Inalámbrico', 19.99, 47, NULL, '2025-11-26 12:59:40'),
(6, 1, 1, 'PROD006', 'Monitor Samsung 24\" Full HD', 189.99, 10, NULL, '2025-11-27 09:49:15'),
(7, 1, 1, 'PROD007', 'Teclado Mecánico Razer BlackWidow', 129.99, 8, NULL, '2025-11-27 09:49:15'),
(8, 1, 1, 'PROD008', 'Mouse Gamer Logitech G502', 49.99, 35, NULL, '2025-11-27 09:49:15'),
(9, 1, 1, 'PROD009', 'Auriculares Sony WH-1000XM4', 279.99, 6, NULL, '2025-11-27 09:49:15'),
(10, 1, 1, 'PROD010', 'Webcam Logitech C920 HD', 69.99, 18, NULL, '2025-11-27 09:49:15'),
(11, 1, 1, 'PROD011', 'Laptop Dell Inspiron 15', 649.99, 4, NULL, '2025-11-27 09:49:15'),
(12, 1, 1, 'PROD012', 'Tablet Samsung Galaxy Tab A8', 199.99, 14, NULL, '2025-11-27 09:49:15'),
(13, 1, 1, 'PROD013', 'Disco Duro Externo Seagate 2TB', 79.99, 21, NULL, '2025-11-27 09:49:15'),
(14, 1, 1, 'PROD014', 'Memoria USB Kingston 64GB', 12.99, 150, NULL, '2025-11-27 09:49:15'),
(15, 1, 1, 'PROD015', 'Cable HDMI 2.0 Premium 2m', 8.99, 88, NULL, '2025-11-27 09:49:15'),
(66, 1, 1, 'PROD954', 'Teclado Gamer RGB', 150.00, 100, '/GestionInventario/public/uploads/products/PROD954_1764613545.jpg', '2025-12-01 18:25:45'),
(67, 1, 1, 'PROD067', 'Adaptador USB-C a HDMI/VGA', 25.99, 75, NULL, '2025-12-01 20:40:00'),
(68, 1, 1, 'PROD068', 'Enrutador WiFi 6 TP-Link', 89.99, 22, NULL, '2025-12-01 20:40:00'),
(69, 1, 1, 'PROD069', 'Impresora Multifunción Epson EcoTank', 259.99, 6, NULL, '2025-12-01 20:40:00'),
(70, 1, 1, 'PROD070', 'Tarjeta Gráfica RTX 4070', 699.99, 2, NULL, '2025-12-01 20:40:00'),
(71, 1, 1, 'PROD071', 'Licencia Antivirus 1 Año', 39.99, 300, NULL, '2025-12-01 20:40:00'),
(72, 1, 1, 'PROD072', 'Silla Gaming Ergonómica Pro', 229.99, 5, NULL, '2025-12-01 20:40:00'),
(73, 1, 1, 'PROD073', 'Alfombrilla Gaming XL RGB', 29.99, 60, NULL, '2025-12-01 20:40:00'),
(74, 1, 1, 'PROD074', 'Kit de Limpieza para Pantallas', 9.99, 120, NULL, '2025-12-01 20:40:00'),
(75, 1, 1, 'PROD075', 'Estación de Carga Inalámbrica Triple', 45.99, 40, NULL, '2025-12-01 20:40:00'),

-- ELECTRODOMÉSTICOS (Category 2, Supplier 2)
(3, 2, 2, 'PROD003', 'Aspiradora Samsung 2000W', 149.99, 8, NULL, '2025-11-26 12:59:40'),
(16, 2, 2, 'PROD016', 'Cafetera Nespresso Essenza Mini', 99.99, 11, NULL, '2025-11-27 09:49:15'),
(17, 2, 2, 'PROD017', 'Licuadora Oster 3 velocidades', 45.99, 19, NULL, '2025-11-27 09:49:15'),
(18, 2, 2, 'PROD018', 'Microondas LG 20L', 129.99, 7, NULL, '2025-11-27 09:49:15'),
(19, 2, 2, 'PROD019', 'Plancha Rowenta Steamforce', 89.99, 13, NULL, '2025-11-27 09:49:15'),
(20, 2, 2, 'PROD020', 'Aspiradora Robot iRobot Roomba', 299.99, 4, NULL, '2025-11-27 09:49:15'),
(21, 2, 2, 'PROD021', 'Ventilador de Torre Honeywell', 59.99, 16, NULL, '2025-11-27 09:49:15'),
(22, 2, 2, 'PROD022', 'Purificador de Aire Xiaomi', 149.99, 9, NULL, '2025-11-27 09:49:15'),
(23, 2, 2, 'PROD023', 'Báscula Digital de Cocina', 19.99, 42, NULL, '2025-11-27 09:49:15'),
(24, 2, 2, 'PROD024', 'Juego de Sartenes Tefal 3 piezas', 79.99, 12, NULL, '2025-11-27 09:49:15'),
(25, 2, 2, 'PROD025', 'Termo Stanley 1L', 34.99, 28, NULL, '2025-11-27 09:49:15'),
(46, 2, 2, 'PROD046', 'Smart TV Samsung 55\" 4K', 699.99, 2, NULL, '2025-11-27 10:25:34'),
(47, 2, 2, 'PROD047', 'Refrigeradora LG InstaView', 1499.99, 0, NULL, '2025-11-27 10:25:34'),
(48, 2, 2, 'PROD048', 'Lavadora Whirlpool 18kg', 899.99, 1, NULL, '2025-11-27 10:25:34'),
(49, 2, 2, 'PROD049', 'Horno Eléctrico 60L', 179.99, 4, NULL, '2025-11-27 10:25:34'),
(50, 2, 2, 'PROD050', 'Freidora de Aire Philips', 149.99, 6, NULL, '2025-11-27 10:25:34'),
(51, 2, 2, 'PROD051', 'Batidora KitchenAid', 299.99, 2, NULL, '2025-11-27 10:25:34'),
(52, 2, 2, 'PROD052', 'Extractor de Jugos Hurom', 449.99, 1, NULL, '2025-11-27 10:25:34'),
(53, 2, 2, 'PROD053', 'Procesador de Alimentos', 129.99, 5, NULL, '2025-11-27 10:25:34'),
(54, 2, 2, 'PROD054', 'Sandwichera Oster', 39.99, 7, NULL, '2025-11-27 10:25:34'),
(55, 2, 2, 'PROD055', 'Tetera Eléctrica Russell', 49.99, 3, NULL, '2025-11-27 10:25:34'),
(76, 2, 2, 'PROD076', 'Tostadora 2 Rebanadas Clásica', 29.99, 50, NULL, '2025-12-01 20:45:00'),
(77, 2, 2, 'PROD077', 'Vaporera Eléctrica 3 Niveles', 59.99, 15, NULL, '2025-12-01 20:45:00'),
(78, 2, 2, 'PROD078', 'Máquina de Palomitas de Aire Caliente', 35.99, 25, NULL, '2025-12-01 20:45:00'),

-- OFICINA Y PAPELERÍA (Category 3, Supplier 3)
(4, 3, 3, 'PROD004', 'Papel A4 Resma 500 hojas', 5.99, 200, NULL, '2025-11-26 12:59:40'),
(26, 3, 3, 'PROD026', 'Silla Ergonómica de Oficina', 189.99, 7, NULL, '2025-11-27 09:49:15'),
(27, 3, 3, 'PROD027', 'Escritorio Regulable en Altura', 349.99, 3, NULL, '2025-11-27 09:49:15'),
(28, 3, 3, 'PROD028', 'Lámpara LED de Escritorio', 29.99, 31, NULL, '2025-11-27 09:49:15'),
(29, 3, 3, 'PROD029', 'Organizador de Escritorio Bambú', 24.99, 45, NULL, '2025-11-27 09:49:15'),
(30, 3, 3, 'PROD030', 'Perforadora de 2 Agujeros', 7.99, 67, NULL, '2025-11-27 09:49:15'),
(31, 3, 3, 'PROD031', 'Grapadora Heavy Duty', 15.99, 52, NULL, '2025-11-27 09:49:15'),
(32, 3, 3, 'PROD032', 'Caja Archivadora Cartón x10', 12.99, 95, NULL, '2025-11-27 09:49:15'),
(33, 3, 3, 'PROD033', 'Marcadores Permanentes x12', 9.99, 120, NULL, '2025-11-27 09:49:15'),
(34, 3, 3, 'PROD034', 'Cuaderno Espiral A4 x5', 14.99, 78, NULL, '2025-11-27 09:49:15'),
(35, 3, 3, 'PROD035', 'Carpetas Colgantes x25', 18.99, 63, NULL, '2025-11-27 09:49:15'),
(56, 3, 3, 'PROD056', 'Impresora HP LaserJet', 299.99, 2, NULL, '2025-11-27 10:25:34'),
(57, 3, 3, 'PROD057', 'Scanner Epson WorkForce', 179.99, 1, NULL, '2025-11-27 10:25:34'),
(58, 3, 3, 'PROD058', 'Proyector BenQ 1080p', 499.99, 0, NULL, '2025-11-27 10:25:34'),
(59, 3, 3, 'PROD059', 'Pizarra Blanca 120x90cm', 89.99, 4, NULL, '2025-11-27 10:25:34'),
(60, 3, 3, 'PROD060', 'Destructora de Papel', 69.99, 5, NULL, '2025-11-27 10:25:34'),
(61, 3, 3, 'PROD061', 'Calculadora Científica', 24.99, 8, NULL, '2025-11-27 10:25:34'),
(62, 3, 3, 'PROD062', 'Reloj de Pared Digital', 34.99, 3, NULL, '2025-11-27 10:25:34'),
(63, 3, 3, 'PROD063', 'Soporte para Laptop', 29.99, 5, NULL, '2025-11-27 10:25:34'),
(64, 3, 3, 'PROD064', 'Hub USB-C 7 puertos', 39.99, 2, NULL, '2025-11-27 10:25:34'),
(65, 3, 3, 'PROD065', 'Webcam Ring Light', 59.99, 1, NULL, '2025-11-27 10:25:34'),
(79, 3, 3, 'PROD079', 'Tinta Negra Cartucho XL', 49.99, 80, NULL, '2025-12-01 20:45:00'),
(80, 3, 3, 'PROD080', 'Bolígrafos Gel x5 Colores', 5.99, 250, NULL, '2025-12-01 20:45:00'),
(81, 3, 3, 'PROD081', 'Archivador Palanca A4', 8.99, 110, NULL, '2025-12-01 20:45:00'),

-- MÓVILES Y TELEFONÍA (Category 4, Supplier 4)
(82, 4, 4, 'PROD082', 'iPhone 15 Pro 128GB', 1299.00, 5, NULL, '2025-12-01 20:50:00'),
(83, 4, 4, 'PROD083', 'Samsung Galaxy S24 Ultra', 1199.00, 3, NULL, '2025-12-01 20:50:00'),
(84, 4, 4, 'PROD084', 'Xiaomi Redmi Note 13', 249.00, 15, NULL, '2025-12-01 20:50:00'),
(85, 4, 4, 'PROD085', 'Funda Silicona iPhone 15', 19.99, 150, NULL, '2025-12-01 20:50:00'),
(86, 4, 4, 'PROD086', 'Cargador Rápido USB-C 65W', 35.99, 90, NULL, '2025-12-01 20:50:00'),

-- VIDEOJUEGOS Y CONSOLAS (Category 5, Supplier 5)
(87, 5, 5, 'PROD087', 'PlayStation 5 Standard Edition', 549.99, 2, NULL, '2025-12-01 20:52:00'),
(88, 5, 5, 'PROD088', 'Xbox Series X', 499.99, 4, NULL, '2025-12-01 20:52:00'),
(89, 5, 5, 'PROD089', 'Nintendo Switch OLED Modelo', 349.99, 7, NULL, '2025-12-01 20:52:00'),
(90, 5, 5, 'PROD090', 'Juego: Elden Ring PS5', 69.99, 25, NULL, '2025-12-01 20:52:00'),
(91, 5, 5, 'PROD091', 'Mando Inalámbrico DualSense Negro', 69.99, 18, NULL, '2025-12-01 20:52:00'),

-- AUDIO Y SONIDO (Category 6, Supplier 6)
(92, 6, 6, 'PROD092', 'Barra de Sonido Samsung Q-Series', 399.00, 5, NULL, '2025-12-01 20:54:00'),
(93, 6, 6, 'PROD093', 'Altavoz Portátil JBL Charge 5', 149.99, 12, NULL, '2025-12-01 20:54:00'),
(94, 6, 6, 'PROD094', 'Auriculares In-Ear Bluetooth Xiaomi', 29.99, 80, NULL, '2025-12-01 20:54:00'),
(95, 6, 6, 'PROD095', 'Tocadiscos Vintage con USB', 99.99, 10, NULL, '2025-12-01 20:54:00'),

-- FOTOGRAFÍA Y DRONES (Category 7, Supplier 7)
(96, 7, 7, 'PROD096', 'Cámara Réflex Canon EOS 90D', 1199.00, 2, NULL, '2025-12-01 20:56:00'),
(97, 7, 7, 'PROD097', 'Drone DJI Mini 4 Pro Fly More Combo', 1099.00, 1, NULL, '2025-12-01 20:56:00'),
(98, 7, 7, 'PROD098', 'Trípode Profesional Aluminio', 49.99, 15, NULL, '2025-12-01 20:56:00'),

-- DEPORTES Y FITNESS (Category 8, Supplier 8)
(99, 8, 8, 'PROD099', 'Smartwatch Garmin Fenix 7', 599.00, 4, NULL, '2025-12-01 20:58:00'),
(100, 8, 8, 'PROD100', 'Bicicleta Estática Plegable', 179.99, 6, NULL, '2025-12-01 20:58:00'),
(101, 8, 8, 'PROD101', 'Esterilla de Yoga Antideslizante', 19.99, 55, NULL, '2025-12-01 20:58:00'),

-- MOBILIARIO (Category 9, Supplier 9)
(102, 9, 9, 'PROD102', 'Sofá Cama 3 Plazas Gris', 599.00, 3, NULL, '2025-12-01 21:00:00'),
(103, 9, 9, 'PROD103', 'Estantería Modular Blanca', 79.99, 10, NULL, '2025-12-01 21:00:00'),
(104, 9, 9, 'PROD104', 'Mesa de Centro Elevable', 129.99, 5, NULL, '2025-12-01 21:00:00'),

-- HERRAMIENTAS (Category 10, Supplier 10)
(105, 10, 10, 'PROD105', 'Taladro Percutor Bosch 800W', 79.99, 15, NULL, '2025-12-01 21:02:00'),
(106, 10, 10, 'PROD106', 'Juego de Destornilladores de Precisión x50', 25.99, 50, NULL, '2025-12-01 21:02:00'),
(107, 10, 10, 'PROD107', 'Caja de Herramientas Metálica', 39.99, 20, NULL, '2025-12-01 21:02:00'),

-- JARDINERÍA (Category 11, Supplier 11)
(108, 11, 11, 'PROD108', 'Cortacésped Eléctrico 1400W', 149.99, 8, NULL, '2025-12-01 21:04:00'),
(109, 11, 11, 'PROD109', 'Set de Herramientas de Jardín x5', 29.99, 30, NULL, '2025-12-01 21:04:00'),
(110, 11, 11, 'PROD110', 'Manguera Extensible 30m', 45.99, 18, NULL, '2025-12-01 21:04:00'),

-- ILUMINACIÓN (Category 12, Supplier 12)
(111, 12, 12, 'PROD111', 'Pack 4 Bombillas LED Smart RGB', 39.99, 40, NULL, '2025-12-01 21:06:00'),
(112, 12, 12, 'PROD112', 'Lámpara de Pie con Regulador', 69.99, 9, NULL, '2025-12-01 21:06:00'),

-- BELLEZA Y CUIDADO PERSONAL (Category 13, Supplier 13)
(113, 13, 13, 'PROD113', 'Secador de Pelo Profesional Iónico', 69.99, 15, NULL, '2025-12-01 21:08:00'),
(114, 13, 13, 'PROD114', 'Máquina de Afeitar Eléctrica 5 en 1', 49.99, 20, NULL, '2025-12-01 21:08:00'),

-- ACCESORIOS COCHE (Category 14, Supplier 14)
(115, 14, 14, 'PROD115', 'Cámara de Coche Dashcam Full HD', 59.99, 18, NULL, '2025-12-01 21:10:00'),
(116, 14, 14, 'PROD116', 'Arrancador de Batería Portátil', 89.99, 10, NULL, '2025-12-01 21:10:00'),

-- PRODUCTOS BAJO/SIN STOCK (STOCK SIMULADO)
(117, 1, 1, 'PROD117', 'Portátil Gaming ASUS ROG Zephyrus', 1999.99, 0, NULL, '2025-12-01 21:12:00'), -- AGOTADO
(118, 5, 5, 'PROD118', 'Edición Coleccionista The Witcher 3', 199.99, 1, NULL, '2025-12-01 21:12:00'), -- STOCK BAJO
(119, 2, 2, 'PROD119', 'Robot de Cocina Multifunción Thermomix', 1199.00, 0, NULL, '2025-12-01 21:12:00'), -- AGOTADO
(120, 9, 9, 'PROD120', 'Silla de Comedor Nórdica (Pack 4)', 159.99, 2, NULL, '2025-12-01 21:12:00'), -- STOCK BAJO
(121, 4, 4, 'PROD121', 'Teléfono Fijo Inalámbrico Duo', 39.99, 1, NULL, '2025-12-01 21:12:00'), -- STOCK BAJO
(122, 1, 1, 'PROD122', 'Disco SSD NVMe 1TB Samsung', 79.99, 3, NULL, '2025-12-01 21:12:00'), -- STOCK BAJO
(123, 2, 2, 'PROD123', 'Secadora de Condensación 8kg Balay', 499.99, 0, NULL, '2025-12-01 21:12:00'), -- AGOTADO

-- MÁS PRODUCTOS DIVERSOS (Supplier 15)
(124, 1, 15, 'PROD124', 'Hub USB 3.0 de 4 puertos', 15.99, 110, NULL, '2025-12-01 21:15:00'),
(125, 3, 15, 'PROD125', 'Tijeras de Oficina Acero Inoxidable', 4.99, 300, NULL, '2025-12-01 21:15:00'),
(126, 6, 15, 'PROD126', 'Micrófono Condensador USB para Streaming', 79.99, 30, NULL, '2025-12-01 21:15:00'),
(127, 8, 15, 'PROD127', 'Bandas de Resistencia Fitness x5', 19.99, 70, NULL, '2025-12-01 21:15:00'),
(128, 12, 15, 'PROD128', 'Foco LED Exterior con Sensor de Movimiento', 29.99, 45, NULL, '2025-12-01 21:15:00'),
(129, 2, 15, 'PROD129', 'Batidora de Mano con Accesorios', 39.99, 55, NULL, '2025-12-01 21:15:00'),
(130, 10, 15, 'PROD130', 'Set de Llaves Allen y Torx', 14.99, 90, NULL, '2025-12-01 21:15:00'),
(131, 5, 15, 'PROD131', 'Volante de Carreras para PS5/PC', 249.99, 8, NULL, '2025-12-01 21:15:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `sale_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sales`
--

INSERT INTO `sales` (`id`, `user_id`, `total`, `sale_date`) VALUES
(1, 1, 1819.97, '2025-12-01 19:06:10'),
(2, 1, 1819.97, '2025-12-01 19:06:10'),
(3, 1, 1349.93, '2025-12-01 19:14:06'),
(4, 3, 224.97, '2025-11-28 10:15:00'),
(5, 3, 449.97, '2025-11-28 15:30:00'),
(6, 1, 74.96, '2025-11-29 09:00:00'),
(7, 3, 309.96, '2025-11-29 14:45:00'),
(8, 1, 419.96, '2025-11-30 11:20:00'),
(9, 3, 99.98, '2025-11-30 17:50:00'),
(10, 1, 599.99, '2025-12-01 09:40:00'),
(11, 3, 163.95, '2025-12-01 11:15:00'),
(12, 1, 107.95, '2025-12-01 14:00:00'),
(13, 3, 238.97, '2025-12-01 16:30:00'),
(14, 1, 289.97, '2025-12-01 18:00:00'),
(15, 3, 114.97, '2025-12-01 20:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sale_details`
--

CREATE TABLE `sale_details` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sale_details`
--

INSERT INTO `sale_details` (`id`, `sale_id`, `product_id`, `quantity`, `price`, `subtotal`) VALUES
(1, 1, 1, 2, 899.99, 1799.98),
(2, 1, 2, 1, 19.99, 19.99),
(3, 2, 1, 2, 899.99, 1799.98),
(4, 2, 2, 1, 19.99, 19.99),
(5, 3, 6, 2, 189.99, 379.98),
(6, 3, 11, 1, 649.99, 649.99),
(7, 3, 63, 1, 29.99, 29.99),
(8, 3, 26, 1, 189.99, 189.99),
(9, 3, 2, 1, 19.99, 19.99),
(10, 3, 13, 1, 79.99, 79.99),
(11, 4, 16, 1, 99.99, 99.99),
(12, 4, 23, 1, 19.99, 19.99),
(13, 4, 30, 5, 7.99, 39.95),
(14, 4, 32, 5, 12.99, 64.95),
(15, 5, 50, 3, 149.99, 449.97),
(16, 6, 33, 5, 9.99, 49.95),
(17, 6, 14, 2, 12.99, 25.98),
(18, 7, 7, 1, 129.99, 129.99),
(19, 7, 8, 2, 49.99, 99.98),
(20, 7, 15, 9, 8.99, 80.91), -- Corregido: 80.91 (9 * 8.99)
(21, 8, 6, 2, 189.99, 379.98),
(22, 8, 15, 4, 8.99, 35.96), -- Corregido: 35.96 (4 * 8.99)
(23, 8, 63, 1, 29.99, 29.99),
(24, 8, 2, 1, 19.99, 19.99),
(25, 9, 17, 2, 45.99, 91.98),
(26, 9, 23, 2, 19.99, 39.98), -- Corregido: 39.98 (2 * 19.99)
(27, 9, 33, 1, 9.99, 9.99),
(28, 10, 51, 2, 299.99, 599.98),
(29, 11, 74, 5, 9.99, 49.95),
(30, 11, 80, 2, 5.99, 11.98),
(31, 11, 124, 6, 15.99, 95.94),
(32, 11, 125, 1, 4.99, 4.99),
(33, 12, 101, 3, 19.99, 59.97),
(34, 12, 106, 1, 25.99, 25.99),
(35, 12, 107, 2, 19.99, 39.98), -- Corregido: 39.98 (2 * 19.99)
(36, 13, 84, 1, 249.00, 249.00),
(37, 14, 115, 3, 59.99, 179.97),
(38, 14, 116, 1, 89.99, 89.99),
(39, 14, 128, 1, 29.99, 29.99),
(40, 15, 94, 2, 29.99, 59.98),
(41, 15, 95, 1, 99.99, 99.99),
(42, 15, 126, 1, 79.99, 79.99),
(43, 15, 127, 2, 19.99, 39.98);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff') DEFAULT 'staff',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$FcJR6Nqp5OA02ZNUdNoWBeeijfNfgoPiyNIHbTrQk4GUcOpcl2Ro6', 'admin', '2025-11-26 11:30:28'),
(3, 'fer', '$2y$10$Rx3.jhz.PKgltmQcoaLSYu4fv4Hnv21DjEO7/mMiOS2yihYnwUNJ2', 'staff', '2025-12-01 20:04:03'),
(10, 'ana', '$2y$10$7rLg898w2R0K.h59R8gqA.mF7q9z7hL2k4.q3H1i8pS0y5V9wD1x', 'staff', '2025-12-01 21:20:00'), -- Clave simulada para '123456'
(11, 'luis', '$2y$10$7rLg898w2R0K.h59R8gqA.mF7q9z7hL2k4.q3H1i8pS0y5V9wD1x', 'staff', '2025-12-01 21:20:00'), -- Clave simulada para '123456'
(12, 'marta', '$2y$10$7rLg898w2R0K.h59R8gqA.mF7q9z7hL2k4.q3H1i8pS0y5V9wD1x', 'staff', '2025-12-01 21:20:00'); -- Clave simulada para '123456'

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `supplier_id` (`supplier_id`);

--
-- Indices de la tabla `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_sale_date` (`sale_date`),
  ADD KEY `idx_user` (`user_id`);

--
-- Indices de la tabla `sale_details`
--
ALTER TABLE `sale_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_sale` (`sale_id`),
  ADD KEY `idx_product` (`product_id`);

--
-- Indices de la tabla `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT de la tabla `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `sale_details`
--
ALTER TABLE `sale_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);

--
-- Filtros para la tabla `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Filtros para la tabla `sale_details`
--
ALTER TABLE `sale_details`
  ADD CONSTRAINT `sale_details_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sale_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- *** FIN DEL SCRIPT COMPLETO Y CORREGIDO ***