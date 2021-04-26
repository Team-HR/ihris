// const { post } = require("jquery");

new Vue({
    el: "#lnd-plan-vue",
    data() {
        return {
            ldplan_id: 0,
            items: [],
            trainings: [],
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
            },
            plan: {
                ldplan_id: null,
                training: "",
                goal: "",
                numHours: "",
                participants: "",
                activities: "",
                evaluation: "",
                frequency: "",
                budgetReq: "",
                partner: "",
                venue: "",
                budget: null
            },
            planDefault: {
                ldplan_id: null,
                training: "",
                goal: "",
                numHours: "",
                participants: "",
                activities: "",
                evaluation: "",
                frequency: "",
                budgetReq: "",
                partner: "",
                venue: "",
                budget: null
            },
            participants: {
                training: "",
                participants: []
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
            if (this.editedIndex != -1) {
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
            } else {
                this.plan.budget = JSON.parse(JSON.stringify(this.budget))
            }
        },
        editBudget(item) {
            // console.log(!item.budget);
            if (!item.budget) {
                this.budget = JSON.parse(JSON.stringify(this.budgetDefault))
            } else {
                this.budget = JSON.parse(JSON.stringify(item.budget))
            }
            if (item.ldplan_id) {
                var index = this.items.map(function (el) {
                    return el.ldplgusponsoredtrainings_id;
                }).indexOf(item.ldplgusponsoredtrainings_id);
                // console.log(index);
                this.editedIndex = index
            }
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
        thousands_separators(num) {
            var num_parts = num.toString().split(".");
            num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return num_parts.join(".");
        },

        editPlan(index) {
            if (index > -1) {
                // this.editedIndex = index
                this.plan = this.items[index]
                var plan = this.plan
                $("#editModalTitle").html("Edit Plan");
                $("#editModal").modal({
                    onDeny: () => {
                        console.log("cancelling...");
                        this.clearPlan()
                    },
                    onApprove: () => {
                        console.log("adding...")
                        console.log(this.plan)
                        $.post('ldplanlgusponsored_proc.php', {
                            editRow: true,
                            ldplgusponsoredtrainings_id: plan.ldplgusponsoredtrainings_id,
                            title_edit: plan.training,
                            goal_edit: plan.goal,
                            hrs_edit: plan.numHours,
                            participants_edit: plan.participants,
                            methods_edit: plan.activities,
                            eval_edit: plan.evaluation,
                            freq_edit: plan.frequency,
                            budget_edit: plan.budgetReq,
                            partner_edit: plan.partner,
                            budget: plan.budget,
                            venue: plan.venue,
                        }, (data, textStatus, xhr) => {
                            console.log(data);
                            this.getItems()
                        });
                    }
                }).modal("show")

            }
            // index  = -1 ; add new modal
            else {
                $("#editModalTitle").html("Add New");
                $("#editModal").modal({
                    onDeny: () => {
                        console.log("cancelling...");
                        this.clearPlan()
                    },
                    onApprove: () => {
                        console.log("adding...")
                        console.log(this.plan)
                        this.items.push(this.plan)
                        var plan = this.plan
                        $.post('ldplanlgusponsored_proc.php', {
                            addNew: true,
                            ldplan_id: this.ldplan_id,
                            training: plan.training,
                            goal: plan.goal,
                            numHours: plan.numHours,
                            participants: plan.participants,
                            activities: plan.activities,
                            evaluation: plan.evaluation,
                            frequency: plan.frequency,
                            budgetReq: plan.budgetReq,
                            partner: plan.partner,
                            budget: plan.budget,
                            venue: plan.venue,
                        }, (data, textStatus, xhr) => {
                            // $(load);
                            // $(msg_added);
                            console.log(data);
                            this.clearPlan()
                            this.getItems()
                        });
                    }
                }).modal("show")
            }
        },

        // delete row start
        deleteRow(ldplgusponsoredtrainings_id) {
            // console.log("delete");
            $("#modal_delete").modal({
                onApprove: () => {
                    $.post('ldplanlgusponsored_proc.php', {
                        deleteRow: true,
                        ldplgusponsoredtrainings_id: ldplgusponsoredtrainings_id
                    }, (data, textStatus, xhr) => {
                        // $(load);
                        // $(msg_deleted);
                        this.getItems()
                    });
                }
            }).modal("show");
        },
        // delete row end


        showParticipants(training,item) {
            this.participants.training = training
            this.participants.participants = JSON.parse(JSON.stringify(item))
            console.log(item);
            $("#showParticipantsModal").modal({
                onHide: () => {
                    $("#showParticipantsAccordion").accordion("close others");
                }
            }).modal("show");
        },



        clearPlan() {
            this.editedIndex = -1
            this.plan = JSON.parse(JSON.stringify(this.planDefault))
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
        getTrainings() {
            $.post('ldplanlgusponsored_proc.php', {
                getTrainings: true
            }, (data, textStatus, xhr) => {
                // var content = jQuery.parseJSON(data);
                $('.getTrainings').search({
                    source: data,
                    searchOnFocus: false,
                    onSelect: (rslt, resp) => {
                        console.log(rslt)
                        this.plan.training = rslt.title
                        // console.log(resp)
                    }
                })
            },
                "json"
            );
        },
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
        this.getTrainings()

        // initialize all modals
        $('.coupled.modal')
            .modal({
                allowMultiple: true,
                closable: false
            })
            ;

        $("#showParticipantsAccordion").accordion();

        // open second modal on first modal buttons
        // $('.second.modal')
        //   .modal('attach events', '.first.modal #addForBtn_');
        // show first immediately



    },
})