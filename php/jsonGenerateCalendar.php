<?php
require('db_conn.php');
session_start();
if (isset($_SESSION['user_id'])) {
    $usuario = $_SESSION['user_id'];
    $rol = $_SESSION['rol'];
    switch ($rol) {
        case 'Admin':
            $query = "SELECT * FROM eventos";
            $result = mysqli_query($conn, $query);
            if (!$result) {
                die("Error en la consulta: " . mysqli_error($conn));
            }
            $eventos = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $eventos[] = $row;
            }
            $json = json_encode($eventos);
            header('Content-Type: application/json');
            echo $json;
            break;
        case 'Profesor':
            header("location: views/teacher.view.php");
            break;
        case 'Estudiante':
            $query = "SELECT alumnoID, cursoID FROM alumnos WHERE usuarioID = $usuario";
            $result = mysqli_query($conn, $query);
            if (!$result) {
                die("Error en la consulta: " . mysqli_error($conn));
            }

            $eventos = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $alumnoID = $row['alumnoID'];
                $cursoID = $row['cursoID'];
                $queryEventos = "SELECT * FROM eventos WHERE cursoID = $cursoID";
                $resultEventos = mysqli_query($conn, $queryEventos);
                if (!$resultEventos) {
                    die("Error en la consulta de eventos: " . mysqli_error($conn));
                }
                while ($rowEvento = mysqli_fetch_assoc($resultEventos)) {
                    $eventos[] = $rowEvento;
                }
            }
            $json = json_encode($eventos);
            header('Content-Type: application/json');
            echo $json;
            break;
        case 'Director':
            // hacer el codigo para el directivo
            break;
        default:
            header("location: inicio.php");
            break;
    }
} else {
    $query = "SELECT * FROM eventos WHERE tipo='acto' OR tipo='feriado'";
    $result = mysqli_query($conn, $query);
    $eventos = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $eventos[] = $row;
    }
    $json = json_encode($eventos);
    header('Content-Type: application/json');
    echo $json;
}
mysqli_close($conn);
?>
