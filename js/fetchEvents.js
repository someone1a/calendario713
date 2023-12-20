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
        function obtenerProximoEvento(data) {
            let hoy = new Date();
            for (let i = 0; i < data.length; i++) {
                let fechaEvento = new Date(data[i].fecha);
                if (hoy <= fechaEvento) {
                    return data[i];
                }
            }
            return null;
        }

        function iniciarConteoRegresivo(proximoEvento) {
            let show = document.getElementById("show");
            let intervalo = setInterval(function () {
                let ahora = new Date().getTime();
                let distancia = new Date(proximoEvento.fecha).getTime() - ahora;
                let dias = Math.floor(distancia / (1000 * 60 * 60 * 24));
                let horas = Math.floor((distancia % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let minutos = Math.floor((distancia % (1000 * 60 * 60)) / (1000 * 60));
                let segundos = Math.floor((distancia % (1000 * 60)) / 1000);
                show.innerHTML = `Faltan ${dias} dias, ${horas} horas, ${minutos} minutos,${segundos} segundos para  ${proximoEvento.evento}`;
                if (distancia < 0) {
                    clearInterval(intervalo);
                    console.log("El evento ha comenzado!");
                }
            }, 1000);
        }

        let proximoEvento = obtenerProximoEvento(data);
        if (proximoEvento) {
            iniciarConteoRegresivo(proximoEvento);
        } else {
            console.log("No hay más eventos programados.");
            show.innerHTML = `No hay ningun Evento`;
        }
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