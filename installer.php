<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $servername = $_POST['servername'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $dbname = $_POST['dbname'];
    $adminUsername = $_POST['adminUsername'];
    $adminPassword = password_hash($_POST['adminPassword'], PASSWORD_BCRYPT);
    $adminEmail = $_POST['adminEmail'];

    $conn = new mysqli($servername, $username, $password);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    if ($conn->query($sql) === TRUE) {
        echo "Database created successfully";
    } else {
        echo "Error creating database: " . $conn->error;
    }

    $conn->select_db($dbname);

    $sql = file_get_contents('db.sql');
    if ($conn->multi_query($sql)) {
        do {
            if ($result = $conn->store_result()) {
                $result->free();
            }
        } while ($conn->next_result());
        echo "Tables created successfully";
    } else {
        echo "Error creating tables: " . $conn->error;
    }

    $configContent = "<?php\n";
    $configContent .= "\$servername = '$servername';\n";
    $configContent .= "\$username = '$username';\n";
    $configContent .= "\$password = '$password';\n";
    $configContent .= "\$dbname = '$dbname';\n";
    $configContent .= "\$conn = new mysqli(\$servername, \$username, \$password, \$dbname);\n";
    $configContent .= "if (\$conn->connect_error) {\n";
    $configContent .= "    die('Connection failed: ' . \$conn->connect_error);\n";
    $configContent .= "}\n";
    file_put_contents('php/db_conn.php', $configContent);

    $sql = "INSERT INTO usuarios (userName, Contraseña, Mail, Rol) VALUES ('$adminUsername', '$adminPassword', '$adminEmail', 'Admin')";
    if ($conn->query($sql) === TRUE) {
        echo "Admin user created successfully";
    } else {
        echo "Error creating admin user: " . $conn->error;
    }

    echo "Installation completed successfully";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Web App Installer</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .installer-form {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }
        .installer-form h1 {
            margin-bottom: 20px;
        }
        .installer-form .form-group {
            margin-bottom: 15px;
        }
        .installer-form .form-control {
            border-radius: 4px;
        }
        .installer-form .btn {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="installer-form">
        <h1>Web App Installer</h1>
        <form method="post">
            <div class="form-group">
                <label for="servername">Server Name:</label>
                <input type="text" id="servername" name="servername" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="dbname">Database Name:</label>
                <input type="text" id="dbname" name="dbname" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="adminUsername">Admin Username:</label>
                <input type="text" id="adminUsername" name="adminUsername" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="adminPassword">Admin Password:</label>
                <input type="password" id="adminPassword" name="adminPassword" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="adminEmail">Admin Email:</label>
                <input type="email" id="adminEmail" name="adminEmail" class="form-control" required>
            </div>
            <input type="submit" value="Install" class="btn btn-primary">
        </form>
    </div>
</body>
</html>
