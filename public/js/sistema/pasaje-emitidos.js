var app = new Vue({
    el:'#wrapper',
    data:{
       reporte:[],
       total_reporte:0,
       offset:4,
       pasaje:{},
       busqueda:{
           lugar:'%',
           local:'%',
           counter:'%',
           aerolinea:'%',
           fecha_ini:'',
           fecha_fin:''
       },
       show_pasaje:'',
       errores:[],
       lugares:[],
       locales:[],
       counters:[],
       aerolineas:[],
       pasajesEliminar:[],
       seleccionarTodo:false,
       encontrados:'',
       adicionales:[],
       total_adicionales:0,
       suma_adicionales:0,
       tipoDocumentos:[]
    },
    computed:{
        isActived() {
            return this.reporte.current_page;
        },
        pagesNumber() {
            if (!this.reporte.to) {
                return [];
            }
            var from = this.reporte.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + (this.offset * 2);
            if (to >= this.reporte.last_page) {
                to = this.reporte.last_page;
            }
            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        },
    },
    methods: {
        listarTipoDocumentos() {
            axios.get('tipo-documentos/filtro').then(({ data }) => (
                this.tipoDocumentos = data
                //this.total_tipoDocumentos = this.tipoDocumentos.length
            ))
        },
        buscar() {
           axios.get('/pasaje-emitidos/'+this.show_pasaje,{params: this.busqueda})
           .then((respuesta ) => {
               //console.log(respuesta.data)
                this.reporte = respuesta.data.pasaje
                this.total_reporte = this.reporte.length
                if(this.total_reporte == 0){
                    this.total_reporte = -1;
                }
                this.errores=[]
            })
            .catch((errors) => {
                if(response = errors.response) {
                    this.errores = response.data.errors,
                    console.log(this.errores)
                }
            })
        },
        listarEliminados() {
            this.show_pasaje='eliminados'
            this.buscar()
        },
        listarTodos() {
            this.show_pasaje = 'todos'
            this.buscar()
        },
        listarActivos() {
            this.show_pasaje = 'activos'
            this.buscar()
        },
        listarEmitidos(){
            axios.get('/pasaje-emitidos/tabla',{params: this.busqueda})
            .then(({ data }) => (
                console.log(data),
                this.reporte = data,
                this.total_reporte = this.reporte.total
             ))
        },
        getResults(page=1) {
            axios.get('/pasaje-emitidos/tabla?page=' + page)
            .then(response => {
                this.reporte = response.data
                this.total_reporte = this.reporte.total
            });
        },
        changePage(page) {
            this.reporte.current_page = page
            this.getResults(page)
        },
        listarLugares() {
            axios.get('/pasaje-emitidos/listar-lugar')
            .then(response => {
                this.lugares = response.data
                this.locales =  []
                this.counters=[]
                this.aerolineas=[]
                this.busqueda.lugar = '%'
                this.busqueda.local = '%'
                this.busqueda.counter = '%'
                this.busqueda.aerolinea='%'
            });
        },
        listarLocales(e) {
            axios.get('/pasaje-emitidos/listar-local',{params: { lugar: e.target.value}})
            .then(response => {
                this.locales = response.data
                this.counters = []
                this.aerolineas=[]
                this.busqueda.local = '%'
                this.busqueda.counter = '%'
                this.busqueda.aerolinea='%'
            });
        },
        listarCounters(e) {
            axios.get('/pasaje-emitidos/listar-counter',
                {params: {
                    lugar: this.busqueda.lugar,
                    local: e.target.value
            }})
            .then(response => {
                this.counters = response.data
                this.aerolineas=[]
                this.busqueda.counter = '%'
                this.busqueda.aerolinea='%'
            });
        },
        listarAerolineas(e) {
            axios.get('/reporte-caja-general/listarAerolineas',{
                params:{
                    lugar: this.busqueda.lugar,
                    local: this.busqueda.local,
                    counter: e.target.value
                }
            })
            .then((response) => {
                this.aerolineas = response.data
                this.busqueda.aerolinea = '%'
            })
        },
        listarUsuarios() {
            axios.get('/reporte-caja-general/lista-usuarios')
            .then(response => {
                this.counters = response.data
                this.busqueda.counter = '%'
            });
        },
        seleccionar_todo() {
            this.pasajesEliminar = []
            if(!this.seleccionarTodo){
                for(var i=0; i<this.reporte.length;i++)
                {
                    this.pasajesEliminar.push(this.reporte[i].id)
                }
            }
        },
        eliminar(id) {
            swal.fire({
                title:"¿Está Seguro de Eliminar?",
                text:'Pasaje Emitidos',
                type:"question",
                showCancelButton: true,
                confirmButtonText:"<i class='fas fa-trash-alt'></i> A Papelera",
                confirmButtonColor:"#6610f2",
                cancelButtonText:"<i class='fas fa-eraser'></i> Permanentemente",
                cancelButtonColor:"#e3342f"
            }).then( (response) => {
                if(response.value) {
                    this.eliminarTemporal(id)
                }
                else if( response.dismiss === swal.DismissReason.cancel) {
                   this.eliminarPermanente(id)
                }
            }).catch(error => {
                swal.showValidationError(
                    `Ocurrió un Error: ${error.response.status}`
                )
            })
        },
        eliminarTemporal(id) {
            axios.post('/pasaje-emitidos/eliminar-temporal',{id:id})
            .then((response) => (
                swal.fire({
                    type : 'success',
                    title : 'Pasajes Emitidos',
                    text : response.data.mensaje,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor:"#1abc9c",
                }).then(respuesta => {
                    if(respuesta.value) {
                       this.listarActivos()
                    }
                })
            ))
            .catch((errors) => {
                if(response = errors.response) {
                    this.errores = response.data.errors
                }
            })
        },
        eliminarPermanente(id) {
            axios.post('/pasaje-emitidos/eliminar-permanente',{id:id})
            .then((response) => (
                swal.fire({
                    type : 'success',
                    title : 'Pasajes Emitidos',
                    text : response.data.mensaje,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor:"#1abc9c",
                }).then(respuesta => {
                    if(respuesta.value) {
                       this.listarActivos()
                    }
                })
            ))
            .catch((errors) => {
                if(response = errors.response) {
                    this.errores = response.data.errors
                }
            })
        },
        restaurar(id) {
            swal.fire({
                title:"¿Está Seguro de Restaurar?",
                text:'Pasajes Emitidos',
                type:"question",
                showCancelButton: true,
                confirmButtonText:"Si",
                confirmButtonColor:"#28a745",
                cancelButtonText:"No",
                cancelButtonColor:"#dc3545"
            }).then( (response) => {
                if(response.value) {
                    axios.post('/pasaje-emitidos/restaurar',{id:id})
                    .then((response) => (
                        swal.fire({
                            type : 'success',
                            title : 'Pasajes Emitidos',
                            text : response.data.mensaje,
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor:"#1abc9c",
                        }).then(respuesta => {
                            if(respuesta.value) {
                            this.listarActivos()
                            }
                        })
                    ))
                    .catch((errors) => {
                        if(response = errors.response) {
                            this.errores = response.data.errors
                        }
                    })
                }
            }).catch((errors) => {
                if(response = errors.response) {
                    this.errores = response.data.errors
                    swal.fire({
                        type : 'error',
                        title : 'Módulos',
                        text : this.errores,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    })
                }
            })
        },
        eliminarSeleccionados() {
            swal.fire({
                title:"¿Está Seguro de Eliminar?",
                text:'Pasaje Emitidos',
                type:"question",
                showCancelButton: true,
                confirmButtonText:"<i class='fas fa-trash-alt'></i> A Papelera",
                confirmButtonColor:"#6610f2",
                cancelButtonText:"<i class='fas fa-eraser'></i> Permanentemente",
                cancelButtonColor:"#e3342f"
            }).then( (response) => {
                if(response.value) {
                    this.eliminarSeleccionadosTemporal()
                }
                else if( response.dismiss === swal.DismissReason.cancel) {
                   this.eliminarSeleccionadosPermanente()
                }
            }).catch(error => {
                swal.showValidationError(
                    `Ocurrió un Error: ${error.response.status}`
                )
            })
        },
        eliminarSeleccionadosTemporal() {
            axios.post('/pasaje-emitidos/eliminar-seleccionados-temporal',this.pasajesEliminar)
            .then((response) => (
                swal.fire({
                    type : 'success',
                    title : 'Menú',
                    text : response.data.mensaje,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor:"#1abc9c",
                }).then(respuesta => {
                    if(respuesta.value) {
                       this.listarActivos()
                    }
                })
            ))
            .catch((errors) => {
                if(response = errors.response) {
                    this.errores = response.data.errors
                }
            })
        },
        eliminarSeleccionadosPermanente() {
            axios.post('/pasaje-emitidos/eliminar-seleccionados-permanente',this.pasajesEliminar)
            .then((response) => (
                swal.fire({
                    type : 'success',
                    title : 'Pasajes Emitidos',
                    text : response.data.mensaje,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor:"#1abc9c",
                }).then(respuesta => {
                    if(respuesta.value) {
                        this.listarActivos()
                        //this.getResults()
                    }
                })
            ))
            .catch((errors) => {
                if(response = errors.response) {
                    this.errores = response.data.errors
                }
            })
        },
        editarPasaje(id) {
            axios.get('pasaje-emitidos/editar',{params:{id:id}})
            .then((response) => {
                this.pasaje = response.data
                this.listarTipoDocumentos()
                $('#editar-pasaje').modal('show');
            })
        },
        verAdicionales(id) {
            axios.get('/pasaje-emitidos/pasaje-adicional',{params:{id:id}})
            .then(response => {
                this.adicionales = response.data
                this.total_adicionales = this.adicionales.length
                var suma =0;
                for(let i=0;i < this.total_adicionales; i++)
                {
                    suma = parseFloat(suma) + parseFloat(this.adicionales[i].total)
                }
                this.suma_adicionales = suma.toFixed(2)
                $('#adicional-modal').modal('show')
            });
        }
    },
    created() {
        this.listarUsuarios()
        //this.listarLugares()
        //this.listarEmitidos();
        //this.getResults();
    },

})
