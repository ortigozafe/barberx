<?php
date_default_timezone_set("America/Sao_Paulo");
require_once "vendor/autoload.php";

$mpdf = new \Mpdf\Mpdf([
	'mode' => 'utf-8',
	'format' => 'A4',
	'default_font_size' => 10,
	'default_font' => 'sans-serif',
	'margin_top' => 20
]);

$dataAtual = date("d/m/Y");

$nomeBarbearia = $dadosPDF[0]->barbearia ?? 'Barbearia não identificada';

$header = "
<div style='text-align: center; margin-bottom: 10px;'>
    <h1 style='color: #007bff; font-family: sans-serif; margin: 0; font-size: 22px;'>Serviços de Hoje - {$nomeBarbearia}</h1>
    <small style='color: #555; font-size: 12px;'>
        <strong>Data:</strong> {$dataAtual} &nbsp;|&nbsp; <strong>Emitido às:</strong> " . date("H:i") . "
    </small>
</div>
<hr style='border-top: 1px solid #007bff; margin: 10px 0;'>
";

$body = "
<table width='100%' style='border-collapse: collapse; margin-top: 20px; font-family: sans-serif;'>
    <thead>
        <tr style='background-color:rgb(212, 205, 252); color: #fff;'>
            <th style='padding: 8px; text-align: left; border: 1px solid #dee2e6;'>Horário</th>
            <th style='padding: 8px; text-align: left; border: 1px solid #dee2e6;'>Cliente</th>
            <th style='padding: 8px; text-align: left; border: 1px solid #dee2e6;'>Serviço</th>
            <th style='padding: 8px; text-align: left; border: 1px solid #dee2e6;'>Profissional</th>
            <th style='padding: 8px; text-align: left; border: 1px solid #dee2e6;'>Status</th>
            <th style='padding: 8px; text-align: left; border: 1px solid #dee2e6;'>Observações</th>
        </tr>
    </thead>
    <tbody>
";

if (empty($dadosPDF)) {
	$body .= "<tr>
        <td colspan='6' style='padding: 10px; text-align: center; border: 1px solid #dee2e6; color: #777;'>Nenhum agendamento para hoje.</td>
    </tr>";
} else {
	foreach ($dadosPDF as $dado) {
		$horario = date("H:i", strtotime($dado->data_hora));

		$status = ucfirst($dado->status);
		$corStatus = match (strtolower($dado->status)) {
			'concluido' => '#198754',
			'agendado'  => '#ffc107', 
			'cancelado' => '#dc3545',
			default     => '#212529'
		};

		$body .= "
        <tr style='background-color: #f9f9f9;'>
            <td style='padding: 8px; border: 1px solid #dee2e6;'>{$horario}</td>
            <td style='padding: 8px; border: 1px solid #dee2e6;'>{$dado->cliente}</td>
            <td style='padding: 8px; border: 1px solid #dee2e6;'>{$dado->servico}</td>
            <td style='padding: 8px; border: 1px solid #dee2e6;'>{$dado->profissional}</td>
            <td style='padding: 8px; border: 1px solid #dee2e6; color: {$corStatus}; font-weight: bold;'>{$status}</td>
            <td style='padding: 8px; border: 1px solid #dee2e6;'>{$dado->observacoes}</td>
        </tr>
        ";
	}
}

$body .= "
    </tbody>
</table>
";

$html = $header . $body;

$mpdf->WriteHTML($html);
$mpdf->Output('servicos_do_dia.pdf', \Mpdf\Output\Destination::INLINE);
