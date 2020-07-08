<?php
$title = "Qualification Standards";
require_once "header.php";
?>
    <div id="app">
        <div class="ui segment" :class="loading">
            
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
                                        <!-- <input class="ui button red" type="button" value="Close"> -->
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
                                        <!-- <input class="ui button red" type="button" value="Close"> -->
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
                                        <!-- <input class="ui button red" type="button" value="Close"> -->
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
                                        <!-- <input class="ui button red" type="button" value="Close"> -->
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
                                        <!-- <input class="ui button red" type="button" value="Close"> -->
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
                
            <div>
                    <div style="width:400px;float:left"><h2>Qualification Standards</h2></div>
                    <div style="width:400px;float:right">
                    <div class="ui icon input fluid">
                        <input type="text" placeholder="Search..." v-model='findValue'>
                        <i class="search icon"></i>
                    </div>
                    </div>
                    <div style="clear:both"></div>
            </div>
            <hr>
            <table class="ui table selectable" id="qs_table">
                <thead>
                    <tr>
                        <th>POSITION TITLE</th>
                        <th>FUNCTIONAL TITLE</th>
                        <th>SG</th>
                        <th>LEVEL</th>
                        <th>GOV'T. SECTOR</th>
                        <th>EDUCATION</th>
                        <th>EXPERIENCE</th>
                        <th>TRAINING</th>
                        <th>ELIGIBILITY</th>
                        <th>COMPETENCY</th>
                        <th>OPTIONS</th>
                    </tr>
               </thead>
                <tbody>
                    <template>
                        <tr v-for="(position,index) in positions" :key="index">
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
                                <td style="text-align:center">
                                    <button class="ui tiny button green icon" @click="editOpenModal(index,position.position_id)"><i class="edit icon"></i></button>
                                    <button class="ui tiny button red icon" @click="removeData(position.position_id)"><i class="trash icon"></i></button>
                                </td>
                            </template>
                            <template v-else>
                                <td colspan="5"></td>
                                <td style="text-align:center">
                                    <button class="ui tiny button primary icon" @click="openQsModal(index)"><i class="add icon"></i></button>
                                </td>
                            </template>

                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
    <script src="umbra/qualification_standards/config.js"></script>
<?
    require_once "footer.php";
?>