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
            fecha_fin:''
       },
       lugar:'',
       lugar_detalle:'',
       suma_reporte:0
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
        this.listarLugares();
    }
})
