<?php
class Agendamento
{
    public function __construct(
        private int $id = 0,
        private int $cliente_id = 0,
        private int $profissional_id = 0,
        private int $servico_id = 0,
        private string $data_hora = "",
        private string $status = "agendado",
        private string $observacoes = ""
    ) {}

    public function getId()
    {
        return $this->id;
    }
    public function getClienteId()
    {
        return $this->cliente_id;
    }
    public function getProfissionalId()
    {
        return $this->profissional_id;
    }
    public function getServicoId()
    {
        return $this->servico_id;
    }
    public function getDataHora()
    {
        return $this->data_hora;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function getObservacoes()
    {
        return $this->observacoes;
    }
}
