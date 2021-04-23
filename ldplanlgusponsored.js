// const { post } = require("jquery");

new Vue({
    el: "#lnd-plan-vue",
    data() {
        return {
            ldplan_id: 0,
            items: [],
            editedIndex: -1,
            budget: {
                allocated: "",
                fors: [],
            },
            budgetDefault: {
                allocated: "",
                fors: [],
            },
            budgetItem: {
                for: "",
                amount: ""
            },
            budgetItemDefault: {
                for: "",
                amount: ""
            }
        }
    },
    methods: {
        addFor() {
            var newFor = JSON.parse(JSON.stringify(this.budgetItem))
            this.budget.fors.push(newFor)
        },
        saveAddedFor() {
            var item = JSON.parse(JSON.stringify(this.budgetItem))
            this.budget.fors.push(item)
            this.budgetItem = JSON.parse(JSON.stringify(this.budgetItemDefault))
            // this.getBudgetTotal()
        },
        trashFor(i) {
            this.budget.fors.splice(i, 1)
        },
        getBudgetTotal() {
            var total = 0
            this.budget.fors.forEach(item => {
                total += item.amount
            });
            this.budget.total = total
        },
        sortBudgetFors() {
            this.budget.fors.sort((a, b) => (Number(a.amount) < Number(b.amount)) ? 1 : -1)
        },
        saveBudget() {
            // console.log(this.budget);
            var editedIndex = this.editedIndex
            // get items[editedIndex].ldplgusponsoredtrainings_id 
            var ldplgusponsoredtrainings_id = this.items[editedIndex].ldplgusponsoredtrainings_id
            var budget = JSON.parse(JSON.stringify(this.budget))

            $.post("ldplanlgusponsored_proc.php", {
                updateBudget: true,
                ldplgusponsoredtrainings_id: ldplgusponsoredtrainings_id,
                budget: budget
            }, (data, textStatus, jqXHR) => {

                // console.log(ldplgusponsoredtrainings_id);
                // vue update
                this.items[editedIndex].budget = budget
                // reset
                this.budget = JSON.parse(JSON.stringify(this.budgetDefault))
                this.editedIndex = -1

            },
                "json"
            );
        },
        editBudget(item) {

            if (!item.budget) {
                this.budget = JSON.parse(JSON.stringify(this.budgetDefault))
            } else {
                this.budget = JSON.parse(JSON.stringify(item.budget))
            }
            var index = this.items.map(function (el) {
                return el.ldplgusponsoredtrainings_id;
            }).indexOf(item.ldplgusponsoredtrainings_id);
            // console.log(index);
            this.editedIndex = index

            $('.first.modal').modal('show');

        },
        getTotal(fors) {
            var total = 0
            fors.forEach(item => {
                total += Number(item.amount)
            });
            return total
        },
        getChange(budget) {
            var change = 0,
                allocated = budget.allocated,
                total = 0

            budget.fors.forEach(item => {
                total += Number(item.amount)
            });

            change = Number(allocated) - total

            return change
        },
        thousands_separators(num)
        {
            var num_parts = num.toString().split(".");
            num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return num_parts.join(".");
        },



















        getURLparams() {
            var url = new URL(window.location.href);
            this.ldplan_id = url.searchParams.get("ldplan_id");
        },
        getItems() {
            $.post("ldplanlgusponsored_proc.php", {
                getItems: true,
                ldplan_id: this.ldplan_id
            }, (data, textStatus, jqXHR) => {
                this.items = data
                // console.log(this.items);
            },
                "json"
            );
        },
        editRow(id) {
            // console.log(id);
        },
        deleteRow(id) {
            // console.log(id);
        }
    },
    computed: {
        totalBudget() {
            var total = 0
            this.budget.fors.forEach(item => {
                total += Number(item.amount)
            });
            return total
        },
        changeBudget() {
            var change = 0
            change = this.budget.allocated - this.totalBudget
            return change
        },
    },
    mounted() {
        // this.getBudgetTotal()

        this.getURLparams()
        this.getItems()


// initialize all modals
$('.coupled.modal')
  .modal({
      allowMultiple: true,
      closable: false
  })
;
// open second modal on first modal buttons
// $('.second.modal')
//   .modal('attach events', '.first.modal #addForBtn_');
// show first immediately



    },
})