<?php
class servicoController
{
    private $param;

    public function __construct()
    {
        $this->param = Conexao::getInstancia();
    }

    /*public function listar_servicos_por_barbearia()
    {
        $servicoDAO = new ServicoDAO($this->param);
        $retornoServico = $servicoDAO->buscar_servicos_por_barbearia($barbearia_id);

    }*/
}
