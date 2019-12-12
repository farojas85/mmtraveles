var app = new Vue({
    el:'#wrapper',
    data:{
       reporte:[],
       total_reporte:'',
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
        }
    },
    created() {
        this.listarLugares()
    }
})
