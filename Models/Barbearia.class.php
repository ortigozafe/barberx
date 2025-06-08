<?php
class Barbearia
{
    public function __construct(
        private int $id = 0,
        private string $nome = "",
        private string $cnpj = "",
        private string $telefone = "",
        private string $email = "",
        private string $endereco = "",
        private int $dono_id = 0,
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
    public function getCnpj()
    {
        return $this->cnpj;
    }
    public function getTelefone()
    {
        return $this->telefone;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getEndereco()
    {
        return $this->endereco;
    }
    public function getDonoId()
    {
        return $this->dono_id;
    }
    public function getDataCadastro()
    {
        return $this->data_cadastro;
    }
}
