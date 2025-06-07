<?php
	class alunoController
	{
		private $param;
		public function __construct()
		{
			$this->param = Conexao::getInstancia();
		}
		public function alunos_mapa()
		{
			require_once "Views/mostrar_alunos_mapa.php";
		}
		public function buscar_dados_mapa()
		{
			$alunoDAO = new alunoDAO($this->param);
			$retorno = $alunoDAO->dados_mapa();
			$retorno = json_encode($retorno);
			echo $retorno;
		}
		public function rota()
		{
			//buscar os endereços alunos_mapa
			$alunoDAO = new alunoDAO($this->param);
			$retorno = $alunoDAO->buscar_enderecos();
			//preparar json
			$enderecos[0] = ['endereco'=>'Praça das Cerejeira', 'numero'=>'444', 'cidade'=>'Bauru', 'uf'=>'SP'];
			
			foreach($retorno as $dado)
			{
				$enderecos[] = ['endereco'=>$dado->endereco, 'numero'=>$dado->numero, 'cidade'=>$dado->cidade,'uf'=>$dado->uf];
			}
			$enderecos = json_encode($enderecos);
				
			//chamar  a visão
			
			require_once "Views/mostrar_rota.php";
		}
	}
?>