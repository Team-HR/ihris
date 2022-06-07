new Vue({
    el: "#cons-tna-vue",
    data() {
        return {
            cons: [],
            item: {},
            targets: []
        }
    },
    methods: {
        getConsolidatedTNA() {
            
            $.post("./dna_proc.php", {
                getConsolidatedTNA: true
            }, (data, textStatus, jqXHR) => {
                // console.log(data);
                this.cons = JSON.parse(JSON.stringify(data));

                this.$nextTick(() => {
                    // The whole view is rendered, so I can safely access or query
                    // the DOM. ¯\_(ツ)_/¯
                    // $(".ui.accordion").accordion();
                })
            },
                "json"
            );
        },
        showTargetParticipants(item) {
            // $("#targetsAccordion").accordion("refresh");



            // $(".ui.accordion.target.participants").accordion("refresh");
            // console.log(item);
            this.item = JSON.parse(JSON.stringify(item));
            
            // $(".targetParticipantsContainer").html();

            $.post('dna_proc.php', {
                getTargetParticipants: true,
                training_id: this.item.training_id,
                departments: this.item.departments
            }, (data, textStatus, xhr) => {
                console.log(data);
                this.targets = data
                /*optional stuff to do after success */
                this.$nextTick(() => {
                    // The whole view is rendered, so I can safely access or query
                    // the DOM. ¯\_(ツ)_/¯
                    // $("#targetsAccordion").accordion();
                    $("#targetsAccordion").accordion("refresh");
                    $(".ui.modal.target.participants").modal("show");
                })

            },
                "json"
            );

        }



    },
    mounted() {
        this.getConsolidatedTNA()
    },

})