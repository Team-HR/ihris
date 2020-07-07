
 $("#disBtn").submit(function (e) {
    e.preventDefault();
    $("#publishBtn").attr("disabled", true);
    return true;
  });

  $(document).ready(function() { 

    $("#data_search").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#plantilla_table tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });

  });


  new Vue({
    el: "#app",
    data: {
      plantillas: []
    },
    methods: {
      init(){
        $.ajax({
          type: "post",
          url: "plantilla_vacantpos_proc.php",
          data: {load:true},
          dataType: "json",
          success: (response)=>{
            this.plantillas = response;
          },
          async: false
        });
      },
      formatFunc(str){
        func = "";
        if (str == ""||str == null) return func;
        func = "("+str+")";
        return func;
      },
      publish(el){
        console.log(el);
        $(el).addClass('loading');
        // $("`#${el}`").addClass('loading');
        // $.ajax({
        //   type: "post",
        //   url: "plantilla_vacantpos_proc.php",
        //   data: {publish: true, plantilla_id: plantilla_id},
        //   dataType: "json",
        //   success: (response)=>{
        //     // console.log(response);
        //     // $('#'+el).removeClass('loading');
        //   }
        // });
      }
    },
    mounted(){
      this.init()
      // console.log(this.plantillas);
    }
  });