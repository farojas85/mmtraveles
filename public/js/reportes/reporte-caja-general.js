var app = new Vue({
    el:'#wrapper',
    data:{
        filtro_aerolineas:[],
        tipoDocumentos:[],
        reporte:[],
        pasaje:{},
        total_reporte:0,
        deudas:[],
        total_deudas:0,
        suma_deudas:0,
        adicionales:[],
        adicional:{
            adicional_detalle:[]
        },
        hora_regreso:false,
        adicional_filtro:[],
        adicional_add:{
            adicional_id:'',
            detalle:'',
            otros:'',
            monto:'',
            service_fee:'',
            importe:''
        },
        total_adicionales:0,
        suma_adicionales:0,
        lugares:[],
        locales:[],
        counters:[],
        total_lugares:'',
        busqueda:{
            lugar:'%',
            local:'%',
            counter:'%',
            aerolinea:'%',
            fecha_ini:'',
            fecha_fin:''
        },
        lugar:'',
        lugar_detalle:'',
        suma_reporte:0,
        aerolineas:[],
        total_aerolineas:0,
        errores:[]
    },
    methods: {
        listarLugares() {
            axios.get('/lugares/lista').then((response) => {
                this.lugares = response.data
                this.total_lugares = this.lugares.length
                let lugard=''
                indice=0
                for (x=0;x<this.lugares.length;x++){
                    indice++;
                    if(indice==1)
                    {
                        lugard +=this.lugares[x].name;
                    }
                    else{
                        lugard += " - "+this.lugares[x].name;
                    }
                }
                this.lugar_detalle = lugard;
                this.locales=[]
                this.counters=[]
                this.aerolineas=[]
                this.busqueda.lugar='%'
                this.busqueda.local='%'
                this.busqueda.counter='%'
                this.busqueda.aerolinea='%'
            })
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
        buscar(){
            axios.get('/reporte-caja-general/tabla',{params:this.busqueda })
            .then((response) => {
                this.reporte = response.data.pasajes
                this.total_reporte = this.reporte.length
                this.suma_reporte =0
                this.reporte.forEach(element => {
                    this.suma_reporte += parseFloat(element.total)
                })

                this.deudas = response.data.deudas
                this.total_deudas = this.deudas.length
                this.suma_deudas = 0
                this.deudas.forEach(element => {
                    this.suma_deudas += parseFloat(element.deuda_monto)
                })

                this.adicionales = response.data.adicionales
                this.total_adicionales = this.adicionales.length
                this.suma_adicionales = 0;
                this.adicionales.forEach(element => {
                    this.suma_adicionales += parseFloat(element.total)
                })
                this.errores=[]
            })
            .catch((errors) => {
                if(response = errors.response) {
                    this.errores = response.data.errors,
                    console.clear()
                }
            })
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
                this.busqueda.aerolinea='%'
                this.total_aerolineas = this.aerolineas.length
            })
        },
        listarUsuarios() {
            axios.get('/reporte-caja-general/lista-usuarios')
            .then(response => {
                this.counters = response.data
                this.busqueda.counter = '%'
            });
        },
        filtroAerolineas(){
            axios.get('/aerolinea/filtro').then(({ data }) => (
                this.filtro_aerolineas = data
            ))
        },
        listarTipoDocumentos() {
            axios.get('tipo-documentos/filtro').then(({ data }) => (
                this.tipoDocumentos = data,
                this.total_tipoDocumentos = this.tipoDocumentos.length
            ))
        },
        filtroAeroPorId(e) {
            axios.get('/aerolinea/filtro-id',{params:{id: e.target.value}})
            .then(({data}) => (
                this.aerolinea.id= data.id,
                this.aerolinea.name = data.name,
                this.aerolinea.description = data.description,
                this.pasaje.ruc = data.ruc,
                this.pasaje.direccion = data.direccion
            ))
        },
        cambiarHorario(e) {
            this.hora_regreso = (e.target.value == 2) ? true : false
        },
        seleccionarDeuda(e){
            this.pasaje.deuda_detalle=''
            if(e.target.value=="essalud"){
                this.pasaje.deuda_detalle = "Es-Salud";
            }
        },
        calcularTotal()
        {
            this.pasaje.sub_total = ( parseFloat(this.pasaje.tarifa) + parseFloat(this.pasaje.tax) + parseFloat(this.pasaje.service_fee) ).toFixed(2);
            this.pasaje.total = (parseFloat(this.pasaje.sub_total) + parseFloat(this.pasaje.igv)).toFixed(2);
        },
        mostrarPasajePagado(id) {
            axios.get('reporte-caja-general/show-pasaje',{params:{id:id}})
            .then((response) => {
                this.pasaje = response.data;
            })
        },
        editarPasajePagado(id){
            this.filtroAerolineas()
            this.listarTipoDocumentos()
            this.mostrarPasajePagado(id)
            $('#pasaje-pagado-edit').modal('show');
        },
        guardarPasaje(){
            axios.post('reporte-caja-general/guardar-pasaje',this.pasaje)
                .then((response) => {
                    Swal.fire({
                        type : 'success',
                        title : 'PASAJES',
                        text : response.data.mensaje,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    }).then(respuesta => {
                        if(respuesta.value) {
                           $('#pasaje-pagado-edit').modal('hide')
                           this.buscar()
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
                       this.buscar()
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
                       this.buscar()
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
        mostrarAdicional(id) {
            axios.get('reporte-caja-general/lista-adicional',{params:{id:id}})
            .then((response) => {
                this.adicional = response.data.adicional
                this.adicional.adicional_detalle = response.data.adicional_detalle
            })
        },
        filtrarAdicionales() {
            axios.get('adicional/filtro').then(({ data }) => (
                this.adicional_filtro = data
            ))
        },
        filtroPorId(e) {
            axios.get('adicional/filtroId',{params: { id: e.target.value}})
            .then(( response ) => {
                this.adicional_add.detalle = response.data.descripcion
                if(response.data.id == 5){
                    this.adicional_add.detalle = ''
                }
            })
        },
        agregarAdicionalTabla() {

            if($('#detalle').val() === null || $('#detalle').val() === '' || $('#montod').val() ==='' || $('#fee').val()==='' ){
                Swal.fire({
                        type : 'warning',
                        title : 'DATOS ADICIONALES',
                        text : 'Debe Ingresar Detalle, Monto y/o Service Fee',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    })
            }
            else{
                const busqueda = this.adicional.adicional_detalle.find(adic => adic.detalle === this.adicional_add.detalle)
                if(busqueda){
                     Swal.fire({
                            type : 'warning',
                            title : 'DATOS ADICIONALES',
                            text : 'Ya se ecuentra añadido el Detalle',
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor:"#1abc9c",
                        })
                }
                else {
                    var det = {
                        'adicional_id':$('#adicional_id').val(),
                        'detalle' : $('#detalle').val(),
                        'monto' : parseFloat($('#montod').val()),
                        'service_fee' : parseFloat($('#fee').val()),
                        'importe' : ( parseFloat($('#montod').val()) + parseFloat($('#fee').val()))
                    }

                    this.adicional.adicional_detalle.push(det);

                    var suma = 0;
                    for(let i=0;i<this.adicional.adicional_detalle.length;i++) {
                        suma = parseFloat(suma) + parseFloat(this.adicional.adicional_detalle[i].importe)
                    }

                    this.total_importe= suma.toFixed(2)
                    this.adicional.monto_pagar =this.total_importe
                    this.adicional.sub_total = this.total_importe
                    this.adicional.igv = 0
                    this.adicional.total =(parseFloat(this.adicional.sub_total) + parseFloat(this.adicional.igv)).toFixed(2)

                    this.adicional_add.adicional_id=''
                    this.adicional_add.detalle = ''
                    this.adicional_add.monto = ''
                    this.adicional_add.service_fee=''
                    this.adicional_add.importe=''
                }
            }
        },
        eliminarAdicionalTabla(ind) {

            this.adicional.adicional_detalle.splice(ind,1)

            if(this.adicional.adicional_detalle.length===0)
            {
                this.adicional.total = 0;
                this.adicional.monto_pagar = 0;
                this.adicional.sub_total = 0;
                this.adicional.igv=0;
            }
            else {

                let suma = 0;
                for(let i=0;i<this.adicional.adicional_detalle.length;i++) {
                    suma = parseFloat(suma) + parseFloat(this.adicional.adicional_detalle[i].importe)
                }
                this.total_importe= suma.toFixed(2)
                this.adicional.monto_pagar =this.total_importe
                this.adicional.sub_total = this.total_importe
                this.adicional.igv = 0
                this.adicional.total =(parseFloat(this.adicional.sub_total) + parseFloat(this.adicional.igv)).toFixed(2)
            }

        },
        editarAdicional(id) {
            this.filtrarAdicionales()
            this.mostrarAdicional(id)
            $('#adicional-edit').modal('show')
        },
        actualizarAdicional() {
            axios.post('reporte-caja-general/actualizar-adicional',this.adicional)
            .then((response) => {
                Swal.fire({
                    type : 'success',
                    title : 'REGISTRO ADICIONALES',
                    text : response.data.mensaje,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor:"#1abc9c",
                }).then(respuesta => {
                    if(respuesta.value) {
                        $('#adicional-edit').modal('hide')
                        this.buscar();
                    }
                })
            })
        },
        eliminarAdicional(id) {
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
                    this.eliminarAdicionalTemporal(id)
                }
                else if( response.dismiss === swal.DismissReason.cancel) {
                   this.eliminarAdicionalPermanente(id)
                }
            }).catch(error => {
                swal.showValidationError(
                    `Ocurrió un Error: ${error.response.status}`
                )
            })
        },
        eliminarAdicionalTemporal(id) {
            axios.post('/reporte-caja-general/eliminar-adicional-temporal',{id:id})
            .then((response) => (
                swal.fire({
                    type : 'success',
                    title : 'Adicionales',
                    text : response.data.mensaje,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor:"#1abc9c",
                }).then(respuesta => {
                    if(respuesta.value) {
                       this.buscar()
                    }
                })
            ))
            .catch((errors) => {
                if(response = errors.response) {
                    this.errores = response.data.errors
                }
            })
        },
        eliminarAdicionalPermanente(id) {
            axios.post('/reporte-caja-general/eliminar-adicional-permanente',{id:id})
            .then((response) => (
                swal.fire({
                    type : 'success',
                    title : 'Adicionales',
                    text : response.data.mensaje,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor:"#1abc9c",
                }).then(respuesta => {
                    if(respuesta.value) {
                       this.buscar()
                    }
                })
            ))
            .catch((errors) => {
                if(response = errors.response) {
                    this.errores = response.data.errors
                }
            })
        },
    },
    created() {
        //this.listarLugares()
        this.listarUsuarios()
    }
})
