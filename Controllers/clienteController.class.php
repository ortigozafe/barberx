<?php
class ClienteController
{
    private $param;

    public function __construct()
    {
        $this->param = Conexao::getInstancia();
    }

    public function cadastrar()
    {
        $titulo = "BarberX - Cadastro";
        $erro = "";

        if ($_POST) {
            $dao = new ClienteDAO($this->param);
            $email = $_POST["email"];
            $telefone = $_POST["telefone"];

            if ($dao->buscar_por_email($email)) {
                $erro = "Este e-mail já está cadastrado em nosso sistema";
            } elseif ($dao->buscar_por_telefone($telefone)) {
                $erro = "Este telefone já está cadastrado em nosso sistema";
            } else {
                $cliente = new Cliente(
                    nome: $_POST["nome"],
                    telefone: $telefone,
                    email: $email,
                    senha: password_hash($_POST["senha"], PASSWORD_DEFAULT)
                );

                $dao->salvar($cliente);

                header("Location: /barberx");
                exit;
            }
        }

        require_once "Views/layout/header.php";
        require_once "Views/form_cliente.php";
        require_once "Views/layout/footer.php";
    }

    public function logar()
    {
        $titulo = "BarberX - Login";
        $erro = "";

        if ($_POST) {
            $email = $_POST["email"] ?? '';
            $senha = $_POST["senha"] ?? '';
            $dao = new ClienteDAO($this->param);

            $cliente = $dao->buscar_por_email($email);

            if (!$cliente || !password_verify($senha, $cliente->senha)) {
                $erro = "E-mail ou senha inválidos";
            } else {
                session_start();
                $_SESSION["cliente_id"] = $cliente->id;
                $_SESSION["cliente_nome"] = $cliente->nome;

                header("Location: /barberx");
                exit;
            }
        }

        require_once "Views/layout/header.php";
        require_once "Views/login_cliente.php";
        require_once "Views/layout/footer.php";
    }

    public function perfil()
    {
        $titulo = "BarberX - Meu Perfil";
        $erro = "";

        if (!isset($_SESSION["cliente_id"])) {
            header("Location: /barberx/logar_cliente");
            exit;
        }

        $cliente_id = $_SESSION["cliente_id"];

        $clienteDAO = new ClienteDAO($this->param);
        $retornoCliente = $clienteDAO->buscar_cliente_por_id($cliente_id);

        if (!$retornoCliente) {
            $erro = "Cliente não encontrado";
        }

        if ($_POST) {
            $clienteAtual = $clienteDAO->buscar_cliente_por_id($cliente_id);

            if (!$clienteAtual) {
                $erro = "Cliente não encontrado.";
            } else {
                $nome = $_POST["nome"];
                $senha = trim($_POST["senha"] ?? "");
                $senhaHash = $senha ? password_hash($senha, PASSWORD_DEFAULT) : $clienteAtual->senha;

                $cliente = new Cliente(
                    $cliente_id,
                    $nome,
                    $_POST["email"],
                    $_POST["telefone"],
                    $senhaHash,
                );

                $clienteDAO->atualizar($cliente);
                $_SESSION["cliente_nome"] = $nome;

                header("Location: /barberx/perfil_cliente");
                exit;
            }
        }

        require_once "Views/layout/header.php";
        require_once "Views/perfil_cliente.php";
        require_once "Views/layout/footer.php";
    }

}
