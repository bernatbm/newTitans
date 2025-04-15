document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;
  
    const calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',     
      windowResize: true,     
      locale: 'es',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      events: '../api/reservas_calendario.php',
      eventClick: function(info) {
        const p = info.event.extendedProps;
        let detalles = `📅 Reserva ${info.event.id}\n\n`;
  
        for (const [clave, valor] of Object.entries(p)) {
          if (valor !== null && valor !== '') {
            const formateado = clave.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
            detalles += `${formateado}: ${valor}\n`;
          }
        }
  
        alert(detalles);
      }
    });
  
    calendar.render();
  });