<?php

require_once __DIR__ . '/../../config/database.php';

class InstituicaoModel
{
    private $conn;
    private $tabela = "instituicao";

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    // Função para criar uma nova instituição
    public function criarInstituicao($nome, $localizacao, $cnpj, $senha)
    {
        try {
            // Hashificando a senha antes de armazenar
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            $query = "INSERT INTO $this->tabela (nome, localizacao, cnpj, senha)
                      VALUES (:nome, :localizacao, :cnpj, :senha)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':localizacao', $localizacao);
            $stmt->bindParam(':cnpj', $cnpj);
            $stmt->bindParam(':senha', $senhaHash);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Função para listar todas as instituições
    public function listarInstituicoes()
    {
        try {
            $query = "SELECT * FROM $this->tabela";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Função para editar uma instituição
    public function editarInstituicao($id, $nome, $localizacao, $cnpj, $senha = null)
    {
        try {
            if ($senha) {
                // Hashificando a senha se foi passada
                $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
                $query = "UPDATE $this->tabela SET nome = :nome, localizacao = :localizacao, cnpj = :cnpj, senha = :senha WHERE id = :id";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':senha', $senhaHash);
            } else {
                // Caso não queira mudar a senha
                $query = "UPDATE $this->tabela SET nome = :nome, localizacao = :localizacao, cnpj = :cnpj WHERE id = :id";
                $stmt = $this->conn->prepare($query);
            }

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':localizacao', $localizacao);
            $stmt->bindParam(':cnpj', $cnpj);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Função para excluir uma instituição
    public function excluirInstituicao($id)
    {
        try {
            $query = "DELETE FROM $this->tabela WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    // Função para validar a senha (caso você precise fazer login)
    public function validarSenha($id, $senha)
    {
        try {
            $query = "SELECT senha FROM $this->tabela WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resultado && password_verify($senha, $resultado['senha'])) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    // Recuperar instituição por id
    public function getInstituicaoById($id)
    {
        try {
            $query = "SELECT * FROM $this->tabela WHERE id_instituicao = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return null;
        }
    }

    // Verificar existência por CNPJ
    public function existsByCnpj($cnpj)
    {
        try {
            $query = "SELECT id_instituicao FROM $this->tabela WHERE cnpj = :cnpj";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':cnpj', $cnpj);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            return false;
        }
    }
}
