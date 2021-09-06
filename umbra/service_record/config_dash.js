var sr_app = new Vue({
  el: "#app_sr",
  data() {
    return {
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
    var queryString = window.location.search;
    var urlParams = new URLSearchParams(queryString);
    var employee_id = urlParams.get("employees_id");
    this.employee_id = employee_id;
    this.init_load();
    this.get_remarks()
  }
});