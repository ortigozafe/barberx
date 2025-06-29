<form method="post" action="/barberx/agendar?id=<?= $barbeariaData   ->id ?>">
    <div class="mb-3">
        <label>Data</label>
        <input type="date" name="data" id="data" class="form-control" required min="<?= date('Y-m-d') ?>">
    </div>

    <div class="mb-3">
        <label>Horário</label>
        <select name="hora" id="hora" class="form-select" required>
            <option value="">Selecione o horário</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Profissional</label>
        <select name="profissional_id" id="profissional_id" class="form-select" required>
            <option value="">Selecione o profissional</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Serviço</label>
        <select name="servico_id" class="form-select" required>
            <?php foreach ($retornoServico as $rs): ?>
                <option value="<?= $rs->id ?>">
                    <?= htmlspecialchars($rs->nome) ?> - R$<?= number_format($rs->preco, 2, ',', '.') ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Observações</label>
        <textarea name="observacoes" class="form-control"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Agendar</button>
</form>

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