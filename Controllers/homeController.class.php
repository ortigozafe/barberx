<?php
class homeController
{
    private $param;

    public function __construct()
    {
        $this->param = Conexao::getInstancia();
    }
	public function home()
	{
		$titulo = "Bem-vindo à BarberX";

		$barbeariaDAO = new BarbeariaDAO($this->param);
		$retorno = $barbeariaDAO->buscar_todas_barbearias();

		require_once "Views/layout/header.php";
		require_once "Views/home.php";
		require_once "Views/layout/footer.php";
	}

	public function logout()
	{
		session_start();
		session_destroy();
		header("Location: /barberx");
		exit;
	}
}
