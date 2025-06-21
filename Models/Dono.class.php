<?php
class Dono
{
    public function __construct(
        private int $id = 0,
        private string $nome = "",
        private string $telefone = "",
        private string $email = "",
        private string $senha = ""
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getTelefone(): string
    {
        return $this->telefone;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getSenha(): string
    {
        return $this->senha;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }
}
