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

    public function minhasBarbearias()
    {
        if (!isset($_SESSION['dono_id'])) {
            header("Location: /barberx/login_dono");
            exit;
        }

        $dono_id = $_SESSION['dono_id'];
        $barbeariaDAO = new BarbeariaDAO($this->param);

        $retorno = $barbeariaDAO->buscar_barbearias_completas_por_dono($dono_id);

        $titulo = "BarberX - Minhas Barbearias";

        require_once "Views/layout/header.php";
        require_once "Views/barbearias_dono.php";
        require_once "Views/layout/footer.php";
    }

    public function cadastrarBarbearia()
    {
        $titulo = "BarberX - Cadastro de barbearia";
        $msg = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $dono = new Dono($_POST['dono_id']);

            $barbearia = new Barbearia(
                0,
                $_POST["nome"],
                $_POST["cnpj"],
                $_POST["telefone"],
                $_POST["email"],
                $_POST["endereco"],
                $dono
            );

            $barbeariaDAO = new BarbeariaDAO($this->param);
            $barbearia_id = $barbeariaDAO->inserir_barbearia($barbearia);
            $barbearia->setId($barbearia_id);

            // inserir horarios
            if (!empty($_POST['dias_abertos'])) {
                $horarioDAO = new HorarioFuncionamentoDAO($this->param);

                foreach ($_POST['dias_abertos'] as $dia => $dados) {
                    if (isset($dados['ativo'])) {
                        $horario = new HorarioFuncionamento(
                            0,
                            $barbearia,
                            $dia,
                            $dados['abertura'],
                            $dados['fechamento']
                        );
                        $horarioDAO->inserirHorario($horario);
                    }
                }
            }

            // inserir profissionais
            if (!empty($_POST['profissionais'])) {
                $profissionalDAO = new ProfissionalDAO($this->param);
                foreach ($_POST['profissionais'] as $prof) {
                    $profissional = new Profissional(
                        0,
                        $prof['nome'],
                        $prof['telefone'],
                        $prof['email'],
                        $barbearia
                    );
                    $profissionalDAO->inserirProfissional($profissional);
                }
            }

            // inserir servicos
            if (!empty($_POST['servicos'])) {
                $servicoDAO = new ServicoDAO($this->param);
                foreach ($_POST['servicos'] as $serv) {
                    $servico = new Servico(
                        0,
                        $serv['nome'],
                        $serv['descricao'],
                        $serv['preco'],
                        $serv['duracao_minutos'],
                        $barbearia
                    );
                    $servicoDAO->inserirServico($servico);
                }
            }

            header("Location: /barberx/barbearias_dono");
            exit;
        }

        require_once "Views/layout/header.php";
        require_once "Views/form_barbearia.php";
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

        $barbearias = $dao->buscar_barbearias_por_dono($dono_id);

        require_once "Views/layout/header.php";
        require_once "Views/dashboard.php";
        require_once "Views/layout/footer.php";
    }

    public function agendaDono()
    {
        if (!isset($_SESSION['dono_id'])) {
            header("Location: /barberx/logar_dono"); // ou onde for a página de login do dono
            exit;
        }

        $dono_id = $_SESSION['dono_id'];

        $barbeariaDAO = new BarbeariaDAO($this->param);
        $barbearias = $barbeariaDAO->buscar_barbearias_por_dono($dono_id);

        $agendamentoDAO = new AgendamentoDAO($this->param);

        $agora = time();

        foreach ($barbearias as $barbearia) {
            // Pega agendamentos da barbearia
            $agendamentos = $agendamentoDAO->listarPorBarbearia($barbearia->id);

            foreach ($agendamentos as $ag) {
                $agDataHora = strtotime($ag->data_hora);
                if ($agDataHora < $agora && $ag->status != 'cancelado' && $ag->status != 'concluido') {
                    $agendamentoDAO->atualizar_status_por_id($ag->id, 'concluido');
                    $ag->status = 'concluido';
                }
            }

            // Você pode salvar os agendamentos atualizados para exibir na view se quiser
            $barbearia->agendamentos = $agendamentos;
        }

        require_once "Views/layout/header.php";
        require_once "Views/agenda_dono.php";
        require_once "Views/layout/footer.php";
    }


    public function apiAgendamentosBarbearia()
    {
        $barbearia_id = $_GET['barbearia_id'] ?? null;

        $agendamentoDAO = new AgendamentoDAO($this->param);
        $dados = $agendamentoDAO->buscar_agendamentos_por_barbearia($barbearia_id);

        echo json_encode($dados);
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

    public function editarBarbearia()
    {
        $titulo = "Editar Barbearia";

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION["dono_id"])) {
            header("Location: /barberx/logar_dono");
            exit;
        }

        $barbearia_id = $_GET["id"] ?? null;

        $barbeariaDAO = new BarbeariaDAO($this->param);
        $barbeariaAtual = $barbeariaDAO->buscar_uma_barbearia($barbearia_id);

        if (!$barbeariaAtual) {
            echo "<script>alert('Barbearia não encontrada.'); location.href='/barberx/barbearias_dono';</script>";
            exit;
        }

        if ($_POST) {
            $nome = $_POST["nome"];
            $cnpj = $_POST["cnpj"];
            $telefone = $_POST["telefone"];
            $email = $_POST["email"];
            $endereco = $_POST["endereco"];

            $barbeariaAtual->setNome($nome);
            $barbeariaAtual->setCnpj($cnpj);
            $barbeariaAtual->setTelefone($telefone);
            $barbeariaAtual->setEmail($email);
            $barbeariaAtual->setEndereco($endereco);

            $barbeariaDAO->atualizar_barbearia($barbeariaAtual);

            header("Location: /barberx/barbearias_dono");
            exit;
        }

        require_once "Views/layout/header.php";
        require_once "Views/editar_barbearia.php";
        require_once "Views/layout/footer.php";
    }

    public function excluirBarbearia()
    {
        if (!isset($_SESSION["dono_id"])) {
            header("Location: /barberx/logar_dono");
            exit;
        }

        $id = $_GET["id"] ?? null;

        if ($id) {
            $barbeariaDAO = new BarbeariaDAO($this->param);
            $barbeariaDAO->excluir_barbearia($id);
        }

        header("Location: /barberx/barbearias_dono");
        exit;
    }
}
