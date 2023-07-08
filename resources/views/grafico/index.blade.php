@extends('layouts.master')
@section('grafico')
active
@endsection
@section('title')
GRÁFICOS ESTADISTICOS
@endsection
@section('content')
<?php
use Carbon\Carbon;

// Obtener el primer registro de la tabla "Venta" ordenado por el campo "FEC_VEN" en orden ascendente
$primerRegistro = \App\Venta::orderBy('FEC_VEN')->first();
// Obtener la fecha actual
$fechaActual = Carbon::now();

if ($primerRegistro) {
    // Obtener el año del primer registro
    $anioPrimerRegistro = date("Y", strtotime($primerRegistro->FEC_VEN));

    // Obtener la fecha del primer registro
    $fechaPrimerRegistro = $primerRegistro->FEC_VEN;

} else {
    echo "No hay registros en la tabla Venta." . PHP_EOL;
}

?>
   <div class="box">
    <div class="box-body">
     <div class="row">
      <div class="col-12 col-md-6">
        <label class="form-check-label" for="grafico_range">
          Rango
        </label>
        <select class="form-control form-control-lg" name="grafico_range" id="grafico_range">
          <option selected value="" disabled="">Seleccione rango</option>
          <option value="years">Años</option>
          <option value="months">Meses</option>
          <option value="weeks">Semanas</option>
          <option value="days">Días</option>
        </select>
      </div>
      <div class="col-12 col-md-6" id="contentYears">
        <label class="form-check-label" for="year">
            Año
        </label>
        <select class="form-control form-control-lg" name="year" id="year">
          <option selected disabled="" >Seleccione año</option>
          @for($i = $anioPrimerRegistro; $i <= $fechaActual->year; $i++)
          <option>{{$i}}</option>
          @endfor
        </select>
      </div>
     </div>
   </div>
   </div>
   <div id="grafico_1" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
   <div id="grafico_2" style="min-width: 310px; height: 900px; margin: 0 auto"></div>
   <div id="grafico_3" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<!-- <div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">GRÁFICOS</h3>
  </div>
  <div class="box-body">

  </div>
</div> -->

@endsection
@section('js')
<script src="highcharts/code/highcharts.js"></script>
<script src="highcharts/code/highcharts-3d.js"></script>
<script src="highcharts/code/modules/exporting.js"></script>
<?php
$actual=\Carbon\Carbon::now()->format('Y');
 ?>
