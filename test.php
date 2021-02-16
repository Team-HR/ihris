<?php
    require_once "_connect.db.php";
    require "header.php";
?>

<div>
        <label for="">Start</label>
        <input type="date" id="start">
        <label for="">End</label>
        <input type="date" id="end">
        <label for="">title</label>
        <input type="text" id="title">  
        <input type="submit" onClick="addE()">

</div>

<div class="ui container" style="background-color: white;padding:10px">
    <div id="calen"></div>
</div>

<script>
    document.addEventListener('DOMContentLoaded',function(){
        var calendarEl = document.getElementById('calen');
        var calendar = new FullCalendar.Calendar(calendarEl,{
            plugins:['dayGrid','interaction'],
            dateClick:function(info){
                calendar.addEvent({start:info.dateStr,title:"char"});
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
    function addE(){
        s = document.getElementById('start').value;
        e = document.getElementById('end').value;
        t = document.getElementById('title');
        calendar.addEvent({start:s,title:t,end:e});
        return false;
    } 


</script>


<?
    require_once "footer.php";
?>