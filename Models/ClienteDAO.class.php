<?php
class ClienteDAO
{
	public function __construct(private $db = null) {}

	public function salvar(Cliente $cliente)
	{
		//var_dump($this->db); 

		$sql = "INSERT INTO cliente (nome, telefone, email, senha) VALUES (?, ?, ?, ?)";
		try {
			$stm = $this->db->prepare($sql);
			$stm->execute([
				$cliente->getNome(),
				$cliente->getTelefone(),
				$cliente->getEmail(),
				$cliente->getSenha()
			]);
			
		} catch (PDOException $e) {
			
			die("Erro ao salvar cliente: " . $e->getMessage());
		}
	}

	public function buscar_por_email(string $email)
	{
		$sql = "SELECT * FROM cliente WHERE email = ?";
		try {
			$stm = $this->db->prepare($sql);
			$stm->execute([$email]);
			
			return $stm->fetch(PDO::FETCH_OBJ);
		} catch (PDOException $e) {
			
			die("Erro ao buscar cliente");
		}
	}

	public function buscar_por_telefone(string $telefone)
	{
		$sql = "SELECT * FROM cliente WHERE telefone = ?";
		$stm = $this->db->prepare($sql);
		$stm->execute([$telefone]);
		return $stm->fetch(PDO::FETCH_ASSOC);
	}
}
