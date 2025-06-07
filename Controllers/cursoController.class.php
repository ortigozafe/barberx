<?php
	class cursoController
	{
		private $param;
		public function __construct()
		{
			$this->param = Conexao::getInstancia();
		}
		
		public function listar()
		{
			// buscar os cursos no BD
			$cursoDAO = new cursoDAO($this->param);
			$retorno = $cursoDAO->buscar_todos_cursos();

			// define o título para o header
			$titulo = "Lista de Cursos";

			// inclui o header (onde $titulo será usado)
			require_once "Views/layout/header.php";

			// inclui a view principal (usar a variável $retorno nela)
			require_once "Views/listar_cursos.php";

			// inclui o footer
			require_once "Views/layout/footer.php";
		}

		public function cadastrar()
		{
			$msg = "";
			
			if($_POST)
			{
				//verificar os dados digitados
				if(empty($_POST["nome"]))
				{
					$msg = "Preencha o nome do curso";
					
				}
				else
				
				{
				//criar a instância do objeto curso
				$curso = new Curso(0, $_POST["nome"]);
				//criar uma instância cursoDAO
				$cursoDAO = new cursoDAO($this->param);
				//chamar o método inserir
				$cursoDAO->inserir($curso);
				
				//redirecionar para o listar
				header("location:/Curso/listar");
				die();
				}
			}
			//visão formulário cadastrar
			require_once "views/form_curso.php";
			
		}
		public function excluir()
		{
			if(isset($_GET["id"]))
			{
				$curso = new curso($_GET["id"]);
				$cursoDAO = new cursoDAO($this->param);
				$cursoDAO->excluir_curso($curso);
				header("location:/Curso/listar");
				die();
			}
		}
		public function alterar()
		{
			$msg = "";
			
			if($_POST)
			{
				//validar os dados
				if(empty($_POST["nome"]))
				{
					$msg = "Preencha o nome do curso";
					
				}
				
				else
				{
					$curso = new curso($_POST["id_curso"], $_POST["nome"]);
					$cursoDAO = new cursoDAO($this->param);
					$cursoDAO->alterar_curso($curso);
					header("location:/Curso/listar");
					die();
					
				}
			}//fim do post
			//buscar os dados do curso para alteração BD
			$curso = new curso($_GET["id"]);
			$cursoDAO = new cursoDAO($this->param);
			$retorno = $cursoDAO->buscar_um_curso($curso);
			//mostrar visão com os dados
			require_once "Views/edit_curso.php";
		}
		public function grafico()
		{
			require_once "Views/grafico_barras.php";
		}
		
		public function dadosgrafico()
		{
			$cursoDAO = new cursoDAO($this->param);
			$retorno = $cursoDAO->buscar_dados_grafico();
			$retorno = json_encode($retorno);
			echo $retorno;
		}
		public function gerar_pdf()
		{
			$msg = "";
			if($_POST)
			{
				if($_POST["curso"] == "0")
				{
					$msg = "Escolha um Curso";
				}
				else
				{
					$curso = new Curso($_POST["curso"]);
					$cursoDAO = new cursoDAO($this->param);
					$ret = $cursoDAO->buscar_dados_pdf($curso);
					if(count($ret) > 0)
					{
						require_once "Views/pdf.php";
					}
					else
					{
						$msg = "Curso sem alunos matriculados";
					}
				}
			}
			$cursoDAO = new cursoDAO($this->param);
			$retorno = $cursoDAO->buscar_todos_cursos();
			require_once "Views/filtro_cursos.php";
		}
	}//fim da classe
?>