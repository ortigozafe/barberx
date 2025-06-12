<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="/barberx/cadastrar_barbearia" class="btn btn-primary rounded-circle">
            <i class="bi bi-plus-lg"></i>
        </a>
    </div>
    <h2 class="text-center mb-4">Barbearias Cadastradas</h2>
    <div class="row justify-content-center">
        <?php foreach ($retorno as $bar): ?>
            <div class="card mb-3 mx-2 p-2" style="width: 16rem; height: 4rem; display: flex; flex-direction: row; align-items: center;">
                <div class="rounded-circle bg-primary" style="width: 40px; height: 40px;"></div>
                <div class="ms-3">
                    <strong><?= htmlspecialchars($bar['nome']) ?></strong><br>
                    <small>Dono: <?= htmlspecialchars($bar['nome_dono']) ?></small><br>
                    <small><?= htmlspecialchars($bar['endereco']) ?></small>
                </div>
                <a href="/barberx/barbearia?id=<?= $bar['id'] ?>" class="btn btn-outline-primary btn-sm ms-auto me-2">➔</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
