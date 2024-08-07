var sr_app = new Vue({
  el: "#app_sr",
  data() {
    return {
      id_for_editing: null,
      record_types: [
        "APPOINTMENT",
        "BUILD-UP",
        "DEATH",
        "END OF CASUAL EMP.",
        "END OF TERM",
        "RESIGNATION",
        "RETIREMENT",
        "SALARY ADJUSTMENT",
        "STEP INCREMENT"
      ],
      statuses: [
        "APPOINTED",
        "ADD-IN",
        "CASUAL",
        "CO-TERMINOUS",
        "CONTRACTUAL/JOB ORDER",
        "ELECTIVE",
        "PERMANENT",
        "PROVISIONARY",
        "SUBSTITUTE",
        "TEMPORARY"
      ],
      salaries: [],
      positions: [],
      place_of_assignments: [],
      records: [],
      sr_type: "",
      sr_designation: "",
      sr_status: "",
      sr_salary_type: "for_buildup",
      sr_salary_rate: "",
      sr_rate_on_schedule: "",
      sr_is_per_session: "",
      sr_date_from: "",
      sr_date_to: "",
      sr_place_of_assignment: "",
      sr_branch: "",
      sr_remarks: "",
      sr_memo: "",
      employee_id: 0,
      remarks_history: [],
    };
  },
  computed: {
    is_casual() {
      return this.sr_status === "";
    }
  },
  methods: {
    init_load() {
      $.ajax({
        type: "GET",
        url: "umbra/service_record/config.php",
        data: {
          init_load: true,
          employee_id: this.employee_id
        },
        dataType: "json",
        success: response => {
          this.records = response;
        },
        async: false
      });
      this.get_positions();
      this.get_salaries();
      this.get_place_of_assignments();
    },
    get_salaries() {
      $.ajax({
        type: "post",
        url: "umbra/service_record/config.php",
        data: {
          get_salaries: true
        },
        dataType: "json",
        success: response => {
          this.salaries = response;
        },
        async: false
      });
    },
    get_place_of_assignments() {
      $.ajax({
        type: "GET",
        url: "umbra/service_record/config.php",
        data: {
          get_place_of_assignments: true
        },
        dataType: "json",
        success: response => {
          this.place_of_assignments = response;
        },
        async: false
      });
    },
    get_positions() {
      $.ajax({
        type: "GET",
        url: "umbra/service_record/config.php",
        data: {
          get_positions: true
        },
        dataType: "json",
        success: response => {
          this.positions = response;
        },
        async: false
      });
    },
    clear_form() {
      $("#add_edit_form").form("reset");
      $(".ui .dropdown").dropdown("clear");
      this.sr_type = "";
      this.sr_designation = "";
      this.sr_status = "";
      this.sr_salary_type = "for_buildup";
      $("#sr_salary_type").dropdown("set selected", this.sr_salary_type);
      this.sr_salary_rate = "";
      this.sr_rate_on_schedule = "";
      this.sr_is_per_session = "";
      this.sr_date_from = "";
      this.sr_date_to = "";
      this.sr_place_of_assignment = "";
      this.sr_branch = "";
      this.sr_remarks = "";
      this.sr_memo = "";
    },
    init_add() {
      this.id_for_editing = null;
      $("#addSR").modal("show");
    },
    init_edit(index) {
      this.id_for_editing = this.records[index].id;
      var sr = this.records[index];

      // console.log(sr);
      this.sr_type = sr.sr_type;

      $("#sr_type").dropdown("set selected", this.sr_type);
      this.sr_designation = sr.sr_designation;
      $("#sr_designation").dropdown("set selected", this.sr_designation);
      this.sr_status = sr.sr_status;
      $("#sr_status").dropdown("set selected", this.sr_status);

      // this.sr_salary_rate?this.sr_salary_rate:this.sr_rate_on_schedule;
      // var type = "";
      if (sr.sr_salary_rate) {
        this.sr_salary_type = "for_buildup";
      } else if (sr.sr_rate_on_schedule) {
        this.sr_salary_type = "rate_on_schedule";
      }

      $("#sr_salary_type").dropdown("set selected", this.sr_salary_type);

      // sr_salary_type
      this.sr_salary_rate = sr.sr_salary_rate;
      this.sr_rate_on_schedule = sr.sr_rate_on_schedule;
      // console.log(this.sr_rate_on_schedule);
      $("#sr_rate_on_schedule").dropdown(
        "set selected",
        this.sr_rate_on_schedule
      );
      this.sr_is_per_session = sr.sr_is_per_session;
      $("#sr_is_per_session").dropdown("set selected", this.sr_is_per_session);
      this.sr_date_from = sr.sr_date_from;
      this.sr_date_to = sr.sr_date_to;
      this.sr_place_of_assignment = sr.sr_place_of_assignment;
      $("#sr_place_of_assignment").dropdown(
        "set selected",
        this.sr_place_of_assignment
      );
      this.sr_branch = sr.sr_branch;
      $("#sr_branch").dropdown("set selected", this.sr_branch);
      this.sr_remarks = sr.sr_remarks;
      this.sr_memo = sr.sr_memo;
      $("#addSR").modal("show");
    },
    init_delete(index) {
      var that = this;
      $("#delete_modal").modal({
        onApprove: () => {
          $.ajax({
            type: "post",
            url: "umbra/service_record/config.php",
            data: {
              init_delete: true,
              id: this.records[index].id
            },
            dataType: "json",
            success: response => {
              if (response > 0) this.records.splice(index, 1);
            }
          });
        },
        duration: 0
      });
      $("#delete_modal").modal("show");
    },

    submit_form() {
      $("#add_edit_form").form({
        fields: {
          sr_type: "empty",
          sr_designation: "empty",
          sr_status: "empty",
          sr_date_from: "empty",
          sr_place_of_assignment: "empty",
          sr_branch: "empty",
          sr_remarks: "empty"
          // sr_memo: 'empty',
        },
        inline: true,
        // on: 'submit',
        shouldTrim: false,
        onSuccess: (event, fields) => {
          if (this.sr_salary_type === "for_buildup") {
            this.sr_rate_on_schedule = "";
          } else {
            this.sr_salary_rate = "";
          }

          var data = {
            employee_id: this.employee_id,
            sr_type: this.sr_type,
            sr_designation: this.sr_designation,
            sr_status: this.sr_status,
            sr_salary_rate: this.sr_salary_rate,
            sr_rate_on_schedule: this.sr_rate_on_schedule,
            sr_is_per_session: this.sr_is_per_session,
            sr_date_from: this.sr_date_from,
            sr_date_to: this.sr_date_to,
            sr_place_of_assignment: this.sr_place_of_assignment,
            sr_branch: this.sr_branch,
            sr_remarks: this.sr_remarks,
            sr_memo: this.sr_memo
          };

          $.ajax({
            type: "post",
            url: "umbra/service_record/config.php",
            data: {
              submit_form: true,
              id_for_editing: this.id_for_editing,
              data: data
            },
            dataType: "json",
            success: response => {
              $("#addSR").modal("hide");
              this.clear_form();
              this.init_load();
              this.get_remarks();
            },
            async: false
          });
        }
      });
      $("#add_edit_form").form("validate form");
    },
    format_date(date) {
      if (date == "") return "To Present";
      var _date = moment(date).format("MMM DD,YYYY");
      return _date;
    },
    get_remarks() {
      // var remarks_history = []
      $.ajax({
        type: "post",
        url: "umbra/service_record/config.php",
        data: {
          get_remarks: true,
        },
        dataType: "json",
        success: data => {
          this.remarks_history = data
          // console.log("remarks this",this.remarks_history);
        },
        async: false
      });
      // this.remarks_history = Object.assign([], remarks_history)
    }
  },
  mounted() {
    // $("#add_edit_form").submit(function (e) {
    //     e.preventDefault()
    // })
    var queryString = window.location.search;
    var urlParams = new URLSearchParams(queryString);
    var employee_id = urlParams.get("employees_id");
    this.employee_id = employee_id;
    this.init_load();

    $("#addSR").modal({
      closable: false,
      duration: 0
    });

    $("#sr_type").dropdown({
      showOnFocus: false,
      onShow() {
        $("#designation_el").dropdown("hide others");
      }
    });

    $("#sr_designation").dropdown({
      clearable: true,
      fullTextSearch: true,
      allowAdditions: true,
      forceSelection: true,
      showOnFocus: false,
      hideAdditions: false
    });

    $("#sr_status").dropdown({
      showOnFocus: false
    });

    $("#sr_is_per_session").dropdown({
      showOnFocus: false
    });

    // $("#sr_salary_type").dropdown();
    $("#sr_salary_type").dropdown("set selected", "for_buildup");

    $("#sr_rate_on_schedule").dropdown({
      clearable: true,
      keepOnScreen: false,
      showOnFocus: false,
      fullTextSearch: "exact",
      allowAdditions: true
    });

    $("#sr_place_of_assignment").dropdown({
      clearable: true,
      allowAdditions: true,
      showOnFocus: false
    });

    $("#sr_branch").dropdown({
      showOnFocus: false
    });

    this.get_remarks()

    var input = document.getElementById("sr_remarks");
    autocomplete({
      input: input,
      fetch: (text, update) => {
        text = text.toLowerCase();
        // you can also use AJAX requests instead of preloaded data
        var suggestions = this.remarks_history.filter(n => n.label.toLowerCase().startsWith(text))
        update(suggestions);
      },
      onSelect: (item) => {
        // input.value = item.label;
        this.sr_remarks = item.value
      }
    });
  }
});

// var input = $("#sr_remarks");

// autocomplete({
//   input: input,
//   fetch: function (text, update) {
//     text = text.toLowerCase();
//     // you can also use AJAX requests instead of preloaded data
//     var suggestions = this.remarks_history.filter(n => n.label.toLowerCase().startsWith(text))
//     update(suggestions);
//   },
//   onSelect: function (item) {
//     input.value = item.label;
//   }
// });