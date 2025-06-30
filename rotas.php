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
$route->get("/barbearias", [barbeariaController::class, "listar"]);
$route->get("/contato", [contatoController::class, "formulario"]);
$route->post("/contato", [contatoController::class, "formulario"]);

// ROTAS DO DONO

// auths
$route->get("/cadastrar_dono", [donoController::class, "cadastrar"]);
$route->post("/cadastrar_dono", [donoController::class, "cadastrar"]);

$route->get("/logar_dono", [donoController::class, "logar"]);
$route->post("/logar_dono", [donoController::class, "logar"]);

// perfil
$route->get("/perfil_dono", [donoController::class, "perfil"]);
$route->post("/perfil_dono", [donoController::class, "perfil"]);

// barbearias
$route->get("/barbearias_dono", [donoController::class, "minhasBarbearias"]);
$route->get("/cadastrar_barbearia", [donoController::class, "cadastrarBarbearia"]);
$route->post("/cadastrar_barbearia", [donoController::class, "cadastrarBarbearia"]);

$route->get("/editar_barbearia", [donoController::class, "editarBarbearia"]);
$route->post("/editar_barbearia", [donoController::class, "editarBarbearia"]);
$route->get("/excluir_barbearia", [donoController::class, "excluirBarbearia"]);

// agendamentos
$route->get("/agenda_dono", [donoController::class, "agendaDono"]);
$route->get("/apiAgendamentosBarbearia", [donoController::class, "apiAgendamentosBarbearia"]);

// dashboard
$route->get("/dashboard", [donoController::class, "dashboard"]);
$route->get("/apiAgendamentosDia", [donoController::class, "apiAgendamentosDia"]);
$route->get("/apiClientesMes", [donoController::class, "apiClientesMes"]);
$route->get("/apiServicosRealizados", [donoController::class, "apiServicosRealizados"]);
$route->get("/apiDadosDashboard", [donoController::class, "apiDadosDashboard"]);

// Rota para os dados do gráfico de barras
$route->get("/dadosgraficobarras", [donoController::class, "dadosgraficobarras"]);

// Rota para os dados do gráfico de pizza
$route->get("/dadosgraficopizza", [donoController::class, "dadosgraficopizza"]);

// pdf
$route->post("/pdf_dia", [donoController::class, "pdf_dia"]);


// ROTAS DO CLIENTE

// auths
$route->get("/cadastrar_cliente", [clienteController::class, "cadastrar"]);
$route->post("/cadastrar_cliente", [clienteController::class, "cadastrar"]);

$route->get("/logar_cliente", [clienteController::class, "logar"]);
$route->post("/logar_cliente", [clienteController::class, "logar"]);

// perfil
$route->get("/perfil_cliente", [clienteController::class, "perfil"]);
$route->post("/perfil_cliente", [clienteController::class, "perfil"]);

// barbearias
$route->get("/barbearias", [barbeariaController::class, "listar"]);
$route->get("/barbearia", [barbeariaController::class, "detalhar"]);

// agendamentos
$route->get("/agenda", [agendamentoController::class, "agenda"]);
$route->get("/agendar", [agendamentoController::class, "agendar"]);
$route->post("/agendar", [agendamentoController::class, "agendar"]);
$route->get("/cancelar_agendamento", [agendamentoController::class, "cancelarAgendamento"]);

// rotas para AJAX do agendamento dinâmico
$route->post("/buscar_horarios", [agendamentoController::class, "buscarHorarios"]);
$route->post("/buscar_profissionais", [agendamentoController::class, "buscarProfissionais"]);


// logout
$route->get("/logout", [homeController::class, "logout"]);