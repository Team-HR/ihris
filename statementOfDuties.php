<?php
$title = "Statement of Duties";
require_once "header.php";
?>
<!-- custom sidebar start -->
<div id="app" class="ui fluid container" style="min-height: 600px; padding: 5px;">
    <div class="ui borderless blue inverted mini menu">
        <div class="left item" style="margin-right: 0px !important;">
            <button onclick="window.history.back(); console.log(window.history);" class="blue ui icon button" title="Back" style="width: 65px;">
                <i class="icon chevron left"></i> Back
            </button>

        </div>
        <div class="item">
            <h3 style="color: white;"><i>Statement Of Duties</i></h3>
        </div>
    </div>
    <div class="ui fluid container">
        <div class="ui centered grid">
            <div class="eight wide column">
                <div class="ui card fluid">
                    <div class="content">
                        <div class="header">
                            <div class="ui grid">
                                <div class="eight wide column">
                                    <h1>
                                        Positions 
                                    </h1>
                                </div>
                                <div class="eight wide column">
                                    <div class="ui mini search">
                                        <div class="ui icon input fluid">
                                            <input class="prompt" type="text" placeholder="Search position" v-model="searchPosition">
                                            <i class="search icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="ui celled table">
                            <thead>
                                <tr>
                                    <th>Position Titles</th>
                                    <th>Functions</th>
                                    <th>Show Duties</th>
                                </tr>
                            </thead>
                            <tbody id="positionRows">
                                <template>
                                    <tr v-for="(position,index) in Positions" :key="index">
                                        <td>{{position.position}}</td>
                                        <td>{{position.functional}}</td>
                                        <td>
                                            <button class="ui button icon primary" @click="dutiesCard(index)">
                                                <i class="icon plus"></i>
                                            </button>
                                        </td>    
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="eight wide column " :style="cardView" style="position:relative">
                <div id="dutiesChildDiv" style="width:100%;">
                    <h1>
                        {{header}} <br>
                        <button class="ui icon mini green button" @click="dutiesModal()">
                            <i class="icon add"></i>Add
                        </button>
                    </h1>
                    <template>
                    <div v-if="Duties.length==0"> 
                    <br>
                    <br>
                    <br>
                        <h1 style="text-align:center;color:#2724248c">No Records Found </h1>
                    </div>
                    <table v-else class="ui celled table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Work Statement</th>
                                <th>Percentage</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                        <template>
                            <tr v-for="(duty,index) in Duties" :key="index">
                                <td>{{duty.no}}</td>
                                <td>{{duty.workstatement}}</td>
                                <td>{{duty.percentile}} %</td>
                                <td>
                                    <button class="ui icon tiny button green" @click="dutiesModal(index)">    
                                        <i class="icon edit"></i>
                                    </button>
                                    <button class="ui icon tiny button red" @click="deleteDuty(duty.statement_id)">
                                        <i class="icon trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><b style="color: green">Total = </b></td>
                                <td>{{totalPercent}} %</td>
                                <td></td>
                            </tr>
                        </template>
                        </tbody>
                    </table>
                    </template>
                </div>
            </div>
        </div>
    </div>

<div class="ui mini modal" id="dutiesModal">
    <div class="header">
        Duties Form
    </div>
    <div class="content">
    <form class="ui form">
        <div class="field">
            <label>No.</label>
            <input type="text" v-model="num" >
        </div>
        <div class="field">
            <label>Percent</label>
            <input type="number" v-model.number="percent">
        </div>
        <div class="field">
            <label>Work Statement</label>
            <textarea rows="5" v-model="workstatement"></textarea>
        </div>
    </form>



    </div>
    <div class="actions">
        <button class="ui ok button green">Save</button>
        <button class="ui cancel button red">Close</button>

    </div>
</div>
</div>

<style>
    .topot{
        position:fixed;
        top:20px;
        width:48% !important;
    }

</style>
<script src="umbra/statementOfDuties/statementOfDuties.js"></script>
<?php require_once "footer.php"; ?>