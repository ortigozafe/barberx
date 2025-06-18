<?php
require_once "Models/Conexao.class.php";
require_once "Models/Dono.class.php";
require_once "Models/DonoDAO.class.php";

class LoginController
{
    private $param;

    public function __construct()
    {
        $this->param = Conexao::getInstancia();
    }

    // Exibe o formulário de login do dono
    public function logar()
    {
        session_start();
        $titulo = "Login Dono";
        $erro = $_SESSION['erro'] ?? null;
        unset($_SESSION['erro']);
        
        require_once "Views/layout/header.php";
        require_once "Views/login_dono.php";
        require_once "Views/layout/footer.php";
    }

    // Processa o login do dono
    public function login()
    {
        session_start();

        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        $senha = filter_input(INPUT_POST, "senha", FILTER_DEFAULT);

        if (!$email || !$senha) {
            $_SESSION['erro'] = "E-mail ou senha inválidos.";
            header("Location: /logar_dono");
            exit;
        }

        $dao = new DonoDAO($this->param);
        $dono = $dao->buscar_por_email($email);

        if (!$dono) {
            $_SESSION['erro'] = "Usuário não encontrado.";
            header("Location: /logar_dono");
            exit;
        }

        if (!password_verify($senha, $dono->getSenha())) {
            $_SESSION['erro'] = "Senha incorreta.";
            header("Location: /logar_dono");
            exit;
        }

        // Login OK: armazena dados na sessão
        $_SESSION['dono_id'] = $dono->getId();
        $_SESSION['dono_nome'] = $dono->getNome();

        header("Location: /barbearias");
        exit;
    }

    // Para deslogar o dono
    public function logout()
    {
        session_start();
        session_destroy();
        header("Location: /logar_dono");
        exit;
    }
}
