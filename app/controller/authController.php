<?php
require_once __DIR__ . '/../model/authModel.php';
require_once __DIR__ . '/../model/professorModel.php';
require_once __DIR__ . '/../model/instituicaoModel.php';

class AuthController {
    private $authModel;
    private $professorModel;
    private $instituicaoModel;

    public function __construct() {
        $this->authModel = new AuthModel();
        $this->professorModel = new ProfessorModel();
        $this->instituicaoModel = new InstituicaoModel();
    }

    // Delegates
    public function loginProfessor($id, $senha) {
        return $this->authModel->loginProfessor($id, $senha);
    }

    public function loginProfessorByName($nome, $senha) {
        return $this->authModel->loginProfessorByName($nome, $senha);
    }

    public function loginInstituicao($cnpj, $senha) {
        return $this->authModel->loginInstituicao($cnpj, $senha);
    }

    public function loginAdmin($senha) {
        return $this->authModel->loginAdmin($senha);
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        session_unset();
        session_destroy();
    }

    // Registro simples: reutiliza models existentes
    public function registerProfessor($nome, $senha, $id_instituicao) {
        return $this->professorModel->criarProfessor($nome, $senha, $id_instituicao);
    }

    public function registerInstituicao($nome, $localizacao, $cnpj, $senha) {
        return $this->instituicaoModel->criarInstituicao($nome, $localizacao, $cnpj, $senha);
    }
}

?>
