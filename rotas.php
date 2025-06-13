<?php
class rotas
{
	private array $rotas = array();

	public function get(string $nome, array $dados)
	{
		$this->rotas['GET'][$nome] = $dados;
	}
	public function post(string $nome, array $dados)
	{
		$this->rotas['POST'][$nome] = $dados;
	}
	public function verificar_rota(string $metodo, string $uri)
	{
		if (isset($this->rotas[$metodo][$uri])) {
			$dados_rota = $this->rotas[$metodo][$uri];
			$classe = $dados_rota[0];
			$metodo = $dados_rota[1];
			$obj = new $classe();
			return $obj->$metodo();
		} else {
			echo "Rota Inválida";
		}
	}
} //fim da classe
$route = new Rotas();

// tela inicial
$route->get("/", [homeController::class, "home"]); 

// rotas do dono
$route->get("/cadastrar_dono", [donoController::class, "cadastrar"]);
$route->post("/salvar_dono", [donoController::class, "salvar"]);
$route->get("/logar_dono", [donoController::class, "logar"]);
$route->post("/login_dono", [donoController::class, "login"]);
$route->get("/barbearias", [barbeariaController::class, "listar"]);
$route->get("/cadastrar_barbearia", [barbeariaController::class, "cadastrar"]);
$route->post("/salvar_barbearia", [barbeariaController::class, "salvar"]);

// rotas do cliente
$route->get("/cadastrar_cliente", [clienteController::class, "cadastrar"]);
$route->post("/salvar_cliente", [clienteController::class, "salvar"]);
$route->get("/logar_cliente", [clienteController::class, "logar"]);
$route->post("/login_cliente", [clienteController::class, "login"]);
$route->get("/barbearias", [barbeariaController::class, "listar"]);
$route->get("/barbearia", [barbeariaController::class, "detalhar"]);
$route->get("/agendar", [agendamentoController::class, "agendar"]);
$route->post("/salvar_agendamento", [agendamentoController::class, "salvar"]);
$route->get("/agenda", [agendamentoController::class, "agenda"]);
$route->get("/cancelar_agendamento", [agendamentoController::class, "cancelar"]);


/*
$route->get("/inserir", [barberController::class, "cadastrar"]);
$route->post("/inserir", [barberController::class, "cadastrar"]);
$route->get("/listar", [cursoController::class, "listar"]);
$route->get("/alterar", [barberController::class, "alterar"]);
$route->post("/alterar", [barberController::class, "alterar"]);
$route->get("/excluir", [barberController::class, "excluir"]);
//gráfico
$route->get("/grafico", [barberController::class, "grafico"]);
$route->get("/dadosgrafico", [barberController::class, "dadosgrafico"]);
$route->get("/gerar_pdf", [barberController::class, "gerar_pdf"]);
$route->post("/gerar_pdf", [barberController::class, "gerar_pdf"]);
$route->get("/alunos_mapa", [alunoController::class, "alunos_mapa"]);
$route->get("/buscar_dados_mapa", [alunoController::class, "buscar_dados_mapa"]);*/

$route->get("/rota", [alunoController::class, "rota"]);
