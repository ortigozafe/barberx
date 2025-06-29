<?php
class HorarioFuncionamentoDAO
{
    public function __construct(private $db = null) {}

    public function inserirHorario($horario)
    {
        $sql = "INSERT INTO horario_funcionamento
                (barbearia_id, dia_semana, horario_abertura, horario_fechamento)
                VALUES (?, ?, ?, ?)";
        try {
            $stm = $this->db->prepare($sql);
            $stm->execute([
                $horario->getBarbearia()->getId(),
                $horario->getDiaSemana(),
                $horario->getHorarioAbertura(),
                $horario->getHorarioFechamento()
            ]);
        } catch (PDOException $e) {
            die("Erro ao inserir horário de funcionamento: " . $e->getMessage());
        }
    }

    public function listarPorBarbearia($barbearia_id)
    {
        $sql = "SELECT * FROM horario_funcionamento WHERE barbearia_id = ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $barbearia_id);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die("Erro ao buscar horários: " . $e->getMessage());
        }
    }

    public function atualizarHorario($horario)
    {
        $sql = "UPDATE horario_funcionamento SET horario_abertura = ?, horario_fechamento = ? WHERE id = ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->execute([
                $horario->getHorarioAbertura(),
                $horario->getHorarioFechamento(),
                $horario->getId()
            ]);
        } catch (PDOException $e) {
            die("Erro ao atualizar horário: " . $e->getMessage());
        }
    }

    public function excluirHorariosPorBarbearia($barbearia_id)
    {
        $sql = "DELETE FROM horario_funcionamento WHERE barbearia_id = ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $barbearia_id);
            $stm->execute();
        } catch (PDOException $e) {
            die("Erro ao excluir horários: " . $e->getMessage());
        }
    }

    public function buscarPorDia($barbearia_id, $diaSemana)
    {
        $sql = "SELECT * FROM horario_funcionamento WHERE barbearia_id = ? AND dia_semana = ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $barbearia_id);
            $stm->bindValue(2, strtolower($diaSemana));
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die("Erro ao buscar horário de funcionamento do dia: " . $e->getMessage());
        }
    }
}
