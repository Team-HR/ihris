
var objArray = [];

function autoEnter() {
  $(".inputLister").keypress(function(e){
      if (e.which == 13){
        $(".btnLister").click();
      }
  });
}

function Lister(title){

        this.arr = [];
        this.title = title;
        this.input_id = this.title+"Input";
        this.list_id = this.title+"List";
        this.list_el = $("#"+this.list_id);
        this.item_class = this.title+"Item";

        objArray.push(this.title);
        objArray[this.title] = [];

        this.render = function (){


        this.el = "<label>"+this.title+": </label>"+
          "<div class='ui small action input'>"+
          "<input class='inputLister' id='"+this.input_id+"' type='text' placeholder='Enter "+title+" here and click add or hit Enter key to add.'>"+
          "<button onclick='addInput(\""+this.title+"\")' class='ui basic mini button btnLister' type='button'><i class='icon add'></i> Add</button>"+
          "</div>"+
          "<div style='border: 1px solid lightgrey; border-radius: 3px; padding: 5px; margin-top: 5px;'>"+
          "<div id='"+this.list_id+"' class='ui middle aligned bulleted list' style='padding-left: 5px;'>"+
          "<i style='color: lightgrey;'>n/a</i>"+
          "</div>"+
          "</div>";
          return this.el;
        };
    
        this.resetLister = function (){
          objArray[this.title] = [];
          createList(this.title);
        };

    addInput = function(title){
      if (val = $("#"+title+"Input").val()) {
        objArray[title].push(val);
        createList(title);
        $("#"+title+"Input").val("");  
      }
    }

    removeFromList = function(title,index){
      objArray[title].splice(index,1);
      createList(title);
    }

    createList = function(title){
      var item = "";
      $("#"+title+"List").html("");
      $.each(objArray[title], function(index, val) {

       item = "<div class='item'>"+
        "<div class='right floated content'>"+
        "<i class='icon times link' onclick='removeFromList(\""+title+"\",\""+index+"\")'></i>"+
        "</div>"+
        "<div class='content "+title+"Item' ondblclick='this.contentEditable=true;' onblur='this.contentEditable=false; objArray[\""+title+"\"]["+index+"] = this.textContent;'>"+val+"</div>"+
        "</div>";
        // 
        $("#"+title+"List").append(item);
      });


      if (objArray[title] !== null) {
        if (objArray[title].length === 0) {
          $("#"+title+"List").html("<i style='color: lightgrey;'>n/a</i>");
        } 
      } else if (objArray[title] === null){
          $("#"+title+"List").html("<i style='color: lightgrey;'>n/a</i>");
      }


    }

}