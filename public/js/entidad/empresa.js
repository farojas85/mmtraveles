var app = new Vue({
    el:'#wrapper',
    data:{
       empresas:[],
       empresa:{
           id:'',
           razon_social:'',
           nombre_comercial:''
       },
       total_empresas:0,
       errores:[],
       offset:4,
       showdeletes:false
    },
    computed:{
        isActived() {
            return this.empresas.current_page;
        },
        pagesNumber() {
            if (!this.empresas.to) {
                return [];
            }
            var from = this.empresas.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + (this.offset * 2);
            if (to >= this.empresas.last_page) {
                to = this.empresas.last_page;
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
            axios.get('/empresas/lista').then(({ data }) => (
                this.empresas = data,
                this.total_empresas = this.empresas.total
             ))
        },
        getResults(page=1) {
            if(this.showdeletes == false) {
                axios.get('/empresas/lista?page=' + page)
                .then(response => {
                    this.empresas = response.data
                    this.total_empresas = this.empresas.total
                });
            }
            else {
                axios.get('/empresas/mostrarEliminados?page=' + page)
                .then(response => {
                    this.empresas = response.data
                    this.total_empresas = this.empresas.total
                });
            }
        },
        changePage(page) {
            this.empresas.current_page = page
            this.getResults(page)
        },
        limpiar(){
            this.errores=[]
            this.empresa.razon_social=''
            this.empresa.nombre_comercial = ''
        },
        nuevo()
        {
            this.limpiar()
            $('#empresa-create').modal('show')
        },
    },
    created() {
        this.listar()
        this.getResults()
    }
})
