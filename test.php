<?php
    require_once "_connect.db.php";
    require "header.php";
?>

<div class="ui container" style="background-color: white;padding:10px">
    <div id="calen"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded',function(){
        var calendarEl = document.getElementById('calen');
        var calendar = new FullCalendar.Calendar(calendarEl,{
            plugins:['dayGrid','interaction'],
            dateClick:function(info){
                calendar.addEvent({start:info.dateStr,title:"char"})
            },
            events: [
            {
            title  : 'event1',
            start  : '2021-01-01'
            },
            {
            title  : 'event2',
            start  : '2021-01-05',
            end    : '2021-01-07'
            },
            {
            title  : 'event3',
            start  : '2021-01-09T12:30:00',
            allDay : false // will make the time show
            }
        ]
        });
        calendar.render();
    });
</script>


<?
    require_once "footer.php";
?>