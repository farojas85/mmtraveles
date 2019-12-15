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
        otros:false,
        pasaje_id:''
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
        calcularTotal()
        {
            this.opcional.sub_total = parseFloat(this.total_importe);
            this.opcional.total = parseFloat(this.opcional.sub_total) + parseFloat(this.opcional.igv)
        },
        guardar(){
            if(this.opcional.adicionales.length== 0){
                Swal.fire({
                    type : 'warning',
                    title : 'REGISTRO ADICIONALES',
                    text : 'Debe Registrar al menos un Detalle en Adicionales',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor:"#1abc9c",
                })
            }
            else {
                axios.post('opcional/guardar',this.opcional)
                    .then((response) => {
                        console.log(response.data)
                        this.opcional_id = response.data.opcional.id
                        Swal.fire({
                            type : 'success',
                            title : 'REGISTRO ADICIONALES',
                            text : response.data.mensaje,
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor:"#1abc9c",
                        }).then(respuesta => {
                            if(respuesta.value) {
                                //window.location.href="pasajeCreate"
                            }
                        })
                    })
                    .catch((errors) => {
                        response = errors.response
                        if(response) {
                            this.errores = response.data.errors,
                            Swal.fire({
                                type : 'warning',
                                title : 'REGISTRO ADICIONALES',
                                text : 'Ingrese datos en Campos Obligatorios',
                                confirmButtonText: 'Aceptar',
                                confirmButtonColor:"#1abc9c",
                            }),
                            console.clear()
                        }
                    })
            }
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
                    this.opcional.sub_total = this.total_importe
                    this.opcional.igv = 0
                    this.opcional.total =(parseFloat(this.opcional.sub_total) + parseFloat(this.opcional.igv)).toFixed(2)

                    this.adicional.adicional_id=''
                    this.adicional.detalle = ''
                    this.adicional.monto = ''
                    this.adicional.service_fee=''
                    this.adicional.importe=''
                }
            }
        },
        eliminarAdicional(ind) {

            this.opcional.adicionales.splice(ind,1)

            if(this.opcional.adicionales.length===0)
            {
                this.opcional.total = 0;
                this.opcional.monto_pagar = 0;
                this.opcional.sub_total = 0;
                this.opcional.igv=0;
            }
            else {

                let suma = 0;
                for(let i=0;i<this.opcional.adicionales.length;i++) {
                    suma = parseFloat(suma) + parseFloat(this.opcional.adicionales[i].importe)
                }
                this.total_importe= suma.toFixed(2)
                this.opcional.monto_pagar =this.total_importe
                this.opcional.sub_total = this.total_importe
                this.opcional.igv = 0
                this.opcional.total =(parseFloat(this.opcional.sub_total) + parseFloat(this.opcional.igv)).toFixed(2)
            }

        }
    },
    created() {
        this.listarTipoDocumentos()
        this.listarAdicionales()
    }
})
