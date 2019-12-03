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
       suma_reporte:0
    },
    methods:{
        listaPasaje(){
            axios.get('/pasajes/ventas').then((response) => {
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
        this.listaPasaje()
    }
})
