<?php

require_once __DIR__ . '/../../config/database.php';

class ProfessorModel
{
    private $conn;

    private $tabela = "professor";

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    public function criarProfessor($nome, $senha, $id_instituicao)
    {
        try {
            // Hashificar a senha antes de armazenar
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
            
            $query = "INSERT INTO $this->tabela (nome, senha, id_instituicao)
                VALUE (:nome, :senha, :id_instituicao)
            ";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':senha', $senhaHash); 
            $stmt->bindParam(':id_instituicao', $id_instituicao);
            $stmt->execute();
            return true;

        } catch (Exception $e) {
            $erro = $e->getMessage();
            return $erro;
        }
    }
}