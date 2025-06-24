<?php
    class AgendamentoDAO
    {
        public function __construct(private $db = null){}

        public function buscar_profissionais_por_barbearia($barbearia_id)
        {
            $sql = "SELECT id, nome FROM profissional WHERE barbearia_id = ?";
            $stm = $this->db->prepare($sql);
            $stm->execute([$barbearia_id]);
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }

        public function buscar_servicos_por_barbearia($barbearia_id)
        {
            $sql = "SELECT id, nome FROM servico WHERE barbearia_id = ?";
            $stm = $this->db->prepare($sql);
            $stm->execute([$barbearia_id]);
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }

        public function inserir_agendamento(Agendamento $agendamento)
        {
            $sql = "INSERT INTO agendamento (cliente_id, profissional_id, servico_id, data_hora, status, observacoes)
                    VALUES (?, ?, ?, ?, ?, ?)";

            $stm = $this->db->prepare($sql);
            $stm->execute([
                $agendamento->getCliente()->getId(),
                $agendamento->getProfissional()->getId(),
                $agendamento->getServico()->getId(),
                $agendamento->getDataHora(),
                $agendamento->getStatus(),
                $agendamento->getObservacoes()
            ]);
        }

        public function buscar_agendamentos_cliente($cliente_id)
        {
            $sql = "SELECT a.*, s.nome AS servico_nome, p.nome AS profissional_nome, b.nome AS barbearia_nome
                    FROM agendamento a
                    JOIN servico s ON a.servico_id = s.id
                    JOIN profissional p ON a.profissional_id = p.id
                    JOIN barbearia b ON p.barbearia_id = b.id
                    WHERE a.cliente_id = ?
                    ORDER BY a.data_hora DESC";

            $stm = $this->db->prepare($sql);
            $stm->execute([$cliente_id]);
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        }

        public function cancelar_agendamento($id)
        {
            $sql = "UPDATE agendamento SET status = 'cancelado' WHERE id = ?";
            $stm = $this->db->prepare($sql);
            return $stm->execute([$id]);
        }

        public function buscar_por_id($id)
        {
            $sql = "SELECT a.*, p.barbearia_id
                    FROM agendamento a
                    JOIN profissional p ON a.profissional_id = p.id
                    WHERE a.id = ?";

            $stm = $this->db->prepare($sql);
            $stm->execute([$id]);
            return $stm->fetch(PDO::FETCH_ASSOC);
        }

        public function atualizar_agendamento(Agendamento $ag)
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
                $ag->getProfissionalId(),
                $ag->getServicoId(),
                $ag->getDataHora(),
                $ag->getStatus(),
                $ag->getObservacoes(),
                $ag->getId(),
                $ag->getClienteId()
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
?>