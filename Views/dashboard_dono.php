<?php
require_once "Views/layout/header_dono.php";
?>

<div class="container mt-5">
    <h2 class="text-center mb-4 fw-bold">Dashboard da Barbearia</h2>
    <div class="row text-white">
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
            <div class="bg-primary rounded shadow p-4 text-center">
                <h5>Gerar PDF do Dia</h5>
                <a href="/dashboard/pdf" class="btn btn-light fw-bold">Gerar PDF</a>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-6">
            <div class="bg-white rounded shadow p-3">
                <h5 class="text-center">Agendamentos por Semana</h5>
                <div id="grafico_barras"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="bg-white rounded shadow p-3">
                <h5 class="text-center">Agendados vs Cancelados</h5>
                <div id="grafico_pizza"></div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    const dadosPizza = <?= json_encode($dados['grafico_pizza'] ?? []) ?>;
    const dadosBarras = <?= json_encode($dados['grafico_barras'] ?? []) ?>;

    // Verifica se há dados para o gráfico de pizza
    if (dadosPizza.length > 0) {
        const seriesPizza = dadosPizza.map(item => item.total);
        const labelsPizza = dadosPizza.map(item => item.status);

        new ApexCharts(document.querySelector("#grafico_pizza"), {
            chart: { type: 'pie' },
            series: seriesPizza,
            labels: labelsPizza,
            colors: ['#198754', '#dc3545']
        }).render();
    } else {
        document.querySelector("#grafico_pizza").innerHTML = "<p class='text-center text-muted'>Sem dados para exibir.</p>";
    }

    // Verifica se há dados para o gráfico de barras
    if (dadosBarras.length > 0) {
        const seriesBarras = dadosBarras.map(item => item.total);
        const labelsBarras = dadosBarras.map(item => item.dia);

        new ApexCharts(document.querySelector("#grafico_barras"), {
            chart: { type: 'bar' },
            series: [{ name: 'Agendamentos', data: seriesBarras }],
            xaxis: { categories: labelsBarras },
            colors: ['#0d6efd']
        }).render();
    } else {
        document.querySelector("#grafico_barras").innerHTML = "<p class='text-center text-muted'>Sem dados para exibir.</p>";
    }
</script>

<?php
require_once "Views/layout/footer.php";
?>
