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

        $titulo = "Barbearias";

        require_once "Views/layout/header.php";
        require_once "Views/barbearias.php";
        require_once "Views/layout/footer.php";
    }

    public function cadastrar()
    {
        $titulo = "Cadastro de Barbearia";
        $msg = "";

        // instanciar o dono

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
            $barbeariaDAO->inserir_barbearia($barbearia);

            header("Location: /barberx/barbearias");
            exit;
        }

        require_once "Views/layout/header.php";
        require_once "Views/form_barbearia.php";
        require_once "Views/layout/footer.php";
    }

    public function detalhar()
    {
        if (!isset($_GET['id'])) {
            echo "ID da barbearia não informado.";
            exit;
        }

        $barbearia_id = new Barbearia($_GET['id']);
        $barbeariaDAO = new BarbeariaDAO($this->param);
        $retornoBarbearia = $barbeariaDAO->buscar_uma_barbearia($barbearia_id);

        $servicoDAO = new ServicoDAO($this->param);
        $retornoServico = $servicoDAO->buscar_um_servico($barbearia_id);

        $profissionalDAO = new ProfissionalDAO($this->param);
        $retornoProfissional = $profissionalDAO->buscar_profissionais_por_barbearia($barbearia_id);
        
var_dump($retornoProfissional);
die();

        $titulo = "BarberX - {$retornoBarbearia->nome}";

        require_once "Views/layout/header.php";
        require_once "Views/visualizar_barbearia.php";
        require_once "Views/layout/footer.php";
    }
}
