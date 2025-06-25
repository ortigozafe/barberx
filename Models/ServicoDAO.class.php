<?php
class ServicoDAO
{
    public function __construct(private $db = null) {}

    public function buscar_servicos_por_barbearia($barbearia_id)
    {
        $sql = "SELECT * FROM servico WHERE id = ?";
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
}
