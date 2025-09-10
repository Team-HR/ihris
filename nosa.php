<?php $title = "NOSA (Casual)";
require_once "header.php";
?>

<div id="nosa-app" class="ui fluid container" style="padding: 5px;">
    <template>
        <div class="ui borderless blue inverted mini menu">
            <div class="left item" style="margin-right: 0px !important;">
                <button onclick="window.history.back();" class="blue ui icon button" title="Back" style="width: 65px;">
                    <i class="icon chevron left"></i> Back
                </button>
            </div>
            <div class="item">
                <h3><i class="users icon"></i> Notice of Salary Adjustment</h3>
            </div>

            <div class="right item">
                <!-- <a href="print_employee_list.php" class="ui button " style="margin-right: 10px;">Print</a> -->
                <button onclick="addModalFunc()" class="green ui icon fluid button" style="margin-right: 10px;" title="Add Personnel">
                    <i class="icon user plus"></i> Add
                </button>
                <!-- <div class="ui icon input">
                <input id="employee_search" type="text" placeholder="Search...">
                <i class="search icon"></i>
            </div> -->
            </div>
        </div>
        <!-- list of NOSA folders start-->

        <div class="ui fluid segment">
            <h1>Notice of Salary Adjustment (Casual)</h1>

            <?php

            if (!isset($_GET["folder"])) {

            ?>

                <table class="ui table" style="width: 500px;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th></th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="folder, i in folders" :key="folder.id">
                            <td>{{i+1}}</td>
                            <td><a href="nosa.php?folder=1" class="ui mini primary button"><i class="ui icon folder"></i> Open</a></td>
                            <td>{{folder.dateString}}</td>
                        </tr>
                    </tbody>
                </table>

            <?php
            } else {
            ?>
                <!--folder records show here start -->

                <button class="ui button primary" @click="getChecked()"><i class="ui icon print"></i> Print Selected</button>
                <table class="ui table" style="width: 1000px;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th></th>
                            <th></th>
                            <th>Name</th>
                            <th>New Rate</th>
                            <th>Old Rate</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item,i in items" :key="item.id">
                            <td>{{i+1}}.)</td>
                            <td>
                                <div class="ui checkbox">
                                    <input type="checkbox" name="example" :value="item.id" ref="checks">
                                    <label></label>
                                </div>
                            </td>
                            <td>
                                <button class="ui basic button" style="width: 100px;"><i class="ui icon edit"></i> Edit</button>
                            </td>
                            <td>{{item.full_name_upper}}</td>
                            <td>{{item.new_salary}}</td>
                            <td>{{item.old_salary}}</td>
                            <td>{{item.created_at}}</td>
                        </tr>
                    </tbody>
                </table>


                <!--folder records show here end -->
            <?php
            }
            ?>


        </div>

        <!-- list of NOSA folders end-->
    </template>
</div>


<script>
    new Vue({
        el: "#nosa-app",
        data: {
            folders: [],
            folderInfo: {},
            items: [],
            checkedValues: []
        },
        methods: {

            getChecked() {
                this.checkedValues = Array.from(this.$refs.checks)
                    .filter(c => c.checked)
                    .map(c => c.value);
                console.log(this.checkedValues);

            },

            getFolders() {
                $.ajax({
                    type: "post",
                    url: "nosa.proc.php",
                    data: {
                        getFolders: true,
                    },
                    dataType: "json",
                    success: (response) => {
                        console.log("get folders: ", response);
                        this.folders = response
                    },
                    async: false
                });
            },


            getFolderRecords() {
                const folderId = this.getFolderId();
                if (!folderId) return false;
                console.log("folderId: ", folderId);
                this.getItems(folderId);

            },

            getItems(id) {
                $.ajax({
                    type: "post",
                    url: "nosa.proc.php",
                    data: {
                        getItems: true,
                        id: id
                    },
                    dataType: "json",
                    success: (response) => {
                        this.items = response
                        console.log("items:", this.items);
                    },
                    async: false
                });
            },

            getFolderId() {
                const urlParams = new URLSearchParams(window.location.search)
                const id = urlParams.get('folder')
                if (id) {
                    return id;
                } else return false
            }


        },
        mounted() {
            this.getFolders()
            this.getFolderRecords()
        }
    });
</script>

<?php require_once "footer.php"; ?>