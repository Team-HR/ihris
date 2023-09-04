<?php
require_once "header.php";
?>

<div id="change_password_vue_app" class="ui container">
    <template>
        <div class="ui borderless blue inverted mini menu">
            <div class="left item" style="margin-right: 0px !important;">
                <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
                    <i class="icon chevron left"></i> Back
                </button>
            </div>
            <div class="item">
                <h3><i class="key icon"></i> Change Password</h3>
            </div>
        </div>
        <div class="ui basic segment">
            <div class="ui three column centered grid">
                <div class="column">
                    <form class="ui form segment" @submit.prevent="submit_form" width="500" :class="status?'error':''">
                        <div class="field" :class="status == 'unauthorized'?'error':''">
                            <label>Current Password</label>
                            <input type="password" placeholder="Current Password" v-model="input.current_password">
                        </div>
                        <div v-if="status == 'unauthorized'" class="ui error message">
                            <div class="header">Wrong password!</div>
                            <p>Please try again.</p>
                        </div>
                        <div class="ui dividing header"></div>
                        <div class="field" :class="status == 'invalid'?'error':''">
                            <label>New Password</label>
                            <input type="password" placeholder="New Password" v-model="input.new_password">
                        </div>
                        <div class="ui error message" v-if="status == 'invalid'">
                            <div class="header">New password invalid!</div>
                            <p>Must not have whitespaces and must be atleast 4 or more characters in length.</p>
                        </div>
                        <div class="field" :class="status == 'mismatched'?'error':''">
                            <label>Confirm Password</label>
                            <input type="password" placeholder="Retype Password" v-model="input.new_password_confirm">
                        </div>
                        <div class="ui error message" v-if="status == 'mismatched'">
                            <div class="header">New password mismatch!</div>
                            <p>Please retype your new password.</p>
                        </div>
                        <button class="ui small green button" type="submit">Change</button>
                        <button class="ui small button" type="button" onclick="window.history.back();">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
        <div id="success_modal" class="ui mini modal">
            <div class="header">Password Change Successful!</div>
            <div class="ui basic segment">
                Password changed succcessfully. Please logout and login again to continue.
            </div>
            <div class="actions">
                <a class="ui small green button" href="logout.php">Logout</a>
            </div>
        </div>
    </template>
</div>

<script>
    var change_password_vue_app = new Vue({
        el: "#change_password_vue_app",
        data() {
            return {
                employee_id: <?= $_SESSION["employee_id"] ?>,
                input: {
                    current_password: "",
                    new_password: "",
                    new_password_confirm: ""
                },
                status: null,
            }
        },
        methods: {
            submit_form() {
                $.post("update_password_proc.php", {
                        submit_form: true,
                        employee_id: this.employee_id,
                        input: this.input
                    },
                    (data, textStatus, jqXHR) => {
                        console.log(data);
                        this.status = data.status
                        if (data.status === null) {
                            this.success_modal()
                        }
                    },
                    "json"
                );
            },
            success_modal() {
                $("#success_modal").modal({
                    closable: false,
                }).modal("show");

            }
        },
        mounted() {}
    });
</script>

<?php require_once "footer.php"; ?>