<?php
    class AgendamentoDAO
    {
        private $conexao;

        public function __construct($conexao)
        {
            $this->conexao = $conexao;
        }

        public function buscar_profissionais_por_barbearia($barbearia_id)
        {
            $sql = "SELECT id, nome FROM profissional WHERE barbearia_id = ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->execute([$barbearia_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function buscar_servicos_por_barbearia($barbearia_id)
        {
            $sql = "SELECT id, nome FROM servico WHERE barbearia_id = ?";
            $stmt = $this->conexao->prepare($sql);
            $stmt->execute([$barbearia_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function inserir_agendamento(Agendamento $ag)
        {
            $sql = "INSERT INTO agendamento (cliente_id, profissional_id, servico_id, data_hora, status, observacoes)
                    VALUES (?, ?, ?, ?, ?, ?)";

            $stmt = $this->conexao->prepare($sql);
            return $stmt->execute([
                $ag->getClienteId(),
                $ag->getProfissionalId(),
                $ag->getServicoId(),
                $ag->getDataHora(),
                $ag->getStatus(),
                $ag->getObservacoes()
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

            $stmt = $this->conexao->prepare($sql);
            $stmt->execute([$cliente_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function cancelar_agendamento($id)
        {
            $sql = "UPDATE agendamento SET status = 'cancelado' WHERE id = ?";
            $stmt = $this->conexao->prepare($sql);
            return $stmt->execute([$id]);
        }

        public function buscar_por_id($id)
        {
            $sql = "SELECT a.*, p.barbearia_id
                    FROM agendamento a
                    JOIN profissional p ON a.profissional_id = p.id
                    WHERE a.id = ?";

            $stmt = $this->conexao->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
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

            $stmt = $this->conexao->prepare($sql);
            return $stmt->execute([
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

            $stmt = $this->conexao->prepare($sql);
            $stmt->execute([$dono_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function contar_status_por_dono($dono_id)
        {
            $sql = "SELECT status, COUNT(*) as quantidade
                    FROM agendamento a
                    JOIN profissional p ON a.profissional_id = p.id
                    JOIN barbearia b ON p.barbearia_id = b.id
                    WHERE b.dono_id = ?
                    GROUP BY status";

            $stmt = $this->conexao->prepare($sql);
            $stmt->execute([$dono_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function agendamentos_por_dia_semana($dono_id)
        {
            $sql = "SELECT DAYNAME(a.data_hora) AS dia_semana, COUNT(*) AS total
                    FROM agendamento a
                    JOIN profissional p ON a.profissional_id = p.id
                    JOIN barbearia b ON p.barbearia_id = b.id
                    WHERE b.dono_id = ?
                    GROUP BY dia_semana";

            $stmt = $this->conexao->prepare($sql);
            $stmt->execute([$dono_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>