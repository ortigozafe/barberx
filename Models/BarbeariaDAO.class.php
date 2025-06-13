<?php
    class BarbeariaDAO
    {
        private $conexao;

        public function __construct($conexao)
        {
            $this->conexao = $conexao;
        }

        public function buscar_todas_barbearias()
        {
            $sql = "SELECT b.*, d.nome AS nome_dono
                    FROM barbearia b
                    JOIN dono d ON b.dono_id = d.id";

            $stmt = $this->conexao->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function inserir_barbearia(Barbearia $barbearia)
        {
            $sql = "INSERT INTO barbearia (nome, cnpj, telefone, email, endereco, dono_id)
                    VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = $this->conexao->prepare($sql);
            $stmt->execute([
                $barbearia->getNome(),
                $barbearia->getCnpj(),
                $barbearia->getTelefone(),
                $barbearia->getEmail(),
                $barbearia->getEndereco(),
                $barbearia->getDonoId()
            ]);
        }

        public function buscar_por_id($id)
        {
            $sql = "SELECT b.*, d.nome AS nome_dono
                    FROM barbearia b
                    JOIN dono d ON b.dono_id = d.id
                    WHERE b.id = ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function buscar_servicos($barbearia_id)
        {
            $sql = "SELECT * FROM servico WHERE barbearia_id = ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->execute([$barbearia_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function buscar_profissionais($barbearia_id)
        {
            $sql = "SELECT * FROM profissional WHERE barbearia_id = ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->execute([$barbearia_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

    }
?>
