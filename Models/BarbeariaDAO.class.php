<?php
    class BarbeariaDAO
    {
        private $conexao;

        public function __construct($conexao)
        {
            $this->conexao = $conexao;
        }

        public function buscar_todas_barbearias(): array
        {
            $sql = "SELECT b.*, d.id AS dono_id, d.nome AS nome_dono, d.telefone AS telefone_dono, d.email AS email_dono
                    FROM barbearia b
                    JOIN dono d ON b.dono_id = d.id";
        
            $stmt = $this->conexao->prepare($sql);
            $stmt->execute();
        
            $barbearias = [];
        
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Criar o objeto Dono
                $dono = new Dono(
                    $row['dono_id'],
                    $row['nome_dono'],
                    $row['telefone_dono'],
                    $row['email_dono']
                );
        
                // Criar o objeto Barbearia com o objeto Dono
                $barbearia = new Barbearia(
                    $row['id'],
                    $row['nome'],
                    $row['cnpj'],
                    $row['telefone'],
                    $row['email'],
                    $row['endereco'],
                    $dono,
                    $row['data_cadastro'] ?? ''
                );
        
                $barbearias[] = $barbearia;
            }
        
            return $barbearias;
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

        public function buscar_por_id(int $id): ?Barbearia
        {
            $sql = "SELECT b.*, d.id AS dono_id, d.nome AS nome_dono, d.telefone AS telefone_dono, d.email AS email_dono
                    FROM barbearia b
                    JOIN dono d ON b.dono_id = d.id
                    WHERE b.id = :id";

            $stmt = $this->conexao->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$row) {
                return null;
            }

            // Criar o objeto Dono
            $dono = new Dono(
                $row['dono_id'],
                $row['nome_dono'],
                $row['telefone_dono'],
                $row['email_dono']
            );

            // Criar o objeto Barbearia com o objeto Dono
            return new Barbearia(
                $row['id'],
                $row['nome'],
                $row['cnpj'],
                $row['telefone'],
                $row['email'],
                $row['endereco'],
                $dono,  // dono é objeto
                $row['data_cadastro'] ?? ''
            );
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
