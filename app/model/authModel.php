<?php

require_once __DIR__ . '/../../config/database.php';

class AuthModel {

    public function loginProfessor($id_professor, $senha) {
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT p.id_professor, p.nome, p.senha, p.id_instituicao, i.nome as instituicao_nome FROM professor p JOIN instituicao i ON p.id_instituicao = i.id_instituicao WHERE p.id_professor = ?");
            $stmt->execute([$id_professor]);

            if ($stmt->rowCount() === 0) {
                return false;
            }

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($senha, $resultado['senha'])) {
                return [
                    'id_professor' => $resultado['id_professor'],
                    'nome' => $resultado['nome'],
                    'id_instituicao' => $resultado['id_instituicao'],
                    'instituicao_nome' => $resultado['instituicao_nome']
                ];
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    public function loginInstituicao($cnpj, $senha) {
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT id_instituicao, nome, senha FROM instituicao WHERE cnpj = ?");
            $stmt->execute([$cnpj]);

            if ($stmt->rowCount() === 0) {
                return false;
            }

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($senha, $resultado['senha'])) {
                return [
                    'id_instituicao' => $resultado['id_instituicao'],
                    'nome' => $resultado['nome']
                ];
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    public function loginAdmin($senha) {
        // Senha estática por enquanto — centraliza o check aqui
        $senha_admin_correta = 'admin123';
        return $senha === $senha_admin_correta;
    }

    public function loginProfessorByName($nome, $senha) {
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT p.id_professor, p.nome, p.senha, p.id_instituicao, i.nome as instituicao_nome FROM professor p JOIN instituicao i ON p.id_instituicao = i.id_instituicao WHERE p.nome = ?");
            $stmt->execute([$nome]);

            if ($stmt->rowCount() === 0) {
                return false;
            }

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($senha, $resultado['senha'])) {
                return [
                    'id_professor' => $resultado['id_professor'],
                    'nome' => $resultado['nome'],
                    'id_instituicao' => $resultado['id_instituicao'],
                    'instituicao_nome' => $resultado['instituicao_nome']
                ];
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }
}

?>
