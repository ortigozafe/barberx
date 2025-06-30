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

    public function buscar_barbearias_por_dono($dono_id)
    {
        $sql = "SELECT * FROM barbearia b WHERE dono_id = ?";

        $stm = $this->db->prepare($sql);
        $stm->bindValue(1, $dono_id);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_OBJ);
    }

    public function buscar_barbearias_completas_por_dono($dono_id)
    {
        $sql = "SELECT 
                b.id,
                b.nome,
                b.cnpj,
                b.telefone,
                b.email,
                b.endereco,
                b.data_cadastro,
                b.imagem,
                d.nome AS nome_dono
            FROM barbearia b
            JOIN dono d ON d.id = b.dono_id
            WHERE b.dono_id = ?
            ORDER BY b.nome";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(1, $dono_id);
        $stm->execute();
        $barbearias = $stm->fetchAll(PDO::FETCH_OBJ);

        foreach ($barbearias as $bar) {
            $sqlProf = "SELECT nome, telefone, email FROM profissional WHERE barbearia_id = ?";
            $stmProf = $this->db->prepare($sqlProf);
            $stmProf->bindValue(1, $bar->id);
            $stmProf->execute();
            $bar->profissionais = $stmProf->fetchAll(PDO::FETCH_OBJ);

            $sqlServ = "SELECT nome, descricao, preco, duracao_minutos FROM servico WHERE barbearia_id = ?";
            $stmServ = $this->db->prepare($sqlServ);
            $stmServ->bindValue(1, $bar->id);
            $stmServ->execute();
            $bar->servicos = $stmServ->fetchAll(PDO::FETCH_OBJ);
        }

        return $barbearias;
    }

    public function inserir_barbearia($barbearia)
    {
        $sql = "INSERT INTO barbearia (nome, cnpj, telefone, email, endereco, dono_id, imagem)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
        try {
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

            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            die("Erro ao inserir barbearia: " . $e->getMessage());
        }
    }

    public function buscar_uma_barbearia($barbearia_id)
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

        $stm = $this->db->prepare($sql);
        $stm->bindValue(1, $barbearia_id);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_OBJ);
    }

    public function atualizar_barbearia(Barbearia $barbearia)
    {
        $sql = "UPDATE barbearia SET nome = ?, cnpj = ?, telefone = ?, email = ?, endereco = ?, imagem = ? WHERE id = ?";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $barbearia->getNome(),
                $barbearia->getCnpj(),
                $barbearia->getTelefone(),
                $barbearia->getEmail(),
                $barbearia->getEndereco(),
                $barbearia->getImagem(),
                $barbearia->getId()
            ]);
        } catch (PDOException $e) {
            die("Erro ao atualizar barbearia: " . $e->getMessage());
        }
    }

    public function excluirTudoRelacionado($barbearia_id)
    {
        try {
            $stm = $this->db->prepare("DELETE FROM agendamento WHERE barbearia_id = ?");
            $stm->execute([$barbearia_id]);

            $stm = $this->db->prepare("DELETE FROM profissional WHERE barbearia_id = ?");
            $stm->execute([$barbearia_id]);

            $stm = $this->db->prepare("DELETE FROM servico WHERE barbearia_id = ?");
            $stm->execute([$barbearia_id]);

            $stm = $this->db->prepare("DELETE FROM horario_funcionamento WHERE barbearia_id = ?");
            $stm->execute([$barbearia_id]);

            $stm = $this->db->prepare("DELETE FROM barbearia WHERE id = ?");
            $stm->execute([$barbearia_id]);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public function buscarPorIdCompleto($id)
    {
        $sql = "SELECT 
                    b.id,
                    b.nome,
                    b.cnpj,
                    b.telefone,
                    b.email,
                    b.endereco,
                    b.data_cadastro,
                    b.imagem,
                    d.nome AS nome_dono
                FROM barbearia b
                JOIN dono d ON d.id = b.dono_id
                WHERE b.id = ?
                LIMIT 1";

        $stm = $this->db->prepare($sql);
        $stm->bindValue(1, $id);
        $stm->execute();
        $barbearia = $stm->fetch(PDO::FETCH_OBJ);

        if ($barbearia) {

            $sqlProf = "SELECT nome, telefone, email FROM profissional WHERE barbearia_id = ?";
            $stmProf = $this->db->prepare($sqlProf);
            $stmProf->bindValue(1, $barbearia->id);
            $stmProf->execute();
            $barbearia->profissionais = $stmProf->fetchAll(PDO::FETCH_OBJ);

            $sqlServ = "SELECT nome, descricao, preco, duracao_minutos FROM servico WHERE barbearia_id = ?";
            $stmServ = $this->db->prepare($sqlServ);
            $stmServ->bindValue(1, $barbearia->id);
            $stmServ->execute();
            $barbearia->servicos = $stmServ->fetchAll(PDO::FETCH_OBJ);
        }

        return $barbearia;
    }

    public function buscarEnderecosBarbearias()
    {
        $sql = "SELECT id, nome, endereco FROM barbearia";
        $stm = $this->db->prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_OBJ);
    }
}
