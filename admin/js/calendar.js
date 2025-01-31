document.addEventListener("DOMContentLoaded", function () {
  var calendarEl = document.getElementById("calendar");

  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: "dayGridMonth",
    initialDate: "2025-01-07",
    headerToolbar: {
      left: "prev,next today",
      center: "title",
      right: "dayGridMonth,timeGridWeek,timeGridDay",
    },
    events: [
      {
        title: "Russel ",
        url: "Appointment.php",
        start: "2025-01-25T13:30:00",
      },
      {
        title: "Josh ",
        url: "Appointment.php",
        start: "2025-01-13T09:30:00",
      },
      {
        title: "Ramo ",
        url: "Appointment.php",
        start: "2025-01-16T10:30:00",
      },

      {
        title: "Michael ",
        url: "Appointment.php",
        start: "2025-01-30T14:30:00",
      },
    ],
  });

  calendar.render();
});
