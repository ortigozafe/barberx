<div class="container py-5 animate__animated animate__fadeInUp">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white text-center rounded-top-4">
                    <h2 class="mb-0 fw-bold">Agendar Horário</h2>
                </div>
                <div class="card-body bg-white p-4">
                    <form method="post" action="/barberx/agendar?id=<?= $barbeariaData->id ?>" enctype="multipart/form-data">
                        <div class="mb-4">
                            <label class="form-label fw-semibold" for="data">Data</label>
                            <input type="date" name="data" id="data" class="form-control form-control-lg shadow-sm" required min="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold" for="hora">Horário</label>
                            <select name="hora" id="hora" class="form-select form-select-lg shadow-sm" required>
                                <option value="">Selecione o horário</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold" for="profissional_id">Profissional</label>
                            <select name="profissional_id" id="profissional_id" class="form-select form-select-lg shadow-sm" required>
                                <option value="">Selecione o profissional</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold" for="servico_id">Serviço</label>
                            <select name="servico_id" id="servico_id" class="form-select form-select-lg shadow-sm" required>
                                <?php foreach ($retornoServico as $rs): ?>
                                    <option value="<?= $rs->id ?>">
                                        <?= htmlspecialchars($rs->nome) ?> - R$<?= number_format($rs->preco, 2, ',', '.') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold" for="observacoes">Observações</label>
                            <textarea name="observacoes" id="observacoes" class="form-control form-control-lg shadow-sm" rows="2" placeholder="Alguma observação? (opcional)"></textarea>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm">
                                <i class="fas fa-calendar-plus me-2"></i>Agendar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
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