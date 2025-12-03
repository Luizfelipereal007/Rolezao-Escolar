<?php

require_once __DIR__ . '/../model/instituicaoModel.php';

class CadastrarInstituicao {

    private $instituicaoModel;

    public function __construct() {
        $this->instituicaoModel = new InstituicaoModel();
    }

    public function cadastrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'];
            $localizacao = $_POST['localizacao'];
            $cnpj = $_POST['cnpj'];
            $senha = $_POST['senha'];

            // Validando os dados
            if (empty($nome) || empty($localizacao) || empty($cnpj) || empty($senha)) {
                echo "Todos os campos são obrigatórios!";
                return;
            }

            // Chamando a função do model para criar a instituição
            $resultado = $this->instituicaoModel->criarInstituicao($nome, $localizacao, $cnpj, $senha);
            if ($resultado === true) {
                echo "Instituição cadastrada com sucesso!";
            } else {
                echo "Erro ao cadastrar instituição: " . $resultado;
            }
        }
    }

    public function listarInstituicoes() {
        return $this->instituicaoModel->listarInstituicoes();
    }

    public function editarInstituicao($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'];
            $localizacao = $_POST['localizacao'];
            $cnpj = $_POST['cnpj'];
            $senha = isset($_POST['senha']) ? $_POST['senha'] : null;

            // Chamando o model para editar a instituição
            $resultado = $this->instituicaoModel->editarInstituicao($id, $nome, $localizacao, $cnpj, $senha);
            if ($resultado === true) {
                echo "Instituição editada com sucesso!";
            } else {
                echo "Erro ao editar instituição: " . $resultado;
            }
        }
    }

    public function excluirInstituicao($id) {
        $resultado = $this->instituicaoModel->excluirInstituicao($id);
        if ($resultado === true) {
            echo "Instituição excluída com sucesso!";
        } else {
            echo "Erro ao excluir instituição: " . $resultado;
        }
    }
}
