<?php
/*
    Add two new columns after num_years_in_gov namely: 
    years_of_service_gov and years_of_service_priv with text as dataype and nullable
    Uncomment iterator function below to alter format of data
*/
// require_once "_connect.db.php";

$data = [];
require_once "header.php";
?>
<div id="perf_rating_list_app">
    <template>
        <div class="ui segment container">
            <h1>Final Numerical Ratings</h1>
            <span>Period: {{period_label}}</span> <br>
            <table class="ui table selectable compact structured">
                <!-- <thead>
                    <tr>
                        <td>Name</td>
                    </tr>
                </thead> -->
                <tbody>
                    <tr v-for="item in items" :key="item.id">
                        <td>{{item.employees_id}}</td>
                        <td><button class="ui mini basic button" @click="copy_rating(item.rating)">Copy</button> {{item.rating}}</td>
                        <td>{{item.name}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </template>
</div>
<script>
    new Vue({
        el: "#perf_rating_list_app",
        data() {
            return {
                period: new URL(location.href).searchParams.get('period'),
                period_label: '',
                items: []
            }
        },
        methods: {
            init_load() {
                this.get_period_label()
                this.get_list()
            },
            get_list() {
                $.post("performance_ratings_list_proc.php", {
                    get_list: true,
                    period: this.period
                }, (data, status) => {
                    this.items = JSON.parse(data);
                    // console.log(data);
                });
            },
            get_period_label() {
                $.post("performance_ratings_list_proc.php", {
                    get_period_label: true,
                    period: this.period
                }, (data, status) => {
                    this.period_label = data;
                });
            },
            copy_rating(rating) {
                // Copy the text inside the text field
                navigator.clipboard.writeText(rating);
                $('body').toast({
                    class: 'success',
                    position: 'top left',
                    showIcon: false,
                    message: 'Copied! ' + rating
                });
            }
        },
        mounted() {
            this.init_load()
        },
    })
</script>
<!-- <pre>
    <?php
    print_r($data);
    ?>
</pre> -->