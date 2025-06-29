<div class="container py-5">
    <h2 class="text-center mb-5 display-5 fw-bold text-primary">Minhas Barbearias</h2>
    <div class="row justify-content-center g-4">
        <?php foreach ($barbearias as $bar): ?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 bg-white shadow-lg border rounded-3 overflow-hidden d-flex flex-column animate__animated animate__fadeInUp">

                    <?php
                    $imageUrl = 'assets/img/noimage.png';
                    $altText = "Imagem da Barbearia {$bar->nome}";
                    ?>
                    <img src="<?= $imageUrl ?>"
                        class="card-img-top shadow-sm"
                        alt="<?= $altText ?>"
                        style="height: 200px; object-fit: contain;">

                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h4 class="card-title text-dark-blue mb-2"><?= $bar->nome ?></h4>
                            <p class="mb-1 text-muted">
                                <i class="fas fa-map-marker-alt me-2"></i>
                                <?= $bar->endereco ?>
                            </p>
                            <p class="mb-1 text-muted">
                                <i class="fas fa-phone me-2"></i><?= $bar->telefone ?>
                            </p>
                            <p class="mb-1 text-muted">
                                <i class="fas fa-envelope me-2"></i><?= $bar->email ?>
                            </p>
                            <hr>
                            <h6 class="fw-bold text-dark-blue mt-3">Profissionais</h6>
                            <?php if (!empty($bar->profissionais)): ?>
                                <ul class="list-unstyled small mb-2">
                                    <?php foreach (explode(',', $bar->profissionais) as $prof): ?>
                                        <li><i class="fas fa-user me-1"></i><?= trim($prof) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p class="small text-muted">Nenhum profissional cadastrado.</p>
                            <?php endif; ?>


                            <h6 class="fw-bold text-dark-blue mt-3">Serviços</h6>
                            <?php if (!empty($bar->servicos)): ?>
                                <ul class="list-unstyled small mb-2">
                                    <?php foreach (explode(',', $bar->servicos) as $serv): ?>
                                        <li><i class="fas fa-scissors me-1"></i><?= trim($serv) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p class="small text-muted">Nenhum serviço cadastrado.</p>
                            <?php endif; ?>

                        </div>
                        <a href="/barberx/barbearia?id=<?= $bar->id ?>" class="btn btn-outline-primary mt-3 w-100">
                            <i class="fas fa-calendar-check me-2"></i>Ver detalhes
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>