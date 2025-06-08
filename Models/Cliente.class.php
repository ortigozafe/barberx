<?php
class Cliente
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
}
