<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'Profesor') {
    header("location: ../login.php");
    exit();
}

require '../php/db_conn.php';

$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fecha = $_POST['fecha'];
    $horaInicio = $_POST['hora_inicio'];
    $horaFin = $_POST['hora_fin'];
    $cursoId = $_POST['curso_id'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];

    $sql = "INSERT INTO Eventos (Fecha, HoraInicio, HoraFin, CursoId, Titulo, Descripcion) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $fecha, $horaInicio, $horaFin, $cursoId, $titulo, $descripcion);

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
    <title>Calendario del Profesor</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="../css/teacher.css">
    <link rel="stylesheet" href="../css/calendar.css">
</head>

<body>
    <h1>Calendario del Profesor</h1>
    <div class="container">
        <div class="tab">
            <button class="tablinks" onclick="openWindow(event, 'mineCalendar')" id="defaultOpen">Mi Calendario</button>
            <button class="tablinks" onclick="openWindow(event, 'cursos')">Mis Cursos</button>
            <button class="tablinks" onclick="openWindow(event, 'addDate')">Añadir Fecha</button>
        </div>
        <div class="tabcontent" id="mineCalendar">
            <div class="calendario">
                <h2>Octubre</h2>
            <?php
                function generateCalendar($month, $year){
                    $daysOfWeek = array('Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom');
                    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                    $firstDay = date('N', strtotime("$year-$month-01"));
                    echo "<table>";
                    echo "<tr>";
                    // Generar encabezados de días de la semana
                    foreach ($daysOfWeek as $day) {
                        echo "<th>$day</th>";
                    }
                    echo "</tr>";
                    echo "<tr>";
                    $currentDay = 1;
                    for ($i = 1; $i < $firstDay; $i++) {
                        echo "<td></td>";
                    }
                    // Generar el calendario
                    while ($currentDay <= $daysInMonth) {
                        for ($i = $firstDay; $i <= 7; $i++) {
                            echo "<td data-date='$year-$month-$currentDay'>";
                            if ($currentDay <= $daysInMonth) {
                                echo $currentDay;
                                $currentDay++;
                            }
                            echo "</td>";
                        }
                        if ($currentDay <= $daysInMonth) {
                            echo "</tr><tr>";
                        }
                        $firstDay = 1;
                    }
                    echo "</tr>";
                    echo "</table>";
                }
                $year = date('Y'); // Año actual
                // Llama a la función para generar el calendario
                generateCalendar(10, $year);
                ?>
            </div>
            <div class="calendario">
                <h2>Noviembre</h2>
                <?php 
                generateCalendar(11,$year)
                ?>
            </div>
            <div class="calendario">
                <h3>Diciembre</h3>
                <?php 
                generateCalendar(12,$year)
                ?>
            </div>
        </div>
        <div class "tabcontent" id="cursos">
            <h1>asdas</h1>
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
                <input type="text" name="curso_id" required>
                <br>
                <label for="titulo">Título del Evento:</label>
                <input type="text" name="titulo" required>
                <br>
                <label for="descripcion">Descripción del Evento:</label>
                <textarea name="descripcion" required></textarea>
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
    </div>
    <script src="../js/tabs.js"></script>
    <script src="../js/addColours.js"></script>
</body>

</html>