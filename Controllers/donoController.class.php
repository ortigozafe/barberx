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
        var_dump($_SESSION);
        $titulo = "Login Dono";
        $erro = "";

        if ($_POST) {
            $email = $_POST["email"] ?? '';
            $senha = $_POST["senha"] ?? '';
            $dao = new DonoDAO($this->param);

            $dono = $dao->buscar_por_email($email);

            if (!$dono || !password_verify($senha, $dono->senha)) {
                $erro = "E-mail ou senha inválidos";
            } else {
                session_start();
                $_SESSION["dono_id"] = $dono->id;
                $_SESSION["dono_nome"] = $dono->nome;

                header("Location: /barberx/dashboard");
                exit;
            }
        }

        require_once "Views/layout/header.php";
        require_once "Views/login_dono.php";
        require_once "Views/layout/footer.php";
    }

    
}
