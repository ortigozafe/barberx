<?php
class contatoController
{
    public function formulario()
    {
        $titulo = "Fale Conosco";
        $mensagem = "";

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $mensagem = "Sua mensagem foi enviada com sucesso!";
        } elseif (isset($_GET["enviado"]) && $_GET["enviado"] === "1") {
            $mensagem = "Sua mensagem foi enviada com sucesso!";
        }

        require_once "Views/layout/header.php";
        require_once "Views/contato.php";
        require_once "Views/layout/footer.php";
    }
}
