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
    <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.css">
    <link rel="stylesheet" href="css/styles.css">
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
            border: 1px solid <?php echo isset($error) ? 'red' : '#ccc'; ?>;
            border-radius: 3px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #333;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            color: #fff;
        }

        .error {
            border: 1px solid red;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Inicio de sesión</h1>
        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <label for="username">Usuario:</label>
            <input type="text" name="username" class="form-control <?php echo isset($error) ? 'error' : ''; ?>" required><br>
            <label for="password">Contraseña:</label>
            <div class="password-wrapper">
                <input type="password" name="password" class="form-control <?php echo isset($error) ? 'error' : ''; ?>" required>
                <span class="password-toggle" onclick="togglePasswordVisibility(this)"><i class="fas fa-eye"></i></span>
            </div>
            <p>Si no tienes un usuario, puedes <a href="register.php">registrarte aquí</a>.</p>
            <input type="submit" value="Iniciar sesión" class="btn btn-primary">
        </form>

        <script>
            function togglePasswordVisibility(element) {
                var passwordInput = element.previousElementSibling;
                var passwordToggle = element.querySelector('i');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    passwordToggle.classList.remove('fa-eye');
                    passwordToggle.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    passwordToggle.classList.remove('fa-eye-slash');
                    passwordToggle.classList.add('fa-eye');
                }
            }
        </script>
    </div>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Calendario713</p>
    </footer>
</body>

</html>
