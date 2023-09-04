var duties_app = new Vue({
    el:"#duties_app",
    data:{
        Duties:[],
        positionId:0,
    },watch:{
        positionId:()=>{
            var xml = new XMLHttpRequest();
            var fd = new FormData();
                fd.append('getDuties',duties_app.positionId)
            xml.onload = function(){
                try {
                    duties_app.Duties = JSON.parse(xml.responseText);
                } catch (error) {
                    msg = xml.responseText;
                    if(!msg){
                        msg = "Connection timeout or page has no response"
                    }

                    $('body')
                    .toast({
                        title: 'Something Went Wrong',
                        message: "Response Error: "+msg+"<br>Caught error: "+error,
                        class:'error'
                    });
                }   
            }
            xml.open('POST','umbra/statementOfDutiesPlanttilla/plantilla_detail.php',true)
            xml.send(fd);
        }
    }
})