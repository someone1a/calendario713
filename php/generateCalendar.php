<?php
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
    if ($month < 12) {
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
            echo "<td data-date='$year-$month-$currentDay' class='calendar-cell'>";
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
generateCalendar($month, $year);
?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarCells = document.querySelectorAll('.calendar-cell');
        calendarCells.forEach(function (cell) {
            cell.addEventListener('click', function () {
                const date = this.getAttribute('data-date');
                const event = getEvent(date);
                if (event) {
                    showModal(event);
                } else {
                    showNoEventModal();
                }
            });
        });

        function getEvent(date) {
            // Implement your logic to retrieve the event for the given date
            // Return the event if found, otherwise return null
        }

        function showModal(event) {
            // Implement your logic to show the modal with the event details
        }

        function showNoEventModal() {
            // Implement your logic to show the modal indicating no event
        }
    });
</script>
