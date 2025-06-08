<?php
require_once "Models/Conexao.class.php";
require_once "Models/Cliente.class.php";
require_once "Models/ClienteDAO.class.php";

class ClienteController
{
    private $param;

    public function __construct()
    {
        $this->param = Conexao::getInstancia();
    }

    public function cadastrar()
    {
        $titulo = "Cadastro de Cliente";
        require_once "Views/layout/header.php";
        require_once "Views/form_cliente.php";
        require_once "Views/layout/footer.php";
    }

    public function salvar()
    {
        $dao = new ClienteDAO($this->param);
        $email = $_POST["email"];

        if ($dao->buscar_por_email($email)) {
            $titulo = "Cadastro de Cliente";
            $erro = "Este e-mail já está cadastrado em nosso sistema";
            require_once "Views/layout/header.php";
            require_once "Views/form_cliente.php";
            require_once "Views/layout/footer.php";
            return;
        }

        $cliente = new Cliente(
            nome: $_POST["nome"],
            telefone: $_POST["telefone"],
            email: $email,
            senha: password_hash($_POST["senha"], PASSWORD_DEFAULT)
        );

        $dao->salvar($cliente);

        header("Location: /barberx");
        exit;
    }


    public function buscar_por_email()
    {
        $dao = new ClienteDAO($this->param);
        $email = $_POST["email"] ?? '';
        $cliente = $dao->buscar_por_email($email);

        echo json_encode($cliente);
    }

    
}
