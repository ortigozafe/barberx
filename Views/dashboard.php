<div class="container mt-5">
    <h2 class="text-center mb-4 fw-bold text-dark-blue fs-1 animate__animated animate__fadeInDown">Dashboard da Barbearia</h2>

    <div class="text-center mt-4">
        <h5 class="mb-3 text-dark-blue">Selecione a barbearia</h5>
        <select id="barbearia_selecionada" class="form-select w-50 mx-auto shadow-sm">
            <option value="">Selecione a barbearia</option>
            <?php foreach ($barbearias as $b): ?>
                <option value="<?= $b->id ?>"><?= htmlspecialchars($b->nome) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="row mt-4">
        <div class="col-md-3 mb-3">
            <div class="bg-white rounded shadow p-4 text-center h-100 animate__animated animate__fadeInUp d-flex flex-column justify-content-between">
                <div>
                    <h5 class="text-dark-blue mb-3">Agendamentos do dia</h5>
                    <h2 class="text-primary fw-bolder" id="agendamentos_dia">0</h2>
                </div>
                <button data-bs-toggle="modal" data-bs-target="#modalAgendamentosDia" class="btn btn-outline-primary mt-3 w-100 fw-bold">
                    <i class="fa fa-info-circle me-2"></i>Ver mais
                </button>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="bg-white rounded shadow p-4 text-center h-100 animate__animated animate__fadeInUp d-flex flex-column justify-content-between">
                <div>
                    <h5 class="text-dark-blue mb-3">Total de clientes no mês</h5>
                    <h2 class="text-primary fw-bolder" id="clientes_mes">0</h2>
                </div>
                <button data-bs-toggle="modal" data-bs-target="#modalClientesMes" class="btn btn-outline-primary mt-3 w-100 fw-bold">
                    <i class="fa fa-info-circle me-2"></i>Ver mais
                </button>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="bg-white rounded shadow p-4 text-center h-100 animate__animated animate__fadeInUp d-flex flex-column justify-content-between">
                <div>
                    <h5 class="text-dark-blue mb-3">Serviços realizados</h5>
                    <h2 class="text-primary fw-bolder" id="servicos_realizados">0</h2>
                </div>
                <button data-bs-toggle="modal" data-bs-target="#modalServicosRealizados" class="btn btn-outline-primary mt-3 w-100 fw-bold">
                    <i class="fa fa-info-circle me-2"></i>Ver mais
                </button>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="bg-white rounded shadow p-4 text-center h-100 d-flex flex-column justify-content-between align-items-center animate__animated animate__fadeInUp">
                <h5 class="mb-3 text-dark-blue">Gerar PDF do Dia</h5>
                <form id="form_pdf" action="/barberx/pdf_dia" method="post" target="_blank" class="w-100">
                    <input type="hidden" name="barbearia_id" id="pdf_barbearia_id">
                    <button type="submit" class="btn mb-4 text-danger w-100 fw-bold pdf-icon-button p-0">
                        <i class="fa fa-file-pdf fa-4x"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="row mt-4 bg-white rounded shadow p-3 animate__animated animate__fadeInLeft">
        <div class="col-md-7 mb-4">
            <h5 class="text-center me-5 mb-3 text-dark-blue">Agendamentos por dia</h5>
            <div id="grafico_barras" style="min-height: 350px;"></div>
        </div>
        <div class="col-md-5 mb-4">
            <h5 class="text-center mb-3 text-dark-blue">Histórico dos agendamentos</h5>
            <div id="grafico_pizza" style="min-height: 350px;"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAgendamentosDia" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Agendamentos do Dia</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="conteudoAgendamentosDia">
                Carregando...
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalClientesMes" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Clientes do Mês</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="conteudoClientesMes">
                Carregando...
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalServicosRealizados" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Serviços Realizados</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="conteudoServicosRealizados">
                Carregando...
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        function gerar_grafico_barras(dados) {
            if (window.barraChart) window.barraChart.destroy();

            const dayTranslator = {
                "Monday": "Segunda",
                "Tuesday": "Terça",
                "Wednesday": "Quarta",
                "Thursday": "Quinta",
                "Friday": "Sexta",
                "Saturday": "Sábado",
                "Sunday": "Domingo"
            };

            const diasTraduzidos = dados.map(d => dayTranslator[d.dia] || d.dia);

            const options = {
                chart: {
                    type: 'bar',
                    height: 350
                },
                series: [{
                    name: "Agendamentos",
                    data: dados.map(d => d.total ?? 0)
                }],
                xaxis: {
                    categories: diasTraduzidos
                },
                colors: ['#007bff']
            };

            window.barraChart = new ApexCharts(document.querySelector("#grafico_barras"), options);
            window.barraChart.render();
        }

        function gerar_grafico_pizza(dados) {
            if (window.pizzaChart) window.pizzaChart.destroy();
            const options = {
                chart: {
                    type: 'pie',
                    height: 350
                },
                series: dados.map(d => d.total),
                labels: dados.map(d => d.status),
                colors: ['#007bff', '#28a745', '#ffc107', '#dc3545']
            };
            window.pizzaChart = new ApexCharts(document.querySelector("#grafico_pizza"), options);
            window.pizzaChart.render();
        }

        const selectBarbearia = document.getElementById("barbearia_selecionada");

        selectBarbearia.addEventListener("change", function() {
            const barbearia_id = this.value;

            if (!barbearia_id) {
                document.getElementById("grafico_barras").innerHTML = "<h5 class='text-center text-muted pt-5'>Selecione uma barbearia</h5>";
                document.getElementById("grafico_pizza").innerHTML = "<h5 class='text-center text-muted pt-5'>Selecione uma barbearia</h5>";
                document.getElementById("agendamentos_dia").textContent = "0";
                document.getElementById("clientes_mes").textContent = "0";
                document.getElementById("servicos_realizados").textContent = "0";
                document.getElementById("pdf_barbearia_id").value = "";
                return;
            }

            document.getElementById("pdf_barbearia_id").value = barbearia_id;

            fetch(`/barberx/apiDadosDashboard?barbearia_id=${barbearia_id}`)
                .then(r => r.json())
                .then(data => {
                    document.getElementById("agendamentos_dia").textContent = data.agendamentos_dia;
                    document.getElementById("clientes_mes").textContent = data.clientes_mes;
                    document.getElementById("servicos_realizados").textContent = data.servicos_realizados;
                });

            fetch(`/barberx/dadosgraficobarras?barbearia_id=${barbearia_id}`)
                .then(res => res.json())
                .then(dados => {
                    if (dados.length > 0) gerar_grafico_barras(dados);
                    else document.getElementById("grafico_barras").innerHTML = "<h5 class='text-center text-muted pt-5'>Sem dados</h5>";
                });

            fetch(`/barberx/dadosgraficopizza?barbearia_id=${barbearia_id}`)
                .then(res => res.json())
                .then(dados => {
                    if (dados.length > 0) gerar_grafico_pizza(dados);
                    else document.getElementById("grafico_pizza").innerHTML = "<h5 class='text-center text-muted pt-5'>Sem dados</h5>";
                });

            const modalAgendamentosDia = document.getElementById("modalAgendamentosDia");
            modalAgendamentosDia.addEventListener("show.bs.modal", function() {
                fetch(`/barberx/apiAgendamentosDia?barbearia_id=${barbearia_id}`)
                    .then(r => r.json())
                    .then(data => {
                        let html = "";
                        if (data.length) {
                            html += "<ul class='list-group'>";
                            data.forEach(a => {
                                html += `<li class="list-group-item"><strong>${a.cliente}</strong> - ${new Date(a.data_hora).toLocaleTimeString()} - ${a.status}<small class="text-muted">(${a.barbearia})</small></li>`;
                            });
                            html += "</ul>";
                        } else {
                            html = "Nenhum agendamento hoje.";
                        }
                        document.getElementById("conteudoAgendamentosDia").innerHTML = html;
                    });
            });

            const modalClientesMes = document.getElementById("modalClientesMes");
            modalClientesMes.addEventListener("show.bs.modal", function() {
                fetch(`/barberx/apiClientesMes?barbearia_id=${barbearia_id}`)
                    .then(r => r.json())
                    .then(data => {
                        let html = "";
                        if (data.length) {
                            html += "<ul class='list-group'>";
                            data.forEach(c => {
                                html += `<li class="list-group-item"><strong>${c.nome}</strong> - ${c.telefone} / ${c.email}<small class="text-muted">(${c.barbearia})</small></li>`;
                            });
                            html += "</ul>";
                        } else {
                            html = "Nenhum cliente este mês.";
                        }
                        document.getElementById("conteudoClientesMes").innerHTML = html;
                    });
            });

            const modalServicosRealizados = document.getElementById("modalServicosRealizados");
            modalServicosRealizados.addEventListener("show.bs.modal", function() {
                fetch(`/barberx/apiServicosRealizados?barbearia_id=${barbearia_id}`)
                    .then(r => r.json())
                    .then(data => {
                        let html = "";
                        if (data.length) {
                            html += "<ul class='list-group'>";
                            data.forEach(s => {
                                html += `<li class="list-group-item"><strong>${s.cliente}</strong> - ${s.servico} em ${new Date(s.data_hora).toLocaleString()}<small class="text-muted">(${s.barbearia})</small></li>`;
                            });
                            html += "</ul>";
                        } else {
                            html = "Nenhum serviço concluído.";
                        }
                        document.getElementById("conteudoServicosRealizados").innerHTML = html;
                    });
            });
        });
    });
</script>