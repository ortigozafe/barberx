<!doctype html>
<html>
	<head>
		<title>Curso</title>
		<meta charset="UTF-8">
	</head>
	<body>
		<h1>Alunos no mapa</h1>
		<br>
		<div id="mapa" style="height:600px"></div>
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBawBTyuD-NFt6lyS_yaf3Jc-GyHlP8oBw"></script>
		
		<script>
			var url="http://localhost/Curso/buscar_dados_mapa";
			fetch(url)
			.then((response)=>{
				return response.json();
			})
			.then((data)=>{
				gerar_mapa(data);
				//alert(data[0].nome);
			})
			.catch((error)=>{
				console.log("Problema ao buscar dados dos alunos", error);
			});
			
			function gerar_mapa(alunos)
			{
				var mapa = new google.maps.Map(document.getElementById("mapa"),{
				zoom:17,
				center:{lat:-22.330953, lng:-49.070956}
				});
				mostrar_marcas(mapa,alunos);
			}
			function mostrar_marcas(mapa,alunos)
			{
				for(let x=0; x < alunos.length; x++)
				{
					var marca = new google.maps.Marker({
					position:{lat:parseFloat(alunos[x].latitude), lng:parseFloat(alunos[x].longitude)},
					map:mapa,
					title:alunos[x].nome
					});
					var infow = new google.maps.InfoWindow();
					google.maps.event.addListener(marca, "click",(function(marca, x){
						return function(){
							infow.setContent("<b>" + alunos[x].nome + "</b><br>" + alunos[x].celular);
							infow.open(mapa, marca)
						}
					})(marca, x));
				}//fim for
			}
		</script>
	</body>
</html>