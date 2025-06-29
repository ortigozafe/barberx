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

        $titulo = "Minha Agenda";

        require_once "Views/layout/header.php";
        require_once "Views/agenda_cliente.php";
        require_once "Views/layout/footer.php";
    }

    private function calcularHorariosProfissionais($horarioDia, $profissionais, $agendamentosDia, $servicos, $data)
    {
        $intervalo = 30; // minutos
        $horaInicio = strtotime($data . ' ' . $horarioDia->horario_abertura);
        $horaFim    = strtotime($data . ' ' . $horarioDia->horario_fechamento);

        // var_dump($horarioDia);
        //  exit;


        $horarios = [];

        while ($horaInicio + ($intervalo * 60) <= $horaFim) {
            $profissionaisLivres = [];

            foreach ($profissionais as $prof) {
                $ocupado = false;

                foreach ($agendamentosDia as $ag) {
                    if ($ag->profissional_id != $prof->id) continue;

                    $servico = array_filter($servicos, fn($s) => $s->id == $ag->servico_id);
                    $duracao = !empty($servico) ? array_values($servico)[0]->duracao_minutos : 30;

                    $ag_inicio = strtotime($ag->data_hora);
                    $ag_fim    = $ag_inicio + ($duracao * 60);

                    if ($horaInicio >= $ag_inicio && $horaInicio < $ag_fim) {
                        $ocupado = true;
                        break;
                    }
                }

                if (!$ocupado) {
                    $profissionaisLivres[] = $prof->id;
                }
            }

            if (!empty($profissionaisLivres)) {
                $horarios[] = [
                    'horario' => date('H:i', $horaInicio),
                    'profissionais' => $profissionaisLivres
                ];
            }

            $horaInicio += ($intervalo * 60);
        }

        return $horarios;
    }

    private function filtrarProfissionaisDisponiveis($profissionais, $agendamentosDia, $horaEscolhida, $servicos)
    {
        $profDisponiveis = [];

        foreach ($profissionais as $prof) {
            $ocupado = false;

            foreach ($agendamentosDia as $ag) {
                if ($ag->profissional_id != $prof->id) continue;

                $servico = array_filter($servicos, fn($s) => $s->id == $ag->servico_id);
                $duracao = !empty($servico) ? array_values($servico)[0]->duracao_minutos : 30;

                $ag_inicio = strtotime($ag->data_hora);
                $ag_fim    = $ag_inicio + ($duracao * 60);

                $horaEscolhidaTS = strtotime($horaEscolhida);

                if ($horaEscolhidaTS >= $ag_inicio && $horaEscolhidaTS < $ag_fim) {
                    $ocupado = true;
                    break;
                }
            }

            if (!$ocupado) {
                $profDisponiveis[] = $prof;
            }
        }
        return $profDisponiveis;
    }

    public function buscarHorarios()
    {
        $data = $_POST['data'];
        $barbearia_id = $_POST['barbearia_id'];

        $diaSemana = strtolower(date('l', strtotime($data)));
        $mapaDias = [
            'sunday'    => 'domingo',
            'monday'    => 'segunda',
            'tuesday'   => 'terca',
            'wednesday' => 'quarta',
            'thursday'  => 'quinta',
            'friday'    => 'sexta',
            'saturday'  => 'sabado'
        ];
        $diaSemanaBanco = $mapaDias[$diaSemana];

        $horarioDAO = new HorarioFuncionamentoDAO($this->param);
        $horarioDia = $horarioDAO->buscarPorDia($barbearia_id, $diaSemanaBanco);

        $agendamentoDAO = new AgendamentoDAO($this->param);
        $agendamentosDia = $agendamentoDAO->listarPorDia($barbearia_id, $data);

        $profissionalDAO = new ProfissionalDAO($this->param);
        $profissionais = $profissionalDAO->buscar_profissionais_por_barbearia($barbearia_id);

        $servicoDAO = new ServicoDAO($this->param);
        $servicos = $servicoDAO->buscar_servicos_por_barbearia($barbearia_id);

        $horarios = $this->calcularHorariosProfissionais($horarioDia, $profissionais, $agendamentosDia, $servicos, $data);

        // retorna JSON
        $resposta = [];
        foreach ($horarios as $h) {
            $resposta[] = [
                'horario' => $h['horario'],
                'full' => $data . ' ' . $h['horario']
            ];
        }
        header("Content-Type: application/json");
        echo json_encode($resposta);
    }

    public function buscarProfissionais()
    {
        $data = $_POST['data'];
        $hora = $_POST['hora'];
        $barbearia_id = $_POST['barbearia_id'];

        $agendamentoDAO = new AgendamentoDAO($this->param);
        $agendamentosDia = $agendamentoDAO->listarPorDia($barbearia_id, $data);

        $profissionalDAO = new ProfissionalDAO($this->param);
        $profissionais = $profissionalDAO->buscar_profissionais_por_barbearia($barbearia_id);

        $servicoDAO = new ServicoDAO($this->param);
        $servicos = $servicoDAO->buscar_servicos_por_barbearia($barbearia_id);

        $profDisponiveis = $this->filtrarProfissionaisDisponiveis($profissionais, $agendamentosDia, $hora, $servicos);

        $resposta = [];
        foreach ($profDisponiveis as $p) {
            $resposta[] = [
                'id' => $p->id,
                'nome' => $p->nome
            ];
        }
        header("Content-Type: application/json");
        echo json_encode($resposta);
    }

    public function agendar()
    {
        // Verifica se o ID da barbearia foi passado
        if (!isset($_GET['id'])) {
            echo "Barbearia não informada.";
            exit;
        }

        $barbearia_id = $_GET['id'];

        // Instancia os DAOs
        $barbeariaDAO = new BarbeariaDAO($this->param);
        $servicoDAO = new ServicoDAO($this->param);
        $profissionalDAO = new ProfissionalDAO($this->param);
        $clienteDAO = new ClienteDAO($this->param);

        // Busca dados da barbearia e valida existência
        $barbeariaData = $barbeariaDAO->buscar_uma_barbearia($barbearia_id);
        if (!$barbeariaData) {
            echo "Barbearia não encontrada.";
            exit;
        }

        // Busca os serviços e profissionais da barbearia (para o formulário)
        $retornoServico = $servicoDAO->buscar_servicos_por_barbearia($barbearia_id);
        $retornoProfissional = $profissionalDAO->buscar_profissionais_por_barbearia($barbearia_id);

        $titulo = "BarberX - Agendar";

        // Arrays para preencher selects dinamicamente se precisar
        $horariosDisponiveis = [];
        $profissionaisDisponiveis = [];

        // Se for POST, trata o envio do formulário
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['data'])) {

            // Captura dados do form
            $dataHora = $_POST['hora'] ?? null;
            $profissional_id = $_POST['profissional_id'] ?? null;
            $servico_id = $_POST['servico_id'] ?? null;
            $observacoes = $_POST['observacoes'] ?? '';

            // Valida dados obrigatórios
            if (!$dataHora || !$profissional_id || !$servico_id) {
                echo "Por favor, preencha todos os campos obrigatórios.";
                exit;
            }

            // Verifica cliente logado
            $cliente_id = $_SESSION["cliente_id"] ?? null;
            if (!$cliente_id) {
                echo "Cliente não logado.";
                exit;
            }

            // Busca dados no banco
            $clienteData = $clienteDAO->buscar_cliente_por_id($cliente_id);
            $profissionalData = $profissionalDAO->buscar_um_profissional($profissional_id);
            $servicoData = $servicoDAO->buscar_um_servico($servico_id);

            // Valida existência dos dados
            if (!$clienteData) {
                echo "Cliente não encontrado.";
                exit;
            }
            if (!$profissionalData) {
                echo "Profissional não encontrado.";
                exit;
            }
            if (!$servicoData) {
                echo "Serviço não encontrado.";
                exit;
            }

            // Cria objetos mantendo orientação a objetos
            $cliente = new Cliente($clienteData->id);
            $profissional = new Profissional($profissionalData->id);
            $servico = new Servico($servicoData->id);
            $barbearia = new Barbearia($barbeariaData->id);

            // Cria o objeto agendamento
            $agendamento = new Agendamento(
                0,
                $cliente,
                $profissional,
                $servico,
                $barbearia,
                $dataHora,
                "pendente",
                $observacoes
            );

            // Insere no banco
            $agendamentoDAO = new AgendamentoDAO($this->param);
            $agendamentoDAO->inserir_agendamento($agendamento);

            // Redireciona com sucesso
            header("Location: /barberx/agenda?sucesso=1");
            exit;
        }

        // Inclui views
        require_once "Views/layout/header.php";
        require_once "Views/form_agendamento.php";
        require_once "Views/layout/footer.php";
    }

    /*public function alterarAgendamento()
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
    }*/

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
