<div class="container py-5 d-flex rounded justify-content-center">
    <div class="card shadow-lg animate__animated animate__fadeInUp" style="max-width: 600px; width: 100%;">
        <div class="card-header bg-primary text-white text-center">
            <h2 class="mb-0">Agendar Horário</h2>
        </div>
        <div class="card-body rounded bg-white p-4">
            <form method="post" action="/barberx/agendar?id=<?= $barbeariaData->id ?>" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="data" class="form-label fw-bold text-dark-blue">Data</label>
                    <input type="date" name="data" id="data" class="form-control" required min="<?= date('Y-m-d') ?>">
                </div>

                <div class="mb-3">
                    <label for="hora" class="form-label fw-bold text-dark-blue">Horário</label>
                    <select name="hora" id="hora" class="form-select" required>
                        <option value="">Selecione o horário</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="profissional_id" class="form-label fw-bold text-dark-blue">Profissional</label>
                    <select name="profissional_id" id="profissional_id" class="form-select" required>
                        <option value="">Selecione o profissional</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="servico_id" class="form-label fw-bold text-dark-blue">Serviço</label>
                    <select name="servico_id" id="servico_id" class="form-select" required>
                        <?php foreach ($retornoServico as $rs): ?>
                            <option value="<?= $rs->id ?>">
                                <?= htmlspecialchars($rs->nome) ?> - R$<?= number_format($rs->preco, 2, ',', '.') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="observacoes" class="form-label fw-bold text-dark-blue">Observações</label>
                    <textarea name="observacoes" id="observacoes" class="form-control"></textarea>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="/barberx" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Voltar
                    </a>
                    <button type="submit" class="btn btn-primary ms-2">
                        <i class="fas fa-calendar-check me-1"></i> Agendar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#data").on("change", function() {
            let data = $(this).val();
            if (data) {
                $.post("/barberx/buscar_horarios", {
                    data: data,
                    barbearia_id: <?= $barbearia_id ?>
                }, function(res) {
                    $("#hora").html('<option value="">Selecione o horário</option>');
                    res.forEach(function(h) {
                        $("#hora").append(`<option value="${h.full}">${h.horario}</option>`);
                    });
                }, "json");
            }
        });

        $("#hora").on("change", function() {
            let hora = $(this).val();
            let data = $("#data").val();
            if (data && hora) {
                $.post("/barberx/buscar_profissionais", {
                    data: data,
                    hora: hora,
                    barbearia_id: <?= $barbearia_id ?>
                }, function(res) {
                    $("#profissional_id").html('<option value="">Selecione o profissional</option>');
                    res.forEach(function(p) {
                        $("#profissional_id").append(`<option value="${p.id}">${p.nome}</option>`);
                    });
                }, "json");
            }
        });
    });
</script>