<div class="container py-5">
    <h2 class="display-5 fw-bold mb-5 text-primary animate__animated animate__fadeInDown">Agenda de Agendamentos</h2>

    <div class="row mb-4 animate__animated animate__fadeIn">
        <div class="col-md-4 mb-2">
            <select id="barbearia_filtro" class="form-select shadow rounded">
                <option value="">Selecione a Barbearia</option>
                <?php foreach ($barbearias as $b): ?>
                    <option value="<?= $b->id ?>"><?= htmlspecialchars($b->nome) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4 mb-2">
            <input type="text" id="filtro_nome" class="form-control shadow rounded" placeholder="Filtrar por cliente">
        </div>
        <div class="col-md-4 d-flex gap-2 mb-2">
            <input type="date" id="filtro_data_inicio" class="form-control shadow rounded">
            <input type="date" id="filtro_data_fim" class="form-control shadow rounded">
        </div>
    </div>

    <div id="lista_agendamentos" class="table-responsive animate__animated animate__fadeInUp shadow rounded-3 bg-white border p-3">
        <h5 class="text-center text-muted">Selecione uma barbearia para ver os agendamentos.</h5>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const select = document.getElementById("barbearia_filtro");
        const filtroNome = document.getElementById("filtro_nome");
        const dataInicio = document.getElementById("filtro_data_inicio");
        const dataFim = document.getElementById("filtro_data_fim");

        function carregarAgendamentos() {
            const id = select.value;
            const nome = filtroNome.value;
            const data_inicio = dataInicio.value;
            const data_fim = dataFim.value;

            if (!id) {
                document.getElementById("lista_agendamentos").innerHTML = "<h5 class='text-center text-muted'>Selecione uma barbearia para ver os agendamentos.</h5>";
                return;
            }

            fetch(`/barberx/apiAgendamentosBarbearia?barbearia_id=${id}`)
                .then(r => r.json())
                .then(data => {
                    let filtrados = data;

                    if (nome) {
                        filtrados = filtrados.filter(a =>
                            a.cliente.toLowerCase().includes(nome.toLowerCase())
                        );
                    }

                    if (data_inicio) {
                        filtrados = filtrados.filter(a =>
                            new Date(a.data_hora) >= new Date(data_inicio)
                        );
                    }

                    if (data_fim) {
                        filtrados = filtrados.filter(a =>
                            new Date(a.data_hora) <= new Date(data_fim + "T23:59:59")
                        );
                    }

                    let html = "";
                    if (filtrados.length > 0) {
                        html += `<table class="table table-hover align-middle mb-0">
                            <thead class="table-primary rounded">
                                <tr>
                                    <th>Cliente</th>
                                    <th>Serviço</th>
                                    <th>Profissional</th>
                                    <th>Data/Hora</th>
                                    <th>Status</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>`;
                        filtrados.forEach(a => {
                            const statusBadge = a.status === 'agendado' ?
                                'bg-success' :
                                (a.status === 'cancelado' ? 'bg-danger' : 'bg-primary');

                            let botoes = '';
                            if (a.status === 'agendado') {
                                botoes = `
                                    <a href="/barberx/cancelar_agendamento_dono?id=${a.id}" class="btn btn-sm btn-danger shadow me-1" title="Cancelar" onclick="return confirm('Deseja cancelar este agendamento?')">
                                        <i class="fas fa-times"></i>
                                    </a>
                                    <a href="/barberx/concluir_agendamento_dono?id=${a.id}" class="btn btn-sm btn-success shadow" title="Concluir" onclick="return confirm('Marcar este agendamento como concluído?')">
                                        <i class="fas fa-check"></i>
                                    </a>
                                `;
                            }

                            html += `
                                <tr>
                                    <td class="text-dark-gray fw-semibold">${a.cliente}</td>
                                    <td class="text-dark-gray">${a.servico}</td>
                                    <td class="text-dark-gray">${a.profissional}</td>
                                    <td class="text-dark-gray">${new Date(a.data_hora).toLocaleString()}</td>
                                    <td>
                                        <span class="badge ${statusBadge} text-white rounded-pill px-3 py-2 shadow-sm">
                                            ${a.status}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        ${botoes}
                                    </td>
                                </tr>`;
                        });

                        html += `</tbody></table>`;
                    } else {
                        html = "<h5 class='text-center text-muted'>Nenhum agendamento encontrado com os filtros aplicados.</h5>";
                    }
                    document.getElementById("lista_agendamentos").innerHTML = html;
                })
                .catch(() => {
                    document.getElementById("lista_agendamentos").innerHTML = "<h5 class='text-center text-danger'>Erro ao carregar os agendamentos.</h5>";
                });
        }

        select.addEventListener("change", carregarAgendamentos);
        filtroNome.addEventListener("input", carregarAgendamentos);
        dataInicio.addEventListener("change", carregarAgendamentos);
        dataFim.addEventListener("change", carregarAgendamentos);
    });
</script>