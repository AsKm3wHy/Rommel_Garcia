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
        groupId: "999",
        title: "Repeating Event",
        start: "2025-01-09T16:00:00",
      },
      {
        groupId: "999",
        title: "Repeating Event",
        start: "2025-01-16T16:00:00",
      },

      {
        title: "Meeting",
        start: "2025-01-12T10:30:00",
        end: "2025-01-12T12:30:00",
      },
      {
        title: "Lunch",
        start: "2025-01-12T12:00:00",
      },
      {
        title: "Meeting",
        start: "2025-01-12T14:30:00",
      },
      {
        title: "Birthday Party",
        start: "2025-01-13T07:00:00",
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
