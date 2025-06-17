<div class="container py-5">
    <h2 class="text-center mb-4">Barbearias Cadastradas</h2>
    <div class="row justify-content-center">
        <?php foreach ($retorno as $bar): ?>
            <div class="card mb-3 mx-2 p-2" style="width: 16rem; height: 4rem; display: flex; flex-direction: row; align-items: center;">
                <div class="rounded-circle bg-primary" style="width: 40px; height: 40px;"></div>
                <div class="ms-3">
                    <strong><?= $bar->getNome() ?></strong><br>
                    <small>Dono: <?= $bar->getDono()->getNome() ?></small><br>
                    <small><?= $bar->getEndereco() ?></small>
                </div>
                <a href="/barberx/barbearia?id=<?= $bar->getId() ?>" class="btn btn-outline-primary btn-sm ms-auto me-2">➔</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
