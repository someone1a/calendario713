<?php
require('php/db_conn.php');

$errors = [];
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userName = $_POST["userName"];
    $nombre = $_POST["name"];
    $apellido = $_POST["lastname"];
    $contrasena = $_POST["contrasena"];
    $mail = $_POST["mail"];

    // Check if the username already exists
    $checkStmt = $conn->prepare("SELECT userName FROM usuarios WHERE userName = ?");
    $checkStmt->bind_param("s", $userName);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        $errors[] = "Ups... El nombre de usuario que elegiste ya fue elegido por alguien más 😓";
    } else {
        $contrasena = password_hash($contrasena, PASSWORD_BCRYPT);

        // Insert the user into the database
        $insertStmt = $conn->prepare("INSERT INTO usuarios (userName, Nombre, Apellido, Contraseña, Mail) VALUES (?, ?, ?, ?, ?)");
        $insertStmt->bind_param("sssss", $userName, $nombre, $apellido, $contrasena, $mail);

        if ($insertStmt->execute()) {
            $successMessage = "¡Registrado con éxito!";
        } else {
            $errors[] = "Error al registrar el usuario.";
        }

        $insertStmt->close();
    }

    $checkStmt->close();
    $conn->close();
}
?>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Calendario 713</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css">
    <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.css">
    <link rel="stylesheet" href="css/login.css">
    <style>
        ul{list-style:none;}

        li::before{
            font-family:"Font Awesome 5 Free";
            content:"\f0eb";
            margin-right:8px;
        }
    </style>
</head>

<body>
    <header class="container">
        <h1 class="text-center">Calendario 713 - Registro</h1>
    </header>
    <main class="container">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h2>Registro</h2>
            <div class="mb-3">
                <label for="userName" class="form-label">Nombre de Usuario:</label>
                <input type="text" name="userName" id="userName" class="form-control" required>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="name" class="form-label">Nombre:</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="col">
                    <label for="lastname" class="form-label">Apellido:</label>
                    <input type="text" name="lastname" id="lastname" class="form-control" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña:</label>
                <div class="input-group">
                    <input type="password" name="contrasena" id="contrasena" class="form-control" required>
                    <button type="button" id="togglePassword" class="btn btn-outline-secondary">Mostrar</button>
                </div>
            </div>
            <div class="mb-3">
                <label for="mail" class="form-label">Mail:</label>
                <input type="email" name="mail" id="mail" class="form-control" required>
            </div>
            <input type="submit" value="Registrarme" class="btn btn-primary">
        </form>

        <script>
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('contrasena');

            togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                togglePassword.textContent = type === 'password' ? 'Mostrar' : 'Ocultar';
            });
        </script>
    </main>

    <!-- Error Modal -->
    <?php if (!empty($errors)) : ?>
        <div class="modal" tabindex="-1" id="error">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">ERROR <i class="fa-solid fa-triangle-exclamation red"></i></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php foreach ($errors as $error) : ?>
                            <p><?php echo $error; ?></p>
                        <?php endforeach; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            window.onload = function () {
                var myModal = new bootstrap.Modal(document.getElementById("error"), {});
                myModal.show();
            }
        </script>
    <?php endif; ?>

    <!-- Success Modal -->
    <?php if (!empty($successMessage)) : ?>
        <div class="modal" tabindex="-1" id="success">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fa-solid fa-thumbs-up"></i> Registrado con Éxito</i></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Tus datos de inicio de sesión son los siguientes:</p>
                        <ul>
                            <li class="tx-alert">Tu nombre de usuario es: <?php echo $userName; ?></li>
                            <li class="tx-alert">El mail con el que te registraste es: <?php echo $mail; ?></li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <a href="login.php" class="btn btn-secondary" data-bs-dismiss="modal">Ir a iniciar sesión</a>
                    </div>
                </div>
            </div>
        </div>
        <script>
            window.onload = function () {
                var myModal = new bootstrap.Modal(document.getElementById("success"), {});
                myModal.show();
            }
        </script>
    <?php endif; ?>

    <footer class="container text-center mt-4">
        <p>Creado Por Walter Carrasco 2023&copy; - 5to ETP</p>
    </footer>
    <script src="node_modules/bootstrap/dist/js/bootstrap.js"></script>
</body>

</html>
