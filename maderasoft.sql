-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-11-2025 a las 23:06:14
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `maderasoft`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `descripcion`) VALUES
(1, 'Tablillas', 'Tablillas de diferentes dimensiones y acabados'),
(2, 'Tablas', 'Tablas de madera para construcción y carpintería'),
(3, 'Orcones', 'Madera rústica tipo orcón para estructuras'),
(4, 'Listones', 'Listones de diversas medidas para ensamblaje'),
(5, 'Triplay', 'Madera contrachapada para múltiples usos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `documento` varchar(20) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` varchar(150) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `nombre`, `documento`, `telefono`, `direccion`, `correo`, `fecha_registro`) VALUES
(1, 'IGNACIO', '61119149', '965155475', 'Pucallpa', 'ignacioptm13@senati.pe', '2025-11-24 22:10:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_ventas`
--

CREATE TABLE `detalle_ventas` (
  `id` int(11) NOT NULL,
  `id_venta` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_unitario` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL,
  `id_venta` int(11) DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `metodo_pago` enum('efectivo','tarjeta','transferencia') DEFAULT NULL,
  `fecha_pago` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `precio_compra` decimal(10,2) DEFAULT NULL,
  `precio_venta` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `id_categoria`, `id_proveedor`, `precio_compra`, `precio_venta`, `stock`, `fecha_registro`) VALUES
(5, 'TABLILLAS', 1, 1, 100.00, 100.00, 10, '2025-11-24 22:16:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `nombre_empresa` varchar(100) DEFAULT NULL,
  `contacto` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `direccion` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `nombre_empresa`, `contacto`, `telefono`, `correo`, `direccion`) VALUES
(1, 'Empresa Ejemplo SAC', 'Juan Pérez', '987654321', 'contacto@empresa.com', 'Av. Lima 123');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `rol` enum('admin','empleado') DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `password`, `rol`, `fecha_creacion`) VALUES
(1, 'Administrador', 'admin', '123456', 'admin', '2025-11-24 22:01:36'),
(2, 'Administrador', 'admin', '$2y$10$q11f74G6D5KsQauzQRLlmOCaglELnqbjQCa150hTQnYe2920Y9hS6', 'admin', '2025-11-24 22:03:22'),
(3, 'Administrador', 'admin1', '$2b$12$GF77U99.NKIw0DbqHT9uDOE73tQQHUxof8NBq6RlYX6p7x3DgybUS', 'admin', '2025-11-24 22:06:43');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `fecha_venta` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `id_cliente`, `id_usuario`, `total`, `fecha_venta`) VALUES
(1, NULL, NULL, NULL, '2025-11-24 22:16:59'),
(2, NULL, NULL, NULL, '2025-11-24 22:17:00'),
(3, NULL, NULL, NULL, '2025-11-24 22:17:10'),
(4, NULL, NULL, NULL, '2025-11-24 22:17:17'),
(5, NULL, NULL, NULL, '2025-11-24 22:17:19'),
(6, NULL, NULL, NULL, '2025-11-24 22:18:15'),
(7, NULL, NULL, NULL, '2025-11-24 22:22:19'),
(8, NULL, NULL, NULL, '2025-11-24 22:25:24'),
(9, NULL, NULL, NULL, '2025-11-24 22:25:33'),
(10, NULL, NULL, NULL, '2025-11-24 22:25:39'),
(11, NULL, NULL, NULL, '2025-11-24 22:25:40'),
(12, NULL, NULL, NULL, '2025-11-24 22:27:42'),
(13, NULL, NULL, NULL, '2025-11-24 22:27:42'),
(14, NULL, NULL, NULL, '2025-11-24 22:30:05'),
(15, NULL, NULL, NULL, '2025-11-24 22:30:09'),
(16, NULL, NULL, NULL, '2025-11-24 22:30:45'),
(17, NULL, NULL, NULL, '2025-11-24 22:32:16'),
(18, NULL, NULL, NULL, '2025-11-25 16:40:27'),
(19, NULL, NULL, NULL, '2025-11-25 16:40:45'),
(20, NULL, NULL, NULL, '2025-11-25 16:42:17'),
(21, NULL, NULL, NULL, '2025-11-25 16:44:18'),
(22, NULL, NULL, NULL, '2025-11-25 16:52:12'),
(23, NULL, NULL, NULL, '2025-11-25 16:55:52'),
(24, NULL, NULL, NULL, '2025-11-25 16:57:51'),
(25, NULL, NULL, NULL, '2025-11-25 17:00:36'),
(26, NULL, NULL, NULL, '2025-11-25 17:01:07'),
(27, NULL, NULL, NULL, '2025-11-25 17:01:34'),
(28, NULL, NULL, NULL, '2025-11-25 17:08:08'),
(29, NULL, NULL, NULL, '2025-11-25 17:08:16'),
(30, NULL, NULL, NULL, '2025-11-25 17:29:36'),
(31, NULL, NULL, NULL, '2025-11-25 17:31:26'),
(32, NULL, NULL, NULL, '2025-11-25 17:33:20');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_venta` (`id_venta`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_venta` (`id_venta`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_categoria` (`id_categoria`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_ventas`
--
ALTER TABLE `detalle_ventas`
  ADD CONSTRAINT `detalle_ventas_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id`),
  ADD CONSTRAINT `detalle_ventas_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`);

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`),
  ADD CONSTRAINT `productos_ibfk_2` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
