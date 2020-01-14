var pie_pagados = null
var fecha = null
var pagados=null
var pieChart = null
var pieChartAero = null
$(function () {
    var role =$('#role_name_name').val()
    if( role=='Administrador' || role== 'Gerente' || role == 'Responsable')
    {
        pagadosHoy()
        aeroHoy()
    }
    resumenHoy()
});

function colorAletorio(){
    return  "#000000".replace(/0/g, () => (~~(Math.random() * 16)).toString(16))
}

function pagadosDia()
{
    fecha_dia_ini = $('#fecha_dia_ini').val()
    fecha_dia_fin  = $('#fecha_dia_fin').val()
    $.ajax({
        url: 'graficas/local-pagados?fecha_ini='+fecha_dia_ini+'&fecha_fin='+fecha_dia_fin,
        type:"GET",
        success: function (response) {

           pagados =  response
           var datos = {
                labels :[],
                datasets :[]
            }
            var set =[]
            var color=[]
            var total = 0
            pagados.forEach(item => {
                datos.labels.push(item.name)
                set.push(item.cantidad)
                color.push(colorAletorio())
                total = parseInt(total) + parseInt(item.cantidad)
            })

            $('#total_counter').val(total)

            datos.datasets = [
                {
                    data :  set,
                    backgroundColor: color
                }
            ]

            var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
            var pieData        = datos;
            var pieOptions     = {
              //maintainAspectRatio : false,
              responsive : true,
            }

            if(window.pieChart)
            {
                window.pieChart.clear()
                window.pieChart.destroy()
            }
            //pieChart.clear()

            window.pieChart = new Chart(pieChartCanvas, {
                type: 'pie',
                data: pieData,
                options: pieOptions
            })
        }
    });
}

function pagadosHoy()
{
    var f= new Date();
    var anio = f.getFullYear();
    var mes = (f.getMonth() +1) < 10 ? '0'+(f.getMonth() +1) : (f.getMonth() +1)
    var dia = f.getDate() < 10 ? '0'+f.getDate() : f.getDate()
    var fecha_ini = anio+'-'+ mes+'-'+ dia
    var fecha_fin = anio+'-'+ mes+'-'+ dia

    $.ajax({
        url: 'graficas/local-pagados?fecha_ini='+fecha_ini+'&fecha_fin='+fecha_fin,
        type:"GET",
        success: function (response) {

           pagados =  response
           var datos = {
                labels :[],
                datasets :[]
            }
            var set =[]
            var color=[]
            var total = 0
            pagados.forEach(item => {
                datos.labels.push(item.name)
                set.push(item.cantidad)
                total = parseInt(total) + parseInt(item.cantidad)
                color.push(colorAletorio())
            })

            $('#total_counter').val(total)

            datos.datasets = [
                {
                    data :  set,
                    backgroundColor: color
                }
            ]

            var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
            var pieData        = datos;
            var pieOptions     = {
              //maintainAspectRatio : false,
              responsive : true,
            }

            if(window.pieChart)
            {
                window.pieChart.clear()
                window.pieChart.destroy()
            }

            window.pieChart = new Chart(pieChartCanvas, {
                type: 'pie',
                data: pieData,
                options: pieOptions
            })
        }
    });
}

function aeroHoy() {
    var f= new Date();
    var anio = f.getFullYear();
    var mes = (f.getMonth() +1) < 10 ? '0'+(f.getMonth() +1) : (f.getMonth() +1)
    var dia = f.getDate() < 10 ? '0'+f.getDate() : f.getDate()
    var fecha_ini = anio+'-'+ mes+'-'+ dia
    var fecha_fin = anio+'-'+ mes+'-'+ dia
    fecha=''
    $.ajax({
        url: 'graficas/total-aerolinea?fecha_ini='+fecha_ini+'&fecha_fin='+fecha_fin,
        type:"GET",
        success: function (response) {
           var aeros =  response
           var datos = {
                labels :[],
                datasets :[]
            }
            var set =[]
            var color=[]
            var total = 0
            aeros.forEach(item => {
                datos.labels.push(item.name)
                set.push(item.cantidad)
                total = parseInt(total) + parseInt(item.cantidad)
                color.push(colorAletorio())
            })

            $('#total_aero').val(total)
            datos.datasets = [
                {
                    data :  set,
                    backgroundColor: color
                }
            ]

            var pieChartCanvas = $('#pieChartAero').get(0).getContext('2d')
            var pieData        = datos;
            var pieOptions     = {
              //maintainAspectRatio : false,
              responsive : true,
            }


            if(window.pieChartAero)
            {
                window.pieChart.clear()
                window.pieChart.destroy()
            }

            window.pieChartAero = new Chart(pieChartCanvas, {
                type: 'pie',
                data: pieData,
                options: pieOptions
            })
        }
    });
}

function aeroDia() {
    fecha_ini= $('#fecha_dia_aero_ini').val()
    fecha_fin= $('#fecha_dia_aero_fin').val()
    $.ajax({
        url: 'graficas/total-aerolinea?fecha_ini='+fecha_ini+'&fecha_fin='+fecha_fin,
        type:"GET",
        success: function (response) {
           var aero =  response
           var datos = {
                labels :[],
                datasets :[]
            }
            var set =[]
            var color=[]
            var total = 0
            aero.forEach(item => {
                datos.labels.push(item.name)
                set.push(item.cantidad)
                color.push(colorAletorio())
                total = parseInt(total)+ parseInt(item.cantidad)
            })

            $('#total_aero').val(total)

            datos.datasets = [
                {
                    data :  set,
                    backgroundColor: color
                }
            ]

            var pieChartCanvas = $('#pieChartAero').get(0).getContext('2d')
            var pieData        = datos;
            var pieOptions     = {
              //maintainAspectRatio : false,
              responsive : true,
            }

            if(window.pieChartAero)
            {
                window.pieChartAero.clear()
                window.pieChartAero.destroy()
            }

            window.pieChartAero = new Chart(pieChartCanvas, {
                type: 'pie',
                data: pieData,
                options: pieOptions
            })
        }
    });
}

function resumenHoy() {
    var f= new Date();
    var anio = f.getFullYear();
    var mes = (f.getMonth() +1) < 10 ? '0'+(f.getMonth() +1) : (f.getMonth() +1)
    var dia = f.getDate() < 10 ? '0'+f.getDate() : f.getDate()
    var fecha = anio+'-'+ mes+'-'+ dia
    var total = 0
    fecha=''
    $.ajax({
        url: 'graficas/resumen-counter?fecha='+fecha,
        type:"GET",
        success: function (response) {
            $("#resumen-tabla").html(response)
        }
    })
}

function resumenDia() {
    fecha=$('#fecha_dia_resumen').val()
    $.ajax({
        url: 'graficas/resumen-counter?fecha='+fecha,
        type:"GET",
        success: function (response) {
            $("#resumen-tabla").html(response)
        }
    })
}
