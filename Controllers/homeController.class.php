<?php

class homeController
{
	public function home()
	{
		session_start();
		$titulo = "Bem-vindo à BarberX";

		$usuario = null;
		if (isset($_SESSION['usuario'])) {
			$usuario = $_SESSION['usuario'];
		}

		require_once "Views/layout/header.php";
		require_once "Views/home.php";
		require_once "Views/layout/footer.php";
	}
}
