<!doctype html>
<html>
	<head>
		<title>Pets</title>
		<meta charset="UTF-8">
	</head>
	<body>
		<h1>Pet</h1>
		<form action="/Adocao/alterar" method="post">
			<input type="hidden" name="id_pet" value="<?php echo $retorno[0]->id_pet?>">
			<label>Nome:</label>
			<input type="text" name="nome" value="<?php echo isset($_POST['nome'])?$_POST['nome']:$retorno[0]->nome ?>">
			<div><?php echo $msg[0];?></div>
			<br><br>
			<label>Idade:</label>
			<input type="number" name="idade" value="<?php echo isset($_POST['idade'])?$_POST['idade']:$retorno[0]->idade ?>">
			<div><?php echo $msg[1];?></div>
			<br><br>
			<label>Cor:</label>
			<input type="text" name="cor" value="<?php echo isset($_POST['cor'])?$_POST['cor']:$retorno[0]->cor ?>">
			<div><?php echo $msg[2];?></div>
			<br><br>
			<label>Porte:</label>
			<select name="porte">
				<?php
				if($retorno[0]->porte == "Mini")
				{
					echo "<option selected>Mini</option>";
				}
				else
				{
				  echo "<option>Mini</option>";
				}
				
				if($retorno[0]->porte == "Pequeno")
				{
					echo "<option selected>Pequeno</option>";
				}
				else
				{
				  echo "<option>Pequeno</option>";
				}
				if($retorno[0]->porte == "Médio")
				{
					echo "<option selected>Médio</option>";
				}
				else
				{
				  echo "<option>Médio</option>";
				}
				if($retorno[0]->porte== "Grande")
				{
					echo "<option selected>Grande</option>";
				}
				else
				{
				  echo "<option>Grande</option>";
				}
				?>
			</select>
			<div><?php echo $msg[3];?></div>
			<br><br>
			<input type="submit" value="Cadastrar">
		</form>
	</body>
</html>