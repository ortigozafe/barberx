<div class="container mt-5">
    <h2 class="text-center mb-5 text-primary fw-bold animate__animated animate__fadeInDown">Agendar um Serviço</h2>

    <form action="/barberx/agendar" method="post" class="mx-auto p-4 rounded-3 shadow-lg bg-white animate__animated animate__fadeInUp" style="max-width: 600px;">

        <input type="hidden" name="id" value="<?= $id_agendamento ?>">

        <input type="hidden" name="barbearia_id" value="<?= $barbearia_id ?>">

        <div class="mb-3">
            <label for="profissional_id" class="form-label text-dark-gray">Profissional</label>
            <select class="form-select border border-secondary" name="profissional_id" id="profissional_id" required>
                <option value="">Selecione um profissional</option>
                <?php
                if (!empty($retornoProfissional)): ?>
                    <?php foreach ($retornoProfissional as $rp): ?>
                        <option value="<?= $rp->id ?>">
                            <?= $rp->nome ?>
                        </option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="" disabled>Nenhum profissional disponível</option>
                <?php endif; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="servico_id" class="form-label text-dark-gray">Serviço</label>
            <select class="form-select border border-secondary" name="servico_id" id="servico_id" required>
                <option value="">Selecione um serviço</option>
                <?php
                if (!empty($retornoServico)): ?>
                    <?php foreach ($retornoServico as $rs): ?>
                        <option value="<?= $rs->id ?>">
                            <?= $rs->nome ?> - R$<?= number_format($rs->preco, 2, ',', '.') ?>
                        </option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="" disabled>Nenhum serviço disponível</option>
                <?php endif; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="data_hora" class="form-label text-dark-gray">Data e Hora</label>
            <input type="datetime-local" class="form-control border border-secondary" name="data_hora" id="data_hora" required>
            <small class="form-text text-muted">Selecione a data e hora desejadas para o agendamento.</small>
        </div>

        <div class="mb-3">
            <label for="observacoes" class="form-label text-dark-gray">Observações (Opcional)</label>
            <textarea class="form-control border border-secondary" name="observacoes" id="observacoes" rows="3" placeholder="Ex: 'Cortar apenas as pontas', 'Chegar 10 minutos antes'"></textarea>
            <small class="form-text text-muted">Alguma observação adicional para o profissional?</small>
        </div>

        <div class="d-grid gap-2 mt-4">
            <button type="submit" class="btn btn-primary btn-lg fw-bold shadow">
                Agendar serviço
            </button>
            <a href="/barberx/agenda" class="btn btn-outline-secondary btn-lg fw-bold">Cancelar</a>
        </div>
    </form>
</div>
</div>