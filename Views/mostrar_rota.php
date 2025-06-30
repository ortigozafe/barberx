<main class="text-dark-emphasis">
	<section class="py-5 bg-light-section">
		<div class="container text-center">
			<h2 class="display-5text-primary">Rota até <span class="fw-bold"> <?= htmlspecialchars($nomeBarbearia) ?> </span></h2>
			<p class="lead mb-5 animate__animated animate__fadeInUp text-dark-gray fs-6">
				Encontre o melhor caminho até as barbearias BarberX partindo da sua localização.
			</p>
			<div id="mapa" class="shadow rounded-3 border" style="width: 100%; height: 600px;"></div>
			<p class="mt-3 text-muted">
				Permitimos acesso à sua localização para traçar a melhor rota.
			</p>
		</div>
	</section>
</main>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBawBTyuD-NFt6lyS_yaf3Jc-GyHlP8oBw"></script>
<script>
	const enderecoDestino = <?php echo $enderecoDestinoJSON; ?>;
	let map, directionsService, directionsRenderer;

	function initMap() {
		directionsService = new google.maps.DirectionsService();
		directionsRenderer = new google.maps.DirectionsRenderer();

		map = new google.maps.Map(document.getElementById("mapa"), {
			zoom: 13,
			center: {
				lat: -22.2954,
				lng: -48.5562
			}
		});
		directionsRenderer.setMap(map);

		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(
				(position) => {
					const userLocation = {
						lat: position.coords.latitude,
						lng: position.coords.longitude
					};
					gerarRota(userLocation, enderecoDestino);
				},
				() => {
					alert("Não conseguimos obter sua localização. Mostrando apenas a barbearia.");
					gerarRota(null, enderecoDestino);
				}
			);
		} else {
			alert("Seu navegador não suporta geolocalização.");
			gerarRota(null, enderecoDestino);
		}
	}

	function gerarRota(userLocation, destino) {
		let origem;

		if (userLocation) {
			origem = new google.maps.LatLng(userLocation.lat, userLocation.lng);
		} else {
			origem = "Jaú, SP, Brasil";
		}

		const request = {
			origin: origem,
			destination: destino,
			travelMode: google.maps.TravelMode.DRIVING
		};

		directionsService.route(request, (result, status) => {
			if (status === "OK") {
				directionsRenderer.setDirections(result);
			} else {
				alert("Não foi possível traçar a rota: " + status);
				console.error("Google Maps Directions error:", status);
			}
		});
	}

	document.addEventListener("DOMContentLoaded", initMap);
</script>