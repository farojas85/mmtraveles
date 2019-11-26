var app = new Vue({
    el:'#wrapper',
    data:{
       reporte:[],
       total_reporte:0,
       offset:4,
       pasaje:[],
       busqueda:{
           fecha_ini:'',
           fecha_fin:''
       },
       errores:[],
       pasajesEliminar:[],
       seleccionarTodo:false,
       encontrados:'',
       adicionales:[],
       total_adicionales:0,
       suma_adicionales:0
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
        buscar() {
           axios.get('/pasaje-emitidos/tabla',{params: this.busqueda})
           .then((respuesta ) => {
                this.reporte = respuesta.data.pasaje
                this.total_reporte = this.reporte.length
                this.encontrados =respuesta.data.contar
                if(this.encontrados == 0){
                    this.total_reporte = -1;
                }
                this.errores=[]
            }) 
            .catch((errors) => {
                if(response = errors.response) {
                    this.errores = response.data.errors,
                    console.clear()
                }
            })
        },
        listarEmitidos(){
            axios.get('/pasaje-emitidos/tabla').then(({ data }) => (
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
                text:'No podrás revertirlo',
                type:"question",
                showCancelButton: true,
                confirmButtonText:"Si",
                confirmButtonColor:"#38c172",
                cancelButtonText:"No",
                cancelButtonColor:"#e3342f"
            }).then( response => {
                if(response.value){
                    axios.post('/pasajes/destroy',{id:id})
                    .then((response) => (
                        swal.fire({
                            type : 'success',
                            title : 'Pasajes',
                            text : response.data.mensaje,
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor:"#1abc9c",
                        }).then(respuesta => {
                            if(respuesta.value) {
                                this.listarEmitidos();
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
        
        
        
        eliminarSeleccionados() {
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
                    axios.post('/pasajes/eliminarSeleccionados',this.pasajesEliminar)
                    .then((response) => (
                        swal.fire({
                            type : 'success',
                            title : 'Menú',
                            text : response.data.mensaje,
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor:"#1abc9c",
                        }).then(respuesta => {
                            if(respuesta.value) {
                                this.listarEmitidos()
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
        //this.listarEmitidos();
        //this.getResults();
    },

})
