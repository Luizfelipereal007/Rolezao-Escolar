<?php
require_once __DIR__ . '/../model/pontoTuristicoModel.php';

class PontoTuristicoController {
    private $model;

    public function __construct() {
        $this->model = new PontoTuristicoModel();
    }

    public function criar($local, $nome, $descricao, $custo) {
        return $this->model->criarPontoTuristico($local, $nome, $descricao, $custo);
    }

    public function listar() {
        return $this->model->listarPontosTuristicos();
    }

    public function atualizar($id, $local, $nome, $descricao, $custo) {
        return $this->model->atualizarPontoTuristico($id, $local, $nome, $descricao, $custo);
    }

    public function excluir($id) {
        return $this->model->excluirPontoTuristico($id);
    }
}

?>
