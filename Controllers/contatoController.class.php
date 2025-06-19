<?php
class contatoController
{
    public function formulario()
    {
        $titulo = "Fale Conosco";
        $mensagem = "";

        if (isset($_GET["enviado"]) && $_GET["enviado"] === "1") {
            $mensagem = "Sua mensagem foi enviada com sucesso!";
        }

        require_once "Views/layout/header.php";
        require_once "Views/contato.php";
        require_once "Views/layout/footer.php";
    }

    public function enviar()
    {
        if ($_POST) {
            // Aqui você poderia enviar e-mail, salvar no banco, etc.
            // Simulação de envio bem-sucedido:
            header("Location: /barberx/contato?enviado=1");
            exit;
        } else {
            echo "Envio inválido.";
        }
    }
}
