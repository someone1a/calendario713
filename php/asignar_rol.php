<?php
include("db_conn.php");
session_start();

$isAdmin = false;

if (isset($_SESSION['rol']) && $_SESSION['rol'] == 'Admin') {
    $isAdmin = true;
}

if (!$isAdmin) {
    echo "No tienes permisos para realizar esta acción.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = $_POST["userID"];
    $nuevoRol = $_POST["nuevoRol"];
    $updateSQL = "UPDATE usuarios SET Rol = ? WHERE UserID = ?";
    $stmt = $conn->prepare($updateSQL);
    $stmt->bind_param("ii", $nuevoRol, $userID);

    if ($stmt->execute()) {
        echo "El rol ha sido asignado correctamente.";
    } else {
        echo "Error al asignar el rol: " . $stmt->error;
    }
    $stmt->close();
}

if (isset($_GET["UserID"])) {
    $userID = $_GET["UserID"];
    $selectSQL = "SELECT UserID, userName, Nombre, Apellido, Mail, Rol
                FROM usuarios
                WHERE UserID = ?";

    $stmt = $conn->prepare($selectSQL);
    $stmt->bind_param("i", $userID);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $usuario = $result->fetch_assoc();
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Asignar Rol</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.css">
</head>

<body class="container">
    <h2>Asignar Rol a Usuario</h2>
    <form method="POST" action="asignar_rol.php">
        <input type="hidden" name="userID" value="<?php echo $usuario['UserID']; ?>">
        <label for="nuevoRol">Nuevo Rol:</label>
        <select name="nuevoRol">
            <option value="1">Estudiante</option>
            <option value="2">Profesor</option>
            <option value="3">Director</option>
            <option value="4">Admin</option>
        </select>
        <input type="submit" value="Asignar Rol">
    </form>
</body>

</html>
