<?php
session_start();
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

// ROTAS GERAIS

$route->get("/", [homeController::class, "home"]); 
$route->get("/empresas", [empresaController::class, "index"]);
$route->get("/contato", [contatoController::class, "formulario"]);
$route->post("/contato", [contatoController::class, "formulario"]);

// ROTAS DO DONO

// auths
$route->get("/cadastrar_dono", [donoController::class, "cadastrar"]);
$route->post("/cadastrar_dono", [donoController::class, "cadastrar"]);

$route->get("/logar_dono", [donoController::class, "logar"]);
$route->post("/logar_dono", [donoController::class, "logar"]);

// barbearias
$route->get("/barbearias", [barbeariaController::class, "listar"]);
$route->get("/cadastrar_barbearia", [barbeariaController::class, "cadastrar"]);
$route->post("/cadastrar_barbearia", [barbeariaController::class, "cadastrar"]);

// dashboard
$route->get("/dashboard", [dashboardDonoController::class, "index"]);

// pdf
$route->get("/gerar_pdf_dia", [dashboardDonoController::class, "gerarPDF"]);



// ROTAS DO CLIENTE

// auths
$route->get("/cadastrar_cliente", [clienteController::class, "cadastrar"]);
$route->post("/cadastrar_cliente", [clienteController::class, "cadastrar"]);

$route->get("/logar_cliente", [clienteController::class, "logar"]);
$route->post("/logar_cliente", [clienteController::class, "logar"]);

// barbearias
$route->get("/barbearias", [barbeariaController::class, "listar"]);
$route->get("/barbearia", [barbeariaController::class, "detalhar"]);

// agendamentos
$route->get("/agenda", [agendamentoController::class, "agenda"]);
$route->get("/agendar", [agendamentoController::class, "agendar"]);
$route->post("/agendar", [agendamentoController::class, "agendar"]);
$route->get("/cancelar_agendamento", [agendamentoController::class, "cancelar"]);



// logout
$route->get("/logout", [homeController::class, "logout"]);