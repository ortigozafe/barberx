<?php
	date_default_timezone_set("America/Sao_Paulo");
	require_once "vendor/autoload.php";
	$mpdf = new \Mpdf\mpdf();
	
	$header = "<h1>Alunos Matriculados no Curso - {$ret[0]->curso}</h1>";
	
	$header .= "<br><br>" . date("d/m/Y");
	
	$body = "<br><br>
				<table>
					<tr>
						<th>Aluno</th>
						<th>Data da Matrícula</th>
					</tr>";
	foreach($ret as $dado)
	{
		$data = explode("-", $dado->data_matricula);
		$dataM = $data[2] . "/" . $data[1] . "/" . $data[0];
		$body .= "<tr>
				  <td>{$dado->nome}</td>
				  <td>{$dataM}</td>
				  </tr>";
	}
	$body .= "</table>";
	
	$html = $header . $body;
	
	
	
	//$estilo = file_get_contents("style/estilo.css");
	//$mpdf->WriteHTML($estilo, 1);
	
	$mpdf->WriteHTML($html);
	$mpdf->Output();
?>