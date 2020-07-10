
// import Vue from 'vue'
// import $ from 'jquery'
import {VueAvatar} from 'vue-avatar-editor-improved'
 
let vm = new Vue({
  el: '#app',
  components: {
    VueAvatar,
  },
  data () {
      return {
        rotation: 0,
        scale: 1,
        id: "",
        last_name: "",
        first_name: "",
        middle_name: "",
        ext_name: "",
        address: "",
        gender: "",
        date_of_birth: "",
        place_of_birth: "",
        contact_no: "",
        validity: "July 01 - December 30, 2020",
        noSelectedImage: true,
        imgUrl: ""
      };
  },
  methods: {
      saveClicked () {
          var img = this.$refs.vueavatar.getImageScaled()
          this.imgUrl = img.toDataURL('image/jpeg', 1.0)
          this.$refs.image.src = this.imgUrl
      },
      onImageReady () {
          this.scale = 1
          this.rotation = 0
          this.noSelectedImage = false
      },
      onSave(){
        var infos = {
          'id':this.id,
          'last_name':this.last_name,
          'first_name':this.first_name,
          'middle_name':this.middle_name,
          'ext_name':this.ext_name,
          'address':this.address,
          'gender':this.gender,
          'date_of_birth':this.date_of_birth,
          'place_of_birth':this.place_of_birth,
          'contact_no':this.contact_no,
          'validity':this.validity
        }
        $.ajax({
            type: "post",
            url: "takay_id.ajax.php",
            data: {
                getImage: true,
                imgBase64: this.imgUrl,
                infos: infos
              },
            dataType: "json",
            success: function (response) {
                console.log(response);
            }
        });
      }
  },
  mounted() {
    $('.ui .checkbox').checkbox()
  },
})