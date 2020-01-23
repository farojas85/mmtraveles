var app = new Vue({
    el:'#wrapper',
    data:{
        pago:{
            id:'',
            local_id:'',
            rubro:'',
            fecha:'',
            monto_soles:'',
            monto_dolares:''
        },
        pagos:[],
        locales:[],
        rubros:[],
        extras:[],
        extra:{
            tipo:'',
            local_id:'',
            rubro:''
        },
        errores:[]
    },
    created() {
    },
    computed: {

    },
    methods: {
        listarLocales() {
            axios.get('locales/filtro').then((response)=> {
                this.locales = response.data
            })
        },
        listarRubros(e) {
            axios.get('pagos/listar-rubros',{params: { local : e.target.value }})
            .then((response) => {
                this.rubros = response.data
            })
        },
        limpiarPago()  {
            this.pago.id=''
            this.pago.local_id='',
            this.pago.rubro='',
            this.pago.fecha='',
            this.pago.monto_soles='',
            this.pago.monto_dolares=''
        },
        nuevoPago() {
            this.limpiarPago()
            this.listarLocales()
            $('#pago-create').modal('show')
        },
        guardarPago() {
            axios.post('pagos/guardar',this.pago)
                .then((response) => {
                    this.errores=[]
                    this.pago = response.data.pago
                    Swal.fire({
                        type : 'success',
                        title : 'PAGOS RUBROS',
                        text : response.data.mensaje,
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor:"#1abc9c",
                    }).then(respuesta => {
                        if(respuesta.value) {
                            $('#pago-create').modal('hide')
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
        nuevoEgreso() {
            this.listarLocales()
            $('#egresos-create').modal('show')
        }
    }
})
