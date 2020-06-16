<?php    
$title = "Feedback";
require_once "header.php";
?>
    <style>
        .myItem_body{
            font-size:15px;
            font-weight:bold;
        }
        .myItem_content{
            padding:10px;
        }

    </style>

    <div id="app">
        <div class="ui segment">
            <h1>Feedbacking Monitoring</h1>
            <hr>
            <div class="ui middle aligned divided selection list" style="max-width:1000px;margin:auto;border:1px solid #00000040;border-radius:10px">
            <template>
                <div class="item myItem_body" v-for="i in current" v-if="i >= started">
                    <div class="right floated content">
                        <a @click="gotoPage(i)"><div class="ui button" >Open</div></a>
                    </div>
                    <div class="content myItem_content">
                    <i class="folder icon blue"></i>
                      {{ i }}
                    </div>
                </div>
            </template>
            </div>
        </div>
    </div>
<?
require_once "footer.php";
?>
<script>

var app = new Vue({
    el:'#app',
    data:{
        started:2019,
        current:new Date().getFullYear(),
    },
    methods:{
        gotoPage:function(i){
            window.location.href = "spmsFeedback.php?year="+i;
        }
    }

});

</script>