<?php
session_start();
$usuario = isset($_SESSION['nombreUsuario']) ? $_SESSION['nombreUsuario'] : '';

if (!isset($_SESSION['nombreUsuario']) || $_SESSION['rol'] !== 'Admin') {
    header("location: ../login.php");
    exit();
}
require("../php/db_conn.php");

function checkUsers($conn)
{
    $sql = "SELECT UserID, userName, Nombre, Apellido, Mail, Rol
        FROM usuarios
        WHERE Rol IS NULL OR Rol='Null'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Usuarios sin rol asignado:</h2>";
        echo "<table class='table table-striped'>
            <tr>
                <th>UserID</th>
                <th>userName</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Mail</th>
                <th>Asignar Rol</th>
            </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>" . $row["UserID"] . "</td>
                <td>" . $row["userName"] . "</td>
                <td>" . $row["Nombre"] . "</td>
                <td>" . $row["Apellido"] . "</td>
                <td>" . $row["Mail"] . "</td>
                <td><a href='../php/asignar_rol.php?UserID=" . $row["UserID"] . "' target='_blank'>Asignar Rol</a></td>
            </tr>";
        }

        echo "</table>";
    } else {
        echo "Todos los usuarios tienen un rol asignado.";
    }

    $conn->close();
}

function addCourse($conn)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["cursoNombre"]) && isset($_POST["cursoDescripcion"])) {
            $cursoNombre = $_POST["cursoNombre"];
            $cursoDescripcion = $_POST["cursoDescripcion"];

            $insertSQL = "INSERT INTO cursos (Nombre, Descripcion) VALUES (?, ?)";
            $stmt = $conn->prepare($insertSQL);
            $stmt->bind_param("ss", $cursoNombre, $cursoDescripcion);

            if ($stmt->execute()) {
                echo "El curso ha sido agregado correctamente.";
            } else {
                echo "Error al agregar el curso: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Calendario del Administrador</title>
    <link rel="stylesheet" href="../node_modules/@fortawesome/fontawesome-free/css/all.css">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="../css/teacher.css">
    <link rel="stylesheet" href="../css/calendar.css">
</head>

<body>
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
            <button class="tablinks" onclick="openWindow(event, 'aprobate')" id="defaultOpen">Aprobar usuario <i class="fa-solid fa-check"></i></button>
            <button class="tablinks" onclick="openWindow(event, 'editUser')">Editar Usuario <i class="fa-solid fa-pen"></i></button>
            <button class="tablinks" onclick="openWindow(event, 'addCourse')">Agregar Curso <i class="fa-solid fa-plus"></i></button>
        </div>
        <main>
            <div class="tabcontent" id="aprobate">
                <?php checkUsers($conn) ?>
            </div>
            <div class="tabcontent" id="editUser">
    <h2>Editar Usuario</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="userID" class="form-label">ID de Usuario:</label>
            <a href="" target="_blank">Seleccionar Usuario</a>
        </div>
        <div class="mb-3">
            <label for="userName" class="form-label">Nombre de Usuario:</label>
            <input type="text" name="userName" id="userName" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido:</label>
            <input type="text" name="apellido" id="apellido" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="mail" class="form-label">Correo Electrónico:</label>
            <input type="email" name="mail" id="mail" class="form-control" required>
        </div>
        <input type="submit" value="Guardar Cambios" class="btn btn-primary">
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["userID"]) && isset($_POST["userName"]) && isset($_POST["nombre"]) && isset($_POST["apellido"]) && isset($_POST["mail"])) {
            $userID = $_POST["userID"];
            $userName = $_POST["userName"];
            $nombre = $_POST["nombre"];
            $apellido = $_POST["apellido"];
            $mail = $_POST["mail"];

            // Actualizar los datos del usuario en la base de datos
            $updateSQL = "UPDATE usuarios SET userName=?, Nombre=?, Apellido=?, Mail=? WHERE UserID=?";
            $stmt = $conn->prepare($updateSQL);
            $stmt->bind_param("ssssi", $userName, $nombre, $apellido, $mail, $userID);

            if ($stmt->execute()) {
                echo "Los datos del usuario han sido actualizados correctamente.";
            } else {
                echo "Error al actualizar los datos del usuario: " . $stmt->error;
            }
            $stmt->close();
        }
    }
    ?>
</div>

            <div class="tabcontent" id="addCourse">
                <h2>Agregar Curso</h2>
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="cursoNombre" class="form-label">Nombre del Curso:</label>
                        <input type="text" name="cursoNombre" id="cursoNombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="cursoDescripcion" class="form-label">Descripción del Curso:</label>
                        <textarea name="cursoDescripcion" id="cursoDescripcion" class="form-control" required></textarea>
                    </div>
                    <input type="submit" value="Agregar Curso" class="btn btn-primary">
                </form>
                <?php addCourse($conn) ?>
            </div>
        </main>
    </div>
    <script src="../js/tabs.js"></script>
</body>

</html>
