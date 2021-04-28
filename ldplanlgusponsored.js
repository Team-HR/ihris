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
                multiplier: 1,
                fors: [],
            },
            budgetDefault: {
                allocated: "",
                multiplier: 1,
                fors: [],
            },
            forItem: {
                for: "",
                amount: ""
            },
            forItemDefault: {
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
                budget: {
                    allocated: "",
                    multiplier: 1,
                    fors: [],
                },
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
                budget: {
                    allocated: "",
                    multiplier: 1,
                    fors: [],
                },
            },
            participants: {
                training: "",
                participants: []
            }
        }
    },
    methods: {
        editBudget(item) {
            // console.log(item);
            if (!item.budget) {
                this.budget = JSON.parse(JSON.stringify(this.budgetDefault))
            } else {
                // console.log("else:",item);
                
                this.budget = item.budget//JSON.parse(JSON.stringify(item.budget))
                if (!this.budget.fors) {
                    this.budget = {
                        allocated: this.budget.allocated,
                        multiplier: this.budget.multiplier?this.budget.multiplier: 1,
                        fors: []
                    }
                }
                console.log("this.budget:",this.budget);
                    
            }
            if (item.ldplgusponsoredtrainings_id) {
                var index = this.items.map(function (el) {
                    return el.ldplgusponsoredtrainings_id;
                }).indexOf(item.ldplgusponsoredtrainings_id);
                this.editedIndex = index
            }
            $('.first.modal').modal('show');
        },
        addFor() {
            var newFor = JSON.parse(JSON.stringify(this.forItem))
            // var budgetDefault = JSON.parse(JSON.stringify(this.budgetDefault))
            this.budget.fors.push(newFor)
        },
        sortBudgetFors() {
            // console.log("sorted");
            if (this.budget.fors) {
                this.budget.fors.sort((a, b) => (Number(a.amount) < Number(b.amount)) ? 1 : -1)
            }
        },
        trashFor(i) {
            this.budget.fors.splice(i, 1)
        },

        saveBudget() {
            // for existing plan
            // console.log(this.editedIndex);
            if (this.editedIndex != -1) {
                var editedIndex = this.editedIndex
                // get items[editedIndex].ldplgusponsoredtrainings_id 
                // console.log(this.items[editedIndex]);
                var ldplgusponsoredtrainings_id = this.items[editedIndex].ldplgusponsoredtrainings_id
                var budget = JSON.parse(JSON.stringify(this.budget))
                // console.log(budget);
                $.post("ldplanlgusponsored_proc.php", {
                    updateBudget: true,
                    ldplgusponsoredtrainings_id: ldplgusponsoredtrainings_id,
                    budget: budget
                }, (data, textStatus, jqXHR) => {


                    // if existing clear all 
                    // if (this.editedIndex > -1) {
                    // this.clearPlan()
                    // this.getItems()
                    // }
                    // else if new
                    // else {
                    // console.log(data);
                    this.items[editedIndex].budget = data
                    // this.budget = JSON.parse(JSON.stringify( this.budgetDefault))
                    this.plan.budget = JSON.parse(JSON.stringify(data))
                    // this.editedIndex = -1
                    // }

                },
                    "json"
                );

            }
            // for new plan
            else {
                this.plan.budget = JSON.parse(JSON.stringify(this.budget))
            }

        },















        getBudgetTotal() {
            var total = 0
            if (this.budget.fors) {
                this.budget.fors.forEach(item => {
                    total += item.amount
                });
            }
            this.budget.total = total
        },

        getTotal(fors) {
            var total = 0
            // if (this.budget.fors) {
                fors.forEach(item => {
                    total += Number(item.amount)
                });
            // }
            return total
        },
        getChange(budget) {

            if (!budget.allocated) return 0

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
        countDepts(arr) {
            var count = 0
            if (arr) {
                count = arr.length
            }
            return count
        },







        editPlan(index) {
            console.log(index);
            if (index > -1) {
                // this.editedIndex = index
                this.plan = this.items[index]
                console.log(this.plan);
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
                // console.log(this.plan);
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
                        // console.log(this.items);
                        var plan = this.plan
                        console.log(plan);
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
                        }, "json");
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


        showParticipants(training, item) {
            this.participants.training = training
            this.participants.participants = JSON.parse(JSON.stringify(item))
            console.log(item);
            $("#showParticipantsModal").modal({
                onHidden: () => {
                    $("#showParticipantsAccordion").accordion("open", 0);
                    // console.log("onHide");
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
                console.log(this.items);
                // console.log("items: ", this.items);
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
        isNotEmpty(arr) {
            if (arr) {
                if (arr.length > 0) {
                    return true
                }
                return false
            } else return false
        }
    },
    computed: {
        multiple() {
            var multiple = this.budget.allocated
            if (this.budget.multiplier) {
                multiple = Number(multiple) * Number(this.budget.multiplier)
            }
            return multiple
            // return this.budget.multiplier
        },
        totalBudget() {
            var total = 0
            if (this.budget.fors) {
                this.budget.fors.forEach(item => {
                    total += Number(item.amount)
                });
            }
            return total
        },
        changeBudget() {
            var change = 0
            if (this.budget.allocated) {
                change = this.budget.allocated - this.totalBudget
            }
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