<?php
session_start();
$usuario = isset($_SESSION['nombreUsuario']) ? $_SESSION['nombreUsuario'] : '';

if (!isset($_SESSION['nombreUsuario']) || $_SESSION['rol'] !== 'Director') {
    header("location: ../login.php");
    exit();
}
require('../php/db_conn.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fecha = $_POST['fecha'];
    $horaInicio = $_POST['hora_inicio'];
    $horaFin = $_POST['hora_fin'];
    $cursoId = $_POST['curso_id'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $tipo = $_POST['tipo'];

    $sql = "INSERT INTO Eventos (Fecha, HoraInicio, HoraFin, CursoId, Titulo, Descripcion, Tipo) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $fecha, $horaInicio, $horaFin, $cursoId, $titulo, $descripcion, $tipo);

    if ($stmt->execute()) {
        $mensaje = "Evento agregado exitosamente.";
    } else {
        $mensaje = "Error al agregar el evento: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="../css/teacher.css">
    <link rel="stylesheet" href="../css/calendar.css">
    <title>Calendario 713 - Directivos</title>
</head>

<body>
    <header>
        <h1 class="txcenter">Calendario 713</h1>
    </header>
    <main>
        <div class="container">
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
        </div>
            <div class="tab">
                <button class="tablinks" onclick="openWindow(event, 'mineCalendar')" id="defaultOpen">Mi Calendario <i class="fa-solid fa-calendar text-primary"></i></button>
                <button class="tablinks" onclick="openWindow(event, 'cursos')">Mis Cursos <i class="fa-solid fa-earth-americas text-success"></i></button>
                <button class="tablinks" onclick="openWindow(event, 'addDate')">Añadir Fecha <i class="fa-solid fa-pencil text-danger"></i></button>
            </div>
            <div class="tabcontent" id="mineCalendar">
                <div class="mes">
                    <h2 class="txcenter">Octubre</h2>
                    <?php generateCalendar($month, $year);?>
                </div>
            </div>

            <div class="tabcontent" id="addDate">
                <h2>Agregar Evento</h2>
                <form method="POST">
                    <label for="fecha">Fecha:</label>
                    <input type="date" name="fecha" required>
                    <br>
                    <label for="hora_inicio">Hora de Inicio:</label>
                    <input type="time" name="hora_inicio" required>
                    <br>
                    <label for="hora_fin">Hora de Fin:</label>
                    <input type="time" name="hora_fin" required>
                    <br>
                    <label for="curso_id">Curso ID:</label>
                    <input type="text" name="curso_id">
                    <br>
                    <label for="titulo">Título del Evento:</label>
                    <input type="text" name="titulo" required>
                    <br>
                    <label for="descripcion">Descripción del Evento:</label>
                    <textarea name="descripcion" required></textarea>
                    <br>
                    <label for="tipo">Tipo de Evento:</label>
                    <select name="tipo" required>
                        <option value="acto">Acto</option>
                        <option value="feriado">Feriado</option>
                        <option value="evento_especial">Evento Especial</option>
                        <option value="entrega_trabajo">Entrega de Trabajo</option>
                        <option value="evaluacion">Evaluación</option>
                    </select>
                    <br>
                    <input type="submit" value="Agregar Evento">
                </form>
            </div>
        </div>
        <?php
        if (!empty($mensaje)) {
            echo '<p>' . $mensaje . '</p>';
        }
        ?>
    </main>
    <footer></footer>
    <script src="../js/tabs.js"></script>
    <script src="../js/fetchEvents.js"></script>
</body>

</html>
