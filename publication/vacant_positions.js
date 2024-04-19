Date.prototype.toDateInputValue = function () {
  var local = new Date(this);
  local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
  return local.toJSON().slice(0, 10);
};

new Vue({
  el: "#app",
  data: {
    plantillas: [],
    date_of_publication: "",
    date_of_deadline: "",
  },
  methods: {
    init() {
      $.ajax({
        type: "post",
        url: "plantilla_vacantpos_proc.php",
        data: { load: true },
        dataType: "json",
        success: (response) => {
          this.plantillas = response;
        },
        async: false,
      });
    },

    formatFunc(str) {
      func = "";
      if (str == "" || str == null) return func;
      func = "(" + str + ")";
      return func;
    },

    publish(plantilla_id) {
      $.ajax({
        type: "post",
        url: "plantilla_vacantpos_proc.php",
        data: { publish: true, plantilla_id: plantilla_id },
        dataType: "json",
        success: (response) => {
          console.log(response);
          if (response.length === 0)
            this.plantillas["id_" + plantilla_id].isPublished = true;
          this.toasted(true);
        },
      });
    },
    restore(plantilla_id) {
      $.ajax({
        type: "post",
        url: "plantilla_vacantpos_proc.php",
        data: { restore: true, plantilla_id: plantilla_id },
        dataType: "json",
        success: (response) => {
          console.log(response);
          if (response.length === 0)
            this.plantillas["id_" + plantilla_id].isPublished = false;
          this.toasted(false);
        },
      });
    },

    toasted(published) {
      $("body").toast({
        title: published ? "Item Published!" : "Item Restored!",
        class: published ? "success" : "warning",
        message: published
          ? "Item ready for publication!"
          : "Item ready for placement!",
        showProgress: "bottom",
        classProgress: published ? "green" : "warning",
        position: "bottom right",
        className: {
          toast: "ui mini message",
        },
      });
    },
    generateFile() {
      $("#generateFileModal")
        .modal("show")
        .modal({
          onApprove: () => {
            var win = window.open(
              "publication_report_gen.php?date_of_publication=" +
                this.date_of_publication +
                "&date_of_deadline=" +
                this.date_of_deadline,
              "_blank"
            );
            // win.focus();
          },
        });
    },
  },
  mounted() {
    this.init();
    this.date_of_publication = new Date().toDateInputValue();
    this.date_of_deadline = new Date().toDateInputValue();

    $("#data_search").on("keyup", function () {
      var value = $(this).val().toLowerCase();
      $("#tableBody tr").filter(function () {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
      });
    });
  },
});
