<main class="text-dark-emphasis">
    <section class="py-5 bg-light-section">
        <div class="container text-center">
            <h2 class="display-5 text-primary">Rota até <span class="fw-bold"><?= htmlspecialchars($nomeBarbearia) ?></span></h2>
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
    console.log("Endereço recebido do PHP:", enderecoDestino);

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

        // debug extra para ver onde o Google geocodifica
        const geocoder = new google.maps.Geocoder();
        geocoder.geocode({ address: enderecoDestino }, (results, status) => {
            if (status === "OK") {
                console.log("Geocode OK:", results[0].geometry.location.toJSON());
                new google.maps.Marker({
                    map,
                    position: results[0].geometry.location,
                    title: "Destino"
                });
                map.setCenter(results[0].geometry.location);
            } else {
                console.error("Erro no geocode:", status);
            }
        });

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const userLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    console.log("Localização do usuário:", userLocation);
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

        console.log("Origem da rota:", origem, "Destino da rota:", destino);

        const request = {
            origin: origem,
            destination: destino,
            travelMode: google.maps.TravelMode.DRIVING
        };

        directionsService.route(request, (result, status) => {
            if (status === "OK") {
                console.log("Directions OK");
                directionsRenderer.setDirections(result);
            } else {
                alert("Não foi possível traçar a rota: " + status);
                console.error("Directions error:", status);
            }
        });
    }

    document.addEventListener("DOMContentLoaded", initMap);
</script>
