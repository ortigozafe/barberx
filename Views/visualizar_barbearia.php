<div class="container mt-5 text-white">
    <div class="row bg-dark p-4 rounded">
        <div class="col-md-4 text-center">
            <img src="assets/img/barbearia.png" alt="Logo" class="img-fluid rounded" style="max-height: 300px;">
        </div>
        <div class="col-md-8">
            <h2><?= htmlspecialchars($dadosBarbearia['nome']) ?></h2>
            <p><strong>Nome do Dono:</strong> <?= htmlspecialchars($dadosBarbearia['nome_dono']) ?></p>
            <p><strong>Endereço:</strong> <?= htmlspecialchars($dadosBarbearia['endereco']) ?></p>
            <p><strong>Celular:</strong> <?= htmlspecialchars($dadosBarbearia['telefone']) ?></p>
            <p><strong>CNPJ:</strong> <?= htmlspecialchars($dadosBarbearia['cnpj']) ?></p>
            <p><strong>Descrição:</strong> Cortes para todas as idades pelo melhor preço!</p>
            <p><strong>Instagram:</strong> @barbershop</p>
            <p><strong>Avaliação:</strong> ⭐ 4.9 (baseado em 631 avaliações)</p>
            <a href="/barberx/agendar?id=<?= $dadosBarbearia['id'] ?>" class="btn btn-warning">Agendar Agora</a>
        </div>
    </div>

    <hr class="my-5">

    <h3 class="text-center text-warning mb-4">Nossos Profissionais</h3>
    <div class="row">
        <?php foreach ($profissionais as $p): ?>
            <div class="col-md-4 mb-3">
                <div class="bg-secondary p-3 rounded">
                    <strong><?= htmlspecialchars($p['nome']) ?></strong><br>
                    <small><?= htmlspecialchars($p['especialidade']) ?></small>
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
                    <strong><?= htmlspecialchars($s['nome']) ?></strong><br>
                    <small><?= htmlspecialchars($s['descricao']) ?></small><br>
                    <strong>Preço:</strong> R$ <?= number_format($s['preco'], 2, ',', '.') ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
