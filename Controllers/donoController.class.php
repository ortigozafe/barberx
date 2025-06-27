<?php
class DonoController
{
    private $param;

    public function __construct()
    {
        $this->param = Conexao::getInstancia();
    }

    public function cadastrar()
    {
        $titulo = "BarberX - Cadastro de empresário";
        $erro = "";

        if ($_POST) {
            $dao = new DonoDAO($this->param);
            $email = $_POST["email"];
            $telefone = $_POST["telefone"];

            if ($dao->buscar_por_email($email)) {
                $erro = "Este e-mail já está cadastrado em nosso sistema";
            } elseif ($dao->buscar_por_telefone($telefone)) {
                $erro = "Este telefone já está cadastrado em nosso sistema";
            } else {
                $dono = new Dono(
                    nome: $_POST["nome"],
                    telefone: $telefone,
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

    public function perfil()
    {
        $titulo = "BarberX - Meu Perfil";
        $erro = "";

        if (!isset($_SESSION["dono_id"])) {
            header("Location: /barberx/logar_dono");
            exit;
        }

        $dono_id = $_SESSION["dono_id"];

        $donoDAO = new donoDAO($this->param);
        $retornodono = $donoDAO->buscar_dono_por_id($dono_id);

        if (!$retornodono) {
            $erro = "dono não encontrado";
        }

        if ($_POST) {
            $donoAtual = $donoDAO->buscar_dono_por_id($dono_id);

            if (!$donoAtual) {
                $erro = "dono não encontrado.";
            } else {
                $nome = $_POST["nome"];
                $senha = trim($_POST["senha"] ?? "");
                $senhaHash = $senha ? password_hash($senha, PASSWORD_DEFAULT) : $donoAtual->senha;

                $dono = new dono(
                    $dono_id,
                    $nome,
                    $_POST["email"],
                    $_POST["telefone"],
                    $senhaHash,
                );

                $donoDAO->atualizar($dono);
                $_SESSION["dono_nome"] = $nome;

                header("Location: /barberx/perfil_dono");
                exit;
            }
        }

        require_once "Views/layout/header.php";
        require_once "Views/perfil_dono.php";
        require_once "Views/layout/footer.php";
    }

    public function dashboard()
    {
        $titulo = "BarberX - Dashboard";
        $erro = "";

        if (!isset($_SESSION["dono_id"])) {
            header("Location: /barberx/logar_dono");
            exit;
        }

        $dono_id = $_SESSION["dono_id"];

        $dao = new DonoDAO($this->param);
        $dados = $dao->dadosDashboard($dono_id);
        $dados = json_encode($dados);
        //echo $dados;

        require_once "Views/layout/header.php";
        require_once "Views/dashboard.php";
        require_once "Views/layout/footer.php";
    }

    public function dadosgraficobarras()
    {
        if (!isset($_SESSION["dono_id"])) {
            header("Location: /barberx/logar_dono");
            exit;
        }

        $dono_id = $_SESSION["dono_id"];
        $dao = new DonoDAO($this->param);

        $dados = $dao->buscarDadosGraficoBarras($dono_id);

        header('Content-Type: application/json');
        echo json_encode($dados);
    }

    public function dadosgraficopizza()
    {
        if (!isset($_SESSION["dono_id"])) {
            header("Location: /barberx/logar_dono");
            exit;
        }

        $dono_id = $_SESSION["dono_id"];
        $dao = new DonoDAO($this->param);

        $dados = $dao->buscarDadosGraficoPizza($dono_id);

        header('Content-Type: application/json'); 
        echo json_encode($dados);
    }

    public function pdf_dia()
    {
        if (!isset($_SESSION["dono_id"])) {
            header("Location: /barberx/logar_dono");
            exit;
        }

        $dono_id = $_SESSION["dono_id"];
        $dao = new DonoDAO($this->param);

        $dadosPDF = $dao->dadosPDF($dono_id);

        if (count($dadosPDF) > 0) {
            require_once "Views/pdf_dia.php";
        } else {
            echo "<script>alert('Nenhum serviço agendado para hoje.'); location.href='/barberx/dashboard';</script>";
        }
    }
}
