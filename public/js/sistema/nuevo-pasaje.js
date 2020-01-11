var app = new Vue({
    el:'#wrapper',
    data:{
        tipoPasaje:['Pagado','Deuda','Adicional'],
        pasaje:{
            tipo_pasaje:'Pagado',
            etapa_persona_id:'',
            local_id:'',
            pasajero:'',
            telefono_pasajero:'',
            email_pasajero:'',
            tipo_documento_id:'',
            numero_documento:'',
            fecha_venta:'',
            ticket_anterior:'',
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
            sub_total:'',
            igv:'',
            total:0,
            pago_soles:'',
            pago_dolares:'',
            pago_visa:'',
            deposito_soles:'',
            deposito_dolares:'',
            deuda:'',
            deuda_detalle:'',
            deuda_monto:'',
            deuda_soles:'',
            deuda_dolares:'',
            deuda_visa:'',
            deuda_depo_soles:'',
            deuda_depo_dolares:'',
            opcional:{
                pasajero:'',
                tipo_documento_id:'',
                numero_documento:'',
                moneda:'USD',
                monto_pagar:0,
                cambio:3.55,
                sub_total:0,
                igv:0,
                total:0,
                pago_soles:0,
                pago_dolares:0,
                pago_visa:0,
                deposito_soles:0,
                deposito_dolares:0,
                adicionales:[]
            },
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
        total_importe:0,
        adicionales:[],
        adicional:{
            adicional_id:'',
            detalle:'',
            otros:'',
            monto:'',
            service_fee:'',
            importe:''
        },
        total_adicionales:0,
        total_opcional:0,
        etapas:[],
        locales:[]
    },
    methods:{
        listarAdicionales() {
            axios.get('adicional/filtro').then(({ data }) => (
                this.adicionales = data,
                this.total_adicionales = this.adicionales.length
            ))
        },
        listarAerolineas(){
            axios.get('/aerolinea/filtro').then(({ data }) => (
                this.aerolineas = data,
                this.total_aerolineas = this.aerolineas.length
            ))
        },
        listarEtapas(){
            axios.get('/etapa-persona/filtro').then(({ data }) => (
                this.etapas = data
            ))
        },
        listarLocales(){
            axios.get('/locales/filtro').then(({ data }) => (
                this.locales = data
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
            var monto_neto = (this.pasaje.monto_neto == '') ? 0 : this.pasaje.monto_neto
            var tarifa = (this.pasaje.tarifa == '') ? 0 : this.pasaje.tarifa
            var tax = (this.pasaje.tax == '') ? 0 : this.pasaje.tax
            var igv = (this.pasaje.igv == '') ? 0 : this.pasaje.igv
            var suma = 0;
            suma = parseFloat(suma) + parseFloat(tarifa)
            suma = parseFloat(suma) + parseFloat(tax)
            suma = parseFloat(suma) + parseFloat(igv)
            var service_fee = parseFloat(monto_neto) - parseFloat(suma)
            this.pasaje.service_fee = (service_fee).toFixed(2)
            total = parseFloat(suma)+ parseFloat(service_fee);
            this.pasaje.total =  total.toFixed(2)
        },
        cambiarHorario(e) {
            this.hora_regreso = (e.target.value == 2) ? true : false
        },
        guardar(){
            axios.post('pasajes/guardar',this.pasaje)
                .then((response) => {
                    console.log(response.data)
                    this.errores=[]
                    this.pasaje_id = response.data.pasaje.id
                    Swal.fire({
                        type : 'success',
                        title : 'VENTA PASAJES',
                        text : response.data.mensaje,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    }).then(respuesta => {
                        if(respuesta.value) {
                            //this.impresion=true
                            window.open('imprimirPasaje/'+this.pasaje_id,'_blank')
                            //window.location.href="pasajeCreate"
                            //document.getElementById("btn-guardar").disabled = true;
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
                const busqueda = this.pasaje.opcional.adicionales.find(adic => adic.detalle === this.adicional.detalle)
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
                        'adicional_id':$('#adicional_name').val(),
                        'detalle' : $('#detalle').val(),
                        'monto' : parseFloat($('#montod').val()),
                        'service_fee' : parseFloat($('#fee').val()),
                        'importe' : ( parseFloat($('#montod').val()) + parseFloat($('#fee').val()))
                    }
                    this.pasaje.opcional.adicionales.push(det);
                    var suma = 0;
                    for(let i=0;i<this.pasaje.opcional.adicionales.length;i++) {
                        suma = parseFloat(suma) + parseFloat(this.pasaje.opcional.adicionales[i].importe)
                    }
                    this.total_importe= suma.toFixed(2)
                    this.pasaje.opcional.monto_pagar =this.total_importe
                    this.pasaje.opcional.sub_total = this.total_importe
                    this.pasaje.opcional.igv = 0
                    this.pasaje.opcional.total =(parseFloat(this.pasaje.opcional.sub_total) + parseFloat(this.pasaje.opcional.igv)).toFixed(2)

                    this.adicional.adicional_id=''
                    this.adicional.detalle = ''
                    this.adicional.monto = ''
                    this.adicional.service_fee=''
                    this.adicional.importe=''
                }
            }
        },
        filtroPorIdAdicional(e) {
            axios.get('adicional/filtroId',{params: { id: e.target.value}})
            .then(( response ) => {
                this.adicional.detalle = response.data.descripcion
                if(response.data.id == 5){
                    this.adicional.detalle = ''
                }
            })
        },
        eliminarAdicional(ind) {
            this.pasaje.opcional.adicionales.splice(ind,1)
        },
        calcularTotalAdicional()
        {
            this.pasaje.opcional.sub_total = parseFloat(this.total_opcional);
            this.pasaje.opcional.total = parseFloat(this.pasaje.opcional.sub_total) + parseFloat(this.pasaje.opcional.igv)
        },
    },
    created() {
        this.listarAerolineas()
        this.empresarPorUsuario()
        this.listarTipoDocumentos()
        this.listarAdicionales()
        this.listarEtapas()
        this.listarLocales()
    }
})
