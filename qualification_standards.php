<?php
$title = "Qualification Standards";
require_once "header.php";
?>
<div class="ui basic segment" id="app">
    <div class="ui fluid container">
        <div class="ui borderless blue inverted mini menu">
            <div class="left item" style="margin-right: 0px !important;">
                <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
                    <i class="icon chevron left"></i> Back
                </button>
            </div>
            <div class="item">
                <h3><i class="graduation cap icon"></i> Qualification Standards</h3>
            </div>
            <div class="right item">
                <div class="ui right input">
                    <div class="ui icon fluid input" style="width: 300px;">
                        <input v-model="findValue" type="text" placeholder="Search...">
                        <i class="search icon"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="ui fluid container" :class="loading" style="margin-top: 5px;">
        <table class="ui very small compact celled structured selectable striped table" id="qs_table">
            <thead>
                <tr>
                    <th class="center aligned">OPTIONS</th>
                    <th class="center aligned">POSITION TITLE</th>
                    <th class="center aligned">FUNCTIONAL TITLE</th>
                    <th class="center aligned">SG</th>
                    <th class="center aligned">LEVEL</th>
                    <th class="center aligned">GOV'T. SECTOR</th>
                    <th class="center aligned">EDUCATION</th>
                    <th class="center aligned">EXPERIENCE</th>
                    <th class="center aligned">TRAINING</th>
                    <th class="center aligned">ELIGIBILITY</th>
                    <th class="center aligned">COMPETENCY</th>
                </tr>
            </thead>
            <tbody>
                <template>
                    <tr v-for="(position,index) in positions" :key="index" :class="{'yellow' : !q_standards[position.position_id]}">
                        <template>
                            <td style="white-space: nowrap;" v-if="q_standards[position.position_id]" style="text-align:center">
                                <button class="ui mini basic button green icon" @click="editOpenModal(index,position.position_id)"><i class="edit icon"></i></button>
                                <button class="ui mini basic button red icon" @click="removeData(position.position_id)"><i class="trash icon"></i></button>
                            </td>
                            <td v-else style="text-align:center">
                                <button class="ui mini button primary icon fluid" @click="openQsModal(index)"><i class="add icon"></i> Add</button>
                            </td>
                        </template>
                        <td>{{position.position}}</td>
                        <td>{{position.functional}}</td>
                        <td>{{position.salaryGrade}}</td>
                        <td>{{position.level}}</td>
                        <td>Local</td>
                        <template v-if="q_standards[position.position_id]">
                            <td>{{q_standards[position.position_id].education}}</td>
                            <td>{{q_standards[position.position_id].experience}}</td>
                            <td>{{q_standards[position.position_id].training}}</td>
                            <td>{{q_standards[position.position_id].eligibility}}</td>
                            <td>{{q_standards[position.position_id].competency}}</td>
                        </template>
                        <template v-else>
                            <td colspan="5"></td>
                        </template>
                    </tr>
                </template>
            </tbody>
        </table>



        <div class="ui modal" id='qs_modal'>
            <i class="close icon"></i>
            <div class="header">Qualification Standards</div>
            <div class="content">
                <form class="ui form" @submit.prevent="qsModalFormSubmit()">
                    <div class="two fields">
                        <div class="field">
                            <label>Position Name</label>
                            <input type="text" v-model="position_form" readonly>
                        </div>
                        <div class="field">
                            <label>Category</label>
                            <input type="text" v-model="category_form" readonly>
                        </div>
                    </div>
                    <div class="field">
                        <label>Function</label>
                        <input type="text" v-model="functional_form" readonly>
                    </div>
                    <div class="three fields">
                        <div class='field'>
                            <label>SG</label>
                            <input type="text" v-model="sg_form" readonly>
                        </div>
                        <div class='field'>
                            <label>LEVEL</label>
                            <input type="text" v-model="level_form" readonly>
                        </div>
                        <div class='field'>
                            <label>GOV'T. SECTOR</label>
                            <input type="text" value="LOCAL" readonly>
                        </div>
                    </div>
                    <div class="field">
                        <label>EDUCATION</label>
                        <textarea rows="2" v-model="education_form"></textarea>
                        <hr>
                        <div class="ui three cards">
                            <div class="card" v-for="(edu,index) in education_suggest" :key="index">
                                <div class="content">
                                    <div class="description">
                                        {{ edu }}
                                    </div>
                                </div>
                                <div class="extra content">
                                    <span class="right floated">

                                    </span>
                                    <span>
                                        <input class="ui button primary" type="button" value="Use" @click="use_sug(index,'education')">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="field">
                        <label>EXPERIENCE</label>
                        <textarea rows="2" v-model="experience_form"></textarea>
                        <hr>
                        <div class="ui three cards">
                            <div class="card" v-for="(exp,index) in experience_suggest" :key="index">
                                <div class="content">
                                    <div class="description">
                                        {{ exp }}
                                    </div>
                                </div>
                                <div class="extra content">
                                    <span class="right floated">

                                    </span>
                                    <span>
                                        <input class="ui button primary" type="button" value="Use" @click="use_sug(index,'experience')">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="field">
                        <label>TRAINING</label>
                        <textarea rows="2" v-model="training_form"></textarea>
                        <hr>
                        <div class="ui three cards">
                            <div class="card" v-for="(train,index) in training_suggest" :key="index">
                                <div class="content">
                                    <div class="description">
                                        {{ train }}
                                    </div>
                                </div>
                                <div class="extra content">
                                    <span class="right floated">

                                    </span>
                                    <span>
                                        <input class="ui button primary" type="button" value="Use" @click="use_sug(index,'training')">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="field">
                        <label>ELIGIBILITY</label>
                        <textarea rows="2" v-model="eligibility_form"></textarea>
                        <hr>
                        <div class="ui three cards">
                            <div class="card" v-for="(eli,index) in eligibility_suggest" :key="index">
                                <div class="content">
                                    <div class="description">
                                        {{ eli }}
                                    </div>
                                </div>
                                <div class="extra content">
                                    <span class="right floated">

                                    </span>
                                    <span>
                                        <input class="ui button primary" type="button" value="Use" @click="use_sug(index,'eligibility')">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="field">
                        <label>COMPETENCY</label>
                        <textarea rows="2" v-model="competency_form"></textarea>
                        <hr>
                        <div class="ui three cards">
                            <div class="card" v-for="(comp,index) in competency_suggest" :key="index">
                                <div class="content">
                                    <div class="description">
                                        {{ comp }}
                                    </div>
                                </div>
                                <div class="extra content">
                                    <span class="right floated">

                                    </span>
                                    <span>
                                        <input class="ui button primary" type="button" value="Use" @click="use_sug(index,'competency')">
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <input class="ui button primary" type="submit" value="SAVE">
                    <input class="ui button red" type="button" value="CANCEL" @click="closeModal()">
                </form>
            </div>
        </div>
    </div>
    <script src="umbra/qualification_standards/config.js"></script>
    <?php require_once "footer.php"; ?>