<script type="text/javascript">
    // validacion de los campos seleccionados
    selectedOption();
    $("#grafico_range").change(function() {
        selectedOption();
    });
    $("#year").change(function() {
        selectedOption();
    });
    function selectedOption(){
        let type_exp = $("#grafico_range").val();
        let selectedYear = $("#year").val();
        if(type_exp == "years" || type_exp == null) {
            $("#contentYears").hide();
            <?php
                $inicio = date("Y", strtotime($primerRegistro->FEC_VEN));
                $fin = $fechaActual->year;
                $conteos = [];
                $categories = [];
                while ($inicio <= $fin) {
                    $count = \App\Venta::whereYear('FEC_VEN', $inicio)->count();
                    $conteos[] = $count;
                    $categories[] = $inicio;
                    $inicio++;
                }
            ?>
            draw( <?php echo json_encode($categories)?>, <?php echo json_encode($conteos)?>, "Ventas por gestiones");
            rangoGrafic2(type_exp, selectedYear);
            rangoGrafic3(type_exp, selectedYear);
        } else {
            $("#contentYears").show();
            if (selectedYear != null) {
                rangoFechas(type_exp, selectedYear);
                rangoGrafic2(type_exp, selectedYear);
                rangoGrafic3(type_exp, selectedYear);
            }
        }
    }

    function rangoFechas(type_exp, selectedYear){
		var route= "{{route('grafico.rangoFechas')}}";
		$.ajax({
			url: route,
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			type: 'POST',
			data: {"type_exp": type_exp,
                    "year": selectedYear },
			success: function(data){
                let titulo = "";
                switch (type_exp) {
                    case "months":
                        titulo = "Ventas por mes en la gestión: " + selectedYear;
                    break;
                    case "weeks":
                        titulo = "Ventas por semanas en la gestión: " + selectedYear;
                    break;
                    case "days":
                        titulo = "Ventas por días en la gestión: " + selectedYear;
                    break;
                    default:
                        break;
                }
                draw( data.categories, data.conteos, titulo);
                },
			error: function(data){
				console.log("error",data);
			}
		});
	}

    function rangoGrafic2(type_exp, selectedYear){
		var route= "{{route('grafico.rangoGrafic2')}}";
		$.ajax({
			url: route,
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			type: 'POST',
			data: {"type_exp": type_exp,
                    "year": selectedYear },
			success: function(data){
                console.log(data)
                let titulo = "";
                if (type_exp == "years" || type_exp == null) {
                    titulo = "Venta de PRODUCTOS por unidades";
                } else {
                    titulo = "Venta de PRODUCTOS por unidades en la gestión: " + selectedYear;
                }
                drawG2(data.categories, data.conteos, titulo)
                },
			error: function(data){
				console.log("error",data);
			}
		});
	}

    function rangoGrafic3(type_exp, selectedYear){
		var route= "{{route('grafico.rangoGrafic3')}}";
		$.ajax({
			url: route,
			headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
			type: 'POST',
			data: {"type_exp": type_exp,
                    "year": selectedYear },
			success: function(data){
                console.log(data)
                let titulo = "";
                if (type_exp == "years" || type_exp == null) {
                    titulo = "Cotizaciones mas solicitadas";
                } else {
                    titulo = "Cotizaciones mas solicitadas en la gestión: " + selectedYear;
                }
                drawG3(data, titulo)
                },
			error: function(data){
				console.log("error",data);
			}
		});
	}

    function draw( categoria, getData, titulo ) {
        for (let i = 0; i < getData.length; i++) {
            getData[i] = parseInt(getData[i]);
        }
        //console.log("======>1", categoria, getData)

        Highcharts.chart('grafico_1', {
        chart: {
            type: 'spline'
        },
        title: {
            text: titulo
        },
        subtitle: {
            text: 'Fuente: SERCOIL'
        },
        xAxis: {
            categories: categoria
        },
        yAxis: {
            title: {
                text: 'Numero de ventas'
            },
            labels: {
                formatter: function () {
                    return this.value + '';
                }
            }
        },
        tooltip: {
            crosshairs: true,
            shared: true
        },
        plotOptions: {
            spline: {
                marker: {
                    radius: 7,
                    lineColor: '#666666',
                    lineWidth: 3
                }
            }
        },
        series: [
        {
            name: 'Ventas realizadas',
            marker: {
                symbol: 'square'
            },
            data: getData

        }
        ]
    });

}
</script>
<script type="text/javascript">

function drawG2(categoria, getData, titulo) {
    for (let i = 0; i < getData.length; i++) {
        getData[i] = parseInt(getData[i]);
    }
    //console.log("======>", categoria, getData)
    Highcharts.chart('grafico_2', {
    chart: {
        type: 'bar'
    },
    title: {
        text: titulo + ""
    },
    subtitle: {
        text: 'Fuente: SERCOIL'
    },
    xAxis: {
        categories: categoria,
        title: {
            text: null
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Venta (unidades)',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        }
    },
    tooltip: {
        valueSuffix: ' unidades vendidas'
    },
    plotOptions: {
        bar: {
            dataLabels: {
                enabled: true
            }
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'top',
        x: -40,
        y: 80,
        floating: true,
        borderWidth: 1,
        backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
        shadow: true
    },
    credits: {
        enabled: false
    },
     series: [
     {
        name: ' ',
        data: getData
     }
    ]
    });
}
</script>
<script type="text/javascript">

function drawG3(getData, titulo) {
    //console.log("======>", getData)
    Highcharts.chart('grafico_3', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: titulo + ""
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: false
                },
                showInLegend: true
            }
        },
        series: [{
            name: 'Porcentaje',
            colorByPoint: true,
            data: getData
        }]
    });
}
</script>
@endsection
