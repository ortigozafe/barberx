<div class="container mt-5 ">
    <h2 class="text-center fw-bold text-dark-blue fs-1 mb-4 animate__animated animate__fadeInDown">Agendamentos</h2>

    <div class="row mb-3 animate__animated animate__fadeInUp">
        <div class="col-md-4">
            <select id="barbearia_filtro" class="form-select shadow-sm">
                <option value="">Selecione a barbearia</option>
                <?php foreach ($barbearias as $b): ?>
                    <option value="<?= $b->id ?>"><?=$b->nome ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <input type="text" id="filtro_nome" class="form-control shadow-sm" placeholder="Filtrar por cliente">
        </div>
        <div class="col-md-4 d-flex gap-2">
            <input type="date" id="filtro_data_inicio" class="form-control shadow-sm">
            <input type="date" id="filtro_data_fim" class="form-control shadow-sm">
        </div>
    </div>

    <div id="lista_agendamentos" class="table-responsive animate__animated animate__fadeInUp">
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
                        html += `<table class="table table-striped table-hover align-middle shadow-sm">
                            <thead class="table-secondary">
                                <tr>
                                    <th>Cliente</th>
                                    <th>Profissional</th>
                                    <th>Serviço</th>
                                    <th>Data/Hora</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>`;
                        filtrados.forEach(a => {
                            html += `
                                <tr>
                                    <td>${a.cliente}</td>
                                    <td>${a.profissional}</td>
                                    <td>${a.servico}</td>
                                    <td>${new Date(a.data_hora).toLocaleString()}</td>
                                    <td>
                                        <span class="badge bg-${a.status === 'agendado' ? 'primary' : (a.status === 'cancelado' ? 'danger' : 'success')}">
                                            ${a.status}
                                        </span>
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