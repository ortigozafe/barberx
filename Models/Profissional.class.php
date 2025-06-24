<?php
class Profissional
{
    public function __construct(
        private int $id = 0,
        private string $nome = "",
        private string $telefone = "",
        private string $email = "",
        private string $especialidade = "",
        private $barbearia = null
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
    public function getEspecialidade()
    {
        return $this->especialidade;
    }
    public function getBarbearia()
    {
        return $this->barbearia;
    }
}
