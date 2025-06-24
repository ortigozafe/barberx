// Em um método 'cadastrarServico' de um controlador (ex: ServicoController)

public function cadastrarServico()
{
    $titulo = "Cadastro de Serviço";
    $msg = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // 1. Criar o objeto Barbearia "relacionado"
        // Assim como você fez com o Dono, se a Barbearia existir só pelo ID
        // (o que é válido se o ServicoDAO só precisar do ID da barbearia)
        $barbeariaDoServico = new Barbearia($_POST['barbearia_id']); 
        // ATENÇÃO: Seu construtor de Barbearia exige 9 parâmetros. 
        // Se a Barbearia for complexa, você pode precisar de um BarbeariaDAO para buscar a Barbearia completa
        // $barbeariaDoServico = $barbeariaDAO->buscar_uma_barbearia($_POST['barbearia_id']);
        // Ou adaptar o construtor da Barbearia para aceitar apenas o ID.

        // 2. Criar o objeto Serviço principal
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