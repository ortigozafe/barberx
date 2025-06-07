<!DOCTYPE html>
<html>
	<head>
		<title>Rota</title>
		<meta charset="UTF-8">
		<style>
			html,body,#mapa{height:100%; margin:0px; padding:0px;}
		</style>
	</head>
	<body>
		<h1>Rota</h1>
		<div id="mapa"></div>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBawBTyuD-NFt6lyS_yaf3Jc-GyHlP8oBw"></script>
		
		
		<script>
			var directionsDisplay;
        var directionService = new google.maps.DirectionsService();

		function inicio() {
			var dados = <?php echo $enderecos;?>;
			
			directionsDisplay = new google.maps.DirectionsRenderer();
			
			var mapOptions = {zoom:15};
			
			var mapa = new google.maps.Map(document.getElementById("mapa"), mapOptions);
			
			directionsDisplay.setMap(mapa);
			
			
			gerar_rota(dados)
        }

        function gerar_rota(dados) {
            var origem = dados[0].endereco + "," + dados[0].numero + "," + dados[0].cidade + "," + dados[0].uf; 
			
			//no caso o destino é igual a origem e não precisa definir novamente, mas se o destino for diferente então sim precisa definí-lo e usar em destination
			
			//var destino = dados[0].endereco + "," + dados[0].numero + "," + dados[0].cidade + "," + dados[0].uf; 
			
			const paradas = [];
			  for (let i = 1; i < dados.length; i++) {
				  let rota = dados[i].endereco + "," + dados[i].numero + "," + dados[i].cidade + "," + dados[i].uf;
				  
				paradas.push({location: rota});
			  }
			//console.log(paradas);
            var request = {
					origin:origem,
					destination:origem,
					waypoints: paradas,
					optimizeWaypoints: true,
					travelMode:google.maps.TravelMode.DRIVING};
					
			directionService.route(request, function(response, status){
				
				if(status == google.maps.DirectionsStatus.OK)
				{
					directionsDisplay.setDirections(response);
				}
				
			});
        }

        
		document.addEventListener("DOMContentLoaded", function () {
		inicio();
		});				
			
		</script>
	</body>
</html>