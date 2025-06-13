<div class="container mt-5 text-white">
    <h2 class="text-center mb-4 text-primary">Agendamentos Atuais</h2>

    <?php if (empty($futuros)): ?>
        <p class="text-center text-black">Nenhum agendamento futuro encontrado.</p>
    <?php else: ?>
        <?php foreach ($futuros as $a): ?>
            <div class="bg-dark p-3 mb-3 rounded">
                <strong><?= $a['barbearia_nome'] ?> - <?= $a['servico_nome'] ?></strong><br>
                Profissional: <?= $a['profissional_nome'] ?><br>
                Data e Hora: <?= date('d/m/Y H:i', strtotime($a['data_hora'])) ?><br>
                <div class="mt-2">
                    <a href="/barberx/agendar?id=<?= $a['id'] ?>&editar=1" class="btn btn-sm btn-primary">Editar</a>
                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#cancelarModal<?= $a['id'] ?>">Cancelar</button>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="cancelarModal<?= $a['id'] ?>" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark text-white">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirmar Cancelamento</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            Tem certeza que deseja cancelar este agendamento?
                        </div>
                        <div class="modal-footer">
                            <a href="/barberx/cancelar_agendamento?id=<?= $a['id'] ?>" class="btn btn-danger">Sim, Cancelar</a>
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
        <?php foreach ($passados as $a): ?>
            <div class="bg-secondary p-3 mb-3 rounded">
                <strong><?= $a['barbearia_nome'] ?> - <?= $a['servico_nome'] ?></strong><br>
                Profissional: <?= $a['profissional_nome'] ?><br>
                Data: <?= date('d/m/Y H:i', strtotime($a['data_hora'])) ?><br>
                Status: <span class="text-warning"><?= ucfirst($a['status']) ?></span>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
