var app = new Vue({
    el:'#wrapper',
    data:{
        pie_fecha_local_pagados:'',
    },
    mounted() {
        this.piePagadosLocal()
    },
    methods:{
        fechaHoy()
        {
            var f= new Date();

            var depa =f.getFullYear() +'-'+ (f.getMonth() +1) +'-'+ f.getDate()
            this.pie_fecha_local_pagados = depa;
        },
        colorAletorio(){
            return  "#000000".replace(/0/g, () => (~~(Math.random() * 16)).toString(16))
        },
        piePagadosLocal()
        {
            axios.get('graficas/local-pagados',{params:{fecha:this.pie_fecha_local_pagados}})
            .then((response) => {
                let pagados = response.data;

                var datos = {
                    labels :[],
                    dataset :[]
                }
                var set =[]
                var color=[]
                pagados.forEach(item => {
                    datos.labels.push(item.nombre)
                    set.push(item.cantidad)
                    color.push(this.colorAletorio())
                })
                datos.dataset.data = set
                datos.dataset.color = color

                // const ctx = document.getElementById('pieChart');
                //     const myChart = new Chart(ctx, {
                //     type: 'pie',
                //     data: datos,
                //     options: {
                //         maintainAspectRatio : false,
                //         responsive : true,
                //     },
                // });
                // var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
                // var pieData        = datos;
                // var pieOptions     = {
                //     maintainAspectRatio : false,
                //     responsive : true,
                // }

                // var pieChart = new Chart(pieChartCanvas, {
                //     type: 'pie',
                //     data: pieData,
                //     options: pieOptions
                // })
            })

        }
    },
    created() {
        this.fechaHoy()
        this.piePagadosLocal()
    }
})
