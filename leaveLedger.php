<?php
$title = "Leave Ledger";

require_once "header.php";
?>

<div class="ui segment" id="leaveLedger">
  <template>
    <li v-for="(item, index) in rows" :key="index">
      {{index+1}} || {{item}}
    </li>
  </template>
</div>

<script>
  var leaveLedger = new Vue({
    el: "#leaveLedger",
    data: {
      rows: []
    },
    methods: {
      getRows() {
        $.post("leaveLedger.backend.php", {
            getRows: true,
            employee_id: 31835
          }, (data, textStatus, jqXHR) => {
            console.log(data);
            this.rows = data
          },
          "json"
        );
      }
    },
    mounted() {
      this.getRows()
    },

  })
</script>

<?php
require_once "footer.php";
?>