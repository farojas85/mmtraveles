var pie_pagados = null
var fecha = null
var pagados=null

$(function () {
    var role =$('#role_name_name').val()
    if( role=='Administrado' || role== 'Gerente' || role == 'Responsable')
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
    fecha_dia = $('#fecha_dia').val()
    $.ajax({
        url: 'graficas/local-pagados?fecha='+fecha_dia,
        type:"GET",
        success: function (response) {

           pagados =  response
           var datos = {
                labels :[],
                datasets :[]
            }
            var set =[]
            var color=[]

            pagados.forEach(item => {
                datos.labels.push(item.name)
                set.push(item.cantidad)
                color.push(colorAletorio())
            })
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

            var pieChart = new Chart(pieChartCanvas, {
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
    var fecha = anio+'-'+ mes+'-'+ dia
    fecha=''
    $.ajax({
        url: 'graficas/local-pagados?fecha='+fecha,
        type:"GET",
        success: function (response) {

           pagados =  response
           var datos = {
                labels :[],
                datasets :[]
            }
            var set =[]
            var color=[]

            pagados.forEach(item => {
                datos.labels.push(item.name)
                set.push(item.cantidad)
                color.push(colorAletorio())
            })
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

            var pieChart = new Chart(pieChartCanvas, {
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
    var fecha = anio+'-'+ mes+'-'+ dia
    var total = 0
    fecha=''
    $.ajax({
        url: 'graficas/total-aerolinea?fecha='+fecha,
        type:"GET",
        success: function (response) {
           var aeros =  response
           var datos = {
                labels :[],
                datasets :[]
            }
            var set =[]
            var color=[]
            total = 0
            aeros.forEach(item => {
                datos.labels.push(item.name)
                set.push(item.cantidad)
                total = parseInt(total) + parseInt(item.cantidad)
                color.push(colorAletorio())
            })
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

            var pieChart = new Chart(pieChartCanvas, {
                type: 'pie',
                data: pieData,
                options: pieOptions
            })
        }
    });
}

function aeroDia() {
    fecha= $('#fecha_dia_aero').val()
    $.ajax({
        url: 'graficas/total-aerolinea?fecha='+fecha,
        type:"GET",
        success: function (response) {
           var aero =  response
           var datos = {
                labels :[],
                datasets :[]
            }
            var set =[]
            var color=[]

            aero.forEach(item => {
                datos.labels.push(item.name)
                set.push(item.cantidad)
                color.push(colorAletorio())
            })
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

            var pieChart = new Chart(pieChartCanvas, {
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
