<?php
class BarbeariaDAO
{
    public function __construct(private $db = null) {}

    public function buscar_todas_barbearias()
    {
        $sql = "SELECT b.*, d.id AS dono_id, d.nome AS nome_dono, d.telefone AS telefone_dono, d.email AS email_dono
                    FROM barbearia b
                    JOIN dono d ON b.dono_id = d.id";

        $stm = $this->db->prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_OBJ);
    }


    public function inserir_barbearia($barbearia)
    {
        $sql = "INSERT INTO barbearia (nome, cnpj, telefone, email, endereco, dono_id, imagem)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stm = $this->db->prepare($sql);
        $stm->execute([
            $barbearia->getNome(),
            $barbearia->getCnpj(),
            $barbearia->getTelefone(),
            $barbearia->getEmail(),
            $barbearia->getEndereco(),
            $barbearia->getDono()->getId(),
            $barbearia->getImagem()
        ]);
    }

    public function buscar_uma_barbearia($barbearia)
    {
        $sql = "SELECT
        b.*,
        b.nome as nome_barbearia,
        d.id AS dono_id,
        d.nome AS nome_dono,
        d.telefone AS telefone_dono,
        d.email AS email_dono
        FROM barbearia b
        JOIN dono d ON b.dono_id = d.id
        WHERE b.id = ?";

        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $barbearia->getId());
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            $this->db = null;
            die("Erro ao buscar barbearia: " . $e->getMessage());
        }
    }


}
