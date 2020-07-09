
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
        validity: ""
      };
  },
  methods: {
      saveClicked () {
          var img = this.$refs.vueavatar.getImageScaled()
          this.$refs.image.src = img.toDataURL('image/jpeg', 1.0)
          console.log(img)
          console.log(this.$refs.image.src)
          $.ajax({
              type: "post",
              url: "takay_id.ajax.php",
              data: {
                  getImage:true,
                  imgBase64:img.toDataURL('image/jpeg',1.0),
                    id: this.id
                },
              dataType: "json",
              success: function (response) {
                  console.log(response);
              }
          });
      },
      onImageReady () {
          this.scale = 1
          this.rotation = 0
      }
  }
})