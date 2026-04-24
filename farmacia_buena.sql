-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-04-2026 a las 16:07:09
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
-- Base de datos: `farmacia_buena`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `edad` int(11) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `telefono_opcional` varchar(15) DEFAULT NULL,
  `direccion` varchar(200) NOT NULL,
  `enfermedad` varchar(100) NOT NULL,
  `alergias` text DEFAULT NULL,
  `tipo_sangre` varchar(5) NOT NULL,
  `fecha_consulta` timestamp NOT NULL DEFAULT current_timestamp(),
  `doctor_asignado` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`id`, `nombre`, `apellido`, `edad`, `telefono`, `telefono_opcional`, `direccion`, `enfermedad`, `alergias`, `tipo_sangre`, `fecha_consulta`, `doctor_asignado`) VALUES
(1, 'María', 'González', 45, '7678-1234', NULL, 'Calle Los Álamos #123, San Miguel', 'Hipertensión', NULL, 'O+', '2026-04-24 13:19:45', 'Dr. Carlos Pérez'),
(2, 'José', 'Ramírez', 32, '7123-4567', '7456-7890', 'Av. Roosevelt #45, Santa Ana', 'Diabetes Tipo 2', 'Penicilina', 'A+', '2026-04-24 13:19:45', 'Dra. Laura Martínez'),
(3, 'Ana', 'Flores', 28, '7987-6543', NULL, 'Pasaje Las Flores #8, San Salvador', 'Gripe estacional', NULL, 'O-', '2026-04-24 13:19:45', 'Dr. Carlos Pérez'),
(4, 'Roberto', 'Mendoza', 67, '7234-5678', '7888-9999', 'Colonia Escalón #234, San Salvador', 'Artritis reumatoide', 'Ibuprofeno', 'B+', '2026-04-24 13:19:45', 'Dra. Laura Martínez'),
(5, 'Carmen', 'López', 54, '7456-8901', NULL, 'Barrio El Centro #12, Usulután', 'Colesterol alto', NULL, 'AB+', '2026-04-24 13:19:45', 'Dr. Miguel Ángel Rivas'),
(6, 'Luis', 'Hernández', 41, '7789-0123', '7012-3456', 'Residencial San Luis #78, La Unión', 'Ansiedad', 'Naproxeno', 'A-', '2026-04-24 13:19:45', 'Dr. Carlos Pérez'),
(7, 'Patricia', 'Díaz', 35, '7345-6789', NULL, 'Calle Principal #56, Morazán', 'Migraña crónica', NULL, 'O+', '2026-04-24 13:19:45', 'Dra. Laura Martínez');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre_completo` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','medico','usuario') DEFAULT 'usuario',
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre_completo`, `email`, `password`, `rol`, `fecha_registro`) VALUES
(1, 'Administradora Andrea', 'admin@farmacia.com', '202cb962ac59075b964b07152d234b70', 'admin', '2026-04-24 13:19:45'),
(2, 'Dra. Katerinne Garcia', 'doctor@farmacia.com', '81dc9bdb52d04dc20036dbd8313ed055', 'medico', '2026-04-24 13:19:45');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
