import Vue from 'vue'
import {VueAvatar} from 'vue-avatar-editor-improved'
 
let vm = new Vue({
  el: '#app',
  components: {
    VueAvatar,
  },
  data () {
      return {
          rotation: 0,
          scale: 1
      };
  },
  methods: {
      saveClicked () {
          var img = this.$refs.vueavatar.getImageScaled()
          this.$refs.image.src = img.toDataURL()
      },
      onImageReady () {
          this.scale = 1
          this.rotation = 0
      }
  }
})