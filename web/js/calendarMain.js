
$(document).ready(function () {
    $('.loader').hide();

    /*
     Paramètres du calendar
     L'affichaque des données est fait directement
     dans full calendar ligne 5580
     */
    $('#calendar').fullCalendar({
        lazyFetching:true,
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        eventLimit: true,
        selectHelper: true,
        minTime: "05:00:00",
        maxTime: "23:00:00",
        eventRender: function (event, element) {
            // Activier le popover de bootstrap sur les labels
            element.popover({html:true});
        },
        events: function (start, end, timezone, callback) {

            $('.loader').show();
           $.ajax({
                type: "POST",
                url: Routing.generate('agil_hall_calendar_data'),
                cache:true,
                dataType: 'json',
                data: {
                    start: moment(start).format('YYYY-MM-DD'),
                    end: moment(end).format('YYYY-MM-DD')
                },


                // Requête ajax
                success: function (doc) {
                    $('.loader').hide();
                    var events = [];
                    $.each(doc, function (key, value) {
                        // Ajouts d'un événement dans la liste d'événements
                        // à afficher
                        events.push({
                            title: value.eventTitle,
                            start: value.eventDate.date,
                            end:   value.eventDateEnd.date,
                            eventId:    value.eventId,
                            description : value.eventText
                        });
                    });
                    callback(events);
                }
            });
        }
    })
});

