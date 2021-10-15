

var comparative_data_vue = new Vue({
  el: "#comparative_data_vue",
  data() {
    return {
      rspvac_id: new URLSearchParams(window.location.search).get("rspvac_id"),
      position: {},
      applicants: [],
      applicant: {
        name: '',
        age: '',
        gender: '',
        civil_status: '',
        mobile_no: '',
        address: '',
        education: '',
        school: '',
        trainings: [],
        experiencies: [],
        eligibilities: [],
        awards: [],
        records_infractions: [],
        remarks: ''
      },
      form_training_input: '',
      form_eligibility_input: '',
      form_award_input: '',
      form_records_infraction_input: '',
      form_experience: {
        position: '',
        description: '',
        status: '',
        company: '',
        sector: '',
        date_from: {
          mm: '',
          dd: '',
          yyyy: ''
        },
        date_to: {
          mm: '',
          dd: '',
          yyyy: ''
        },
        years_of_service: '',
      }
    }
  },
  methods: {
    load() {
      $.get("comparativeDataInfo.ajax.php", {
        rspvac_id: this.rspvac_id,
        load: true
      }, (data, textStatus, jqXHR) => {
        this.position = JSON.parse(JSON.stringify(data))
        // console.log('load: ', data);
      },
        "json"
      );
    },

    get_list_of_applicants() {
      $.get("comparativeDataInfo.ajax.php", {
        rspvac_id: this.rspvac_id,
        load_list: true
      }, (data, textStatus, jqXHR) => {
        this.applicants = JSON.parse(JSON.stringify(data))
        // console.log('applicants: ', data[0]);
      },
        "json"
      );
    },
    parse_date(start, end) {
      var dates = ""

      var start = start ? new Date(start) : null;
      var end = end ? new Date(end) : null;

      // dates = start +" "+end
      if (end == "-00-00") {
        end = null
      }
      if (!start && !end) {
        dates = "(Dates not indicated)"
      } else if (!start && end) {
        dates = "(To: )" + moment(end).format('ll')
      } else if (start && !end) {
        dates = "(From: " + moment(start).format('ll') + " to Present)"
      } else {
        dates = "(" + moment(start).format('ll') + " - " + moment(end).format('ll') + ")";
      }
      return dates
      // moment(date).format('ll')
    },

    add_applicant_training() {
      this.applicant.trainings.push(this.form_training_input)
      this.form_training_input = ''
    },
    add_applicant_eligibility() {
      this.applicant.eligibilities.push(this.form_eligibility_input)
      this.form_eligibility_input = ''
    },
    add_applicant_award() {
      this.applicant.awards.push(this.form_award_input)
      this.form_award_input = ''
    },
    add_applicant_records_infraction() {
      this.applicant.records_infractions.push(this.form_records_infraction_input)
      this.form_records_infraction_input = ''
    },
    add_new_applicant_submit() {
      // add input not entered/left unentered in the form input start
      this.add_applicant_training()
      this.add_applicant_eligibility()
      this.add_applicant_award()
      this.add_applicant_records_infraction()
      // add input not entered/left unentered in the form input end
      console.log(this.applicant);
      console.log(this.form_experience);
    },
    add_edit_applicant(applicant_id) {
      if (!applicant_id) return this.add_new_applicant()
      return this.edit_applicant(applicant_id)
    },
    add_new_applicant() {
      $("#add_new_applicant_modal").modal({
        closable: false,
        onApprove: () => {
          this.add_new_applicant_submit()
          return false
        }
      }).modal("show")
    },
    edit_applicant(applicant_id) {
      // console.log(applicant_id);
      // alert()
    },

    delete_entry(rspvac_id) {
      console.log(rspvac_id);
    },

    get_yos() {
      this.form_experience.date_from
      this.form_experience.date_to

      startdate = this.prep_date(
        this.form_experience.date_from.mm,
        this.form_experience.date_from.dd,
        this.form_experience.date_from.yyyy
      )

      enddate = this.prep_date(
        this.form_experience.date_to.mm,
        this.form_experience.date_to.dd,
        this.form_experience.date_to.yyyy
      )

      var yos = this.dateDiff(startdate, enddate);

      this.form_experience.years_of_service

      // if complete
      if (yos.years && yos.months) {
        this.form_experience.years_of_service = `${yos.years} Yr/s and ${yos.months} Mo/s`
      }
      // months only
      else if (!yos.years && yos.months) {
        this.form_experience.years_of_service = `${yos.months} Mo/s`
      }
      // if years only
      else
        this.form_experience.years_of_service = `${yos.years} Yr/s` 



    },

    prep_date(mm, dd, yyyy) {
      // return `${mm}-${dd}-${yyyy}`
      //date complete
      if (mm && dd && yyyy) {
        return new Date(`${mm}-${dd}-${yyyy}`)
      }
      //date mm and yyyy only
      else if (mm && !dd && yyyy) {
        return new Date(`${mm}-01-${yyyy}`)
      }
      //date yyyy only
      else return new Date(`01-01-${yyyy}`)
    },

    dateDiff(startdate, enddate) {

      startdate = new Date(startdate) // remember this is equivalent to 06 01 2010

      enddate = (enddate) ? new Date(enddate) : new Date() //if enddate is undefined

      //define moments for the startdate and enddate
      var startdateMoment = moment(startdate);
      var enddateMoment = moment(enddate);

      if (startdateMoment.isValid() === true && enddateMoment.isValid() === true) {
        //getting the difference in years
        var years = enddateMoment.diff(startdateMoment, 'years');

        //moment returns the total months between the two dates, subtracting the years
        var months = enddateMoment.diff(startdateMoment, 'months') - (years * 12);

        //to calculate the days, first get the previous month and then subtract it
        // startdateMoment.add(years, 'years').add(months, 'months');
        // var days = enddateMoment.diff(startdateMoment, 'days')

        return {
          years: years,
          months: months,
          // days: days
        };

      }
      else {
        return undefined;
      }

    }
  },
  mounted() {

    $('.ui.dropdown').dropdown();

    this.load()
    this.get_list_of_applicants()
    // for testing only below
    this.add_new_applicant()
  }
});