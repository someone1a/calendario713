-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-10-2023 a las 18:15:12
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
-- Base de datos: `calendario713`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `CursoID` int(11) NOT NULL,
  `NombreCurso` varchar(100) DEFAULT NULL,
  `idAlumnos` varchar(255) NOT NULL,
  `Descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`CursoID`, `NombreCurso`, `idAlumnos`, `Descripcion`) VALUES
(0, '5ETP', '', 'quinto ETP 2023'),
(1, '5ETP', '', 'quinto ETP 2023');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `tipo` enum('acto','feriado','prueba','tp','especial') NOT NULL,
  `Fecha` date DEFAULT NULL,
  `HoraInicio` time DEFAULT NULL,
  `HoraFin` time DEFAULT NULL,
  `CursoID` int(11) DEFAULT NULL,
  `Titulo` varchar(100) DEFAULT NULL,
  `Descripcion` text DEFAULT NULL,
  `EventoId` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`tipo`, `Fecha`, `HoraInicio`, `HoraFin`, `CursoID`, `Titulo`, `Descripcion`, `EventoId`) VALUES
('acto', '2023-11-17', '10:40:00', '12:00:00', 0, 'Dia de la soberania Nacional', 'profes Reguilo, Manzo', 3),
('feriado', '2023-12-24', '00:00:00', '00:00:00', 0, 'Navidad', 'Felices Fiestas!', 4),
('feriado', '2023-11-20', '00:00:00', '00:00:00', 0, 'Dia de la soberania Nacional', 'FERIADO', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscripciones`
--

CREATE TABLE `inscripciones` (
  `InscripcionID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `CursoID` int(11) DEFAULT NULL,
  `FechaInscripcion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `UserID` int(11) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `Contraseña` varchar(255) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Apellido` varchar(255) NOT NULL,
  `Mail` varchar(255) NOT NULL,
  `Rol` enum('Estudiante','Profesor','Director','Admin') DEFAULT NULL,
  `cursoId` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`UserID`, `userName`, `Contraseña`, `Nombre`, `Apellido`, `Mail`, `Rol`, `cursoId`) VALUES
(7, 'abrojodigital', '$2y$10$KlW59rLNXocoZMcZBwZEKub7Q9bN7Zp0fbQrlYNKqh5s305ujwXaa', 'Pablo', 'Bersier', 'abrogodigital@proton.sh', 'Director', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`CursoID`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`EventoId`);

--
-- Indices de la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD PRIMARY KEY (`InscripcionID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `CursoID` (`CursoID`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `EventoId` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `inscripciones`
--
ALTER TABLE `inscripciones`
  ADD CONSTRAINT `inscripciones_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `usuarios` (`UserID`),
  ADD CONSTRAINT `inscripciones_ibfk_2` FOREIGN KEY (`CursoID`) REFERENCES `cursos` (`CursoID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
