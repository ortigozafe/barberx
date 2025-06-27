<div class="container mt-5">
    <h2 class="text-center mb-4 fw-bold text-primary fs-1">Dashboard da Barbearia</h2>
    <div class="row text-white mt-5">
        <div class="col-md-3 mb-3">
            <div class="bg-primary rounded shadow p-4 text-center">
                <h5>Agendamentos do Dia</h5>
                <h2><?= $dados['agendamentos_dia'] ?? 0 ?></h2>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="bg-primary rounded shadow p-4 text-center">
                <h5>Total de Clientes no Mês</h5>
                <h2><?= $dados['clientes_mes'] ?? 0 ?></h2>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="bg-primary rounded shadow p-4 text-center">
                <h5>Serviços Realizados</h5>
                <h2><?= $dados['servicos_realizados'] ?? 0 ?></h2>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="bg-primary rounded shadow p-4 text-center h-100">
                <h5 class="mb-3">Gerar PDF do Dia</h5>
                <a href="/barberx/pdf_dia" class="btn btn-light fw-bold">Gerar PDF</a>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-6">
            <div class="bg-white rounded shadow p-3">
                <h5 class="text-center mb-3">Agendamentos por Dia da Semana</h5>
                <div id="grafico_barras"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="bg-white rounded shadow p-3">
                <h5 class="text-center mb-3">Status dos Agendamentos</h5>
                <div id="grafico_pizza"></div>
            </div>
        </div>
    </div>
</div>

<div class="mb-4 p-3" id="grafico_barras"></div>
<div class="mb-4 p-3 id="grafico_pizza"></div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetch("/barberx/dadosgraficobarras") 
            .then(response => response.json())
            .then(dados => {
                if (dados.length > 0) {
                    gerar_grafico_barras(dados);
                } else {
                    document.getElementById("grafico_barras").innerHTML = "<h5 class='text-center'>Sem dados para gerar o gráfico de barras</h5>";
                }
            })
            .catch(() => {
                document.getElementById("grafico_barras").innerHTML = "<h5 class='text-center text-danger'>Erro ao carregar dados do gráfico de barras.</h5>";
            });

        fetch("/barberx/dadosgraficopizza") 
            .then(response => response.json())
            .then(dados => {
                if (dados.length > 0) {
                    gerar_grafico_pizza(dados);
                } else {
                    document.getElementById("grafico_pizza").innerHTML = "<h5 class='text-center'>Sem dados para gerar o gráfico de pizza</h5>";
                }
            })
            .catch(() => {
                document.getElementById("grafico_pizza").innerHTML = "<h5 class='text-center text-danger'>Erro ao carregar dados do gráfico de pizza.</h5>";
            });

        function gerar_grafico_barras(dados) {
            const dias = dados.map(item => item.dia);
            const valores = dados.map(item => parseInt(item.total));

            var options = {
                chart: {
                    type: 'bar',
                    height: 350,
                },
                series: [{
                    name: 'Agendamentos',
                    data: valores
                }],
                xaxis: {
                    categories: dias
                },
                colors: ['#0d6efd'],
                plotOptions: {
                    bar: {
                        borderRadius: 5
                    }
                },
                dataLabels: {
                    enabled: true
                }
            };
            var chart = new ApexCharts(document.querySelector("#grafico_barras"), options);
            chart.render();
        }

        function gerar_grafico_pizza(dados) {
            const status = dados.map(item => item.status);
            const valoresPizza = dados.map(item => parseInt(item.total));

            var optionsPizza = {
                chart: {
                    type: 'pie',
                    height: 350,
                },
                series: valoresPizza,
                labels: status,
                colors: ['#ffc107','#198754', '#dc3545'],
                dataLabels: {
                    enabled: true
                },
                legend: {
                    position: 'bottom'
                }
            };
            var chartPizza = new ApexCharts(document.querySelector("#grafico_pizza"), optionsPizza);
            chartPizza.render();
        }
    });
</script>