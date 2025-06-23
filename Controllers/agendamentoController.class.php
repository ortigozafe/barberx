<?php
class agendamentoController
{
    private $param;

    public function __construct()
    {
        $this->param = Conexao::getInstancia();
    }

    public function agendar()
    {
        $titulo = "Novo Agendamento";
        $erro = "";
        $editar = false;
        $agendamento = null;
        $profissionais = [];
        $servicos = [];
        $barbearia_id = 0;

        $agendamentoDAO = new AgendamentoDAO($this->param);

        // Se for POST, processa o agendamento
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION["cliente_id"])) {
            $id = isset($_POST["id"]) ? intval($_POST["id"]) : 0;

            $ag = new Agendamento(
                $id,
                $_SESSION["cliente_id"],
                $_POST["profissional_id"],
                $_POST["servico_id"],
                $_POST["data_hora"],
                "agendado",
                $_POST["observacoes"]
            );

            if ($id > 0) {
                $agendamentoDAO->atualizar_agendamento($ag);
            } else {
                $agendamentoDAO->inserir_agendamento($ag);
            }

            header("Location: /barberx/agenda");
            exit;
        }

        // Se for GET para editar ou novo
        if (isset($_GET['editar']) && $_GET['editar'] == 1) {
            $editar = true;
            $id = intval($_GET['id']);
            $agendamento = $agendamentoDAO->buscar_por_id($id);

            if (!$agendamento || $agendamento['cliente_id'] != $_SESSION['cliente_id']) {
                echo "Agendamento inválido.";
                exit;
            }

            $barbearia_id = $agendamento['barbearia_id'];
        } else {
            if (!isset($_GET["id"])) {
                echo "ID da barbearia não informado!";
                exit;
            }

            $barbearia_id = intval($_GET["id"]);
        }

        $profissionais = $agendamentoDAO->buscar_profissionais_por_barbearia($barbearia_id);
        $servicos = $agendamentoDAO->buscar_servicos_por_barbearia($barbearia_id);

        $titulo = $editar ? "Editar Agendamento" : "Novo Agendamento";

        require_once "Views/layout/header.php";
        require_once "Views/form_agendamento.php";
        require_once "Views/layout/footer.php";
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
