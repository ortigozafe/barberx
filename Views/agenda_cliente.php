<div class="container mt-5 text-white">
    <h2 class="text-center mb-4 text-primary">Agendamentos Atuais</h2>

    <?php if (empty($futuros)): ?>
        <p class="text-center text-black">Nenhum agendamento futuro encontrado.</p>
    <?php else: ?>
        <?php foreach ($futuros as $a): ?>
            <div class="bg-dark p-3 mb-3 rounded">
                <strong><?= $a->getProfissional()->getBarbearia()->getNome() ?> - <?= $a->getServico()->getNome() ?></strong><br>
                Profissional: <?= $a->getProfissional()->getNome() ?><br>
                Data e Hora: <?= date('d/m/Y H:i', strtotime($a->getDataHora())) ?><br>
                <div class="mt-2">
                    <a href="/barberx/agendar?id=<?= $a->getId() ?>&editar=1" class="btn btn-sm btn-primary">Editar</a>
                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#cancelarModal<?= $a->getId() ?>">Cancelar</button>
                </div>
            </div>

            <div class="modal fade" id="cancelarModal<?= $a->getId() ?>" tabindex="-1" aria-labelledby="cancelarModalLabel<?= $a->getId() ?>" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark text-white">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cancelarModalLabel<?= $a->getId() ?>">Confirmar Cancelamento</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Tem certeza que deseja cancelar o agendamento de **<?= $a->getServico()->getNome() ?>** com **<?= $a->getProfissional()->getNome() ?>** em **<?= date('d/m/Y H:i', strtotime($a->getDataHora())) ?>**?
                        </div>
                        <div class="modal-footer">
                            <a href="/barberx/cancelar_agendamento?id=<?= $a->getId() ?>" class="btn btn-danger">Sim, Cancelar</a>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <hr class="my-5">

    <h2 class="text-center mb-4 text-primary">Histórico de Agendamentos</h2>
    <?php if (empty($passados)): ?>
        <p class="text-center text-black">Nenhum agendamento anterior.</p>
    <?php else: ?>
        <?php foreach ($passados as $a):  ?>
            <div class="bg-secondary p-3 mb-3 rounded">
                <strong><?= $a->getProfissional()->getBarbearia()->getNome() ?> - <?= $a->getServico()->getNome() ?></strong><br>
                Profissional: <?= $a->getProfissional()->getNome() ?><br>
                Data: <?= date('d/m/Y H:i', strtotime($a->getDataHora())) ?><br>
                Status: <span class="text-warning"><?= ucfirst($a->getStatus()) ?></span>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>