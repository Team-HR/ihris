"use strict";

var _data;

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

$(document).ready(function () {
  $(".dropdown").dropdown({
    fullTextSearch: true
  });
});
var app = new Vue({
  el: "#app",
  data: (_data = {
    Employees: [],
    All_Employees: [],
    Plantilla: [],
    employees_id: 0,
    waitLoad: "loading"
  }, _defineProperty(_data, "employees_id", ""), _defineProperty(_data, "plantilla_id", ""), _defineProperty(_data, "status_of_appointment", ""), _defineProperty(_data, "csc_authorized_official", "Gina Crucio"), _defineProperty(_data, "date_signed_by_csc", ""), _defineProperty(_data, "committee_chair", 42214), _defineProperty(_data, "date_of_appointment", ""), _defineProperty(_data, "date_of_assumption", ""), _defineProperty(_data, "csc_mc_no", ""), _defineProperty(_data, "series_no", ""), _defineProperty(_data, "HRMO", 21805), _defineProperty(_data, "office_assignment", ""), _defineProperty(_data, "nature_of_appointment", ""), _defineProperty(_data, "date_of_signing", ""), _defineProperty(_data, "deliberation_date_from", ""), _defineProperty(_data, "deliberation_date_to", ""), _defineProperty(_data, "published_at", "CSC Job Portal "), _defineProperty(_data, "posted_in", "BVP"), _defineProperty(_data, "govId_type", ""), _defineProperty(_data, "govId_no", ""), _defineProperty(_data, "govId_issued_date", ""), _defineProperty(_data, "posted_date_from", ""), _defineProperty(_data, "posted_date_to", ""), _defineProperty(_data, "csc_release_date", ""), _defineProperty(_data, "sworn_date", ""), _defineProperty(_data, "cert_issued_date", ""), _defineProperty(_data, "casual_promotion", ""), _defineProperty(_data, "probationary_period", ""), _defineProperty(_data, "date_of_last_promotion", ""), _data),
  methods: {
    getEmployees: function getEmployees() {
      var fd = new FormData();
      fd.append("Employees", true);
      var xml = new XMLHttpRequest();

      xml.onload = function () {
        res = JSON.parse(xml.responseText);
        app.Employees = res.Employees;
        app.All_Employees = res.All_Employees;
      };

      xml.open("POST", "umbra/appointments/config.php", true);
      xml.send(fd);
    },
    get_plantilla: function get_plantilla() {
      dataId = document.getElementById("appointments_form").attributes["data-id"].value;
      app.plantilla_id = dataId;
      var fd = new FormData();
      fd.append("Plantilla", dataId);
      var xml = new XMLHttpRequest();

      xml.onload = function () {
        res = JSON.parse(xml.responseText);

        if (res.status) {
          app.Plantilla = res.dat;
          app.waitLoad = "";
        } else {
          console.log(res.status);
          $("body").toast({
            position: "top center",
            "class": "warning",
            title: "Opps!! Can't Overwrite",
            message: "There is an Existing Data pls Vacate<br>Please wait redirecting"
          });
          setTimeout(function () {
            window.location.href = "plantilla.php";
          }, 3000);
        }
      };

      xml.open("POST", "umbra/appointments/config.php", true);
      xml.send(fd);
    },
    formatNumber: function formatNumber(num) {
      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
    },
    saveAppointment: function saveAppointment() {
      if (!app.employees_id) {
        $("body").toast({
          position: "top center",
          "class": "error",
          title: "No Employee Selected",
          message: "Please Select an Employee and Confirm"
        });
        window.location.href = "#headerAppoint";
      } else {
        var fd = new FormData();
        fd.append("saveAppointment", true);
        fd.append("employees_id", app.employees_id);
        fd.append("plantilla_id", app.plantilla_id);
        fd.append("status_of_appointment", app.status_of_appointment);
        fd.append("csc_authorized_official", app.csc_authorized_official);
        fd.append("date_signed_by_csc", app.date_signed_by_csc);
        fd.append("committee_chair", app.committee_chair);
        fd.append("date_of_appointment", app.date_of_appointment);
        fd.append("date_of_assumption", app.date_of_assumption);
        fd.append("csc_mc_no", app.csc_mc_no);
        fd.append("series_no", app.series_no);
        fd.append("HRMO", app.HRMO);
        fd.append("office_assignment", app.office_assignment);
        fd.append("nature_of_appointment", app.nature_of_appointment);
        fd.append("date_of_signing", app.date_of_signing);
        fd.append("deliberation_date_from", app.deliberation_date_from);
        fd.append("deliberation_date_to", app.deliberation_date_to);
        fd.append("published_at", app.published_at);
        fd.append("posted_in", app.posted_in);
        fd.append("govId_type", app.govId_type);
        fd.append("govId_no", app.govId_no);
        fd.append("govId_issued_date", app.govId_issued_date);
        fd.append("posted_date_from", app.posted_date_from);
        fd.append("posted_date_to", app.posted_date_to);
        fd.append("csc_release_date", app.csc_release_date);
        fd.append("sworn_date", app.sworn_date);
        fd.append("cert_issued_date", app.cert_issued_date);
        fd.append("casual_promotion", app.casual_promotion);
        fd.append("probationary_period", app.probationary_period);
        fd.append("date_of_last_promotion", app.date_of_last_promotion);
        var xml = new XMLHttpRequest();

        xml.onload = function () {
          app.waitLoad = "loading";
          res = JSON.parse(xml.responseText);
          $("body").toast({
            position: "top center",
            "class": res.color,
            message: res.msg
          });

          if (res.status) {
            setTimeout(function () {
              window.location.href = "plantilla.php";
            }, 3000);
          } else {
            app.waitLoad = "";
          }
        };

        xml.open("POST", "umbra/appointments/config.php");
        xml.send(fd);
      }
    }
  },
  mounted: function mounted() {
    var interval = setInterval(function () {
      if (document.readyState == "complete") {
        app.getEmployees();
        app.get_plantilla();
        clearInterval(interval);
      }
    }, 1000);
  }
});