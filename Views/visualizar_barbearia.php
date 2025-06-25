<main class="bg-light text-dark-emphasis py-5">
    <div class="container">
        <section class="barbearia-details card bg-white shadow-lg border rounded-3 p-4 mb-5 animate__animated animate__fadeIn">
            <div class="row align-items-center">
                <div class="col-md-4 text-center mb-4 mb-md-0">
                    <?php
                    $barberImageUrl = isset($retornoBarbearia->imagem) ? $retornoBarbearia->imagem : '';
                    if (empty($barberImageUrl) || !is_string($barberImageUrl) || (!str_contains($barberImageUrl, '.png') && !str_contains($barberImageUrl, '.jpg') && !str_contains($barberImageUrl, '.jpeg') && !str_contains($barberImageUrl, '.gif') && !str_contains($barberImageUrl, 'assets/'))) {
                        $barberImageUrl = 'assets/img/noimage.png'; 
                    }
                    ?>
                    <img src="<?= htmlspecialchars($barberImageUrl) ?>"
                        alt="Imagem da Barbearia <?= htmlspecialchars($retornoBarbearia->nome) ?>"
                        class="img-fluid rounded-3 me-3"
                        style="max-height: 300px; object-fit: cover; width: 100%;">
                </div>
                <div class="col-md-7 ms-4">
                    <h2 class="display-5 fw-bold mb-3 text-primary animate__animated animate__fadeInDown"><?= htmlspecialchars($retornoBarbearia->nome) ?></h2>
                    <p class="text-dark-gray"><strong class="text-dark"><i class="fas fa-user-tie me-2"></i>Dono:</strong> <?= htmlspecialchars($retornoBarbearia->nome_dono) ?></p>
                    <p class="text-dark-gray"><strong class="text-dark"><i class="fas fa-map-marker-alt me-2"></i>Endereço:</strong> <?= htmlspecialchars($retornoBarbearia->endereco) ?></p>
                    <p class="text-dark-gray"><strong class="text-dark"><i class="fas fa-phone-alt me-2"></i>Celular:</strong> <?= htmlspecialchars($retornoBarbearia->telefone) ?></p>
                    <p class="text-dark-gray"><strong class="text-dark"><i class="fas fa-id-card me-2"></i>CNPJ:</strong> <?= htmlspecialchars($retornoBarbearia->cnpj) ?></p>
                    <p class="text-dark-gray"><strong class="text-dark"><i class="fas fa-info-circle me-2"></i>Descrição:</strong> Cortes para todas as idades pelo melhor preço! </p>
                    <p class="text-dark-gray"><strong class="text-dark"><i class="fab fa-instagram me-2"></i>Instagram:</strong> @barbershop </p>
                    <p class="text-dark-gray"><strong class="text-dark"><i class="fas fa-star me-2"></i>Avaliação:</strong> 4.9 (baseado em 631 avaliações) </p>
                    <a href="/barberx/agendar?id=<?= htmlspecialchars($retornoBarbearia->id) ?>" class="btn btn-primary btn-lg mt-3 fw-bold">
                        <i class="fas fa-calendar-check me-2"></i>Agendar Agora
                    </a>
                </div>
            </div>
        </section

        <hr class="my-5 text-dark-gray opacity-25">
        <section class="profissionais-section py-5">
            <h3 class="text-center display-6 fw-bold mb-5 text-primary">Nossos Profissionais</h3>
            <div class="row justify-content-center g-4">
                <?php if (!empty($retornoProfissional)): ?>
                    <?php foreach ($retornoProfissional as $rp): ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 bg-white shadow-sm border rounded-3 p-3 text-center animate__animated animate__fadeInUp">
                                <i class="fas fa-cut fa-3x text-primary mb-3"></i>
                                <h4 class="card-title text-dark-blue mb-2"><?= htmlspecialchars($rp->nome) ?></h4>
                                <p class="card-text text-dark-gray"><small><?= htmlspecialchars($rp->especialidade) ?></small></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-dark-gray">Nenhum profissional cadastrado para esta barbearia ainda.</p>
                <?php endif; ?>
            </div>
        </section>

        <hr class="my-5 text-dark-gray opacity-25">
        <section class="servicos-section py-5">
            <h3 class="text-center display-6 fw-bold mb-5 text-primary">Nossos Serviços</h3>
            <div class="row justify-content-center g-4">
                <?php if (!empty($retornoServico)): ?>
                    <?php foreach ($retornoServico as $s): ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 bg-white shadow-sm border rounded-3 p-3 animate__animated animate__fadeInUp">
                                <h4 class="card-title text-dark-blue mb-2"><i class="fas fa-scissors me-2"></i><?= htmlspecialchars($s->nome) ?></h4>
                                <p class="card-text text-dark-gray"><small><?= htmlspecialchars($s->descricao) ?></small></p>
                                <p class="card-text text-dark-blue fs-5 mt-auto"><strong>Preço:</strong> R$ <?= number_format($s->preco, 2, ',', '.') ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-dark-gray">Nenhum serviço cadastrado para esta barbearia ainda.</p>
                <?php endif; ?>
            </div>
        </section>
    </div>
</main>