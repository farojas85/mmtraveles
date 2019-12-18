var app = new Vue({
    el:'#wrapper',
    data:{
        pie_fecha_local_pagados:'',
    },
    methods:{
        piePagadosLocal()
        {
            axios.get('graficas/local-pagados',{params:{fecha:this.pie_fecha_local_pagados}})
            .then((Response) => {
                console.log(response.data)
            })

        }
    },
    created() {
        this.piePagadosLocal()
    }
})
