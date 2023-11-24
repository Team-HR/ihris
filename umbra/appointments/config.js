new Vue({
  el: "#app",
  data: {
    Employees: [],
    All_Employees: [],
    Plantilla: [],
    employees_id: null,
    waitLoad: "loading",
    // employees_id: "",
    plantilla_id: "",
    reason_of_vacancy: "",
    status_of_appointment: "",
    csc_authorized_official: "Dir. Merlinda F. Quillano",
    date_signed_by_csc: "",
    committee_chair: 42214,
    date_of_appointment: "",
    date_of_assumption: "",
    csc_mc_no: "",
    series_no: "",
    HRMO: 21805,
    office_assignment: "",
    nature_of_appointment: "",
    date_of_signing: "",
    deliberation_date_from: "",
    deliberation_date_to: "",
    published_at: "CSC Job Portal ",
    posted_in: "BVP",
    govId_type: "",
    govId_no: "",
    govId_issued_date: "",
    posted_date_from: "",
    posted_date_to: "",
    csc_release_date: "",
    sworn_date: "",
    cert_issued_date: "",
    casual_promotion: "",
    probationary_period: "",
    date_of_last_promotion: "",
  },
  watch: {
    Plantilla(val) {
      this.reason_of_vacancy = val.reason_of_vacancy;
    },
  },
  computed: {
    isVacant() {
      return this.Plantilla.incumbent != 0 ? false : true;
    },
    incumbentName() {
      return this.Plantilla.incumbent_appointment
        ? this.Plantilla.incumbent_appointment.lastName +
            ", " +
            this.Plantilla.incumbent_appointment.firstName +
            " " +
            this.Plantilla.incumbent_appointment.middleName +
            " " +
            this.Plantilla.incumbent_appointment.extName
        : "";
    },
  },
  methods: {
    getEmployees() {
      $.post(
        "umbra/appointments/config.php",
        {
          Employees: true,
        },
        (data) => {
          const res = JSON.parse(data);
          // console.log(res);
          this.Employees = res.Employees;
          this.All_Employees = res.All_Employees;
        }
      );
    },
    get_plantilla() {
      const dataId =
        document.getElementById("appointments_form").attributes["data-id"]
          .value;
      this.plantilla_id = dataId;
      // console.log(this.plantilla_id);
      $.post("umbra/appointments/config.php", { Plantilla: dataId }, (data) => {
        const res = JSON.parse(data);
        // console.log(res);
        if (res.status) {
          this.Plantilla = res.dat;
          this.employees_id = this.Plantilla.incumbent_appointment
            ? this.Plantilla.incumbent_appointment.employees_id
            : null;

          if (this.Plantilla.incumbent != 0) {
            this.Employees.push({
              employees_id: this.Plantilla.incumbent_appointment.employees_id,
              extName: this.Plantilla.incumbent_appointment.extName,
              firstName: this.Plantilla.incumbent_appointment.firstName,
              lastName: this.Plantilla.incumbent_appointment.lastName,
              middleName: this.Plantilla.incumbent_appointment.middleName,
            });

            // edit input start
            // saveAppointment: true,
            // this.employees_id = this.Plantilla.incumbent_appointment.employees_id
            // this.plantilla_id = this.Plantilla.incumbent_appointment.plantilla_id
            // this.reason_of_vacancy = this.Plantilla.incumbent_appointment.reason_of_vacancy
            this.status_of_appointment =
              this.Plantilla.incumbent_appointment.status_of_appointment;
            $("#status_of_appointment").dropdown(
              "set selected",
              this.status_of_appointment
            );
            this.csc_authorized_official =
              this.Plantilla.incumbent_appointment.csc_authorized_official;
            this.date_signed_by_csc =
              this.Plantilla.incumbent_appointment.date_signed_by_csc;
            this.committee_chair =
              this.Plantilla.incumbent_appointment.committee_chair;
            $("#committee_chair").dropdown(
              "set selected",
              this.committee_chair
            );
            this.date_of_appointment =
              this.Plantilla.incumbent_appointment.date_of_appointment;
            this.date_of_assumption =
              this.Plantilla.incumbent_appointment.date_of_assumption;
            this.csc_mc_no = this.Plantilla.incumbent_appointment.csc_mc_no;
            this.series_no = this.Plantilla.incumbent_appointment.series_no;
            this.HRMO = this.Plantilla.incumbent_appointment.HRMO;
            $("#HRMO").dropdown("set selected", this.HRMO);
            this.office_assignment =
              this.Plantilla.incumbent_appointment.office_assignment;
            this.nature_of_appointment =
              this.Plantilla.incumbent_appointment.nature_of_appointment;
            $("#nature_of_appointment").dropdown(
              "set selected",
              this.nature_of_appointment
            );
            this.date_of_signing =
              this.Plantilla.incumbent_appointment.date_of_signing;
            this.deliberation_date_from =
              this.Plantilla.incumbent_appointment.deliberation_date_from;
            this.deliberation_date_to =
              this.Plantilla.incumbent_appointment.deliberation_date_to;
            this.published_at =
              this.Plantilla.incumbent_appointment.published_at;
            this.posted_in = this.Plantilla.incumbent_appointment.posted_in;
            this.govId_type = this.Plantilla.incumbent_appointment.govId_type;
            this.govId_no = this.Plantilla.incumbent_appointment.govId_no;
            this.govId_issued_date =
              this.Plantilla.incumbent_appointment.govId_issued_date;
            this.posted_date_from =
              this.Plantilla.incumbent_appointment.posted_date_from;
            this.posted_date_to =
              this.Plantilla.incumbent_appointment.posted_date_to;
            this.csc_release_date =
              this.Plantilla.incumbent_appointment.csc_release_date;
            this.sworn_date = this.Plantilla.incumbent_appointment.sworn_date;
            this.cert_issued_date =
              this.Plantilla.incumbent_appointment.cert_issued_date;
            this.casual_promotion =
              this.Plantilla.incumbent_appointment.casual_promotion;
            this.probationary_period =
              this.Plantilla.incumbent_appointment.probationary_period;
            this.date_of_last_promotion =
              this.Plantilla.incumbent_appointment.date_of_last_promotion;
            // edit input end
          }

          this.waitLoad = "";
        } else {
          this.waitLoad = "";
          // $("body").toast({
          //   position: "top center",
          //   class: "warning",
          //   title: "Opps!! Can't Overwrite",
          //   message:
          //     "There is an Existing Data pls Vacate<br>Please wait redirecting",
          // });
          // setTimeout(() => {
          //   window.location.href = "plantilla.php";
          // }, 3000);
        }
      });
    },
    formatNumber(num) {
      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
    },
    saveAppointment() {
      if (!this.employees_id) {
        $("body").toast({
          position: "top center",
          class: "error",
          title: "No Employee Selected",
          message: "Please Select an Employee and Confirm",
        });
        window.location.href = "#headerAppoint";
      } else {
        // console.log({
        //   saveAppointment: true,
        //   appointment_id: this.Plantilla.incumbent,
        //   employees_id: this.employees_id,
        //   plantilla_id: this.plantilla_id,
        //   reason_of_vacancy: this.reason_of_vacancy,
        //   status_of_appointment: this.status_of_appointment,
        //   csc_authorized_official: this.csc_authorized_official,
        //   date_signed_by_csc: this.date_signed_by_csc,
        //   committee_chair: this.committee_chair,
        //   date_of_appointment: this.date_of_appointment,
        //   date_of_assumption: this.date_of_assumption,
        //   csc_mc_no: this.csc_mc_no,
        //   series_no: this.series_no,
        //   HRMO: this.HRMO,
        //   office_assignment: this.office_assignment,
        //   nature_of_appointment: this.nature_of_appointment,
        //   date_of_signing: this.date_of_signing,
        //   deliberation_date_from: this.deliberation_date_from,
        //   deliberation_date_to: this.deliberation_date_to,
        //   published_at: this.published_at,
        //   posted_in: this.posted_in,
        //   govId_type: this.govId_type,
        //   govId_no: this.govId_no,
        //   govId_issued_date: this.govId_issued_date,
        //   posted_date_from: this.posted_date_from,
        //   posted_date_to: this.posted_date_to,
        //   csc_release_date: this.csc_release_date,
        //   sworn_date: this.sworn_date,
        //   cert_issued_date: this.cert_issued_date,
        //   casual_promotion: this.casual_promotion,
        //   probationary_period: this.probationary_period,
        //   date_of_last_promotion: this.date_of_last_promotion,
        // });
        // return false;
        this.waitLoad = "loading";
        $.post(
          "umbra/appointments/config.php",
          {
            saveAppointment: true,
            appointment_id: this.Plantilla.incumbent,
            employees_id: this.employees_id,
            plantilla_id: this.plantilla_id,
            reason_of_vacancy: this.reason_of_vacancy,
            status_of_appointment: this.status_of_appointment,
            csc_authorized_official: this.csc_authorized_official,
            date_signed_by_csc: this.date_signed_by_csc,
            committee_chair: this.committee_chair,
            date_of_appointment: this.date_of_appointment,
            date_of_assumption: this.date_of_assumption,
            csc_mc_no: this.csc_mc_no,
            series_no: this.series_no,
            HRMO: this.HRMO,
            office_assignment: this.office_assignment,
            nature_of_appointment: this.nature_of_appointment,
            date_of_signing: this.date_of_signing,
            deliberation_date_from: this.deliberation_date_from,
            deliberation_date_to: this.deliberation_date_to,
            published_at: this.published_at,
            posted_in: this.posted_in,
            govId_type: this.govId_type,
            govId_no: this.govId_no,
            govId_issued_date: this.govId_issued_date,
            posted_date_from: this.posted_date_from,
            posted_date_to: this.posted_date_to,
            csc_release_date: this.csc_release_date,
            sworn_date: this.sworn_date,
            cert_issued_date: this.cert_issued_date,
            casual_promotion: this.casual_promotion,
            probationary_period: this.probationary_period,
            date_of_last_promotion: this.date_of_last_promotion,
          },
          (data) => {
            const res = JSON.parse(data);
            $("body").toast({
              position: "top center",
              class: res.color,
              message: res.msg,
            });
            if (res.status) {
              // setTimeout(() => {
              window.location.href = "plantilla.php";
              // }, 3000);
            } else {
              this.waitLoad = "";
            }
          }
        );
      }
    },
  },

  mounted() {
    var interval = setInterval(() => {
      if (document.readyState == "complete") {
        this.getEmployees();
        this.get_plantilla();
        // console.log("mounted(): ", this.Plantilla);
        clearInterval(interval);
      }
    }, 1000);
    $(".dropdown").dropdown({
      fullTextSearch: true,
    });
  },
});
