<?php
require_once "Models/Conexao.class.php";
require_once "Models/Dono.class.php";
require_once "Models/DonoDAO.class.php";

class DonoController
{
    private $param;

    public function __construct()
    {
        $this->param = Conexao::getInstancia();
    }

    public function cadastrar()
    {
        $titulo = "Cadastro de Dono";
        require_once "Views/layout/header.php";
        require_once "Views/form_dono.php";
        require_once "Views/layout/footer.php";
    }

    public function salvar()
    {
        $dao = new DonoDAO($this->param);
        $email = $_POST["email"];

        if ($dao->buscar_por_email($email)) {
            $titulo = "Cadastro de Dono";
            $erro = "Este e-mail já está cadastrado em nosso sistema";
            require_once "Views/layout/header.php";
            require_once "Views/form_dono.php";
            require_once "Views/layout/footer.php";
            return;
        }

        $dono = new Dono(
            nome: $_POST["nome"],
            telefone: $_POST["telefone"],
            email: $email,
            senha: password_hash($_POST["senha"], PASSWORD_DEFAULT)
        );

        $dao->salvar($dono);

        header("Location: /barberx");
        exit;
    }


    public function buscar_por_email()
    {
        $email = $_POST["email"] ?? '';
        $dao = new DonoDAO($this->param);
        $dono = $dao->buscar_por_email($email);

        echo json_encode($dono);
    }
}
