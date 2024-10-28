<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $servername = $_POST['servername'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $dbname = $_POST['dbname'];

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

    echo "Installation completed successfully";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Web App Installer</title>
</head>
<body>
    <h1>Web App Installer</h1>
    <form method="post">
        <label for="servername">Server Name:</label>
        <input type="text" id="servername" name="servername" required><br><br>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <label for="dbname">Database Name:</label>
        <input type="text" id="dbname" name="dbname" required><br><br>
        <input type="submit" value="Install">
    </form>
</body>
</html>
