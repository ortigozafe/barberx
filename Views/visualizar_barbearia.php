<main class="bg-light text-dark-emphasis py-5">
    <div class="container">
        <!-- SEÇÃO PRINCIPAL -->
        <section class="barbearia-details card bg-white shadow-lg border rounded-3 p-5 mb-5 animate__animated animate__fadeIn">
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
                <div class="col-md-8">
                    <h2 class="display-5 fw-bold mb-3 text-primary animate__animated animate__fadeInDown"><?= htmlspecialchars($retornoBarbearia->nome) ?></h2>
                    <p><strong><i class="fas fa-user-tie me-2"></i>Dono:</strong> <?= htmlspecialchars($retornoBarbearia->nome_dono) ?></p>
                    <p><strong><i class="fas fa-map-marker-alt me-2"></i>Endereço:</strong> <?= htmlspecialchars($retornoBarbearia->endereco) ?></p>
                    <p><strong><i class="fas fa-phone-alt me-2"></i>Celular:</strong> <?= htmlspecialchars($retornoBarbearia->telefone) ?></p>
                    <p><strong><i class="fas fa-id-card me-2"></i>CNPJ:</strong> <?= htmlspecialchars($retornoBarbearia->cnpj) ?></p>

                    <h4 class="mt-4 text-secondary"><i class="far fa-clock me-2"></i>Horários de Funcionamento</h4>
                    <ul class="list-group list-group-flush mb-3">
                        <?php if (!empty($retornoHorario)): ?>
                            <?php foreach ($retornoHorario as $h): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong><?= ucfirst($h->dia_semana) ?>:</strong>
                                    <?= htmlspecialchars($h->horario_abertura) ?> às <?= htmlspecialchars($h->horario_fechamento) ?>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="list-group-item text-muted">Horários ainda não cadastrados.</li>
                        <?php endif; ?>
                    </ul>

                    <a href="/barberx/agendar?id=<?= $retornoBarbearia->id ?>" class="btn btn-primary btn-lg mt-3 fw-bold animate__animated animate__pulse animate__infinite">
                        <i class="fas fa-calendar-check me-2"></i>Agendar Horário
                    </a>
                </div>
            </div>
        </section>

        <!-- SERVIÇOS -->
        <section class="servicos-section py-5">
            <h3 class="text-center display-6 fw-bold mb-5 text-primary">Nossos Serviços</h3>
            <div class="row justify-content-center g-4">
                <?php if (!empty($retornoServico)): ?>
                    <?php foreach ($retornoServico as $rs): ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm border rounded-3 p-3 animate__animated animate__fadeInUp">
                                <h4 class="card-title text-dark-blue mb-2"><i class="fas fa-scissors me-2"></i><?= htmlspecialchars($rs->nome) ?></h4>
                                <p class="card-text text-dark-gray"><?= htmlspecialchars($rs->descricao) ?></p>
                                <p class="card-text text-dark-blue fs-5"><strong>Preço:</strong> R$ <?= number_format($rs->preco, 2, ',', '.') ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-dark-gray">Nenhum serviço cadastrado para esta barbearia ainda.</p>
                <?php endif; ?>
            </div>
        </section>

        <!-- PROFISSIONAIS -->
        <section class="profissionais-section py-5">
            <h3 class="text-center display-6 fw-bold mb-5 text-primary">Nossos Profissionais</h3>
            <div class="row justify-content-center g-4">
                <?php if (!empty($retornoProfissional)): ?>
                    <?php foreach ($retornoProfissional as $rp): ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm border rounded-3 p-3 text-center animate__animated animate__fadeInUp">
                                <i class="fas fa-user fa-3x text-primary mb-3"></i>
                                <h4 class="card-title mb-2"><?= htmlspecialchars($rp->nome) ?></h4>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center text-dark-gray">Nenhum profissional cadastrado para esta barbearia ainda.</p>
                <?php endif; ?>
            </div>
        </section>
    </div>
</main>