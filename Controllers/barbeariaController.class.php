<?php
class barbeariaController
{
    private $param;

    public function __construct()
    {
        $this->param = Conexao::getInstancia();
    }

    public function listar()
    {
        $barbeariaDAO = new BarbeariaDAO($this->param);
        $retorno = $barbeariaDAO->buscar_todas_barbearias();

        $titulo = "BarberX - Barbearias";

        require_once "Views/layout/header.php";
        require_once "Views/barbearias.php";
        require_once "Views/layout/footer.php";
    }

    public function detalhar()
    {
        if (!isset($_GET['id'])) {
            echo "ID da barbearia não informado.";
            exit;
        }

        $barbearia_id = $_GET['id'];
        $barbeariaDAO = new BarbeariaDAO($this->param);
        $retornoBarbearia = $barbeariaDAO->buscar_uma_barbearia($barbearia_id);

        $servicoDAO = new ServicoDAO($this->param);
        $retornoServico = $servicoDAO->buscar_servicos_por_barbearia($barbearia_id);

        $profissionalDAO = new ProfissionalDAO($this->param);
        $retornoProfissional = $profissionalDAO->buscar_profissionais_por_barbearia($barbearia_id);

        $horarioDAO = new HorarioFuncionamentoDAO($this->param);
        $retornoHorario = $horarioDAO->listarPorBarbearia($barbearia_id);

        $titulo = "BarberX - {$retornoBarbearia->nome}";

        require_once "Views/layout/header.php";
        require_once "Views/visualizar_barbearia.php";
        require_once "Views/layout/footer.php";
    }

    public function rota()
    {
        $barbeariaDAO = new BarbeariaDAO($this->param);

        $idBarbearia = $_GET['id'] ?? null;

        if ($idBarbearia) {
            $barbearia = $barbeariaDAO->buscar_uma_barbearia($idBarbearia);
            if ($barbearia) {
                $enderecoDestino = $barbearia->endereco . ', Brasil';
            } else {
                $enderecoDestino = 'Endereço padrão, Brasil';
            }
        } else {
            $enderecoDestino = 'Endereço padrão, Brasil';
        }

        $titulo = "BarberX - Rota até Barbearia";
        $enderecoDestinoJSON = json_encode($enderecoDestino);

        $nomeBarbearia = $barbearia->nome ?? 'Barbearia';

        require_once "Views/layout/header.php";
        require_once "Views/mostrar_rota.php";
        require_once "Views/layout/footer.php";
    }
}
