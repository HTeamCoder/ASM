$(document).ready(function () {
    if (!jQuery().fullCalendar) {
        return;
    }

    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    var h = {};

    if ($('#calendar').width() <= 400) {
        $('#calendar').addClass("mobile");
        h = {
            left: 'title, prev, next',
            center: '',
            right: 'today,month,agendaWeek,agendaDay'
        };
    } else {
        $('#calendar').removeClass("mobile");
        if (Metronic.isRTL()) {
            h = {
                right: 'title',
                center: '',
                left: 'prev,next,today,month,agendaWeek,agendaDay'
            };
        } else {
            h = {
                left: 'title',
                center: '',
                right: 'prev,next,today,month,agendaWeek,agendaDay'
            };
        }
    }
    $('#calendar').fullCalendar('destroy'); // destroy the calendar
    $('#calendar').fullCalendar({ //re-initialize the calendar
        disableDragging : false,
        header: h,
        selectable: true,
        selectHelper: true,
        select: function(start, end) {
            
            var eventData;
            var title;
            if (title) {
                // alert(start);
                // alert(end);
                eventData = {
                    title: title,
                    start: start,
                    end: end
                };
                $('#calendar').fullCalendar('renderEvent', eventData, true); // stick? = true
            }
            // $('#calendar').fullCalendar('unselect');
        },
        editable: true,
        // eventLimit: true,
        lang: 'vi',

        events: function(start, end, timezone, callback) {
            $.ajax({
                url: 'index.php?r=site/getlichthidonhang',

                success: function(data) {
                    data = JSON.parse(data);
                    var events = [];
                    var background = ['#44b6ae','#8775a7','#e35b5a','#578ebe','#8895a9','#dfba49','#89c4f4'];
                    $.each(data, function(i,item) {
                        // alert( i + ": " + item['ngaydat'] );
                        events.push({
                            title: item['name'],
                            start: item['ngaythi'], // will be parsed
                            dataid: item['id'],
                            backgroundColor:background[Math.floor(Math.random() * background.length)]
                        });
                    });
                    callback(events);
                }
            });
        }
    });
});
