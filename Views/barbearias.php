<div class="container py-5">
    <h2 class="text-center mb-5 display-5 fw-bold text-primary">Barbearias </h2>
    <div class="row justify-content-center g-4"> <?php foreach ($retorno as $bar): ?>
            <div class="col-12 col-md-6 col-lg-4"> <div class="card h-100 bg-white shadow-lg border rounded-3 overflow-hidden d-flex flex-column animate__animated animate__fadeInUp">
                    <?php
                    $imageUrl = $bar->getImagem();
                    if (empty($imageUrl)) { // Verifica se a URL da imagem está vazia ou nula
                        $imageUrl = 'assets/img/noimage.png'; // Caminho para sua imagem padrão
                        $altText = 'Imagem não disponível para ' . htmlspecialchars($bar->getNome());
                    } else {
                        $altText = 'Imagem da Barbearia ' . htmlspecialchars($bar->getNome());
                    }
                    ?>
                    <img src="<?= htmlspecialchars($imageUrl) ?>" class="card-img-top shadow-sm" alt="<?= $altText ?>" style="height: 200px; object-fit: contain;">

                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h3 class="card-title text-dark-blue mb-2"><?= htmlspecialchars($bar->getNome()) ?></h3>
                            <p class="card-text text-dark-gray mb-1"><small><i class="fas fa-user-tie me-2"></i>Dono: <?= htmlspecialchars($bar->getDono()->getNome()) ?></small></p>
                            <p class="card-text text-dark-gray mb-3"><small><i class="fas fa-map-marker-alt me-2"></i><?= htmlspecialchars($bar->getEndereco()) ?></small></p>
                        </div>
                        <a href="/barberx/barbearia?id=<?= htmlspecialchars($bar->getId()) ?>" class="btn btn-outline-primary mt-auto">
                            <i class="fas fa-calendar-alt me-2"></i>Agendar
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>