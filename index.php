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
</head>

<body>
    <header>
        <h1>Calendario713</h1>
        <nav>
        </nav>
    </header>
    <main class="container">
        <?php
        require("php/generateCalendar.php");
        ?>
    </main>
    <footer>
        <footer>
            <p>&copy; <?php echo date("Y"); ?> Calendario713</p>
        </footer>
    </footer>
    <script>
        const cells = document.querySelectorAll('td[data-date]')
        const today = new Date()
        today.setHours(0, 0, 0, 0)
        cells.forEach(cell => {
            const cellDate = new Date(cell.getAttribute('data-date') + 'T00:00:00')
            if (cellDate.getTime() === today.getTime()) {
                cell.classList.add('today')
            }
        });
    </script>
</body>

</html>