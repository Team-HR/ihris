var personneltrainingsApp = new Vue({
    el: "#personneltrainings-app",
    data() {
        return {
            items: [], //items with respondents
            itemsNoRespondents: []
        }
    },
    methods: {
        initLoad() {
            $.ajax({
                type: "post",
                url: "personneltrainings_proc.php",
                data: {
                    init_load: true,
                    year: "",
                },
                dataType: "json",
                success: (res) => {
                    // console.log(res);
                    this.items = Object.assign([], res.withRespondents);
                    this.itemsNoRespondents = Object.assign([], res.noRespondents);
                }
            });
        },
        editFunc(personneltrainings_id) {
            //get_data
            $.post('personneltrainings_proc.php', {
                get_data: true,
                personneltrainings_id: personneltrainings_id
            }, (data, textStatus, xhr) => {
                /*optional stuff to do after success */
                var array = jQuery.parseJSON(data);
                $("#inputTrainingEdit").val(array.training);
                $("#inputDate1Edit").val(array.startDate);
                $("#inputDate2Edit").val(array.endDate);
                $("#inputHrsEdit").val(array.numHours);
                $("#inputVenueEdit").val(array.venue);
                $("#inputRemarksEdit").val(array.remarks);
                $("#inputTime1_edit").val(array.timeStart);
                $("#inputTime2_edit").val(array.timeEnd);
            });

            $("#editModal").modal({
                onApprove: () => {
                    $.post('personneltrainings_proc.php', {
                        editTraining: true,
                        personneltrainings_id: personneltrainings_id,
                        training: $("#inputTrainingEdit").val(),
                        startDate: $("#inputDate1Edit").val(),
                        endDate: $("#inputDate2Edit").val(),
                        numHours: $("#inputHrsEdit").val(),
                        venue: $("#inputVenueEdit").val(),
                        remarks: $("#inputRemarksEdit").val(),
                        timeStart: $("#inputTime1_edit").val(),
                        timeEnd: $("#inputTime2_edit").val(),
                    }, (data, textStatus, xhr) => {
                        this.initLoad();
                        this.savedMsg();
                    });
                }
            }).modal("show");


        },

        deleteFunc(personneltrainings_id) {
            $("#deleteModal").modal({
                onApprove: () => {
                    $.post('personneltrainings_proc.php', {
                        deleteTraining: true,
                        personneltrainings_id: personneltrainings_id
                    }, (data, textStatus, xhr) => {
                        this.initLoad();
                        this.deletedMsg();
                    });
                }
            }).modal("show");
            // $(deleteMsg);
        },
        addedMsg() {
            // save msg animation start 
            $("#addedMsg").transition({
                animation: 'fly down',
                onComplete: () => {
                    setTimeout(() => {
                        $("#addedMsg").transition('fly down');
                    }, 1000);
                }
            });
            // save msg animation end
        },
        savedMsg() {
            // edit msg animation start 
            $("#savedMsg").transition({
                animation: 'fly down',
                onComplete: () => {
                    setTimeout(() => {
                        $("#savedMsg").transition('fly down');
                    }, 1000);
                }
            });
            // edit msg animation end
        },
        deletedMsg() {
            // delete msg animation start 
            $("#deletedMsg").transition({
                animation: 'fly down',
                onComplete: () => {
                    setTimeout(() => {
                        $("#deletedMsg").transition('fly down');
                    }, 1000);
                }
            });
            // delete msg animation end 
        }


    },
    mounted() {

        // init tab component
        $(".personneltrainings.menu .item").tab();
        this.initLoad()
    },
})
