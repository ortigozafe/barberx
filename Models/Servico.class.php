<?php
class Servico
{
    public function __construct(
        private int $id = 0,
        private string $nome = "",
        private string $descricao = "",
        private float $preco = 0.0,
        private int $duracao_minutos = 0,
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
    public function getDescricao()
    {
        return $this->descricao;
    }
    public function getPreco()
    {
        return $this->preco;
    }
    public function getDuracaoMinutos()
    {
        return $this->duracao_minutos;
    }
    public function getBarbearia()
    {
        return $this->barbearia;
    }
}
