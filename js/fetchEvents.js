function isToday(date) {
    const today = new Date();
    return (
        date.getDate() === today.getDate() &&
        date.getMonth() === today.getMonth() &&
        date.getFullYear() === today.getFullYear()
    );
}

fetch('../php/jsonGenerateCalendar.php')
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        const esLocale = 'es-ES';
        const dateFormatter = new Intl.DateTimeFormat(esLocale, { day: 'numeric', month: 'long', year: 'numeric' });

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
    const cells = document.querySelectorAll('td[data-date]')
    const today = new Date()
    today.setHours(0, 0, 0, 0)

    cells.forEach(cell => {
        const cellDate = new Date(cell.getAttribute('data-date') + 'T00:00:00')
        if (cellDate.getTime() === today.getTime()) {
            cell.classList.add('today')
        }
    });
}

addTodayClassToCells()