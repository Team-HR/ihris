var auth_user_app = new Vue({
    el: "#auth_user_app",
    data() {
        return {
            user: {},
            employees_id: new URLSearchParams(window.location.search).get("employees_id"),
        }
    },
    methods: {
        get_auth() {
            $.post("employeeinfo.v2.ajax.php", {
                get_auth_user: true,
                employees_id: this.employees_id,
            }, (data, textStatus, jqXHR) => {
                this.user = JSON.parse(JSON.stringify(data))
                console.log(data);
            },
                "json"
            );
        },
    },
    mounted() {
        this.get_auth()
    }

});