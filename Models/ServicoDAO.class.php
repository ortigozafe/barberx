<?php
class ServicoDAO
{
    public function __construct(private $db = null) {}

    public function inserirServico($servico)
    {
        $sql = "INSERT INTO servico (nome, descricao, preco, duracao_minutos, barbearia_id)
            VALUES (?, ?, ?, ?, ?)";
        try {
            $stm = $this->db->prepare($sql);
            return $stm->execute([
                $servico->getNome(),
                $servico->getDescricao(),
                $servico->getPreco(),
                $servico->getDuracaoMinutos(),
                $servico->getBarbearia()->getId()
            ]);
        } catch (PDOException $e) {
            die("Erro ao salvar serviço: " . $e->getMessage());
        }
    }

    public function buscar_servicos_por_barbearia($barbearia_id)
    {
        $sql = "SELECT * FROM servico s WHERE s.barbearia_id = ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $barbearia_id);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            $this->db = null;
            die("Erro ao buscar servico: " . $e->getMessage());
        }
    }

    public function buscar_um_servico($servico_id)
    {
        $sql = "SELECT * FROM servico WHERE id = ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $servico_id);
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            $this->db = null;
            die("Erro ao buscar servico: " . $e->getMessage());
        }
    }
}
