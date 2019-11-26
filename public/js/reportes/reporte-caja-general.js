var app = new Vue({
    el:'#wrapper',
    data:{
       reporte:[],
       total_reporte:'',
       lugares:[],
       total_lugares:'',
       busqueda:{
            lugar_id:'',
            fecha_ini:'',
            fecha_fin:'',
            aerolinea_id:''
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
                this.lugares = response.data,
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
            })
        },
        buscar(){
            axios.get('/reporte-caja-general/tabla',{params:this.busqueda })
            .then((response) => {
                this.reporte = response.data
                this.total_reporte = this.reporte.length
                this.suma_reporte =0
                this.reporte.forEach(element => {
                    this.suma_reporte += element.tarifa
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
        listarAerolineas() {
            axios.get('/reporte-caja-general/listarAerolineas')
            .then((response) => {
                this.aerolineas = response.data
                this.total_aerolineas = this.aerolineas.length
            })
        }
    },
    created() {
        this.listarLugares();
        this.listarAerolineas();
    }
})
