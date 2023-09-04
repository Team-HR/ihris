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
                <h3 class="info--text">COMPETENCY RECORD REQUEST</h3>
              </v-card-title>

              <v-card-text>
                <v-data-table :headers="headers" :items="records" :items-per-page="5">

                  <template v-slot:item.actions="{ item }">
                    <v-btn color="info" :href=`competency_requests_record.php?id=${item.id}` text>Open</v-btn>
                  </template>
                  <template v-slot:no-data>
                    <v-btn color="primary" @click="get_records">
                      Reset
                    </v-btn>
                  </template>
                </v-data-table>
                <!-- {{records}} -->
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
          records: [],
          headers: [{
              text: 'Request #',
              align: 'right',
              sortable: false,
              value: 'id',
            },
            {
              text: 'Last Name',
              value: 'last_name'
            },
            {
              text: 'First Name',
              value: 'first_name'
            },
            {
              text: 'Middle Name',
              value: 'middle_name'
            },
            {
              text: 'Ext',
              value: 'ext_name'
            },
            {
              text: 'Assessment Timestamp',
              value: 'created_at'
            },
            {
              text: 'Actions',
              value: 'actions',
              align: 'center',
              sortable: false
            },
          ],
        }
      },
      methods: {
        get_records() {
          $.get("competency_requests.ajax.php?get_records",
            (data, textStatus, jqXHR) => {
              this.records = JSON.parse(JSON.stringify(data))
              // console.log(data);
            },
            "json"
          );
        }
      },
      mounted() {
        this.get_records()
      }
    })
  </script>
</body>

</html>