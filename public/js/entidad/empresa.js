var app = new Vue({
    el:'#wrapper',
    data:{
       empresas:[],
       empresa:{
           id:'',
           razon_social:'',
           nombre_comercial:'',
           ruc:'',
           direccion:'',
           estado:''
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
            this.empresa.ruc=''
            this.empresa.direccion=''
        },
        nuevo()
        {
            this.limpiar()
            $('#empresa-create').modal('show')
        },
        guardar() {
            axios.post('empresas/store',this.empresa)
                .then((response) => {
                    Swal.fire({
                        type : 'success',
                        title : 'EMPRESA',
                        text : response.data.mensaje,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    }).then(respuesta => {
                        if(respuesta.value) {
                            $('#empresa-create').modal('hide')
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
            axios.get('empresas/show',{params: {id:id }})
                .then((response) => {
                    this.empresa.id= response.data.id
                    this.empresa.razon_social= response.data.razon_social
                    this.empresa.nombre_comercial= response.data.nombre_comercial
                    this.empresa.ruc= response.data.ruc
                    this.empresa.direccion= response.data.direccion
                    this.empresa.estado = response.data.estado
                })
        },
        mostrar(id){
            this.limpiar()
            this.cargarDatos(id)
            $('#empresa-show').modal('show')
        },
        editar(id) {
            this.limpiar()
            this.cargarDatos(id)
            $('#empresa-edit').modal('show')
        },
        actualizar() {
            axios.put('empresas/update',this.empresa)
                .then((response) => {
                    Swal.fire({
                        type : 'success',
                        title : 'EMPRESA',
                        text : response.data.mensaje,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    }).then(respuesta => {
                        if(respuesta.value) {
                            $('#empresa-edit').modal('hide')
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
                    axios.post('/empresas/destroy',{id:id})
                    .then((response) => (
                        swal.fire({
                            type : 'success',
                            title : 'Menú',
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
            axios.get('/empresas/mostrarEliminados').then(({ data }) => (
                this.empresas = data,
                this.total_empresas = this.empresas.total
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
                    axios.post('/empresas/restaurar',{id:id})
                    .then((response) => (
                        swal.fire({
                            type : 'success',
                            title : 'EMPRESAS',
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
