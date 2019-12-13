var app = new Vue({
    el:'#wrapper',
    data:{
       reporte:[],
       total_reporte:'',
       deudas:[],
       total_deudas:0,
       suma_deudas:0,
       adicionales:[],
       total_adicionales:0,
       suma_adicionales:0,
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
                this.reporte = response.data.pasajes
                this.total_reporte = this.reporte.length
                this.suma_reporte =0
                this.reporte.forEach(element => {
                    this.suma_reporte += parseFloat(element.total)
                })

                this.deudas = response.data.deudas
                this.total_deudas = this.deudas.length
                this.suma_deudas = 0
                this.deudas.forEach(element => {
                    this.suma_deudas += parseFloat(element.deuda_monto)
                })

                this.adicionales = response.data.adicionales
                this.total_adicionales = this.adicionales.length
                this.suma_adicionales = 0;
                this.adicionales.forEach(element => {
                    this.suma_adicionales += parseFloat(element.importe)
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
        },
        listarUsuarios() {
            axios.get('/reporte-caja-general/lista-usuarios')
            .then(response => {
                this.counters = response.data
                this.busqueda.counter = '%'
            });
        }
    },
    created() {
        this.listarLugares()
        this.listarUsuarios()
    }
})
