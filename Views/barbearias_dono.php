<div class="container py-5">
    <h2 class="text-center mb-4 display-5 fw-bold text-primary animate__animated animate__fadeInRight">Minhas Barbearias</h2>

    <div class="d-flex justify-content-center mb-4 animate__animated animate__fadeInUp">
        <a href="/barberx/cadastrar_barbearia" class="btn btn-outline-primary btn-lg"> 
            <i class="fas fa-plus me-2"></i> Adicionar Barbearia
        </a>
    </div>

    <div class="row justify-content-center g-4 animate__animated animate__fadeInLeft">
        <?php if (!empty($retorno)): ?>
            <?php foreach ($retorno as $bar): ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 bg-white shadow-lg border rounded-3 overflow-hidden d-flex flex-column">
                        <?php

                            $imageUrl = !empty($bar->imagem) ? "assets/img/" . htmlspecialchars($bar->imagem) : 'assets/img/noimage.png';

                            $altText = 'Imagem da barbearia ' . htmlspecialchars($bar->nome);
                        ?>

                        <!--<img src="assets/img/<?= htmlspecialchars($bar->imagem) ?>" alt="Imagem da barbearia" />-->


                        <img src="<?= $imageUrl ?>" class="card-img-top img-fluid" alt="<?= $altText ?>" style="height: 200px; object-fit: contain;">
                        <div class="card-body d-flex flex-column">
                            <h3 class="card-title text-dark-blue mb-2"><?= htmlspecialchars($bar->nome) ?></h3>
                            <p class="text-muted small mb-1"><strong>CNPJ:</strong> <?= htmlspecialchars($bar->cnpj) ?></p>
                            <p class="text-muted small mb-1"><strong>Telefone:</strong> <?= htmlspecialchars($bar->telefone) ?></p>
                            <p class="text-muted small mb-3"><strong>Endereço:</strong> <?= htmlspecialchars($bar->endereco) ?></p>

                            <h6 class="fw-bold text-dark-blue mt-3">Profissionais</h6>
                            <?php if (!empty($bar->profissionais)): ?>
                                <ul class="list-unstyled small mb-3">
                                    <?php foreach ($bar->profissionais as $prof): ?>
                                        <li>
                                            <i class="fas fa-user me-1"></i>
                                            <?= htmlspecialchars($prof->nome) ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p class="small text-muted">Nenhum profissional cadastrado.</p>
                            <?php endif; ?>

                            <h6 class="fw-bold text-dark-blue mt-3">Serviços</h6>
                            <?php if (!empty($bar->servicos)): ?>
                                <ul class="list-unstyled small mb-3">
                                    <?php foreach ($bar->servicos as $serv): ?>
                                        <li>
                                            <i class="fas fa-scissors me-1"></i>
                                            <?= htmlspecialchars($serv->nome) ?> — R$ <?= htmlspecialchars(number_format($serv->preco, 2, ',', '.')) ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p class="small text-muted">Nenhum serviço cadastrado.</p>
                            <?php endif; ?>
                        </div>
                        <div class="card-footer bg-transparent border-top d-flex justify-content-around align-items-center p-3">
                            <a href="/barberx/editar_barbearia?id=<?= htmlspecialchars($bar->id) ?>" class="btn btn-sm btn-success text-white me-2">
                                <i class="fas fa-edit me-1"></i> Editar
                            </a>

                            <a href="/barberx/excluir_barbearia?id=<?= htmlspecialchars($bar->id) ?>" 
                            class="btn btn-sm btn-danger"
                            onclick="return confirm('Tem certeza que deseja excluir esta barbearia?');">
                                <i class="fas fa-trash me-1"></i> Excluir
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <p class="text-center text-muted fs-5">Nenhuma barbearia cadastrada para este dono ainda.</p>
                <p class="text-center text-muted">Clique em "Adicionar Barbearia" para começar!</p>
            </div>
        <?php endif; ?>
    </div>
</div>