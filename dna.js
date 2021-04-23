new Vue({
    el: "#cons-tna-vue",
    data() {
        return {
            cons: []
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
                    $(".ui.accordion").accordion();
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