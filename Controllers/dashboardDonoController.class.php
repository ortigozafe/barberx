<?php

class dashboardDonoController
{
    private $conexao;

    public function __construct()
    {
        $this->conexao = Conexao::getInstancia();
    }

    public function index()
    {
        session_start();

        if (!isset($_SESSION["dono_id"])) {
            header("Location: /login_dono");
            exit;
        }

        $dono_id = $_SESSION["dono_id"];

        $dados = [];

        // Buscar a barbearia do dono
        $sql = "SELECT id FROM barbearia WHERE dono_id = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([$dono_id]);
        $barbearia = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$barbearia) {
            $dados["erro"] = "Nenhuma barbearia encontrada.";
            require_once "Views/dashboard_dono.php";
            return;
        }

        $barbearia_id = $barbearia["id"];

        // Total de agendamentos do dia
        $sql = "SELECT COUNT(*) AS total FROM agendamento a
                JOIN profissional p ON a.profissional_id = p.id
                WHERE DATE(a.data_hora) = CURDATE() AND p.barbearia_id = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([$barbearia_id]);
        $dados["agendamentos_dia"] = $stmt->fetchColumn();

        // Total de clientes no mês
        $sql = "SELECT COUNT(DISTINCT cliente_id) AS total FROM agendamento a
                JOIN profissional p ON a.profissional_id = p.id
                WHERE MONTH(a.data_hora) = MONTH(CURRENT_DATE()) AND p.barbearia_id = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([$barbearia_id]);
        $dados["clientes_mes"] = $stmt->fetchColumn();

        // Total de serviços realizados (status = concluído)
        $sql = "SELECT COUNT(*) FROM agendamento a
                JOIN profissional p ON a.profissional_id = p.id
                WHERE a.status = 'concluido' AND p.barbearia_id = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([$barbearia_id]);
        $dados["servicos_realizados"] = $stmt->fetchColumn();

        // Dados para gráfico de pizza (agendados x cancelados)
        $sql = "SELECT status, COUNT(*) AS total FROM agendamento a
                JOIN profissional p ON a.profissional_id = p.id
                WHERE p.barbearia_id = ?
                GROUP BY status";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([$barbearia_id]);
        $pizza = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $dados["grafico_pizza"] = $pizza;

        // Dados para gráfico de barras (quantidade de agendamentos por dia da semana)
        $sql = "SELECT DAYNAME(data_hora) AS dia, COUNT(*) AS total
                FROM agendamento a
                JOIN profissional p ON a.profissional_id = p.id
                WHERE p.barbearia_id = ?
                GROUP BY dia";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([$barbearia_id]);
        $barras = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $dados["grafico_barras"] = $barras;

        // Dados dos serviços do dia (para PDF)
        $sql = "SELECT a.data_hora, c.nome AS cliente, s.nome AS servico, p.nome AS profissional
                FROM agendamento a
                JOIN cliente c ON a.cliente_id = c.id
                JOIN servico s ON a.servico_id = s.id
                JOIN profissional p ON a.profissional_id = p.id
                WHERE DATE(a.data_hora) = CURDATE() AND p.barbearia_id = ?
                ORDER BY a.data_hora";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([$barbearia_id]);
        $dados["servicos_hoje"] = $stmt->fetchAll(PDO::FETCH_OBJ);

        require_once "Views/dashboard_dono.php";
    }

    public function gerarPDF()
    {
        session_start();

        if (!isset($_SESSION["dono_id"])) {
            header("Location: /login_dono");
            exit;
        }

        $dono_id = $_SESSION["dono_id"];

        $sql = "SELECT id FROM barbearia WHERE dono_id = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([$dono_id]);
        $barbearia = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$barbearia) {
            echo "Barbearia não encontrada";
            exit;
        }

        $barbearia_id = $barbearia["id"];

        $sql = "SELECT a.data_hora, c.nome AS cliente, s.nome AS servico, p.nome AS profissional
                FROM agendamento a
                JOIN cliente c ON a.cliente_id = c.id
                JOIN servico s ON a.servico_id = s.id
                JOIN profissional p ON a.profissional_id = p.id
                WHERE DATE(a.data_hora) = CURDATE() AND p.barbearia_id = ?
                ORDER BY a.data_hora";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([$barbearia_id]);
        $ret = $stmt->fetchAll(PDO::FETCH_OBJ);

        if (count($ret) > 0) {
            require_once "Views/pdf_dia.php";
        } else {
            echo "<script>alert('Nenhum serviço agendado para hoje.'); location.href='/dashboard';</script>";
        }
    }
}
