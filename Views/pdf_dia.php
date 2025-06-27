<?php
date_default_timezone_set("America/Sao_Paulo");
require_once "vendor/autoload.php";
$mpdf = new \Mpdf\Mpdf();

$header = "<h1>Serviços Agendados Hoje</h1>";
$header .= "<br><strong>Data de emissão:</strong> " . date("d/m/Y H:i");

$body = "<br><br>
		<table border='1' width='100%' style='border-collapse:collapse'>
			<tr>
				<th>Horário</th>
				<th>Cliente</th>
				<th>Serviço</th>
				<th>Profissional</th>
			</tr>";

foreach ($ret as $dado) {
    $dataHora = date("d/m/Y H:i", strtotime($dado->data_hora));
    $body .= "<tr>
			<td>{$dataHora}</td>
			<td>{$dado->cliente}</td>
			<td>{$dado->servico}</td>
			<td>{$dado->profissional}</td>
		</tr>";
}

$body .= "</table>";

$html = $header . $body;

//$estilo = file_get_contents("style/estilo.css");
//$mpdf->WriteHTML($estilo, 1);

$mpdf->WriteHTML($html);
$mpdf->Output();
