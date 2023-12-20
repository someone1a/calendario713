<?php
session_start();
$usuario = isset($_SESSION['nombreUsuario']) ? $_SESSION['nombreUsuario'] : '';

if (!isset($_SESSION['nombreUsuario']) || $_SESSION['rol'] !== 'Director') {
    header("location: ../login.php");
    exit();
}
require('../php/db_conn.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POT - calendario713</title>
    <link rel="stylesheet" href="../node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="../css/teacher.css">
    <link rel="stylesheet" href="../css/calendar.css">
</head>

<body>
    <header>
        <h1 class="txcenter">Calendario 713</h1>
    </header>
    <main>
        <main class="container">
            <div class="user-info">
                <?php
                if (!empty($usuario)) {
                    echo "<span class='welcome'>Bienvenido: $usuario</span>";
                    echo "<br>";
                    echo "<a href='../php/logout.php' class='txright'>Cerrar sesión <i class='fa-solid fa-right-to-bracket'></i></a>";
                } else {
                    echo "No has iniciado sesión.";
                }
                ?>
                <div class="tab">
                    <button class="tablinks" onclick="openWindow(event, 'mineCalendar')" id="defaultOpen">Mi Calendario <i class="fa-solid fa-calendar text-primary"></i></button>
                    <button class="tablinks" onclick="openWindow(event, 'cursos')">Mis Cursos <i class="fa-solid fa-earth-americas text-success"></i></button>
                    <button class="tablinks" onclick="openWindow(event, 'addDate')">Añadir Fecha <i class="fa-solid fa-pencil text-danger"></i></button>
                </div>
                <div class="tabcontent" id="mineCalendar">
                    <?php
                    generateCalendar($month, $year);
                    ?>
                </div>
            </div>
        </main>
        <footer>
            <p>&copy; <?php echo date("Y"); ?> Calendario713</p>
        </footer>
</body>

</html>