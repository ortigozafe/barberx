<?php
	class alunoDAO
	{
		public function __construct(private $db = null){}
		
		public function dados_mapa()
		{
			$sql = "SELECT * FROM aluno";
			try
			{
				$stm = $this->db->prepare($sql);
				$stm->execute();
				$this->db = null;
				return $stm->fetchAll(PDO::FETCH_OBJ);
			}
			catch(PDOException $e)
			{
				$this->db = null;
				die("Problema ao buscar os alunos");
			}
		}//fim do buscar
		public function buscar_enderecos()
		{
			$sql = "SELECT endereco, numero, cidade, uf FROM aluno";
			try
			{
				$stm = $this->db->prepare($sql);
				$stm->execute();
				$this->db = null;
				return $stm->fetchAll(PDO::FETCH_OBJ);
			}
			catch(PDOException $e)
			{
				$this->db = null;
				die("Problema ao buscar endereços");
			}
		}
	}
?>