<div class="container mt-5 text-white">
    <h2 class="text-center mb-4">Agendar um Serviço</h2>

    <form action="/barberx/salvar_agendamento" method="post" class="mx-auto" style="max-width: 600px;">
        <div class="mb-3">
            <label for="profissional_id" class="form-label">Profissional</label>
            <select class="form-select" name="profissional_id" id="profissional_id" required>
                <option value="">Selecione</option>
                <?php foreach ($profissionais as $p): ?>
                    <option value="<?= $p['id'] ?>" <?= isset($agendamento) && $agendamento['profissional_id'] == $p['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($p['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="servico_id" class="form-label">Serviço</label>
            <select class="form-select" name="servico_id" id="servico_id" required>
                <option value="">Selecione</option>
                <?php foreach ($servicos as $s): ?>
                    <option value="<?= $s['id'] ?>" <?= isset($agendamento) && $agendamento['servico_id'] == $s['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($s['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

        </div>

        <div class="mb-3">
            <label for="data_hora" class="form-label">Data e Hora</label>
            <input type="datetime-local" class="form-control" name="data_hora" id="data_hora" required>
        </div>

        <div class="mb-3">
            <label for="observacoes" class="form-label">Observações</label>
            <textarea class="form-control" name="observacoes" id="observacoes" rows="3"></textarea>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-success">Agendar</button>
        </div>
    </form>
</div>
