<?php
class contatoController
{
    public function formulario()
    {
        $titulo = "Fale Conosco";

        require_once "Views/layout/header.php";
        require_once "Views/contato.php";
        require_once "Views/layout/footer.php";
    }
}
