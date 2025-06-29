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

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION["dono_id"])) {
            header("Location: /barberx/logar_dono");
            exit;
        }

        $dono_id = $_SESSION["dono_id"];

        $donoDAO = new DonoDAO($this->param);
        $retornoDono = $donoDAO->buscar_dono_por_id($dono_id);

        if (!$retornoDono) {
            $erro = "Dono não encontrado";
        }

        if ($_POST) {
            $donoAtual = $donoDAO->buscar_dono_por_id($dono_id);

            if (!$donoAtual) {
                $erro = "Dono não encontrado.";
            } else {
                $nome = $_POST["nome"];
                $email = $_POST["email"];
                $telefone = $_POST["telefone"];
                $novaSenha = trim($_POST["senha"] ?? "");
                $senhaHashParaAtualizar = $donoAtual->senha;

                if (!empty($novaSenha)) {
                    $senhaHashParaAtualizar = password_hash($novaSenha, PASSWORD_DEFAULT);
                }

                $donoComEmailExistente = $donoDAO->buscar_por_email($email);
                $donoComTelefoneExistente = $donoDAO->buscar_por_telefone($telefone);

                if ($donoComEmailExistente && $donoComEmailExistente->id != $dono_id) {
                    $erro = "Este e-mail já está cadastrado para outro empresário.";
                } elseif ($donoComTelefoneExistente && $donoComTelefoneExistente->id != $dono_id) {
                    $erro = "Este telefone já está cadastrado para outro empresário.";
                } else {
                    $dono = new Dono(
                        id: $dono_id,
                        nome: $nome,
                        email: $email,
                        telefone: $telefone,
                        senha: $senhaHashParaAtualizar
                    );

                    $donoDAO->atualizar($dono);
                    $_SESSION["dono_nome"] = $nome;

                    header("Location: /barberx/perfil_dono");
                    exit;
                }
            }
        }

        require_once "Views/layout/header.php";
        require_once "Views/perfil_dono.php";
        require_once "Views/layout/footer.php";
    }


    public function dashboard()
    {
        $titulo = "BarberX - Dashboard";

        if (!isset($_SESSION["dono_id"])) {
            header("Location: /barberx/logar_dono");
            exit;
        }

        $dono_id = $_SESSION["dono_id"];
        $dao = new DonoDAO($this->param);

        $barbearias = $dao->buscarBarbeariasPorDono($dono_id);

        if (empty($barbearias)) {
            die("Nenhuma barbearia cadastrada.");
        }

        require_once "Views/layout/header.php";
        require "Views/dashboard.php";  
        require_once "Views/layout/footer.php";
    }


    public function apiDadosDashboard()
    {
        if (!isset($_SESSION["dono_id"])) {
            header("Location: /barberx/logar_dono");
            exit;
        }
        $barbearia_id = $_GET["barbearia_id"] ?? null;

        $dao = new DonoDAO($this->param);
        $dados = $dao->dadosDashboard($barbearia_id);

        header("Content-Type: application/json");
        echo json_encode($dados);
    }


    public function apiAgendamentosDia()
    {
        if (!isset($_SESSION["dono_id"])) {
            header("Location: /barberx/logar_dono");
            exit;
        }

        $barbearia_id = $_GET['barbearia_id'] ?? null;

        $dao = new DonoDAO($this->param);
        $agendamentos = $dao->listarAgendamentosDia($barbearia_id);

        header("Content-Type: application/json");
        echo json_encode($agendamentos);
    }

    public function apiClientesMes()
    {
        if (!isset($_SESSION["dono_id"])) {
            header("Location: /barberx/logar_dono");
            exit;
        }

        $barbearia_id = $_GET['barbearia_id'] ?? null;

        $dao = new DonoDAO($this->param);
        $clientes = $dao->listarClientesMes($barbearia_id);

        header("Content-Type: application/json");
        echo json_encode($clientes);
    }

    public function apiServicosRealizados()
    {
        if (!isset($_SESSION["dono_id"])) {
            header("Location: /barberx/logar_dono");
            exit;
        }

        $barbearia_id = $_GET['barbearia_id'] ?? null;

        $dao = new DonoDAO($this->param);
        $servicos = $dao->listarServicosRealizados($barbearia_id);

        header("Content-Type: application/json");
        echo json_encode($servicos);
    }


    public function dadosgraficobarras()
    {
        if (!isset($_SESSION["dono_id"])) {
            header("Location: /barberx/logar_dono");
            exit;
        }

        $barbearia_id = $_GET["barbearia_id"] ?? null;

        if (!$barbearia_id) {
            header('Content-Type: application/json');
            echo json_encode([]);
            return;
        }

        $dao = new DonoDAO($this->param);
        $dados = $dao->buscarDadosGraficoBarras($barbearia_id);

        header('Content-Type: application/json');
        echo json_encode($dados);
    }

    public function dadosgraficopizza()
    {
        if (!isset($_SESSION["dono_id"])) {
            header("Location: /barberx/logar_dono");
            exit;
        }

        $barbearia_id = $_GET['barbearia_id'] ?? null;

        if (!$barbearia_id) {
            echo json_encode([]);
            return;
        }

        $dao = new DonoDAO($this->param);
        $dados = $dao->buscarDadosGraficoPizza($barbearia_id);

        header('Content-Type: application/json');
        echo json_encode($dados);
    }


    public function pdf_dia()
    {
        if (!isset($_SESSION["dono_id"])) {
            header("Location: /barberx/logar_dono");
            exit;
        }

        $barbearia_id = $_POST["barbearia_id"] ?? null;

        if (!$barbearia_id) {
            echo "<script>alert('Selecione a barbearia'); history.back();</script>";
            exit;
        }

        $dao = new DonoDAO($this->param);
        $dadosPDF = $dao->dadosPDF($barbearia_id);

        if ($dadosPDF) {
            require_once "Views/pdf_dia.php";
        } else {
            echo "<script>alert('Nenhum serviço hoje.'); location.href='/barberx/dashboard';</script>";
        }
    }
}
