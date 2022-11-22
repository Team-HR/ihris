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
<div id="perf_rating_app">
    <template>
        <div class="ui segment container">
            <form action="performance_ratings_list.php" method="GET">
                <select name="period" id="period" class="ui dropdown" required>
                    <option value="">Select Period</option>
                    <option value="21">July - Dec 2021</option>
                    <option value="22">Jan - June 2022</option>
                </select>
                <button type="submit" class="ui button">Submit</button>
            </form>
        </div>
    </template>
</div>
<script>
    new Vue({
        el: "#perf_rating_app",
        data() {
            return {
                test: "test"
            }
        },
        mounted() {
            $("#period").dropdown();
        },
    })
</script>
<!-- <pre>
    <?php
    print_r($data);
    ?>
</pre> -->