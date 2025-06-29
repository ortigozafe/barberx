<?php
class agendamentoController
{
    private $param;

    public function __construct()
    {
        $this->param = Conexao::getInstancia();
    }

    public function agenda()
    {
        if (!isset($_SESSION["cliente_id"])) {
            header("Location: /barberx/logar_cliente");
            exit;
        }

        $cliente_id = $_SESSION["cliente_id"];
        $agendamentoDAO = new AgendamentoDAO($this->param);
        $todos = $agendamentoDAO->buscar_agendamentos_cliente($cliente_id);

        $futuros = [];
        $passados = [];
        $agora = date("Y-m-d H:i:s");

        foreach ($todos as $a) {
            if ($a["data_hora"] > $agora && $a["status"] === "agendado") {
                $futuros[] = $a;
            } else {
                $passados[] = $a;
            }
        }

        $titulo = "Minha Agenda";

        require_once "Views/layout/header.php";
        require_once "Views/agenda_cliente.php";
        require_once "Views/layout/footer.php";
    }


    public function agendar()
    {
        if (!isset($_SESSION["cliente_id"])) {
            header("Location: /barberx/logar_cliente");
            exit;
        }

        $erro = "";

        $barbearia_id = $_GET['id'] ?? $_POST['barbearia_id'] ?? null;
        $barbeariaDAO = new BarbeariaDAO($this->param);
        $retornoBarbearia = $barbeariaDAO->buscar_uma_barbearia($barbearia_id);

        //var_dump($barbearia_id);


        $servicoDAO = new ServicoDAO($this->param);
        $retornoServico = $servicoDAO->buscar_servicos_por_barbearia($barbearia_id);

        $profissionalDAO = new ProfissionalDAO($this->param);
        $retornoProfissional = $profissionalDAO->buscar_profissionais_por_barbearia($barbearia_id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cliente = new Cliente($_SESSION['cliente_id']);
            $profissional = new Profissional($_POST['profissional_id']);
            $servico = new Servico($_POST['servico_id']);
            $barbearia = new Barbearia($barbearia_id);

            $agendamento = new Agendamento(
                0,
                $cliente,
                $profissional,
                $servico,
                $barbearia,
                $_POST["data_hora"],
                "agendado",
                $_POST["observacoes"]
            );

            $agendamentoDAO = new AgendamentoDAO($this->param);
            $agendamentoDAO->inserir_agendamento($agendamento);

            $titulo = "BarberX - {$retornoBarbearia->nome}";

            header("Location: /barberx/agenda");
            exit;
        }

        require_once "Views/layout/header.php";
        require_once "Views/form_agendamento.php";
        require_once "Views/layout/footer.php";
    }

    public function alterarAgendamento()
    {
        if (!isset($_SESSION["cliente_id"])) {
            header("Location: /barberx/logar_cliente");
            exit;
        }

        if (!isset($_GET["id"])) {
            echo "ID do agendamento não informado.";
            exit;
        }

        $agendamento_id = intval($_GET["id"]);
        $agendamentoDAO = new AgendamentoDAO($this->param);
        $agendamento = $agendamentoDAO->buscar_por_id($agendamento_id);

        if (!$agendamento) {
            echo "Agendamento não encontrado.";
            exit;
        }

        // Objeto Barbearia associado
        $barbearia = $agendamento->getBarbearia();
        $barbearia_id = $barbearia->getId();

        // Dados auxiliares para o formulário
        $profissionalDAO = new ProfissionalDAO($this->param);
        $retornoProfissional = $profissionalDAO->buscar_profissionais_por_barbearia($barbearia_id);

        $servicoDAO = new ServicoDAO($this->param);
        $retornoServico = $servicoDAO->buscar_servicos_por_barbearia($barbearia_id);

        $erro = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (empty($_POST["profissional_id"])) {
                $erro = "Selecione um profissional.";
            } elseif (empty($_POST["servico_id"])) {
                $erro = "Selecione um serviço.";
            } elseif (empty($_POST["data_hora"])) {
                $erro = "Informe a data e hora do agendamento.";
            } else {
                $cliente = $agendamento->getCliente();
                $profissional = new Profissional($_POST['profissional_id']);
                $servico = new Servico($_POST['servico_id']);
                $data_hora = $_POST["data_hora"];
                $observacoes = $_POST["observacoes"];
                $status = $agendamento->getStatus();

                $agendamento_atualizado = new Agendamento(
                    $agendamento_id,
                    $cliente,
                    $profissional,
                    $servico,
                    $barbearia,
                    $data_hora,
                    $status,
                    $observacoes
                );

                $agendamentoDAO->atualizar_agendamento($agendamento_atualizado);

                header("Location: /barberx/agenda");
                exit;
            }
        }

        $titulo = "Editar Agendamento";

        require_once "Views/layout/header.php";
        require_once "Views/form_editar_agendamento.php";
        require_once "Views/layout/footer.php";
    }

    public function cancelar()
    {
        if (!isset($_GET["id"])) {
            echo "ID inválido.";
            return;
        }

        $id = intval($_GET["id"]);

        $agendamentoDAO = new AgendamentoDAO($this->param);
        $agendamentoDAO->cancelar_agendamento($id);

        header("Location: /barberx/agenda");
        exit;
    }


}
