<?php
// Comprueba si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtén los datos enviados por el usuario
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Verifica si los datos son correctos
    if ($username == "usuario" && $password == "contraseña") {
        // Los datos son correctos, redirige al usuario a la página de inicio
        header("Location: inicio.php");
        exit();
    } else {
        // Los datos son incorrectos, establece una bandera para mostrar los campos en rojo
        $error = true;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inicio de sesión</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css">
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
    }

    h1 {
        color: #333;
        text-align: center;
    }

    form {
        width: 300px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }

    input[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #333;
        color: #fff;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }

    .error {
        border: 1px solid red;
    }
</style>
</head>
<body>
    <h1>Inicio de sesión</h1>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="username">Usuario:</label>
        <input type="text" name="username" <?php if (isset($error)) echo 'class="error"'; ?> required><br>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" <?php if (isset($error)) echo 'class="error"'; ?> required><br>

        <input type="submit" value="Iniciar sesión">
    </form>
</body>
</html>
