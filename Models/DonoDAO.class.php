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

    // terminar essa funcao 
    // nao esta buscando corretamente profissionais e servicos

    public function buscar_barbearias_por_dono($dono_id)
    {
        try {
            // buscar todas as barbearias do dono
            $sql = "SELECT * FROM barbearia WHERE dono_id = ?";
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $dono_id);
            $stm->execute();
            $barbearias = $stm->fetchAll(PDO::FETCH_ASSOC);

            $retorno = [];

            foreach ($barbearias as $b) {
                // profissionais
                $sql = "SELECT nome FROM profissional WHERE barbearia_id = ?";
                $stm = $this->db->prepare($sql);
                $stm->bindValue(1, $b['id']);
                $stm->execute();
                $profissionais = $stm->fetchAll(PDO::FETCH_COLUMN);

                // serviços
                $sql = "SELECT nome FROM servico WHERE barbearia_id = ?";
                $stm = $this->db->prepare($sql);
                $stm->bindValue(1, $b['id']);
                $stm->execute();
                $servicos = $stm->fetchAll(PDO::FETCH_COLUMN);

                // dono
                $sql = "SELECT nome FROM dono WHERE id = ?";
                $stm = $this->db->prepare($sql);
                $stm->bindValue(1, $dono_id);
                $stm->execute();
                $nome_dono = $stm->fetchColumn();

                $obj = (object) [
                    'id' => $b['id'],
                    'nome' => $b['nome'],
                    'cnpj' => $b['cnpj'],
                    'telefone' => $b['telefone'],
                    'email' => $b['email'],
                    'endereco' => $b['endereco'],
                    'data_cadastro' => $b['data_cadastro'],
                    'imagem' => $b['imagem'],
                    'nome_dono' => $nome_dono,
                    'profissionais' => $profissionais,
                    'servicos' => $servicos
                ];

                $retorno[] = $obj;
            }

            return $retorno;
        } catch (PDOException $e) {
            die("Erro ao buscar barbearias: " . $e->getMessage());
        }
    }



    public function dadosDashboard($barbearia_id)
    {
        try {
            // total agendamentos do dia
            $sql = "SELECT COUNT(*) FROM agendamento WHERE DATE(data_hora) = CURDATE() AND barbearia_id = ?";
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $barbearia_id);
            $stm->execute();
            $agendamentos_dia = $stm->fetchColumn();

            // total clientes no mês
            $sql = "SELECT COUNT(DISTINCT cliente_id) FROM agendamento WHERE MONTH(data_hora) = MONTH(CURRENT_DATE()) AND barbearia_id = ?";
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $barbearia_id);
            $stm->execute();
            $clientes_mes = $stm->fetchColumn();

            // serviços realizados
            $sql = "SELECT COUNT(*) FROM agendamento WHERE status = 'concluido' AND barbearia_id = ?";
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $barbearia_id);
            $stm->execute();
            $servicos_realizados = $stm->fetchColumn();

            return (object) [
                'agendamentos_dia' => $agendamentos_dia,
                'clientes_mes' => $clientes_mes,
                'servicos_realizados' => $servicos_realizados
            ];
        } catch (PDOException $e) {
            die("Erro ao carregar dashboard: " . $e->getMessage());
        }
    }

    public function listarAgendamentosDia($barbearia_id)
    {
        $sql = "SELECT a.id, c.nome as cliente, a.data_hora, a.status, b.nome as barbearia
            FROM agendamento a
            JOIN cliente c ON c.id = a.cliente_id
            JOIN barbearia b ON b.id = a.barbearia_id
            WHERE DATE(a.data_hora) = CURDATE()
            AND a.barbearia_id = ?
            ORDER BY a.data_hora";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(1, $barbearia_id);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_OBJ);
    }


    public function listarClientesMes($barbearia_id)
    {
        $sql = "SELECT DISTINCT c.id, c.nome, c.telefone, c.email, b.nome as barbearia
            FROM agendamento a
            JOIN cliente c ON c.id = a.cliente_id
            JOIN barbearia b ON b.id = a.barbearia_id
            WHERE MONTH(a.data_hora) = MONTH(CURRENT_DATE())
            AND a.barbearia_id = ?";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(1, $barbearia_id);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_OBJ);
    }


    public function listarServicosRealizados($barbearia_id)
    {
        $sql = "SELECT a.id, c.nome as cliente, a.data_hora, s.nome as servico, b.nome as barbearia
            FROM agendamento a
            JOIN cliente c ON c.id = a.cliente_id
            JOIN servico s ON s.id = a.servico_id
            JOIN barbearia b ON b.id = a.barbearia_id
            WHERE a.status = 'concluido'
            AND a.barbearia_id = ?
            ORDER BY a.data_hora DESC";
        $stm = $this->db->prepare($sql);
        $stm->bindValue(1, $barbearia_id);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_OBJ);
    }



    public function buscarDadosGraficoBarras($barbearia_id)
    {
        try {
            $sql = "SELECT DAYNAME(data_hora) AS dia, COUNT(*) AS total
                FROM agendamento
                WHERE barbearia_id = ?
                GROUP BY dia
                ORDER BY WEEKDAY(data_hora)";
            $stm = $this->db->prepare($sql);
            $stm->bindValue(1, $barbearia_id);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die("Erro ao carregar gráfico de barras: " . $e->getMessage());
        }
    }

    public function buscarDadosGraficoPizza($barbearia_id)
    {
        try {
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

    public function dadosPDF($barbearia_id)
    {
        try {
            $sql = "SELECT a.data_hora, a.status, a.observacoes, c.nome AS cliente, b.nome AS barbearia, s.nome AS servico, p.nome AS profissional
            FROM agendamento a
            JOIN cliente c ON a.cliente_id = c.id
            JOIN servico s ON a.servico_id = s.id
            JOIN barbearia b ON a.barbearia_id = b.id
            JOIN profissional p ON a.profissional_id = p.id
            WHERE DATE(a.data_hora) = CURDATE()
              AND a.barbearia_id = ?
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
