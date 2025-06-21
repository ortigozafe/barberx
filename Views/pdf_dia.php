<?php
require_once "vendor/autoload.php";
date_default_timezone_set("America/Sao_Paulo");

$mpdf = new \Mpdf\Mpdf();

// Cabeçalho
$html = "<h2>Serviços Agendados - " . date("d/m/Y") . "</h2><hr>";
$html .= "<p>Relatório de serviços do dia da barbearia.</p><br>";

// Tabela com os dados
$html .= "<table border='1' width='100%' style='border-collapse: collapse; text-align: left; font-size: 12px;'>
            <thead>
                <tr>
                    <th>Horário</th>
                    <th>Profissional</th>
                    <th>Serviço</th>
                    <th>Cliente</th>
                </tr>
            </thead>
            <tbody>";

foreach ($ret as $item) {
    $hora = date("H:i", strtotime($item->data_hora));
    $html .= "<tr>
                <td>{$hora}</td>
                <td>{$item->profissional}</td>
                <td>{$item->servico}</td>
                <td>{$item->cliente}</td>
              </tr>";
}

$html .= "</tbody></table>";

// Geração do PDF
$mpdf->WriteHTML($html);
$mpdf->Output("relatorio_servicos_" . date("Ymd") . ".pdf", "I");
exit;
?>
