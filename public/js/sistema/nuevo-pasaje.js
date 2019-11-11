var app = new Vue({
    el:'#wrapper',
    data:{
       pasaje:{
           pasajero:'',
           tipo_documento:'',
           numero_documento:'',
           fecha_venta:'',
           ticket_number:'',
           aerolinea_id:'',
           direccion:'',
           ruc:'',
           codigo:'',
           ruta:'',
           tipo_viaje:'',
           fecha_vuelo:'',
           hora_vuelo:'',
           vuelo:'',
           cl:'',
           st:'',
           equipaje:'',
           moneda:'',
           cambio:'',
           not_igv:0,
           tarifa:'',
           tax:'',
           service_fee:'',
           sub_total:'',
           igv:'',
           total:''
       },
       aerolineas:[],
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
       pasaje_id:'',
       errores:[],

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
                console.log(data),
                this.tipoDocumentos = data,
                this.total_tipoDocumentos = this.tipoDocumentos.length
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
        guardar(){
            axios.post('pasajes/guardar',this.pasaje)
                .then((response) => {
                    this.pasaje_id = response.data.pasaje.id
                    Swal.fire({
                        type : 'success',
                        title : 'VENTA PASAJES',
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
        imprimir()
        {
            axios.get('pasajeImprimir',{params:{pasaje_id: this.pasaje_id}})
            .then((response) => {

            })
        }
    },
    created() {
        this.listarAerolineas()
        this.empresarPorUsuario()
        this.listarTipoDocumentos()
    }
})
