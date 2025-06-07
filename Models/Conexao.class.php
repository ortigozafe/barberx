<?php
	//singleton
	class Conexao
	{
		private static $conexao;
		private function __construct(){}
		public static function getInstancia()
		{
		if(empty(self::$conexao))
		{
			$parametros = "mysql:host=localhost;dbname=barberx;charset=utf8mb4";
			try
			{
				self::$conexao = new PDO($parametros, "root", "");
			}
			catch(PDOException $e)
			{
				//echo $e->getCode();
				//echo $e->getMessage();
				echo "Problema na conexão";
				die();
			}
		}//fim do if
		return self::$conexao;
	}//fim do método
}
?>