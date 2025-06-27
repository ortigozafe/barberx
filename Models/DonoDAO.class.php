<?php
class DonoDAO
{
    public function __construct(private $db = null) {}

    public function salvar($dono)
    {
        $sql = "INSERT INTO dono (nome, telefone, email, senha) VALUES (?, ?, ?, ?)";
        try {
            $stm = $this->db->prepare($sql);
            $stm->execute([
                $dono->getNome(),
                $dono->getTelefone(),
                $dono->getEmail(),
                $dono->getSenha()
            ]);
        } catch (PDOException $e) {
            die("Erro ao salvar dono: " . $e->getMessage());
        }
    }

    public function buscar_dono_por_id($dono_id)
    {
        $sql = "SELECT * FROM dono WHERE id = ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $dono_id);
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die("Erro ao buscar dono por ID: " . $e->getMessage());
        }
    }

    public function atualizar($dono)
    {
        $sql = "UPDATE dono SET nome = ?, telefone = ?, email = ?, senha = ? WHERE id = ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->execute([
                $dono->getNome(),
                $dono->getTelefone(),
                $dono->getEmail(),
                $dono->getSenha(),
                $dono->getId()
            ]);
        } catch (PDOException $e) {
            die("Erro ao atualizar dono: " . $e->getMessage());
        }
    }

    public function buscar_por_email($email)
    {
        $sql = "SELECT * FROM dono WHERE email = ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $email);
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die("Erro ao buscar dono");
        }
    }

    public function buscar_por_telefone($telefone)
    {
        $sql = "SELECT * FROM dono WHERE telefone = ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $telefone);
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die("Erro ao buscar dono");
        }
    }

    public function dadosDashboard($dono_id)
    {
        $dados = [];

        try {
            // selecionar a barbearia com id do dono
            $sql = "SELECT id FROM barbearia WHERE dono_id = ?";
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $dono_id);
            $stm->execute();
            $barbearia = $stm->fetch(PDO::FETCH_OBJ);

            if (!$barbearia) {
                $dados["erro"] = "Nenhuma barbearia cadastrada.";
                return $dados;
            }

            $barbearia_id = $barbearia->id;

            // total agendamentos do dia
            $sql = "SELECT COUNT(*) FROM agendamento WHERE DATE(data_hora) = CURDATE() AND barbearia_id = ?";
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $barbearia_id);
            $stm->execute();
            $dados["agendamentos_dia"] = $stm->fetchColumn();

            // total clientes no mês
            $sql = "SELECT COUNT(DISTINCT cliente_id) FROM agendamento WHERE MONTH(data_hora) = MONTH(CURRENT_DATE()) AND barbearia_id = ?";
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $barbearia_id);
            $stm->execute();
            $dados["clientes_mes"] = $stm->fetchColumn();

            // serviços realizados
            $sql = "SELECT COUNT(*) FROM agendamento WHERE status = 'concluido' AND barbearia_id = ?";
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $barbearia_id);
            $stm->execute();
            $dados["servicos_realizados"] = $stm->fetchColumn();
        } catch (PDOException $e) {
            die("Erro ao carregar dashboard: " . $e->getMessage());
        }

        return $dados;
    }

    public function buscarDadosGraficoBarras($dono_id)
    {
        try {
            $sqlBarbearia = "SELECT id FROM barbearia WHERE dono_id = ?";
            $stmBarbearia = $this->db->prepare($sqlBarbearia);
            $stmBarbearia->bindValue(1, $dono_id);
            $stmBarbearia->execute();
            $barbearia = $stmBarbearia->fetch(PDO::FETCH_OBJ);

            if (!$barbearia) {
                return [];
            }

            $barbearia_id = $barbearia->id;

            $sql = "SELECT DAYNAME(data_hora) AS dia, COUNT(*) AS total
            FROM agendamento
            WHERE barbearia_id = ?
            GROUP BY dia
            ORDER BY WEEKDAY(data_hora);";
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $barbearia_id);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function buscarDadosGraficoPizza($dono_id)
    {
        try {
            $sqlBarbearia = "SELECT id FROM barbearia WHERE dono_id = ?";
            $stmBarbearia = $this->db->prepare($sqlBarbearia);
            $stmBarbearia->bindValue(1, $dono_id);
            $stmBarbearia->execute();
            $barbearia = $stmBarbearia->fetch(PDO::FETCH_OBJ);

            if (!$barbearia) {
                return [];
            }

            $barbearia_id = $barbearia->id;

            $sql = "SELECT status, COUNT(*) AS total
                    FROM agendamento
                    WHERE barbearia_id = ?
                    GROUP BY status";
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $barbearia_id);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function dadosPDF($dono_id)
    {
        try {
            $sql = "SELECT id FROM barbearia WHERE dono_id = ?";
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $dono_id);
            $stm->execute();
            $barbearia = $stm->fetch(PDO::FETCH_OBJ);

            if (!$barbearia) {
                return [];
            }

            $barbearia_id = $barbearia["id"];

            $sql = "SELECT a.data_hora, c.nome AS cliente, s.nome AS servico, p.nome AS profissional
                FROM agendamento a
                JOIN cliente c ON a.cliente_id = c.id
                JOIN servico s ON a.servico_id = s.id
                JOIN profissional p ON a.profissional_id = p.id
                WHERE DATE(a.data_hora) = CURDATE() AND p.barbearia_id = ?
                ORDER BY a.data_hora";
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $barbearia_id);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die("Erro ao gerar PDF: " . $e->getMessage());
        }
    }
}
