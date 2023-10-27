-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-10-2023 a las 20:24:31
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `childminder-alert`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL,
  `nombres` varchar(30) NOT NULL,
  `apellidos` varchar(30) NOT NULL,
  `tipo_documento` varchar(15) NOT NULL,
  `num_documento` varchar(15) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `telefono` varchar(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `fecha_nac` date NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `rol` varchar(20) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `clave` varchar(50) NOT NULL,
  `imagen` longtext NOT NULL,
  `estado` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idusuario`, `nombres`, `apellidos`, `tipo_documento`, `num_documento`, `direccion`, `telefono`, `email`, `fecha_nac`, `descripcion`, `rol`, `usuario`, `clave`, `imagen`, `estado`) VALUES
(1, 'christopher', 'PS', 'DNI', '12312312', 'La Molina, Lima, Perú', '123123123', 'email@email.com', '2001-05-16', 'Esta es una descripción mía.', 'admin', 'admin', 'admin', '1686791488.jpg', '0'),
(2, 'miguel', 'GH', 'DNI', '12312312', 'La Molina, Lima, Perú', '123123123', 'email@email.com', '2001-05-07', 'Esta es una descripción mía.', 'usuario', 'miguel', 'miguel', '1686791488.jpg', '1');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idusuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
