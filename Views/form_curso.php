<!doctype html>
<html>
	<head>
		<title>Pets</title>
		<meta charset="UTF-8">
	</head>
	<body>
		<h1>Curso</h1>
		<form action="/Curso/inserir" method="post">
			<label>Nome:</label>
			<input type="text" name="nome" value="<?php echo isset($_POST['nome'])?$_POST['nome']:'' ?>">
			<div><?php echo $msg;?></div>
			<br><br>
			
			<input type="submit" value="Cadastrar">
		</form>
	</body>
</html>