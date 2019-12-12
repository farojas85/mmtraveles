var app = new Vue({
    el:'#wrapper',
    data:{
        pasajes:[],
        total_pasajes:'',
        images:[
            { id: 611 , ruta: 'images/aerolineas/peruvian.png'},
            { id: 612 , ruta: 'images/aerolineas/latam.jpg'},
            { id: 613 , ruta: 'images/aerolineas/costamar.png'},
            { id: 614 , ruta: 'images/aerolineas/avianca.png'},
            { id: 622 , ruta: 'images/aerolineas/atsa.jpeg'},
        ],
        logo_linea:'images/aerolineas/peruvian.png',
        suma_reporte:0,
        lugares:[],
        locales:[],
        counters:[],
        aerolineas:[],
        busqueda:{
            lugar:'%',
            local:'%',
            counter:'%',
            aerolinea:'%',
            fecha_ini:'',
            fecha_fin:''
        },
        errores:[]
    },
    methods:{
        listarLugares() {
            axios.get('/pasaje-emitidos/listar-lugar')
            .then(response => {
                this.lugares = response.data
                this.locales =  []
                this.counters=[]
                this.aerolineas=[]
                this.busqueda.lugar = '%'
                this.busqueda.local = '%'
                this.busqueda.counter = '%'
                this.busqueda.aerolinea='%'
            });
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
                this.busqueda.aerolinea = '%'
            })
        },
        listaPasaje(){
            axios.get('/pasajes/ventas',{params:this.busqueda}).then((response) => {
                console.log(response.data)
                this.pasajes = response.data
                this.total_pasajes = this.pasajes.length
                this.suma_reporte =0
                for(let i = 0; i <this.total_pasajes; i++)
                {
                    this.suma_reporte += parseFloat(this.pasajes[i].total)
                }
            })
        },
    },
    created() {
        this.listarLugares()
        //this.listaPasaje()
    }
})
