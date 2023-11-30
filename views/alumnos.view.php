<?php
session_start();
$usuario = isset($_SESSION['nombreUsuario']) ? $_SESSION['nombreUsuario'] : '';

if (!isset($_SESSION['nombreUsuario']) || $_SESSION['rol'] !== 'Estudiante') {
    header("location: ../login.php");
    exit();
}
require("../php/db_conn.php");
