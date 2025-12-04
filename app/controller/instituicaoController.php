<?php
require_once __DIR__ . '/../model/instituicaoModel.php';

class InstituicaoController {
    private $model;

    public function __construct() {
        $this->model = new InstituicaoModel();
    }

    public function criar($nome, $localizacao, $cnpj, $senha) {
        return $this->model->criarInstituicao($nome, $localizacao, $cnpj, $senha);
    }

    public function listar() {
        return $this->model->listarInstituicoes();
    }

    public function getById($id) {
        return $this->model->getInstituicaoById($id);
    }

    public function existsByCnpj($cnpj) {
        return $this->model->existsByCnpj($cnpj);
    }

    public function editar($id, $nome, $localizacao, $cnpj, $senha = null) {
        return $this->model->editarInstituicao($id, $nome, $localizacao, $cnpj, $senha);
    }

    public function excluir($id) {
        return $this->model->excluirInstituicao($id);
    }
}

?>
