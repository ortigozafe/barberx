<!doctype html>
<html>
	<head>
		<title>Gráfico de Barras</title>
		<meta charset="UTF-8">
		<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	</head>
	<body>
		<h1>Alunos por curso</h1>
		<div id="chart"></div>
		
		<script>
			fetch("/curso/dadosgrafico")
			.then(response=>response.json())
			.then(dados=>{
				if(dados.length > 0)
				{
					gerar_grafico(dados);
					//alert(dados[0].curso);
				}
				else
				{
					document.getElementById("chart").innerHTML = "<h1>Não há dados para geração do gráfico</h1>";
				}
			})
			.catch(()=>{
				alert("Deu ruim");
			})
			
			function gerar_grafico(dados)
			{
				var valores = [];
				var legendas = [];
				for(var x = 0; x < dados.length; x++)
				{
					legendas[x] = dados[x].curso;
					valores[x] = parseInt(dados[x].valor);
				}
				
				var options = {
					series: [{
					  name: 'Servings',
					  data: valores
					}],
					  
					chart: {
					  height: 350,
					  type: 'bar',
					},
					plotOptions: {
					  bar: {
						borderRadius: 10,
						columnWidth: '50%',
					  }
					},
					dataLabels: {
					  enabled: false
					},
					stroke: {
					  width: 0
					},
					grid: {
					  row: {
						colors: ['#fff', '#f2f2f2']
					  }
					},
					xaxis: {
					  labels: {
						rotate: -45
					  },
					  categories: legendas,
					  tickPlacement: 'on'
					},
					yaxis: {
					  title: {
						text: 'Servings',
					  },
					},
					fill: {
					  type: 'gradient',
					  gradient: {
						shade: 'light',
						type: "horizontal",
						shadeIntensity: 0.25,
						gradientToColors: undefined,
						inverseColors: true,
						opacityFrom: 0.85,
						opacityTo: 0.85,
						stops: [50, 0, 100]
					  },
					}
				}
			
				var chart = new ApexCharts(document.querySelector("#chart"), options);
				chart.render();
			}
		</script>
		
	</body>
</html>