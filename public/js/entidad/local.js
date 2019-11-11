var app = new Vue({
    el:'#wrapper',
    data:{
       locales:[],
       local:{
           id:'',
           nombre:'',
           descripcion:'',
           empresa_id:'',
           lugar_id:'',
           estado:''
       },
       total_locales:0,
       errores:[],
       offset:4,
       showdeletes:false,
       empresas:[],
       lugares:[]
    },
    computed:{
        isActived() {
            return this.locales.current_page;
        },
        pagesNumber() {
            if (!this.locales.to) {
                return [];
            }
            var from = this.locales.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + (this.offset * 2);
            if (to >= this.locales.last_page) {
                to = this.locales.last_page;
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
        listarEmpresa(){
            axios.get('empresas/filtro')
                .then(({data}) =>(
                    this.empresas = data
                ))
        },
        listarLugares(){
            axios.get('lugares/filtro')
                .then(({data}) =>(
                    this.lugares = data
                ))
        },
        listar() {
            axios.get('/locales/lista').then(({ data }) => (
                this.locales = data,
                this.total_locales = this.locales.total
             ))
        },
        getResults(page=1) {
            if(this.showdeletes == false) {
                axios.get('/locales/lista?page=' + page)
                .then(response => {
                    this.locales = response.data
                    this.total_locales = this.locales.total
                });
            }
            else {
                axios.get('/locales/mostrarEliminados?page=' + page)
                .then(response => {
                    this.locales = response.data
                    this.total_locales = this.locales.total
                });
            }
        },
        changePage(page) {
            this.locales.current_page = page
            this.getResults(page)
        },
        limpiar(){
            this.errores=[]
            this.local.nombre=''
            this.local.descripcion = ''
            this.local.empresa_id=''
            this.local.lugar_id=''
            this.local.estado =''
        },
        nuevo()
        {
            this.listarEmpresa()
            this.listarLugares()
            this.limpiar()
            $('#local-create').modal('show')
        },
        guardar() {
            axios.post('locales/store',this.local)
                .then((response) => {
                    Swal.fire({
                        type : 'success',
                        title : 'LOCAL',
                        text : response.data.mensaje,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    }).then(respuesta => {
                        if(respuesta.value) {
                            $('#local-create').modal('hide')
                            this.listar()
                            this.getResults()
                        }
                    })
                })
                .catch((errors) => {
                    if(response = errors.response) {
                        this.errores = response.data.errors,
                        console.clear()
                    }
                })
        },
        cargarDatos(id){
            axios.get('locales/show',{params: {id:id }})
                .then((response) => {
                    this.local.id= response.data.id
                    this.local.nombre= response.data.nombre
                    this.local.empresa_id= response.data.empresa_id
                    this.local.lugar_id= response.data.lugar_id
                    this.local.estado  = response.data.estado
                })
        },
        mostrar(id){
            this.limpiar()
            this.listarEmpresa()
            this.listarLugares()
            this.cargarDatos(id)
            $('#local-show').modal('show')
        },
        editar(id) {
            this.limpiar()
            this.listarEmpresa()
            this.listarLugares()
            this.cargarDatos(id)
            $('#local-edit').modal('show')
        },
        actualizar() {
            axios.put('locales/update',this.local)
                .then((response) => {
                    Swal.fire({
                        type : 'success',
                        title : 'LOCALES',
                        text : response.data.mensaje,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    }).then(respuesta => {
                        if(respuesta.value) {
                            $('#local-edit').modal('hide')
                            this.listar()
                            this.getResults()
                        }
                    })
                })
                .catch((errors) => {
                    if(response = errors.response) {
                        this.errores = response.data.errors,
                        console.clear()
                    }
                })
        },
        eliminar(id){
            swal.fire({
                title:"¿Está Seguro de Eliminar?",
                text:'No podrás revertirlo',
                type:"question",
                showCancelButton: true,
                confirmButtonText:"Si",
                confirmButtonColor:"#38c172",
                cancelButtonText:"No",
                cancelButtonColor:"#e3342f"
            }).then( response => {
                if(response.value){
                    axios.post('/locales/destroy',{id:id})
                    .then((response) => (
                        swal.fire({
                            type : 'success',
                            title : 'LOCALES',
                            text : response.data.mensaje,
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor:"#1abc9c",
                        }).then(respuesta => {
                            if(respuesta.value) {
                                this.listar(),
                                this.getResults()
                            }
                        })
                    ))
                    .catch((errors) => {
                        if(response = errors.response) {
                            this.errores = response.data.errors
                        }
                    })
                }
            }).catch(error => {
                this.$Progress.fail()
                swal.showValidationError(
                    `Ocurrió un Error: ${error.response.status}`
                )
            })
        },
        mostrarEliminados() {
            this.showdeletes = true
            axios.get('/locales/mostrarEliminados').then(({ data }) => (
                this.locales = data,
                this.total_locales = this.locales.total
            ))
            this.getResults()
        },
        mostrarTodos() {
            this.showdeletes = false
            this.listar()
            this.getResults()
        },
        restaurar(id){
            swal.fire({
                title:"¿Está Seguro de Restaurar el Registro?",
                text:'Puede Eliminarlo Cuando desee',
                type:"question",
                showCancelButton: true,
                confirmButtonText:"Si",
                confirmButtonColor:"#38c172",
                cancelButtonText:"No",
                cancelButtonColor:"#e3342f"
            }).then( response => {
                if(response.value){
                    axios.post('/locales/restaurar',{id:id})
                    .then((response) => (
                        swal.fire({
                            type : 'success',
                            title : 'LOCALES',
                            text : response.data.mensaje,
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor:"#1abc9c",
                        }).then(respuesta => {
                            if(respuesta.value) {
                                this.showdeletes = false;
                                this.listar(),
                                this.getResults()
                            }
                        })
                    ))
                    .catch((errors) => {
                        if(response = errors.response) {
                            this.errores = response.data.errors
                        }
                    })
                }
            }).catch(error => {
                this.$Progress.fail()
                swal.showValidationError(
                    `Ocurrió un Error: ${error.response.status}`
                )
            })
        }
    },
    created() {
        this.listar()
        this.getResults()
    }
})
