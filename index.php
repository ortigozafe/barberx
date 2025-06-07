<?php
	require_once "rotas.php";
	spl_autoload_register(function($class){
		if(file_exists('Controllers/' . $class . '.class.php'))
		{
			require_once 'Controllers/' . $class . '.class.php';
		}
		else if(file_exists('Models/' . $class . '.class.php'))
		{
			require_once 'Models/' . $class . '.class.php';
		}
		else
		{
			die("Arquivo não existe " . $class);
		}
	});
	
	//rotas
	$uri = parse_url($_SERVER["REQUEST_URI"])["path"];
	$uri = substr($uri, strpos($uri,'/',1));
	$route->verificar_rota($_SERVER["REQUEST_METHOD"],$uri);

?>