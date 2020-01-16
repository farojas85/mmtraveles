var app = new Vue({
    el:'#wrapper',
    data:{
        texto:'',
        seleccionar_pasajero:false,
        pasajeros:[],
        total_pasajeros:-1,
        pagados:[],
        deudas:[],
        adicionales:[],
        errores:[]
    },
    created() {

    },
    computed: {

    },
    methods:{
        buscarPasajero()
        {
            this.seleccionar_pasajero = false
            this.pagados = []
            this.deudas = []
            this.adicionales= []

            axios.get('busqueda-pasajeros/buscar-pasajero',{params:{texto: this.texto}})
            .then((response) => {
                this.pasajeros = response.data
                this.total_pasajeros = this.pasajeros.length
                this.errores=[]
            })
            .catch((errors) => {
                if(response = errors.response) {
                    this.errores = response.data.errors,
                    console.clear()
                }
            })
        },
        listarPasajes(numero_documento)
        {
            axios.get('busqueda-pasajeros/listar-pasajes',{params:{numero_documento : numero_documento}})
            .then((response) => {
                console.log(response.data)
                this.seleccionar_pasajero = true
                this.pagados = response.data.pagados
            })
        }
    }
})
