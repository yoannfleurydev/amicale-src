/**
 * Created by Matthieu.C on 24/02/2016.
 */
$(document).ready(function () {
    /*
     Paramètres du calendar
     L'affichaque des données est fait directement
     dans full calendar ligne 5580
     */
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        eventRender: function (event, element) {
            // Activier le popover de bootstrap sur les labels
            element.popover({html:true});
        },
        events: function (start, end, timezone, callback) {
            $.ajax({
                type: "POST",
                url: Routing.generate('agil_hall_calendar_data'),
                dataType: 'json',
                data: {
                    // our hypothetical feed requires UNIX timestamps
                    start: start.unix(),
                    end: end.unix()
                },
                // Requête ajax
                success: function (doc) {
                    var events = [];
                    $.each(doc, function (key, value) {
                        // Ajouts d'un événement dans la liste d'événements
                        // à afficher
                        events.push({
                            title: value.eventTitle,
                            start: value.eventDate.date,
                            end:   value.eventDateEnd.date,
                            description : value.eventText,
                            allDay : true
                        });
                    });
                    callback(events);
                }
            });
        }
    })
});

