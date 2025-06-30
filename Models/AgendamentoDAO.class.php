<?php
class AgendamentoDAO
{
    public function __construct(private $db = null) {}

    public function inserir_agendamento($agendamento)
    {
        $sql = "INSERT INTO agendamento (cliente_id, profissional_id, servico_id, barbearia_id, data_hora, status, observacoes)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stm = $this->db->prepare($sql);
        $stm->execute([
            $agendamento->getCliente()->getId(),
            $agendamento->getProfissional()->getId(),
            $agendamento->getServico()->getId(),
            $agendamento->getBarbearia()->getId(),
            $agendamento->getDataHora(),
            $agendamento->getStatus(),
            $agendamento->getObservacoes()
        ]);
    }

    public function buscar_agendamentos_cliente($cliente_id)
    {
        $sql = "SELECT 
                a.id AS agendamento_id,
                a.data_hora,
                a.status,
                a.observacoes,
                s.nome AS servico_nome,
                s.preco AS servico_preco,
                p.nome AS profissional_nome,
                p.email AS profissional_email,
                b.nome AS barbearia_nome,
                b.imagem AS barbearia_imagem
            FROM agendamento a
            JOIN servico s ON a.servico_id = s.id
            JOIN profissional p ON a.profissional_id = p.id
            JOIN barbearia b ON a.barbearia_id = b.id
            WHERE a.cliente_id = ?
            ORDER BY a.data_hora DESC";

        $stm = $this->db->prepare($sql);
        $stm->bindValue(1, $cliente_id);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_OBJ);
    }

    public function atualizar_status_por_id($id, $novoStatus)
    {
        $sql = "UPDATE agendamento SET status = ? WHERE id = ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->execute([$novoStatus, $id]);
        } catch (PDOException $e) {
            die("Erro ao atualizar status do agendamento: " . $e->getMessage());
        }
    }


    public function buscar_por_id($id)
    {
        $sql = "SELECT * FROM agendamento WHERE id = ?";

        $stm = $this->db->prepare($sql);
        $stm->execute([$id]);

        $row = $stm->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Agendamento(
                $row['id'],
                new Cliente($row['cliente_id']),
                new Profissional($row['profissional_id']),
                new Servico($row['servico_id']),
                new Barbearia($row['barbearia_id']),
                $row['data_hora'],
                $row['status'],
                $row['observacoes']
            );
        }
        return null;
    }


    public function buscar_agendamentos_por_barbearia($barbearia_id)
    {
        $barbearia_id = $_GET['barbearia_id'] ?? null;

        $sql = "SELECT 
            a.id, 
            c.nome AS cliente, 
            p.nome AS profissional,
            s.nome AS servico,
            a.data_hora,
            a.status
        FROM agendamento a
        JOIN cliente c ON c.id = a.cliente_id
        JOIN profissional p ON p.id = a.profissional_id
        JOIN servico s ON s.id = a.servico_id
        WHERE a.barbearia_id = ?
        ORDER BY a.data_hora DESC";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(1, $barbearia_id);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_OBJ);
    }

    public function atualizar_status($ag)
    {
        $sql = "UPDATE agendamento SET status = ? WHERE id = ?";
        $stm = $this->db->prepare($sql);
        return $stm->execute([$ag->getStatus(), $ag->getId()]);
    }

    public function listarPorBarbearia($barbearia_id)
    {
        $sql = "SELECT * FROM agendamento WHERE barbearia_id = ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $barbearia_id);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die("Erro ao buscar agendamentos da barbearia: " . $e->getMessage());
        }
    }

    public function listarPorDia($barbearia_id, $data)
    {
        $sql = "SELECT * FROM agendamento WHERE barbearia_id = ? AND DATE(data_hora) = ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $barbearia_id);
            $stm->bindValue(2, $data);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die("Erro ao buscar agendamentos do dia: " . $e->getMessage());
        }
    }

    public function atualizar_agendamento($ag)
    {
        $sql = "UPDATE agendamento SET 
                    profissional_id = ?, 
                    servico_id = ?, 
                    data_hora = ?, 
                    status = ?, 
                    observacoes = ?
                WHERE id = ? AND cliente_id = ?";

        $stm = $this->db->prepare($sql);
        return $stm->execute([
            $ag->getProfissional()->getId(),
            $ag->getServico()->getId(),
            $ag->getDataHora(),
            $ag->getStatus(),
            $ag->getObservacoes(),
            $ag->getId(),
            $ag->getCliente()->getId()
        ]);
    }


    public function buscar_agendamentos_do_dia_por_dono($dono_id)
    {
        $sql = "SELECT a.*, c.nome AS cliente_nome, p.nome AS profissional_nome, s.nome AS servico_nome
                    FROM agendamento a
                    JOIN cliente c ON a.cliente_id = c.id
                    JOIN profissional p ON a.profissional_id = p.id
                    JOIN servico s ON a.servico_id = s.id
                    JOIN barbearia b ON p.barbearia_id = b.id
                    WHERE b.dono_id = ? AND DATE(a.data_hora) = CURDATE()
                    ORDER BY a.data_hora ASC";

        $stm = $this->db->prepare($sql);
        $stm->execute([$dono_id]);
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contar_status_por_dono($dono_id)
    {
        $sql = "SELECT status, COUNT(*) as quantidade
                    FROM agendamento a
                    JOIN profissional p ON a.profissional_id = p.id
                    JOIN barbearia b ON p.barbearia_id = b.id
                    WHERE b.dono_id = ?
                    GROUP BY status";

        $stm = $this->db->prepare($sql);
        $stm->execute([$dono_id]);
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agendamentos_por_dia_semana($dono_id)
    {
        $sql = "SELECT DAYNAME(a.data_hora) AS dia_semana, COUNT(*) AS total
                    FROM agendamento a
                    JOIN profissional p ON a.profissional_id = p.id
                    JOIN barbearia b ON p.barbearia_id = b.id
                    WHERE b.dono_id = ?
                    GROUP BY dia_semana";

        $stm = $this->db->prepare($sql);
        $stm->execute([$dono_id]);
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }
}
