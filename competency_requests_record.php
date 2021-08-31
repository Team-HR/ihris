<!DOCTYPE html>
<html>

<head>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
</head>

<body>
    <div id="app">
        <v-app>
            <v-main>
                <v-container>
                    <template>

                        <v-card class="mx-auto" width="1000">
                            <v-card-title primary-title>
                                <v-btn color="info" class="mr-5" text @click="back()">Back</v-btn>
                                <h3>{{full_name}}</h3>
                            </v-card-title>
                            <v-card-text>

                                {{self_assessed_record}}

                            </v-card-text>
                        </v-card>


                    </template>
                </v-container>
            </v-main>
        </v-app>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        new Vue({
            el: '#app',
            vuetify: new Vuetify(),
            data() {
                return {
                    id: new URLSearchParams(window.location.search).get("id"),
                    self_assessed_record: []
                }
            },
            methods: {
                back() {
                    window.history.back();
                },
                get_self_assessed_record() {
                    $.get(`competency_requests.ajax.php?get_self_assessed_record=${this.id}`,
                        (data, textStatus, jqXHR) => {
                            this.self_assessed_record = JSON.parse(JSON.stringify(data))
                            // console.log(data);
                        },
                        "json"
                    );
                }
            },
            computed: {
                full_name() {
                    return this.self_assessed_record.last_name + ", " + this.self_assessed_record.first_name + " " + this.self_assessed_record.middle_name + " " + this.self_assessed_record.ext_name
                }
            },
            mounted() {
                this.get_self_assessed_record()
            }
        })
    </script>
</body>

</html>