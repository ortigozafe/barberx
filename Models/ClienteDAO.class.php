<?php
class ClienteDAO
{
	public function __construct(private $db = null) {}

	public function salvar($cliente)
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

	public function buscar_cliente_por_id($cliente_id)
	{
		$sql = "SELECT * FROM cliente WHERE id = ?";
		try {
			$stm = $this->db->prepare($sql);
			$stm->bindValue(1, $cliente_id);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);
		} catch (PDOException $e) {
			die("Erro ao buscar cliente por ID: " . $e->getMessage());
		}
	}

	public function atualizar($cliente)
	{
		$sql = "UPDATE cliente SET nome = ?, telefone = ?, email = ?, senha = ? WHERE id = ?";
		try {
			$stm = $this->db->prepare($sql);
			$stm->execute([
				$cliente->getNome(),
				$cliente->getTelefone(),
				$cliente->getEmail(),
				$cliente->getSenha(),
				$cliente->getId()
			]);
		} catch (PDOException $e) {
			die("Erro ao atualizar cliente: " . $e->getMessage());
		}
	}

	public function buscar_por_email($email)
	{
		$sql = "SELECT * FROM cliente WHERE email = ?";
		try {
			$stm = $this->db->prepare($sql);
			$stm->bindValue(1, $email);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);
		} catch (PDOException $e) {
			die("Erro ao buscar cliente");
		}
	}

	public function buscar_por_telefone($telefone)
	{
		$sql = "SELECT * FROM cliente WHERE telefone = ?";
		try {
			$stm = $this->db->prepare($sql);
			$stm->bindValue(1, $telefone);
			$stm->execute();
			return $stm->fetch(PDO::FETCH_OBJ);
		} catch (PDOException $e) {
			die("Erro ao buscar cliente");
		}
	}
}
