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
        $msg = "";
        require_once "Views/form_barbearia.php";
    }

    public function salvar()
    {
        if ($_POST) {
            $barbearia = new Barbearia(
                0,
                $_POST["nome"],
                $_POST["cnpj"],
                $_POST["telefone"],
                $_POST["email"],
                $_POST["endereco"],
                $_POST["dono_id"] // ou $_SESSION['dono_id']
            );

            $barbeariaDAO = new BarbeariaDAO($this->param);
            $barbeariaDAO->inserir_barbearia($barbearia);

            header("Location: /barberx/barbearias");
            exit;
        }
    }

    public function detalhar()
    {
        if (!isset($_GET['id'])) {
            echo "ID da barbearia não informado.";
            exit;
        }

        $id = intval($_GET['id']);
        $barbeariaDAO = new BarbeariaDAO($this->param);
        $dadosBarbearia = $barbeariaDAO->buscar_por_id($id);
        $servicos = $barbeariaDAO->buscar_servicos($id);
        $profissionais = $barbeariaDAO->buscar_profissionais($id);

        $titulo = "Visualizar Barbearia";

        require_once "Views/layout/header.php";
        require_once "Views/visualizar_barbearia.php";
        require_once "Views/layout/footer.php";
    }


}
?>
