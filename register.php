<?php
// FILEPATH: /c:/xampp/htdocs/calendario713 - proyecto desarrollo/register.php

// Verificar si se ha enviado el formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validar los datos (puedes agregar más validaciones según tus necesidades)
    if (empty($nombre) || empty($email) || empty($password)) {
        echo "Por favor, completa todos los campos.";
    } else {
        require("php/conn.php");
        $sql = "INSERT INTO usuarios (nombre, email, password) VALUES ('$nombre', '$email', '$password')";
        if ($conexion->query($sql) === true) {
            echo "¡Registro exitoso!";
        } else {
            echo "Error al registrar: " . $conexion->error;
        }

        $conexion->close();
    }
}
?>
        

        <!-- Formulario de registro -->
        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Registrarse</button>
        </form>
