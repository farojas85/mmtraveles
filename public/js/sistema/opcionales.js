var app = new Vue({
    el:'#wrapper',
    data:{
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
        tipoDocumentos:[],
        total_tipoDocumentos:'',
        impresion:false,
        hora_regreso:false,
        errores:[],
        total_adicionales:0,
        adicionales:[],
        adicional:{
            adicional_id:'',
            detalle:'',
            otros:'',
            monto:'',
            service_fee:'',
            importe:''
        },
        total_importe:0,
        otros:false
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
        listarAdicionales() {
            axios.get('adicional/filtro').then(({ data }) => (
                this.adicionales = data,
                this.total_adicionales = this.adicionales.length
            ))
        },
        seleccionarotro(e)
        {
            if(e.target.value == 5){
                this.adicional.detalle =''
            }
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
        filtroPorId(e) {
            axios.get('adicional/filtroId',{params: { id: e.target.value}})
            .then(( response ) => {
                this.adicional.detalle = response.data.descripcion
                if(response.data.id == 5){
                    this.adicional.detalle = ''
                }
            })
        },
        agregarAdicional() {

            if($('#adicional_name').val() === null || $('#adicional_name').val() === ''){
                Swal.fire({
                        type : 'warning',
                        title : 'DATOS ADICIONALES',
                        text : 'Debe Ingresar Detalle, Monto y/o Service Fee',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    })
            }
            else{
                const busqueda = this.opcional.adicionales.find(adic => adic.detalle === this.adicional.detalle)
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

                    this.opcional.adicionales.push(det);
                    var suma = 0;
                    for(let i=0;i<this.opcional.adicionales.length;i++) {
                        suma = parseFloat(suma) + parseFloat(this.opcional.adicionales[i].importe)
                    }
                    this.total_importe= suma.toFixed(2)
                    this.opcional.monto_pagar =this.total_importe
                    this.opcional.sub_total = this.
                }
            }
        },
        eliminarAdicional(ind) {
            this.opcional.adicionales.splice(ind,1)
        }
    },
    created() {
        this.listarTipoDocumentos()
        this.listarAdicionales()
    }
})
