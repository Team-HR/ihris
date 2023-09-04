
function Departments(label){
        this.label = label;
        this.render = function (){
        this.el = "<label>"+this.label+":</label>";
        return this.el;
  };

}