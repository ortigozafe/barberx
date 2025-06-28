<div class="container mt-5">
    <h2 class="text-center mb-4 fw-bold text-dark-blue fs-1 animate__animated animate__fadeInDown">Dashboard da Barbearia</h2>

    <div class="row mt-3">
        <div class="col-md-3 mb-3">
            <div class="bg-white rounded shadow p-4 text-center h-100 animate__animated animate__fadeInUp d-flex flex-column justify-content-between">
                <div>
                    <h5 class="text-dark-blue mb-3">Agendamentos do dia</h5>
                    <h2 class="text-primary fw-bolder" id="agendamentos_dia"><?= $dadosDashboard->agendamentos_dia ?? 0 ?></h2>
                </div>
                <btn data-bs-toggle="modal" data-bs-target="#modalAgendamentosDia" class="btn btn-outline-primary mt-3 w-100 fw-bold">
                    <i class="fa fa-info-circle me-2"></i>Ver mais
                </btn>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="bg-white rounded shadow p-4 text-center h-100 animate__animated animate__fadeInUp d-flex flex-column justify-content-between">
                <div>
                    <h5 class="text-dark-blue mb-3">Total de clientes no mês</h5>
                    <h2 class="text-primary fw-bolder" id="clientes_mes"><?= $dadosDashboard->clientes_mes ?? 0 ?></h2>
                </div>
                <btn data-bs-toggle="modal" data-bs-target="#modalClientesMes" class="btn btn-outline-primary mt-3 w-100 fw-bold">
                    <i class="fa fa-info-circle me-2"></i>Ver mais
                </btn>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="bg-white rounded shadow p-4 text-center h-100 animate__animated animate__fadeInUp d-flex flex-column justify-content-between">
                <div>
                    <h5 class="text-dark-blue mb-3">Serviços realizados</h5>
                    <h2 class="text-primary fw-bolder" id="servicos_realizados"><?= $dadosDashboard->servicos_realizados ?? 0 ?></h2>
                </div>
                <btn data-bs-toggle="modal" data-bs-target="#modalServicosRealizados" class="btn btn-outline-primary mt-3 w-100 fw-bold">
                    <i class="fa fa-info-circle me-2"></i>Ver mais
                </btn>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="bg-white rounded shadow p-4 text-center h-100 d-flex flex-column justify-content-between align-items-center animate__animated animate__fadeInUp">
                <h5 class="mb-3 text-dark-blue">Gerar PDF do Dia</h5>
                <form action="/barberx/pdf_dia" method="post" target="_blank" class="w-100">
                    <select name="barbearia_id" class="form-select mb-3" required>
                        <option value="">Selecione a barbearia</option>
                        <?php foreach ($dadosDashboard->barbearias as $b): ?>
                            <option value="<?= $b->id ?>"><?= htmlspecialchars($b->nome) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-outline-primary fw-bold w-100"><i class="fa fa-file me-2"></i>Gerar PDF</button>
                </form>
            </div>
        </div>
    </div>

    <div class="row mt-5 bg-white rounded shadow p-3 animate__animated animate__fadeInLeft">
        <div class="col-12 mb-5 mt-4">
            <div class="text-center">
                <h5 class="mb-3 text-dark-blue">Selecionar barbearia para gráficos</h5>
                <select id="barbearia_graficos" class="form-select w-50 mx-auto" required>
                    <option value="">Selecione a barbearia</option>
                    <?php foreach ($dadosDashboard->barbearias as $b): ?>
                        <option value="<?= $b->id ?>"><?= htmlspecialchars($b->nome) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <h5 class="text-center mb-3 text-dark-blue">Agendamentos por dia</h5>
            <div id="grafico_barras" style="min-height: 350px;"></div>
        </div>
        <div class="col-md-6 mb-4">
            <h5 class="text-center mb-3 text-dark-blue">Histórico dos agendamentos</h5>
            <div id="grafico_pizza" style="min-height: 350px;"></div>
        </div>
    </div>
</div>

<!-- Modal Agendamentos do Dia -->
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

<!-- Modal Clientes do Mês -->
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

