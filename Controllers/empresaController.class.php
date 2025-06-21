<?php
class empresaController
{
    public function index()
    {
        session_start();

        $titulo = "Para Barbearias - Junte-se à Plataforma BarberX";
        require_once "Views/layout/header.php";
        require_once "Views/empresas.php";
        require_once "Views/layout/footer.php";
    }
}
