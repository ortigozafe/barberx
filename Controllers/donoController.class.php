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
        $erro = "";

        if ($_POST) {
            $dao = new DonoDAO($this->param);
            $email = $_POST["email"];

            if ($dao->buscar_por_email($email)) {
                $erro = "Este e-mail já está cadastrado em nosso sistema";
            } else {
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
        }

        require_once "Views/layout/header.php";
        require_once "Views/form_dono.php";
        require_once "Views/layout/footer.php";
    }

    public function logar()
    {
        session_start();
        $titulo = "Login Dono";
        $erro = "";

        if ($_POST) {
            $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
            $senha = filter_input(INPUT_POST, "senha", FILTER_DEFAULT);

            if (!$email || !$senha) {
                $erro = "Email ou senha inválidos.";
            } else {
                $dao = new DonoDAO($this->param);
                $dono = $dao->buscar_por_email($email);

                if (!$dono) {
                    $erro = "Usuário não encontrado.";
                } elseif (!password_verify($senha, $dono->getSenha())) {
                    $erro = "Senha incorreta.";
                } else {
                    $_SESSION['dono_id'] = $dono->getId();
                    $_SESSION['dono_nome'] = $dono->getNome();

                    header("Location: /barbearias");
                    exit;
                }
            }
        }

        require_once "Views/layout/header.php";
        require_once "Views/login_dono.php";
        require_once "Views/layout/footer.php";
    }

    public function buscar_por_email()
    {
        $email = $_POST["email"] ?? '';
        $dao = new DonoDAO($this->param);
        $dono = $dao->buscar_por_email($email);

        echo json_encode($dono);
    }
}
