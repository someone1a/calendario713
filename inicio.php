<?php
session_start();

// Verificar si el usuario tiene un rol asignado
if (isset($_SESSION['rol'])) {
    $rol = $_SESSION['rol'];

    // Redirigir a la vista correspondiente según el rol
    switch ($rol) {
        case 'Admin':
            header("location: views/admin.view.php");
            break;
        case 'Profesor':
            header("location: views/teacher.view.php");
            break;
        case 'Estudiante':
            header("location: views/alumnos.view.php");
            break;
        case 'Director':
            header("location: views/directivo.view.php");
            break;
        default:
            header("location: inicio.php");
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Calendario 713</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.css">
    <link rel="stylesheet" href="css/inicio.css">
</head>
<body>
    <div class="container">
        <h2>Bienvenido a Calendario 713</h2>
        
        <div class="alert alert-info">
            <p>Estás registrado en Calendario 713 y estás esperando a que el administrador te asigne un rol.</p>
            <p>Por favor, ten paciencia y espera a que te informen sobre tu rol y permisos.</p>
        </div>
        
        <p>Si tienes alguna pregunta o necesitas asistencia, puedes ponerte en contacto con el administrador.</p>
    </div>
</body>
</html>
