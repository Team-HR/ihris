

var comparative_data_vue = new Vue({
  el: "#comparative_data_vue",
  data() {
    return {
      rspvac_id: new URLSearchParams(window.location.search).get("rspvac_id"),
      position: {},
      applicants: [],
      applicant: {
        applicant_id: null,
        name: '',
        age: '',
        gender: '',
        civil_status: '',
        mobile_no: '',
        address: '',
        education: '',
        school: '',
        trainings: [],
        experiences: [],
        eligibilities: [],
        awards: [],
        records_infractions: [],
        remarks: ''
      },
      applicant_cleared: {
        applicant_id: null,
        name: '',
        age: '',
        gender: '',
        civil_status: '',
        mobile_no: '',
        address: '',
        education: '',
        school: '',
        trainings: [],
        experiences: [],
        eligibilities: [],
        awards: [],
        records_infractions: [],
        remarks: ''
      },
      form_training_input: {
        training: '',
        hrs: ''
      },
      form_eligibility_input: '',
      form_award_input: '',
      form_records_infraction_input: '',
      form_experience: {
        id: null,
        sector: '',
        company: '',
        position: '',
        description: '',
        status: '',
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
        years_of_service: { years: 0, months: 0 }
      },
      form_experience_cleared: {
        id: null,
        sector: '',
        company: '',
        position: '',
        description: '',
        status: '',
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
        years_of_service: { years: 0, months: 0 }
      },
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
      this.form_training_input = {
        training: '',
        hrs: ''
      }
    },

    applicant_experience_editor() {
      $("#applicant_experience_editor_modal").modal({
        allowMultiple: true,
        closable: false
      }).modal("show")
    },


    add_applicant_experience() {
      if (this.form_experience.id !== null) {
        var i = this.form_experience.id
        this.applicant.experiences[i] = JSON.parse(JSON.stringify(this.form_experience))
      } else {
        this.applicant.experiences.push(this.form_experience)
      }
      this.reset_applicant_experience()
    },
    edit_applicant_experience(x) {
      this.applicant_experience_editor()
      this.form_experience = JSON.parse(JSON.stringify(this.applicant.experiences[x]))
      this.form_experience.id = x
      $("#form_experience_sector").dropdown("set selected", this.form_experience.sector)
      $("#form_experience_status").dropdown("set selected", this.form_experience.status)
    },
    reset_applicant_experience() {
      // reset form_experience start
      this.form_experience = JSON.parse(JSON.stringify(this.form_experience_cleared))
      $("#form_experience_sector").dropdown("clear")
      $("#form_experience_status").dropdown("clear")
      // reset form_experience end
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
    add_new_applicant() {
      // reset form initially start
      this.applicant = JSON.parse(JSON.stringify(this.applicant_cleared))
      $(".ui.compact.dropdown.gender").dropdown("restore defaults")
      $(".ui.compact.dropdown.civil_status").dropdown("restore defaults")
      // reset form initially end
      $("#add_new_applicant_modal").modal({
        allowMultiple: true,
        closable: false,
        onApprove: () => {
          this.save_new_applicant_submit()
          // return false
        }
      }).modal("show")
    },
    save_new_applicant_submit() {
      console.log("Before ajax: ", this.applicant);
      $.post("comparativeDataInfo.ajax.php", {
        save_new_applicant_submit: true,
        rspvac_id: this.rspvac_id,
        applicant: this.applicant
      },
        (data, textStatus, jqXHR) => {
          console.log("save_new_applicant_submit(): ", data);
        },
        "json"
      );

    },
    add_edit_applicant(applicant_id) {
      if (!applicant_id) return this.add_new_applicant()
      return this.edit_applicant(applicant_id)
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

      // this.form_experience.years_of_service

      // if complete
      if (yos.years && yos.months) {
        // this.form_experience.years_of_service = `${yos.years} Yr/s and ${yos.months} Mo/s`
        this.form_experience.years_of_service.years = yos.years
        this.form_experience.years_of_service.months = yos.months
      }
      // months only
      else if (!yos.years && yos.months) {
        // this.form_experience.years_of_service = `${yos.months} Mo/s`
        this.form_experience.years_of_service.years = 0
        this.form_experience.years_of_service.months = yos.months
      }
      // if years only
      else {
        // this.form_experience.years_of_service = `${yos.years} Yr/s`
        this.form_experience.years_of_service.years = yos.years
        this.form_experience.years_of_service.months = 0
      }


    },

    prep_date(mm, dd, yyyy) {
      // return `${mm}-${dd}-${yyyy}`
      // get current month and date for zeroing empty mm/dd inputs start
      var dateObj = new Date();
      var cur_month = dateObj.getUTCMonth() + 1; //months from 1-12
      var cur_day = dateObj.getUTCDate();
      // get current month and date for zeroing empty mm/dd inputs end

      //date complete
      if (mm && dd && yyyy) {
        return new Date(`${mm}-${dd}-${yyyy}`)
      }
      //date mm and yyyy only
      else if (mm && !dd && yyyy) {
        return new Date(`${mm}-${cur_day}-${yyyy}`)
      }
      //date yyyy only
      else if (!mm && !dd && yyyy) {
        return new Date(`${cur_month}-${cur_day}-${yyyy}`)
      }
      //else all null
      else return new Date()

    },

    format_date_to_str(mm, dd, yyyy) {
      //date complete
      if (mm && dd && yyyy) {
        var date = new Date(`${mm}-${dd}-${yyyy}`)
        return moment(date).format("ll");
      }
      //date mm and yyyy only
      else if (mm && !dd && yyyy) {
        var date = new Date(`${mm}-01-${yyyy}`)
        return moment(date).format("MMM YYYY");
      }
      //date yyyy only
      else if (!mm && !dd && yyyy) {
        return yyyy
      }
      //else all null
      else return "Present"
    },

    applicant_experience_has_data(experiences) {
      if (experiences.length > 0) return true
      return false
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

    },
    set_applicant(res) {
      this.applicant.applicant_id = res.applicant_id
      this.applicant.name = res.name
      this.applicant.age = res.age
      this.applicant.gender = res.gender
      $(".ui.compact.dropdown.gender").dropdown("set selected", res.gender)
      this.applicant.civil_status = res.civil_status
      $(".ui.compact.dropdown.civil_status").dropdown("set selected", res.civil_status)
      this.applicant.mobile_no = res.mobile_no
      this.applicant.address = res.address
      this.applicant.education = res.education
      this.applicant.school = res.school
      this.applicant.trainings = res.trainings
      this.applicant.experiences = res.experiences
      this.applicant.eligibilities = res.eligibilities
      this.applicant.awards = res.awards
      this.applicant.records_infractions = res.records_infractions
      this.applicant.remarks = res.remarks
      console.log(res);
    },
    reset_applicant() {
      this.applicant.applicant_id = null
      // this.applicant.name = res.name
      this.applicant.age = ''
      this.applicant.gender = ''
      $(".ui.compact.dropdown.gender").dropdown("restore defaults")
      this.applicant.civil_status = ''
      $(".ui.compact.dropdown.civil_status").dropdown("restore defaults")
      this.applicant.mobile_no = ''
      this.applicant.address = ''
      this.applicant.education = ''
      this.applicant.school = ''
      // this.applicant.trainings = res.trainings
      // this.applicant.experiences = res.experiences
      // this.applicant.eligibilities = res.eligibilities
      // this.applicant.awards = res.awards
      // this.applicant.records_infractions = res.records_infractions
      this.applicant.remarks = ''
    }
  },
  mounted() {

    $('.ui.dropdown').dropdown({
      showOnFocus: false
    });
    $('.ui.search')
      .search({
        searchOnFocus: false,
        apiSettings: {
          url: 'comparativeDataInfo.ajax.php?query={query}'
        },
        fields: {
          results: 'items',
          title: 'name',
          description: 'address'
        },
        minCharacters: 3,
        onSelect: (result) => {
          console.log("result: ", result)
          // console.log("response: ",response);
          this.set_applicant(result)
        },
        onResultsOpen: () => {
          // console.log("opened");
          this.reset_applicant()
        }
      })
      ;
    this.load()
    this.get_list_of_applicants()
    // for testing only below
    this.add_new_applicant()
  }
});