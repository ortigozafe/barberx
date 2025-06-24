<?php
class ProfissionalDAO
{
    public function __construct(private $db = null) {}

    public function salvar(Profissional $profissional): bool
    {
        $sql = "INSERT INTO profissional (nome, telefone, email, especialidade, barbearia_id) VALUES (?, ?, ?, ?, ?)";
        try {
            $stm = $this->db->prepare($sql);
            return $stm->execute([
                $profissional->getNome(),
                $profissional->getTelefone(),
                $profissional->getEmail(),
                $profissional->getEspecialidade(),
                $profissional->getBarbearia()->getId()
            ]);
        } catch (PDOException $e) {
            die("Erro ao salvar profissional: " . $e->getMessage());
        }
    }

    public function buscarPorId(int $id): ?Profissional
    {
        $sql = "SELECT p.*, 
                       b.nome AS barbearia_nome, b.cnpj, b.telefone AS barbearia_telefone, 
                       b.email AS barbearia_email, b.endereco, b.data_cadastro, b.imagem, 
                       d.id AS dono_id, d.nome AS dono_nome, d.telefone AS dono_telefone, 
                       d.email AS dono_email, d.senha AS dono_senha
                FROM profissional p
                JOIN barbearia b ON p.barbearia_id = b.id
                JOIN dono d ON b.dono_id = d.id
                WHERE p.id = ?";
        
        try {
            $stm = $this->db->prepare($sql);
            $stm->execute([$id]);
            $dados = $stm->fetch(PDO::FETCH_ASSOC);

            if (!$dados) {
                return null;
            }

            $dono = new Dono(
                $dados['dono_id'],
                $dados['dono_nome'],
                $dados['dono_telefone'],
                $dados['dono_email'],
                $dados['dono_senha']
            );

            $barbearia = new Barbearia(
                $dados['barbearia_id'],
                $dados['barbearia_nome'],
                $dados['cnpj'],
                $dados['barbearia_telefone'],
                $dados['barbearia_email'],
                $dados['endereco'],
                $dono, // Objeto Dono
                $dados['data_cadastro'],
                $dados['imagem']
            );

            return new Profissional(
                $dados['id'],
                $dados['nome'],
                $dados['telefone'],
                $dados['email'],
                $dados['especialidade'],
                $dados['barbearia_id']
            );

        } catch (PDOException $e) {
            die("Erro ao buscar profissional por ID: " . $e->getMessage());
        }
    }

    public function buscarPorTelefone(string $telefone): ?Profissional
    {
        $sql = "SELECT p.*, 
                       b.nome AS barbearia_nome, b.cnpj, b.telefone AS barbearia_telefone, 
                       b.email AS barbearia_email, b.endereco, b.data_cadastro, b.imagem, 
                       d.id AS dono_id, d.nome AS dono_nome, d.telefone AS dono_telefone, 
                       d.email AS dono_email, d.senha AS dono_senha
                FROM profissional p
                JOIN barbearia b ON p.barbearia_id = b.id
                JOIN dono d ON b.dono_id = d.id
                WHERE p.telefone = ?";
        
        try {
            $stm = $this->db->prepare($sql);
            $stm->execute([$telefone]);
            $dados = $stm->fetch(PDO::FETCH_ASSOC);

            if (!$dados) {
                return null;
            }

            $dono = new Dono(
                $dados['dono_id'],
                $dados['dono_nome'],
                $dados['dono_telefone'],
                $dados['dono_email'],
                $dados['dono_senha']
            );

            $barbearia = new Barbearia(
                $dados['barbearia_id'],
                $dados['barbearia_nome'],
                $dados['cnpj'],
                $dados['barbearia_telefone'],
                $dados['barbearia_email'],
                $dados['endereco'],
                $dono, 
                $dados['data_cadastro'],
                $dados['imagem']
            );

            return new Profissional(
                $dados['id'],
                $dados['nome'],
                $dados['telefone'],
                $dados['email'],
                $dados['especialidade'],
                $dados['barbearia_id'] 
            );

        } catch (PDOException $e) {
            die("Erro ao buscar profissional por telefone: " . $e->getMessage());
        }
    }

    public function buscarProfissionaisPorBarbearia(int $barbearia_id): array
    {
        $sql = "SELECT p.*, 
                       b.nome AS barbearia_nome, b.cnpj, b.telefone AS barbearia_telefone, 
                       b.email AS barbearia_email, b.endereco, b.data_cadastro, b.imagem, 
                       d.id AS dono_id, d.nome AS dono_nome, d.telefone AS dono_telefone, 
                       d.email AS dono_email, d.senha AS dono_senha
                FROM profissional p
                JOIN barbearia b ON p.barbearia_id = b.id
                JOIN dono d ON b.dono_id = d.id
                WHERE p.barbearia_id = ?";
        
        try {
            $stm = $this->db->prepare($sql);
            $stm->execute([$barbearia_id]);
            $resultados = $stm->fetchAll(PDO::FETCH_ASSOC);

            $profissionais = [];
            foreach ($resultados as $dados) {
                $dono = new Dono(
                    $dados['dono_id'],
                    $dados['dono_nome'],
                    $dados['dono_telefone'],
                    $dados['dono_email'],
                    $dados['dono_senha']
                );

                $barbearia = new Barbearia(
                    $dados['barbearia_id'],
                    $dados['barbearia_nome'],
                    $dados['cnpj'],
                    $dados['barbearia_telefone'],
                    $dados['barbearia_email'],
                    $dados['endereco'],
                    $dono, // Objeto Dono
                    $dados['data_cadastro'],
                    $dados['imagem']
                );

                $profissionais[] = new Profissional(
                    $dados['id'],
                    $dados['nome'],
                    $dados['telefone'],
                    $dados['email'],
                    $dados['especialidade'],
                    $dados['barbearia_id']
                );
            }
            return $profissionais;

        } catch (PDOException $e) {
            die("Erro ao buscar profissionais por barbearia: " . $e->getMessage());
        }
    }
}