<!-- Modal Serviços Realizados -->
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
        const selectBarbearia = document.getElementById("barbearia_graficos");

        selectBarbearia.addEventListener("change", function() {
            const barbearia_id = this.value;

            if (!barbearia_id) {
                document.getElementById("grafico_barras").innerHTML = "<h5 class='text-center text-muted pt-5'>Selecione uma barbearia para exibir os dados</h5>";
                document.getElementById("grafico_pizza").innerHTML = "<h5 class='text-center text-muted pt-5'>Selecione uma barbearia para exibir os dados</h5>";
                return;
            }

            fetch(`/barberx/dadosgraficobarras?barbearia_id=${barbearia_id}`)
                .then(res => res.json())
                .then(dados => {
                    if (dados.length > 0) {
                        gerar_grafico_barras(dados);
                    } else {
                        document.getElementById("grafico_barras").innerHTML = "<h5 class='text-center text-muted pt-5'>Sem dados para gerar o gráfico de barras</h5>";
                    }
                });

            fetch(`/barberx/dadosgraficopizza?barbearia_id=${barbearia_id}`)
                .then(res => res.json())
                .then(dados => {
                    if (dados.length > 0) {
                        gerar_grafico_pizza(dados);
                    } else {
                        document.getElementById("grafico_pizza").innerHTML = "<h5 class='text-center text-muted pt-5'>Sem dados para gerar o gráfico de pizza</h5>";
                    }
                });
        });
    });

    function gerar_grafico_barras(dados) {
        const dayTranslator = {
            "Monday": "Segunda",
            "Tuesday": "Terça",
            "Wednesday": "Quarta",
            "Thursday": "Quinta",
            "Friday": "Sexta",
            "Saturday": "Sábado",
            "Sunday": "Domingo"
        };

        const dias = dados.map(item => dayTranslator[item.dia] || item.dia);
        const valores = dados.map(item => parseInt(item.total));

        const options = {
            chart: {
                type: 'bar',
                height: 350,
                toolbar: {
                    show: false
                }
            },
            series: [{
                name: 'Agendamentos',
                data: valores
            }],
            xaxis: {
                categories: dias,
                labels: {
                    style: {
                        colors: '#003a70',
                        fontFamily: 'Poppins, sans-serif'
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: '#003a70',
                        fontFamily: 'Poppins, sans-serif'
                    }
                }
            },
            colors: ['#007bff'],
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    distributed: true
                }
            },
            dataLabels: {
                enabled: true,
                style: {
                    colors: ['#fff']
                }
            },
            grid: {
                borderColor: '#e9ecef',
                row: {
                    colors: ['#f8f9fa', 'transparent'],
                    opacity: 0.7
                }
            }
        };

        const chart = new ApexCharts(document.querySelector("#grafico_barras"), options);
        chart.render();
    }

    function gerar_grafico_pizza(dados) {
        const statusMap = {
            "pending": "Pendente",
            "completed": "Concluído",
            "canceled": "Cancelado"
        };

        const labels = dados.map(item => statusMap[item.status] || item.status);
        const valores = dados.map(item => parseInt(item.total));

        const optionsPizza = {
            chart: {
                type: 'pie',
                height: 350,
                toolbar: {
                    show: false
                }
            },
            series: valores,
            labels: labels,
            colors: ['#ffc107', '#198754', '#dc3545'],
            dataLabels: {
                enabled: true,
                formatter: (val, opts) => opts.w.config.labels[opts.seriesIndex] + ": " + val.toFixed(1) + '%',
                style: {
                    colors: ['#fff']
                },
                dropShadow: {
                    enabled: true,
                    top: 1,
                    left: 1,
                    blur: 1,
                    opacity: 0.45
                }
            },
            legend: {
                position: 'bottom',
                labels: {
                    colors: '#003a70',
                    fontFamily: 'Poppins, sans-serif'
                }
            },
            tooltip: {
                fillSeriesColor: false
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        const chartPizza = new ApexCharts(document.querySelector("#grafico_pizza"), optionsPizza);
        chartPizza.render();
    }

    document.addEventListener("DOMContentLoaded", function() {
        const barbeariaId = <?= $barbearia_id ?>;

        const modalAgendamentosDia = document.getElementById("modalAgendamentosDia");
        modalAgendamentosDia.addEventListener("show.bs.modal", function() {
            fetch(`/barberx/apiAgendamentosDia?barbearia_id=${barbeariaId}`)
                .then(r => r.json())
                .then(data => {
                    let html = "";
                    if (data.length) {
                        html += "<ul class='list-group'>";
                        data.forEach(a => {
                            html += `<li class="list-group-item">
                                <strong>${a.cliente}</strong> - ${new Date(a.data_hora).toLocaleTimeString()}, ${a.status} 
                                <small class="text-muted">(${a.barbearia})</small>
                            </li>`;
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
            fetch(`/barberx/apiClientesMes?barbearia_id=${barbeariaId}`)
                .then(r => r.json())
                .then(data => {
                    let html = "";
                    if (data.length) {
                        html += "<ul class='list-group'>";
                        data.forEach(c => {
                            html += `<li class="list-group-item">
                                <strong>${c.nome}</strong> - Celular: ${c.telefone} / Email: ${c.email} 
                                <small class="text-muted">(${c.barbearia})</small>
                            </li>`;
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
            fetch(`/barberx/apiServicosRealizados?barbearia_id=${barbeariaId}`)
                .then(r => r.json())
                .then(data => {
                    let html = "";
                    if (data.length) {
                        html += "<ul class='list-group'>";
                       data.forEach(s => {
                            html += `<li class="list-group-item">
                                <strong>${s.cliente}</strong> - ${s.servico} em ${new Date(s.data_hora).toLocaleString()} 
                                <small class="text-muted">(${s.barbearia})</small>
                            </li>`;
                        });
                        html += "</ul>";
                    } else {
                        html = "Nenhum serviço concluído.";
                    }
                    document.getElementById("conteudoServicosRealizados").innerHTML = html;
                });
        });
    });
</script>