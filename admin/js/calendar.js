document.addEventListener("DOMContentLoaded", function () {
  var calendarEl = document.getElementById("calendar");

  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: "dayGridMonth",
    headerToolbar: {
      left: "prev,next today",
      center: "title",
      right: "dayGridMonth,timeGridWeek,timeGridDay",
    },
    events: window.appointmentsData || [],
    eventClick: function(info) {
      // Let FullCalendar handle the navigation (it uses the url property)
      // But open in the same tab
      if (info.event.url) {
        window.location.href = info.event.url;
        info.jsEvent.preventDefault();
      }
    }
  });

  calendar.render();
});
