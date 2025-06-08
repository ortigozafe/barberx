<?php
class DonoDAO
{
    public function __construct(private $db = null) {}

    public function salvar(Dono $dono)
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

    public function buscar_por_email(string $email)
    {
        $sql = "SELECT * FROM dono WHERE email = ?";
        try {
            $stm = $this->db->prepare($sql);
            $stm->execute([$email]);
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            die("Erro ao buscar dono");
        }
    }

    public function buscar_por_telefone(string $telefone)
    {
        $sql = "SELECT * FROM dono WHERE telefone = ?";
        $stm = $this->db->prepare($sql);
        $stm->execute([$telefone]);
        return $stm->fetch(PDO::FETCH_ASSOC);
    }
}
