<div class="container py-5">
    <h2 class="text-center mb-4 display-5 fw-bold text-primary">Barbearias</h2>

    <div class="d-flex justify-content-center mb-4">
        <button id="btn-filtrar" class="btn btn-outline-primary disabled opacity-50 fw-bold px-4 py-2" disabled>
            Carregando barbearias...
        </button>
    </div>

    <div id="loader" class="text-center mb-3" style="display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Carregando...</span>
        </div>
        <p>Obtendo localização das barbearias, aguarde...</p>
    </div>

    <div id="lista-barbearias" class="row justify-content-center g-4">
    </div>

    <nav aria-label="Paginação das barbearias" class="mt-4">
        <ul class="pagination justify-content-center">
            <li class="page-item disabled" id="btn-prev">
                <button class="page-link">Anterior</button>
            </li>
            <li class="page-item disabled" id="btn-next">
                <button class="page-link">Próximo</button>
            </li>
        </ul>
    </nav>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBawBTyuD-NFt6lyS_yaf3Jc-GyHlP8oBw"></script>
<script>
    const barbearias = <?= json_encode(array_map(function ($bar) {
                            return [
                                'id' => $bar->id,
                                'nome' => $bar->nome,
                                'telefone' => $bar->telefone,
                                'endereco' => $bar->endereco,
                                'imagem' => !empty($bar->imagem) ? 'assets/img/' . $bar->imagem : 'assets/img/noimage.png',
                            ];
                        }, $retorno)); ?>;

    let barbeariasComCoords = [];
    let listaFiltrada = [];
    const maxPorPagina = 6;
    let paginaAtual = 1;
    let filtroAtivo = false;
    let userLocation = null;

    const geocoder = new google.maps.Geocoder();

    const btnFiltrar = document.getElementById('btn-filtrar');
    const loader = document.getElementById('loader');
    const listaContainer = document.getElementById('lista-barbearias');

    function getDistance(lat1, lng1, lat2, lng2) {
        function toRad(x) {
            return x * Math.PI / 180;
        }

        const R = 6371; 
        const dLat = toRad(lat2 - lat1);
        const dLng = toRad(lng2 - lng1);
        const a = Math.sin(dLat / 2) ** 2 +
            Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
            Math.sin(dLng / 2) ** 2;
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c;
    }

    function montarCards(pagina) {
        listaContainer.innerHTML = '';

        const inicio = (pagina - 1) * maxPorPagina;
        const fim = inicio + maxPorPagina;
        const subset = listaFiltrada.slice(inicio, fim);

        if (subset.length === 0) {
            listaContainer.innerHTML = `<p class="text-center text-muted fs-5">Nenhuma barbearia para mostrar.</p>`;
            atualizarBotoesPaginacao();
            return;
        }

        subset.forEach(bar => {
            const card = document.createElement('div');
            card.className = 'col-12 col-md-6 col-lg-4';
            card.innerHTML = `
            <div class="card h-100 bg-white shadow-lg border rounded-3 overflow-hidden d-flex flex-column animate__animated animate__fadeInUp">
                <img src="${bar.imagem}" class="card-img-top shadow-sm" alt="Imagem da Barbearia ${bar.nome}" style="height: 200px; object-fit: contain;">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h3 class="card-title text-dark-blue mb-2">${bar.nome}</h3>
                        <p class="card-text text-dark-gray mb-1"><small><i class="fas fa-phone me-2"></i>Celular: ${bar.telefone}</small></p>
                        <p class="card-text text-dark-gray mb-3"><small><i class="fas fa-map-marker-alt me-2"></i>${bar.endereco}</small></p>
                        ${ filtroAtivo && bar.distancia !== undefined ? `<p class="text-muted"><small>Distância: ${bar.distancia.toFixed(2)} km</small></p>` : ''}
                    </div>
                    <a href="/barberx/barbearia?id=${bar.id}" class="btn btn-outline-primary mt-auto">
                        <i class="fas fa-calendar-alt me-2"></i>Agendar
                    </a>
                </div>
            </div>
        `;
            listaContainer.appendChild(card);
        });

        atualizarBotoesPaginacao();
    }

    function atualizarBotoesPaginacao() {
        const btnPrev = document.getElementById('btn-prev');
        const btnNext = document.getElementById('btn-next');
        btnPrev.classList.toggle('disabled', paginaAtual === 1);
        btnNext.classList.toggle('disabled', paginaAtual >= Math.ceil(listaFiltrada.length / maxPorPagina));
    }

    document.getElementById('btn-prev').addEventListener('click', () => {
        if (paginaAtual > 1) {
            paginaAtual--;
            montarCards(paginaAtual);
        }
    });

    document.getElementById('btn-next').addEventListener('click', () => {
        if (paginaAtual < Math.ceil(listaFiltrada.length / maxPorPagina)) {
            paginaAtual++;
            montarCards(paginaAtual);
        }
    });

    btnFiltrar.addEventListener('click', () => {
        filtroAtivo = !filtroAtivo;
        paginaAtual = 1;

        if (filtroAtivo) {
            if (!navigator.geolocation) {
                alert('Seu navegador não suporta geolocalização.');
                filtroAtivo = false;
                montarCards(paginaAtual);
                atualizarBotaoFiltro();
                return;
            }

            navigator.geolocation.getCurrentPosition(position => {
                userLocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                calcularCoordsDasBarbearias().then(() => {
                    barbeariasComCoords.forEach(bar => {
                        bar.distancia = getDistance(userLocation.lat, userLocation.lng, bar.lat, bar.lng);
                    });
                    listaFiltrada = [...barbeariasComCoords].sort((a, b) => a.distancia - b.distancia);
                    montarCards(paginaAtual);
                    atualizarBotaoFiltro();
                }).catch(() => {
                    alert('Erro ao obter localização das barbearias. Mostrando sem filtro.');
                    filtroAtivo = false;
                    montarCards(paginaAtual);
                    atualizarBotaoFiltro();
                });
            }, () => {
                alert('Não foi possível obter sua localização. Mostrando sem filtro.');
                filtroAtivo = false;
                montarCards(paginaAtual);
                atualizarBotaoFiltro();
            });

        } else {
            listaFiltrada = [...barbearias];
            montarCards(paginaAtual);
            atualizarBotaoFiltro();
        }
    });

    function atualizarBotaoFiltro() {
        if (filtroAtivo) {
            btnFiltrar.textContent = 'Mostrar todas as barbearias';
            btnFiltrar.classList.remove('btn-outline-primary');
            btnFiltrar.classList.add('btn-primary');
        } else {
            btnFiltrar.textContent = 'Mostrar as mais próximas';
            btnFiltrar.classList.remove('btn-primary');
            btnFiltrar.classList.add('btn-outline-primary');
        }
    }

    function calcularCoordsDasBarbearias() {
        return new Promise((resolve, reject) => {
            barbeariasComCoords = [];
            let count = 0;

            loader.style.display = 'block';
            btnFiltrar.disabled = true;

            barbearias.forEach(bar => {
                geocoder.geocode({
                    address: bar.endereco + ', Brasil'
                }, (results, status) => {
                    if (status === 'OK' && results[0]) {
                        barbeariasComCoords.push({
                            ...bar,
                            lat: results[0].geometry.location.lat(),
                            lng: results[0].geometry.location.lng()
                        });
                    } else {
                        console.warn('Não foi possível geocodificar:', bar.endereco, status);
                        barbeariasComCoords.push({
                            ...bar,
                            lat: null,
                            lng: null
                        });
                    }
                    count++;
                    if (count === barbearias.length) {
                        loader.style.display = 'none';
                        btnFiltrar.disabled = false;
                        barbeariasComCoords = barbeariasComCoords.filter(b => b.lat !== null && b.lng !== null);
                        resolve();
                    }
                });
            });
        });
    }

    listaFiltrada = [...barbearias];
    montarCards(paginaAtual);
    btnFiltrar.disabled = false;
    atualizarBotaoFiltro();
</script>