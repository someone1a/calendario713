<?php
require_once 'php/db_conn.php';

function isAppInstalled() {
    global $conn;
    $tables = ['cursos', 'eventos', 'inscripciones', 'usuarios'];
    foreach ($tables as $table) {
        $result = $conn->query("SHOW TABLES LIKE '$table'");
        if ($result->num_rows == 0) {
            return false;
        }
    }
    return true;
}

if (!isAppInstalled()) {
    header('Location: installer.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Calendario713 - Página de Inicio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <meta name="description" content="Calendario escolar de la escuela 713">
    <meta name="keywords" content="calendario, fechas importantes, calendario escolar, calendario713">
    <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/calendar.css">
</head>

<body>
    <header class="container">
        <h1 class="text-center">Calendario713</h1>
        <nav class="d-flex justify-content-end">
            <a href="login.php" class="btn btn-primary me-2">Iniciar Sesion</a>
            <a href="register.php" class="btn btn-secondary">Registrarme</a>
        </nav>
    </header>
    <main class="container">
        <?php
        require("php/generateCalendar.php");
        ?>
    </main>
    <footer class="container text-center mt-4">
        <p>&copy; <?php echo date("Y"); ?> Calendario713</p>
    </footer>
    <script>
        function isToday(date) {
            const today = new Date();
            return (
                date.getDate() === today.getDate() &&
                date.getMonth() === today.getMonth() &&
                date.getFullYear() === today.getFullYear()
            );
        }

        fetch('php/jsonGenerateCalendar.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                const esLocale = 'es-ES';
                const dateFormatter = new Intl.DateTimeFormat(esLocale, {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });

                data.forEach(event => {
                    const eventDate = new Date(event.Fecha + 'T00:00:00');
                    const eventName = event.Titulo;
                    const eventType = event.tipo;
                    const matchingCells = document.querySelectorAll(`td[data-date="${event.Fecha}"]`);

                    matchingCells.forEach(cell => {
                        cell.classList.add(eventType);
                        const table = cell.closest('table');
                        const divSiguiente = table.nextElementSibling;
                        if (divSiguiente && divSiguiente.tagName === 'DIV') {
                            const formattedDate = dateFormatter.format(eventDate);
                            divSiguiente.innerHTML += `<p><i class="fas fa-bookmark"></i> ${formattedDate} - ${eventName} (${eventType})</p>`;
                        } else {
                            console.log('No se encontró un div siguiente a la tabla.');
                        }
                    });
                });
            })
            .catch(e => {
                console.log(e.message);
            });

        function addTodayClassToCells() {
            const cells = document.querySelectorAll('td[data-date]');
            const today = new Date();
            console.log('Today:', today);

            cells.forEach(cell => {
                const cellDateAttribute = cell.getAttribute('data-date');
                console.log('Cell Date Attribute:', cellDateAttribute);


                const cellDate = new Date(cellDateAttribute);
                if (today.toDateString() === cellDate.toDateString()) {
                    cell.classList.add('today');
                }
            });
        }
        const dateFormatter = new Intl.DateTimeFormat('es-ES', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        const addDate = () => {
            const table = document.querySelector('table');
            const divSiguiente = table.nextElementSibling;
            if (divSiguiente && divSiguiente.tagName === 'DIV') {
                const formattedDate = dateFormatter.format(new Date());
                divSiguiente.innerHTML += `<p class="txcenter"><i class="fa-solid fa-calendar" style="color: #50e259;"></i> Hoy Es: ${formattedDate}</p>`;
            } else {
                console.log('No se encontró un div siguiente a la tabla.');
            }
        };

        document.addEventListener('DOMContentLoaded', addDate);
        document.addEventListener('DOMContentLoaded', addTodayClassToCells);
    </script>
</body>

</html>
