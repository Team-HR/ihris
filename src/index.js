// import _ from 'lodash';
// import './style.css';
// import Icon from './icon.png';
// import Data from './data.xml';
// function component() {
//     const element = document.createElement('div');
  
//     // Lodash, currently included via a script, is required for this line to work
//     // Lodash, now imported by this script
//     element.innerHTML = _.join(['Hello', 'webpack'], ' ');
  
//     return element;
//   }
  
//   document.body.appendChild(component());
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