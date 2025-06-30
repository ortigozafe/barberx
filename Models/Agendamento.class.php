<?php
class Agendamento
{
    public function __construct(
        private int $id = 0,
        private $cliente = null,
        private $profissional = null,
        private $servico = null,
        private $barbearia = null,
        private string $data_hora = "",
        private string $status = "agendado",
        private string $observacoes = ""
    ) {}

    public function getId()
    {
        return $this->id;
    }
    public function getCliente()
    {
        return $this->cliente;
    }
    public function getProfissional()
    {
        return $this->profissional;
    }
    public function getServico()
    {
        return $this->servico;
    }
    public function getBarbearia()
    {
        return $this->barbearia;
    }
    public function getDataHora()
    {
        return $this->data_hora;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function setStatus($status)
    {
        $this->status = $status;
    }
    public function getObservacoes()
    {
        return $this->observacoes;
    }
}
