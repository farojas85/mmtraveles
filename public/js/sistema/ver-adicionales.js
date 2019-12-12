var app = new Vue({
    el:'#wrapper',
    data:{
       opcionales:[],
       total_opcionales:'',
       suma_reporte:0,
       suma_adicional:0
    },
    methods:{
        listaOpcional(){
            axios.get('/opcional/ventas').then((response) => {
                this.opcionales = response.data
                this.total_opcionales = this.opcionales.length
                this.suma_reporte =0
                for(let i = 0; i <this.total_opcionales; i++)
                {
                    this.suma_reporte += parseFloat(this.opcionales[i].total)
                }
            })
        },
        verAdicionales(id) {
            axios.get('/opcional/show',{params:{id : id}})
            .then((response) => {
                $('#modal-adicionales-title').html('Adicionales Descripción');
                $('#modal-adicionales-body').html(response.data);
                $('#modal-adicionales').modal('show');
            })
        }
    },
    created() {
        this.listaOpcional()
    }
})
