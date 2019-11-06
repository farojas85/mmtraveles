var app = new Vue({
    el:'#wrapper',
    data:{
       pasaje:{
           pasajero:'',
           codigo:'',
           ruta:'',
           tipo_viaje:'',
           not_igv:0,
           aerolinea_id:'',
           porcentaje:'',
           razon_social:'',
           direccion:'',
           pasaje_total:'',
           monto_neto:'',
           tuaa:'',
           pago_soles:'',
           pago_dolares:'',
           pago_visa:'',
           deposito_soles:'',
           deposito_dolares:'',
           telefono:'',
           observaciones:'',
           fecha_venta:'',
           razon_social:'',
           direccion:''
       },
       aerolineas:[],
       total_aerolineas:'',
       images:[
           { id: 611 , ruta: 'images/aerolineas/peruvian.png'},
           { id: 612 , ruta: 'images/aerolineas/latam.jpg'},
           { id: 613 , ruta: 'images/aerolineas/costamar.png'},
           { id: 614 , ruta: 'images/aerolineas/avianca.png'},
           { id: 622 , ruta: 'images/aerolineas/atsa.jpeg'},
       ],
       logo_linea:'images/aerolineas/peruvian.png',
       empresa:[],
       impresion:true,
       pasaje_id:''
    },
    methods:{
        listarAerolineas(){
            axios.get('/aerolinea/filtro').then(({ data }) => (
                this.aerolineas = data,
                this.total_aerolineas = this.aerolineas.length
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
    }
})
