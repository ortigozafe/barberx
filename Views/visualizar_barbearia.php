<div class="container mt-5 text-white">
    <div class="row bg-dark p-4 rounded">
        <div class="col-md-4 text-center">
            <img src="assets/img/barbearia.png" alt="Logo" class="img-fluid rounded" style="max-height: 300px;">
        </div>
        <div class="col-md-8">
            <h2><?= htmlspecialchars($barbearia->getNome()) ?></h2>
            <p><strong>Nome do Dono:</strong> <?= htmlspecialchars($barbearia->getDono()->getNome()) ?></p>
            <p><strong>Endereço:</strong> <?= htmlspecialchars($barbearia->getEndereco()) ?></p>
            <p><strong>Celular:</strong> <?= htmlspecialchars($barbearia->getTelefone()) ?></p>
            <p><strong>CNPJ:</strong> <?= htmlspecialchars($barbearia->getCnpj()) ?></p>
            <p><strong>Descrição:</strong> Cortes para todas as idades pelo melhor preço!</p>
            <p><strong>Instagram:</strong> @barbershop</p>
            <p><strong>Avaliação:</strong> ⭐ 4.9 (baseado em 631 avaliações)</p>
            <a href="/barberx/agendar?id=<?= $barbearia->getId() ?>" class="btn btn-warning">Agendar Agora</a>
        </div>
    </div>

    <hr class="my-5">

    <h3 class="text-center text-warning mb-4">Nossos Profissionais</h3>
    <div class="row">
        <?php foreach ($profissionais as $p): ?>
            <div class="col-md-4 mb-3">
                <div class="bg-secondary p-3 rounded">
                    <strong><?= htmlspecialchars($p->getNome()) ?></strong><br>
                    <small><?= htmlspecialchars($p->getEspecialidade()) ?></small>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <hr class="my-5">

    <h3 class="text-center text-warning mb-4">Nossos Serviços</h3>
    <div class="row">
        <?php foreach ($servicos as $s): ?>
            <div class="col-md-4 mb-3">
                <div class="bg-secondary p-3 rounded">
                    <strong><?= htmlspecialchars($s->getNome()) ?></strong><br>
                    <small><?= htmlspecialchars($s->getDescricao()) ?></small><br>
                    <strong>Preço:</strong> R$ <?= number_format($s->getPreco(), 2, ',', '.') ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
