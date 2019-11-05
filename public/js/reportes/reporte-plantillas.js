var app = new Vue({
    el:'#wrapper',
    data:{
       reporte:[],
       total_reporte:'',
       aerolineas:[],
       total_aerolineas:'',
       busqueda:{
            aerolinea_id:'',
            fecha_ini:'',
            fecha_fin:''
       },
       lugar:'',
       lugar_detalle:'',
       suma_reporte:0
    },
    methods: {

        listaraerolineas() {
            axios.get('/aerolinea/filtro').then((response) => {
                this.aerolineas = response.data,
                this.total_aerolineas = this.aerolineas.length
            })
        },
        buscar(){
            axios.get('/reporte-caja-general/tabla',{params:this.busqueda }).then((response) => {
                this.reporte = response.data
                this.total_reporte = this.reporte.length
                this.suma_reporte =0
                this.reporte.forEach(element => {
                    this.suma_reporte += element.pasaje_total
                });
            })
        }
    },
    created() {
        this.listaraerolineas();
    }
})
