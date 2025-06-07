<!doctype html>
<html>
	<head>
		<title>Adoção</title>
		<meta charset="UTF-8">
	</head>
	<body>
		<h1>Lista de Cursos</h1>
		<br>
		<table border="1">
			<tr>
				<th>Nome</th>
				
				
			</tr>
			<?php
				foreach($retorno as $dado)
				{
					echo "<tr>
					      <td>{$dado->nome}</td>
						  
						  </tr>";
				}
			?>
		</table>
	</body>
</html>