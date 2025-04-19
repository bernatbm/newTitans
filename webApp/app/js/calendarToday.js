
    var calendarEl = document.getElementById('calendarToday');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'timeGridDay',  // Muestra solo el día actual con horas
      initialDate: new Date(),     // Asegura que sea hoy
      headerToolbar: {
        left: '',
        center: 'title',
        right: ''
      },
      height: 'auto',
      locale: 'es' // Puedes cambiar el idioma
    });

    calendar.render();
  
