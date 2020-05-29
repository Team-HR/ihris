<div class="ui tiny form">
    <h4 class="ui header">II. FAMILY BACKGROUND</h4>

    <i>Spouse's Informaion</i>
    <hr>
    <div class="four fields">
        <div class="field">
            <label for="">Surname:</label>
            <input type="text" placeholder="">
        </div>
        <div class="field">
            <label for="">Firstname:</label>
            <input type="text" placeholder="">
        </div>
        <div class="field">
            <label for="">Middlename:</label>
            <input type="text" placeholder="">
        </div>
        <div class="field">
            <label for="">Name extension:</label>
            <input type="text" placeholder="">
        </div>
    </div>
    <div class="three fields">
        <div class="field">
            <label for="">Occupation:</label>
            <input type="text"> 
        </div>
        <div class="field">
            <label for="">Employeer/Business Name:</label>
            <input type="text"> 
        </div>
        <div class="field">
            <label for="">Telephone No.:</label>
            <input type="text"> 
        </div>
    </div>

    <i>Father's Name</i>
    <hr>
    <div class="four fields">
        <div class="field">
            <label for="">Surname:</label>
            <input type="text" placeholder="">
        </div>
        <div class="field">
            <label for="">Firstname:</label>
            <input type="text" placeholder="">
        </div>
        <div class="field">
            <label for="">Middlename:</label>
            <input type="text" placeholder="">
        </div>
        <div class="field">
            <label for="">Name extension:</label>
            <input type="text" placeholder="">
        </div>
    </div>
    <i>Mother's Maiden Name</i>
    <hr>
    <div class="three fields">
        <div class="field">
            <label for="">Surname:</label>
            <input type="text" placeholder="">
        </div>
        <div class="field">
            <label for="">Firstname:</label>
            <input type="text" placeholder="">
        </div>
        <div class="field">
            <label for="">Middlename:</label>
            <input type="text" placeholder="">
        </div>
        <!-- <div class="field">
            <label for="">Name extension:</label>
            <input type="text" placeholder="">
        </div> -->
    </div>
    <i>Name of Children</i>
    <hr>
    <table class="ui very small compact table">
        <thead>
            <tr>
                <th>NAME</th>
                <th>BIRTHDATE</th>
            </tr>
        </thead>
        <tbody>
        <tr v-for="i in 10">
            <td>Child {{i}}</td>
            <td>Birthdate {{i}} </td>
        </tr>
        </tbody>
    </table>
    <!-- <div :key="i" class="two  fields">
        <div class="field">
            <label for="">Fullname:</label>
            <input type="text"> 
        </div>
        <div class="field">
            <label for="">Birthdates:</label>
            <input type="text"> 
        </div>
    </div> -->
</div>