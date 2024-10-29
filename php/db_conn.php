<?php
$servername = "localhost";
$username = "cale_713";
$password = "@tNKq9l8q0!AujF%";
$dbname = "cale_calendario713";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}
function generateCalendar($month, $year)
{
    $month = max(1, min(12, $month));
    $year = max(1, $year);
    $daysOfWeek = array('Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom');
    $monthId = "{$year}-{$month}";
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $firstDay = date('N', strtotime("$year-$month-01"));
    $monthName = DateTime::createFromFormat('!m', $month)->format('F');
    echo "<div class='calendar-navigation'>";
    echo "<a href='?month=" . ($month - 1) . "&year=$year'><i class='fa-solid fa-arrow-left'></i></a>";
    echo "<span class='txcenter'>$monthName $year</span>";
    if($month < 12){
        echo "<a href='?month=" . ($month + 1) . "&year=$year'><i class='fa-solid fa-arrow-right'></i></a>";
    }
    if ($month == 12) {
        echo "<a href='?month=1&year=" . ($year + 1) . "'>Siguiente Año <i class='fa-solid fa-arrow-right'></i></a>";
    }
    echo "</div>";
    echo "<table id='$monthId'>";
    echo "<tr>";
    foreach ($daysOfWeek as $day) {
        echo "<th>$day</th>";
    }
    echo "</tr>";
    echo "<tr>";
    $currentDay = 1;
    for ($i = 1; $i < $firstDay; $i++) {
        echo "<td></td>";
    }
    while ($currentDay <= $daysInMonth) {
        for ($i = $firstDay; $i <= 7; $i++) {
            echo "<td data-date='$year-$month-$currentDay' class=''>";
            if ($currentDay <= $daysInMonth) {
                echo $currentDay;
                $currentDay++;
            }
            echo "</td>";
        }
        if ($currentDay <= $daysInMonth) {
            echo "</tr><tr>";
        }
        $firstDay = 1;
    }
    echo "</tr>";
    echo "</table>";
    echo "<div id='$monthId'></div>";
}

$year = isset($_GET['year']) ? $_GET['year'] : date('Y');
$month = isset($_GET['month']) ? $_GET['month'] : date('n');

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
