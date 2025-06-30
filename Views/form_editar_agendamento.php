<div class="container py-5 d-flex rounded justify-content-center">
    <?php if (!empty($erro)): ?>
        <div class="alert alert-danger w-100 text-center"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>
    <div class="card shadow-lg animate__animated animate__fadeInUp" style="max-width: 600px; width: 100%;">
        <div class="card-header bg-primary text-white text-center">
            <h2 class="mb-0">Editar Agendamento</h2>
        </div>
        <div class="card-body rounded bg-white p-4">
            <form method="post" action="/barberx/editar_agendamento?id=<?= $agendamento->getId() ?>" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="data" class="form-label fw-bold text-dark-blue">Data</label>
                    <input type="date" name="data" id="data" class="form-control" required
                        min="<?= date('Y-m-d') ?>"
                        value="<?= date('Y-m-d', strtotime($agendamento->getDataHora())) ?>">
                </div>

                <div class="mb-3">
                    <label for="hora" class="form-label fw-bold text-dark-blue">Horário</label>
                    <select name="hora" id="hora" class="form-select" required>
                        <!-- Será preenchido via JS -->
                    </select>
                </div>

                <div class="mb-3">
                    <label for="profissional_id" class="form-label fw-bold text-dark-blue">Profissional</label>
                    <select name="profissional_id" id="profissional_id" class="form-select" required>
                        <!-- Será preenchido via JS -->
                    </select>
                </div>

                <div class="mb-3">
                    <label for="servico_id" class="form-label fw-bold text-dark-blue">Serviço</label>
                    <select name="servico_id" id="servico_id" class="form-select" required>
                        <?php foreach ($retornoServico as $rs): ?>
                            <option value="<?= $rs->id ?>"
                                <?= $agendamento->getServico()->getId() == $rs->id ? 'selected' : '' ?>>
                                <?= htmlspecialchars($rs->nome) ?> - R$<?= number_format($rs->preco, 2, ',', '.') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="observacoes" class="form-label fw-bold text-dark-blue">Observações</label>
                    <textarea name="observacoes" id="observacoes" class="form-control"><?= htmlspecialchars($agendamento->getObservacoes()) ?></textarea>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="/barberx/agenda" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Voltar
                    </a>
                    <button type="submit" class="btn btn-primary ms-2">
                        <i class="fas fa-save me-1"></i> Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Função para carregar horários disponíveis
        function carregarHorarios(dataSelecionada) {
            if (dataSelecionada) {
                $.post("/barberx/buscar_horarios", {
                    data: dataSelecionada,
                    barbearia_id: <?= $agendamento->getBarbearia()->getId() ?>
                }, function(res) {
                    $("#hora").html('<option value="">Selecione o horário</option>');
                    res.forEach(function(h) {
                        $("#hora").append(`<option value="${h.full}">${h.horario}</option>`);
                    });

                    // Após carregar os horários, setar o horário atual selecionado, se existir
                    let horarioAtual = "<?= date('H:i', strtotime($agendamento->getDataHora())) ?>";
                    if (horarioAtual) {
                        $("#hora").val(horarioAtual).trigger("change");
                    }
                }, "json");
            } else {
                $("#hora").html('<option value="">Selecione o horário</option>');
                $("#profissional_id").html('<option value="">Selecione o profissional</option>');
            }
        }

        // Função para carregar profissionais disponíveis
        function carregarProfissionais(data, hora) {
            if (data && hora) {
                $.post("/barberx/buscar_profissionais", {
                    data: data,
                    hora: hora,
                    barbearia_id: <?= $agendamento->getBarbearia()->getId() ?>
                }, function(res) {
                    $("#profissional_id").html('<option value="">Selecione o profissional</option>');
                    res.forEach(function(p) {
                        $("#profissional_id").append(`<option value="${p.id}">${p.nome}</option>`);
                    });

                    // Após carregar profissionais, selecionar o profissional atual, se existir
                    let profAtual = "<?= $agendamento->getProfissional()->getId() ?>";
                    if (profAtual) {
                        $("#profissional_id").val(profAtual);
                    }
                }, "json");
            } else {
                $("#profissional_id").html('<option value="">Selecione o profissional</option>');
            }
        }

        // Evento mudança na data: carregar horários
        $("#data").on("change", function() {
            let data = $(this).val();
            carregarHorarios(data);
        });

        // Evento mudança no horário: carregar profissionais
        $("#hora").on("change", function() {
            let hora = $(this).val();
            let data = $("#data").val();
            carregarProfissionais(data, hora);
        });

        // Ao carregar a página, carregar horários e profissionais automaticamente com os valores atuais
        let dataAtual = $("#data").val();
        carregarHorarios(dataAtual);
    });
</script>