<!doctype html>
<html>
	<head>
		<title>Filtro curso</title>
		<meta charset="UTF-8">
	</head>
	<body>
		<h1>Cursos</h1>
		<form action="/Curso/gerar_pdf" method="post">
			<select name="curso">
				<option value="0">Escolha um curso</option>
				<?php
					foreach($retorno as $dado)
					{
						echo "<option value='{$dado->id_curso}'>{$dado->nome}</option>";
					}
				?>
			</select>
			<div><?php echo $msg; ?></div>
			<br><br>
			<input type="submit" value="Enviar">
		</form>
	</body>
</html>