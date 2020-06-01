<div class="ui tiny form">
<button class="mini teal ui button right floated"><i class="icon edit"></i> Edit</button>
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
    </div>
    <i>Name of Children</i>
    <hr>
    <table class="ui very small compact structured celled table">
        <thead>
            <tr>
                <th>Name of the Child</th>
                <th>Date of Birth</th>
            </tr>
        </thead>
        <tbody>
        <tr v-for="i in 2">
            <td>Child {{i}}</td>
            <td>mm/dd/yyyy</td>
        </tr>
        </tbody>
    </table>
</div>