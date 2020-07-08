
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

      publish(plantilla_id){
        $.ajax({
          type: "post",
          url: "plantilla_vacantpos_proc.php",
          data: {publish: true, plantilla_id: plantilla_id},
          dataType: "json",
          success: (response)=>{
            console.log(response);
            if(response.length === 0) this.plantillas['id_'+plantilla_id].isPublished = true;
            this.toasted(true)
          }
        });
      },
      restore(plantilla_id){
        $.ajax({
          type: "post",
          url: "plantilla_vacantpos_proc.php",
          data: {restore: true, plantilla_id: plantilla_id},
          dataType: "json",
          success: (response)=>{
            console.log(response);
            if(response.length === 0) this.plantillas['id_'+plantilla_id].isPublished = false;
            this.toasted(false)
          }
        });
      },

      toasted(published){
        $('body').toast({
          title: published?'Item Published!':'Item Restored!',
          class: published?'success':'warning',
          message: published?'Item ready for publication!':'Item ready for placement!',
          showProgress: 'bottom',
          classProgress: published?'green':'warning',
          position: 'bottom right',
          className: {
            toast: 'ui mini message'
          }
        });
      }
    
    },
    mounted(){
      this.init()
      // console.log(this.plantillas);
    }
  });