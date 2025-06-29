<?php

class HorarioFuncionamento
{
    public function __construct(
        private int $id = 0,
        private $barbearia = null,
        private string $dia_semana = '',
        private string $horario_abertura = '',
        private string $horario_fechamento = ''
    ) {}

    public function getId()
    {
        return $this->id;
    }

    public function getBarbearia()
    {
        return $this->barbearia;
    }

    public function getDiaSemana()
    {
        return $this->dia_semana;
    }

    public function getHorarioAbertura()
    {
        return $this->horario_abertura;
    }

    public function getHorarioFechamento()
    {
        return $this->horario_fechamento;
    }
}
