<?php
    $title="Takay ID";
    require "header.php";
?>
<div class="ui container">

<div id="app" class="ui segment">
      <vue-avatar
      :width=200
      :height=200
      :rotation="rotation"
      :scale="scale"
      ref="vueavatar"
      @vue-avatar-editor:image-ready="onImageReady"
      >
    </vue-avatar>
    <br>
    <input
      type="range"
      min=1
      max=3
      step=0.02
      v-model='scale'
    />
    <input
      type="range"
      min=1
      max=3
      step=0.02
      v-model='rotation'
    />
    <br>
    <button class="ui green button" v-on:click="saveClicked"><i class="icon camera"></i>Take Snap</button>
    <br>
    <img ref="image">



    <div class="ui form">
<div class="ui stackable four column grid">
  <div class="column">
        <div class="field">
            <label>ID No</label>
            <input type="text" v-model="id" placeholder="ID Number">
        </div>
  </div>
  <div class="column">
        <div class="field">
            <label>Last Name</label>
            <input type="text" v-model="last_name" placeholder="Last Name">
        </div>
  </div>
  <div class="column">
        <div class="field">
            <label>First Name</label>
            <input type="text" v-model="first_name" placeholder="First Name">
        </div>
  </div>
  <div class="column">
        <div class="field">
            <label>Middle Name</label>
            <input type="text" v-model="middle_name" placeholder="Middle Name">
        </div>
  </div>
  <div class="column">
        <div class="field">
            <label>Name Ext</label>
            <input type="text" v-model="ext_name" placeholder="e.g. JR, SR, III,...etc">
        </div>
  </div>
  <div class="column">
        <div class="field">
            <label>Last Name</label>
            <select v-model="gender">
                <option value="" disabled>Gender</option>
                <option value="m">Male</option>
                <option value="f">Male</option>
            </select>
        </div>
  </div>
  <div class="column">
        <div class="field">
            <label>Date of Birth</label>
            <input type="date" v-model="date_of_birth">
        </div>
  </div>
  <div class="column">
        <div class="field">
            <label>Place of Birth</label>
            <input type="text" v-model="place_of_birth" placeholder="Place of Birth">
        </div>
  </div>
  <div class="column">
        <div class="field">
            <label>Contact No.</label>
            <input type="text" v-model="contact_no" placeholder="Contact Number">
        </div>
  </div>
  <div class="column">
        <div class="field">
            <label>Validity</label>
            <input type="text" v-model="validity" placeholder="e.g. January 1 - July 30, 2000">
        </div>
  </div>
</div>










    </div>
    
</div>

</div>
<script src="dist/main.js"></script>


<?php
    require "footer.php";
?>