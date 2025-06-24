public function cadastrarProfissional()
{
    $titulo = "Cadastro de Profissional";
    $msg = "";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // 1. Criar o objeto Barbearia "relacionado"
        // Novamente, se o construtor da Barbearia for complexo, pode precisar buscar ela completa
        $barbeariaDoProfissional = new Barbearia($_POST['barbearia_id']); 

        // 2. Criar o objeto Profissional principal
        $profissional = new Profissional(
            0, // ID (0 para novo)
            $_POST["nome_profissional"],
            $_POST["especialidade_profissional"],
            $barbeariaDoProfissional // Objeto Barbearia relacionado
        );

        // 3. Chamar o DAO para inserir o profissional
        $profissionalDAO = new ProfissionalDAO($this->param);
        $profissionalDAO->inserir_profissional($profissional);

        // 4. Redirecionar
        header("Location: /barberx/profissionais"); // Ou para a página da barbearia
        exit;
    }

    require_once "Views/layout/header.php";
    require_once "Views/form_profissional.php"; // Formulário para o profissional
    require_once "Views/layout/footer.php";
}