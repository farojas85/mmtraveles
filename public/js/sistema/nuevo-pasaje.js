var app = new Vue({
    el:'#wrapper',
    data:{
        pasaje:{
            pasajero:'',
            tipo_documento_id:'',
            numero_documento:'',
            fecha_venta:'',
            ticket_number:'',
            aerolinea_id:'',
            direccion:'',
            ruc:'',
            codigo:'',
            ruta:'',
            ruta_vuelta:'',
            tipo_viaje:'',
            fecha_vuelo:'',
            fecha_retorno:'',
            hora_vuelo:'',
            hora_vuelta:'',
            vuelo:'',
            vuelo_vuelta:'',
            cl:'',
            cl_vuelta:'',
            st:'',
            st_vuelta:'',
            equipaje:'',
            equipaje_vuelta:'',
            moneda:'USD',
            monto_neto:'',
            cambio:3.55,
            not_igv:1,
            tarifa:'',
            tax:'',
            service_fee:'',
            sub_total:0,
            igv:0,
            total:0,
            pago_soles:'',
            pago_dolares:'',
            pago_visa:'',
            deposito_soles:'',
            deposito_dolares:'',
            adicionales:[],
            deuda:'',
            deuda_detalle:'',
            deuda_monto:''
        },
        aerolineas:[],
        aerolinea:{
            id:'',
            name:'',
            description:'',
            ruc:'',
            direccion:''
        },
        total_aerolineas:'',
        tipoDocumentos:[],
        total_tipoDocumentos:'',
        images:[
           { id: 611 , ruta: 'images/aerolineas/peruvian.png'},
           { id: 612 , ruta: 'images/aerolineas/latam.jpg'},
           { id: 613 , ruta: 'images/aerolineas/costamar.png'},
           { id: 614 , ruta: 'images/aerolineas/avianca.png'},
           { id: 622 , ruta: 'images/aerolineas/atsa.jpeg'},
        ],
        logo_linea:'images/aerolineas/peruvian.png',
        empresa:[],
        impresion:false,
        hora_regreso:false,
        pasaje_id:'',
        errores:[],
        total_adicionales:0,
        adicional:{
            detalle:'',
            monto:'',
            service_fee:'',
            importe:''
        },
        total_importe:0,
    },
    methods:{
        listarAerolineas(){
            axios.get('/aerolinea/filtro').then(({ data }) => (
                this.aerolineas = data,
                this.total_aerolineas = this.aerolineas.length
            ))
        },
        listarTipoDocumentos() {
            axios.get('tipo-documentos/filtro').then(({ data }) => (
                this.tipoDocumentos = data,
                this.total_tipoDocumentos = this.tipoDocumentos.length
            ))
        },
        filtroPorId(e) {
            axios.get('/aerolinea/filtro-id',{params:{id: e.target.value}})
            .then(({data}) => (
                console.log(data),
                this.aerolinea.id= data.id,
                this.aerolinea.name = data.name,
                this.aerolinea.description = data.description,
                this.pasaje.ruc = data.ruc,
                this.pasaje.direccion = data.direccion
            ))
        },
        empresarPorUsuario() {
            axios.get('/empresas/empresaUsuario').then(({ data }) => (
                this.empresa = data
            ))
        },
        seleccionarImage(event){
            imagen = this.images.filter( image => image.id == event.target.value);
            if(imagen.length >0){
                this.logo_linea =this.images.filter( image => image.id == event.target.value)[0].ruta.toString()
            }
            else{
                this.logo_linea=''
            }
            //this.logo_linea = this.images.filter( image => image.id == event.target.value)[0].ruta.toString()
        },
        calcularIgv(e)
        {
            if(event.target.checked === true)
            {
                this.pasaje.igv = 0
            }
            else
            {
                 this.pasaje.igv = parseFloat(this.pasaje.sub_total)*0.18
            }
             this.pasaje.total = parseFloat(this.pasaje.sub_total) + parseFloat(this.pasaje.igv)
        },
        calcularTotal()
        {

            this.pasaje.sub_total = parseFloat(this.pasaje.tarifa) + parseFloat(this.pasaje.tax) + parseFloat(this.pasaje.service_fee);
            this.pasaje.total = parseFloat(this.pasaje.sub_total) + parseFloat(this.pasaje.igv)
        },
        cambiarHorario(e) {
            this.hora_regreso = (e.target.value == 2) ? true : false
        },
        guardar(){
            axios.post('pasajes/guardar',this.pasaje)
                .then((response) => {
                    console.log(response.data)

                    this.pasaje_id = response.data.pasaje.id
                    Swal.fire({
                        type : 'success',
                        title : 'VENTA PASAJES',
                        text : response.data.mensaje,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    }).then(respuesta => {
                        if(respuesta.value) {
                            this.impresion=true
                            document.getElementById("btn-guardar").disabled = true;
                            //window.location.href="pasajeCreate"
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

        verPasajes()
        {
            window.location.href="pasajeVentas";
        },
        seleccionarDeuda(e){
            this.pasaje.deuda_detalle=''
            if(e.target.value=="essalud"){
                this.pasaje.deuda_detalle = "Es-Salud";
            }
        },
        imprimir()
        {
            axios.get('pasajeImprimir',{params:{pasaje_id: this.pasaje_id}})
            .then((response) => {

            })
        },
        agregarAdicional() {

            if($('#detalle').val() === null || $('#detalle').val() === ''){
                Swal.fire({
                        type : 'warning',
                        title : 'DATOS ADICIONALES',
                        text : 'Debe Ingresar Detalle, Monto y/o Service Fee',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    })
            }
            else{
                const busqueda = this.pasaje.adicionales.find(adic => adic.detalle === this.adicional.detalle)
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
                        'detalle' : $('#detalle').val(),
                        'monto' : parseFloat($('#montod').val()),
                        'service_fee' : parseFloat($('#fee').val()),
                        'importe' : ( parseFloat($('#montod').val()) + parseFloat($('#fee').val()))
                    }

                    this.pasaje.adicionales.push(det);
                    var suma = 0;
                    for(let i=0;i<this.pasaje.adicionales.length;i++) {
                        suma = parseFloat(suma) + parseFloat(this.pasaje.adicionales[i].importe)
                    }
                    this.total_importe= suma.toFixed(2)
                }
            }
        },
        eliminarAdicional(ind) {
            this.pasaje.adicionales.splice(ind,1)
        }
    },
    created() {
        this.listarAerolineas()
        this.empresarPorUsuario()
        this.listarTipoDocumentos()
    }
})
