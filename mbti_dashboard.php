<div id="mbtiVueApp">
    <template>
        <!-- results down here -->
        <template v-if="results.length > 0">
            <div v-for="result, res in results" :key="res" class="ui segment green">
                <h3>Personality Type: {{result.personalityType}}</h3> <i>({{result.created_at}})</i>
                <div class="ui grid" style="margin-top: 10px;">
                    <div class="two wide column" v-for="res, key in result.raw" :key="key">
                        <h3 style="text-align: center;">{{key}}</h3>
                        <h4>Total Points: {{result.raw[key].total}}</h4>
                        <li v-for="item, i in result.raw[key].qc" :key="i">{{item.code}} - {{item.points}}</li>
                    </div>
                    <br>
                </div>
            </div>
        </template>

        <a class="ui green small button" href="mbti.php">Start Test</a>
    </template>
</div>

<script>
    new Vue({
        el: "#mbtiVueApp",
        data() {
            return {
                results: {}
            }
        },
        methods: {
            getDataIfExisting() {
                $.post("mbti_proc.php", {
                        getDataIfExisting: true
                    },
                    (data, textStatus, jqXHR) => {
                        // console.log(data);
                        this.results = data
                    },
                    "json"
                );
            },
        },
        mounted() {
            this.getDataIfExisting()
        }
    })
</script>