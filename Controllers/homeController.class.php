<?php

	class homeController
	{
		public function home()
	{
		$titulo = "Bem-vindo à BarberX";
		require_once "Views/layout/header.php";
		require_once "Views/home.php";
		require_once "Views/layout/footer.php";
	}

	}
?>