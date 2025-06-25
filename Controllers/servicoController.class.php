<?php
class servicoController
{
    private $param;

    public function __construct()
    {
        $this->param = Conexao::getInstancia();
    }


    public function listar_servicos_por_barbearia()
    {
        $servicoDAO = new ServicoDAO($this->param);
        $retornoServico = $servicoDAO->buscar_servicos_por_barbearia();

    }


    public function cadastrarServico()
    {
        $titulo = "Cadastro de Serviço";
        $msg = "";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $barbeariaDoServico = new Barbearia($_POST['barbearia_id']);

            $servico = new Servico(
                0, // ID (0 para novo)
                $_POST["nome_servico"],
                $_POST["descricao_servico"],
                (float)$_POST["preco_servico"], // Converta para float!
                $barbeariaDoServico // Objeto Barbearia relacionado
            );

            // 3. Chamar o DAO para inserir o serviço
            $servicoDAO = new ServicoDAO($this->param);
            $servicoDAO->inserir_servico($servico);

            // 4. Redirecionar
            header("Location: /barberx/servicos"); // Ou para a página da barbearia
            exit;
        }

        require_once "Views/layout/header.php";
        require_once "Views/form_servico.php"; // Formulário para o serviço
        require_once "Views/layout/footer.php";
    }
}
