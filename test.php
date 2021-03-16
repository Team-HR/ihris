<?php
    require_once "_connect.db.php";
    require "header.php";
?>
<div class="ui container" style="background-color: white;padding:10px">
    <div id="calen"></div>
</div>
<script>
    document.addEventListener('DOMContentLoaded',function(){
        var calendarEl = document.getElementById('sdf');
        var event_id = 0;
        var calendar = new FullCalendar.Calendar(calendarEl,{
            plugins:['dayGrid','interaction'],
            dateClick:function(info){
                e = this.getEvents();
                if(e.length>0){
                    for(c=0;c<e.length;c++){
                        if(e[c].start.toString()==info.date.toString()){
                            evnt = e[c];
                            evnt.remove();
                        }else if(c==e.length-1){
                            calendar.addEvent({start:info.dateStr,title:"Selected",id:event_id});
                            console.log(this.getEvents());
                            event_id++;
                        }
                    }
                }else{
                    calendar.addEvent({start:info.dateStr,title:"Selected",id:event_id});
                    console.log(info);
                    event_id++;
                }
            },
            editable:true
        });
        calendar.render();
    });
</script>
<?
    require_once "footer.php";
?>