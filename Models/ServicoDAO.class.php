<?php
class ServicoDAO
{
    public function __construct(private $db = null) {}

    public function buscar_um_servico($servico)
    {
        $sql = "SELECT * FROM servico WHERE id = ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $servico->getId());
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            $this->db = null;
            die("Erro ao buscar servico: " . $e->getMessage());
        }
    }
}
