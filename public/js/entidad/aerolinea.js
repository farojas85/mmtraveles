
var app = new Vue({
    el:'#wrapper',
    data:{
       aerolineas:[],
       aerolinea:{},
       total_aerolineas:'',
       errores:[],
       offset:4,
       showdeletes:false
    },
    computed:{
        isActived() {
            return this.aerolineas.current_page;
        },
        pagesNumber() {
            if (!this.aerolineas.to) {
                return [];
            }
            var from = this.aerolineas.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + (this.offset * 2);
            if (to >= this.aerolineas.last_page) {
                to = this.aerolineas.last_page;
            }
            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        },
    },
    methods:{
        listar() {
            axios.get('/aerolinea/lista').then(({ data }) => (
                this.aerolineas = data,
                this.total_aerolineas = this.aerolineas.total
             ))
        },
        getResults(page=1) {
            if(this.showdeletes == false) {
                axios.get('/aerolinea/lista?page=' + page)
                .then(response => {
                    this.aerolineas = response.data
                    this.total_aerolineas = this.aerolineas.total
                });
            }
            else {
                axios.get('/aerolinea/mostrarEliminados?page=' + page)
                .then(response => {
                    this.aerolineas = response.data
                    this.total_aerolineas = this.aerolineas.total
                });
            }
        },
        changePage(page) {
            this.aerolineas.current_page = page
            this.getResults(page)
        },
    },
    created() {
        this.listar()
    }
})
