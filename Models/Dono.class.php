<?php
class Dono
{
    public function __construct(
        private int $id = 0,
        private string $nome = "",
        private string $telefone = "",
        private string $email = "",
        private string $senha = "",
        private string $data_cadastro = ""
    ) {}

    public function getId()
    {
        return $this->id;
    }
    public function getNome()
    {
        return $this->nome;
    }
    public function getTelefone()
    {
        return $this->telefone;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getSenha()
    {
        return $this->senha;
    }
    public function getDataCadastro()
    {
        return $this->data_cadastro;
    }

     // Método para buscar Dono pelo email no banco
    public static function buscarPorEmail(string $email): ?Dono
    {
        // Ajuste a conexão PDO conforme sua config
        $pdo = new PDO("mysql:host=localhost;dbname=seu_banco", "usuario", "senha");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT * FROM donos WHERE email = :email LIMIT 1");
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        // Retorna um objeto Dono preenchido
        return new Dono(
            (int)$row['id'],
            $row['nome'],
            $row['telefone'],
            $row['email'],
            $row['senha'],
            $row['data_cadastro']
        );
    }
}
