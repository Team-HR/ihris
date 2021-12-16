<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>

<style>
    tr {
        text-align: center;
    }
</style>

<div id="app">
    <template>
        <div v-for="(page,p) in num_pages" style="_page-break-inside:avoid; display: _block; _height: 297mm;">

            <table :key="p" border="1" style="table-layout:fixed; border-collapse: collapse; height: 100%; page-break-inside:avoid;">
                <tr v-for="(row,i) in num_rows" :key="i">
                    <td style="width:105mm; height: 32mm">{{employees[((num_rows*p)+i)*2]}}</td>
                    <td style="width:105mm; height: 32mm">{{employees[(((num_rows*p)+i)*2)+1]}}</td>
                </tr>
            </table>

        </div>
    </template>
</div>

<script>
    new Vue({
        el: "#app",
        data: {
            num_pages: 0,
            num_rows: 8,
            num_employees_per_page: 0,
            department: "CITY TREASURER'S OFFICE",
            employees: [
                "SUMALPONG, GEMMA G.",
                "ACABAL, BERNARDO  A.",
                "AMADEO, ROVILLA V.",
                "ADAPON, SHERYL G.",
                "ALVIOLA, EDGARDO A.",
                "ASPAREN, SARITA ALICIA N.",
                "ATAY, SUSAN V.",
                "BALASABAS, MA. CLARETTE T.",
                "BARRON, EMERALD A.",
                "BAYNOSA, LODEBER T.",
                "CORDEVILLA, CHUCHO V.",
                "DUHAYLUNGSOD, WILLIAM P., JR.",
                "ESTIÑOSO, MA. JEZEBEL G.",
                "GANTALAO, MARICON C.",
                "GERONA, HENELYN D.",
                "GOTLADERA, ARNEL ANTONIO Q.",
                "GOTLADERA, GREMAR Y.",
                "GRACIADAS, SYLVIA S.",
                "HOYOHOY, JENETTE B.",
                "JAMANDRON, JOHNJAY F.",
                "JOSEPH, FE JANET B.",
                "LACSON, VICTORIO S.",
                "MAPUTY, WILDE G.",
                "MARTINEZ, ELENITA M.",
                "MELENDRES, RUSSEL IRA B.",
                "MONCAL, RACHEL B.",
                "OCCEÑA, DEMETRIO S.",
                "OJEÑOS, IAN A.",
                "GALABAY, EMMEROSE O.",
                "PIÑERO, ARGEL JOSEPH L.",
                "PIÑERO, NOVA V.",
                "QUINDO, NOEL T.",
                "RUSIANA, JONATHAN T.",
                "SENIEL, FRETCHIE",
                "TABILON, ROSALINDA A.",
                "TATON, DIOSAN T.",
                "TIGMO, ELVIE CARMEL A.",
                "TORALDE, MENCHU V.",
                "TUBESA, JUVY D.",
                "VILLARIN, MA. RAYZA E.",
                "YURONG, CHRISTOPHER S.",
                "VECENTE M. BERONIO",
                "REY V. CORDOVA",
                "JUDITH T. DUKA",
                "VILMA G. RENDON",
                "TALEON, GALILEO T.",
                "TRIAS, JOAN",
                "YAP, DEEVI COREN S.",
                "ABADIANO, BEATRIZ",
                "ABRASALDO, JUN EARL T.",
                "ARROYO, ESTELA",
                "BACARAT, AMERSHAD M.",
                "BALUCOS, NOEMIE P.",
                "BAWEGA,  RONEL L.",
                "CADALSO, JUNERALLEN Y.",
                "CANCIO, RESELITO D.",
                "CATID, NOVALIE",
                "DILOY, MAYRIE JOY",
                "DUHAYLUNGSOD, GEMMA",
                "ENRIQUEZ, GODOFREDO ANTHONY II, M.",
                "ESNARDO, RYAN",
                "MASAYON, MARC ERIC E.",
                "MEMIS, MARLON S.",
                "PABRO, PAUL XERZIES Y.",
                "PALAMOS, LESLIE A.",
                "PAMILAGA, ALLEN JOHN",
                "PAPASIN, NOEL Q. JR.",
                "SANOY, ARNIEL",
                "SAYSON, JUDITO",
                "SUMALPONG, IAN",
                "TABAY, KERR A.",
                "TIGLE, OLIVER JR., M.",
                "TULAYBA, ARIANNE G.",
                "VILLAMIL, LILY H.",
            ]
        },
        methods: {
            get_num_pages() {
                var employees = this.employees
                var length = 0
                length = this.employees.length
                this.num_employees_per_page = this.num_rows * 2
                this.num_pages = Math.ceil(length / (this.num_rows * 2))
                console.log(this.num_pages)
            }
        },
        mounted() {
            this.get_num_pages()
            console.log(Math.ceil(74 / this.num_rows));
        }
    })
</script>