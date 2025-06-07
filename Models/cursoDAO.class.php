<?php
	class cursoDAO 
	{
		public function __construct(private $db = null){}
		
		public function buscar_todos_cursos()
		{
			$sql = "SELECT * FROM curso";
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
				die("Problema ao buscar os cursos");
			}
		}//fim do buscar
		public function inserir($curso)
		{
			$sql = "INSERT INTO curso (nome) VALUES(?)";
			try
			{
				$stm = $this->db->prepare($sql);
				$stm->bindValue(1,$curso->getNome());
				
				$stm->execute();
				$this->db = null;
				return "curso inserido com sucesso";
			}
			catch(PDOException $e)
			{
				$this->db = null;
				die("Erro ao inserir curso");
			}
		}
		public function excluir_curso($curso)
		{
			$sql = "DELETE FROM curso WHERE id_curso = ?";
			try
			{
				$stm = $this->db->prepare($sql);
				$stm->bindValue(1, $curso->getId_curso());
				$stm->execute();
				$this->db = null;
				return "Exclusão com sucesso";		
			}
			catch(PDOException $e)
			{
				$this->db = null;
				die("Problema ao excluir curso");
			}
		}
		public function buscar_um_curso($curso)
		{
			$sql = "SELECT * FROM curso WHERE id_curso = ?";
			try
			{
				$stm = $this->db->prepare($sql);
				$stm->bindValue(1, $curso->getId_curso());
				$stm->execute();
				return $stm->fetchAll(PDO::FETCH_OBJ);
			}
			catch(PDOException $e)
			{
				$this->db = null;
				die("Problema ao buscar um curso");
			}
		}
		public function alterar_curso($curso)
		{
			$sql = "UPDATE curso SET nome = ? WHERE id_curso = ?";
			try
			{
				$stm = $this->db->prepare($sql);
				$stm->bindValue(1,$curso->getNome());
				
				$stm->bindValue(2,$curso->getId_curso());
				$stm->execute();
				$this->db = null;
				return "curso Alterado com sucesso";
			}
			catch(PDOException $e)
			{
				$this->db = null;
				die("Problema ao alterar um curso");
			}
		}
		public function buscar_dados_grafico()
		{
			$sql = "SELECT curso.nome as curso, count(aluno.id_aluno) as valor FROM curso, matricula, aluno WHERE curso.id_curso = matricula.id_curso AND aluno.id_aluno = matricula.id_aluno Group By curso.nome Order By valor desc";
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
				return "Problema ao buscar dados para o gráfico";
			}
		}
		public function buscar_dados_pdf($curso)
		{
			$sql = "SELECT a.nome, m.data_matricula, c.nome as curso FROM curso as c, aluno as a, matricula as m WHERE m.id_aluno = a.id_aluno AND m.id_curso = c.id_curso AND c.id_curso = ?";
			try
			{
				$stm = $this->db->prepare($sql);
				$stm->bindValue(1, $curso->getId_curso());
				$stm->execute();
				$this->db = null;
				return $stm->fetchAll(PDO::FETCH_OBJ);
			}
			catch(PDOException $e)
			{
				$this->db = null;
				die("Problema ao buscar dados para o pdf");
			}
		}
	}//fim da classe
?>