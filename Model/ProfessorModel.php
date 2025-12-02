<?php

require_once __DIR__ . '/../config/database.php';

class InstituicaoModel
{
    private $conn;

    private $tabela = "professor";

    public function criarProfessor($nome, $senha, $id_instituicao)
    {
        try {
            $query = "INSERT INTO $this->tabela (nome, senha, id_instituicao)
                VALUE (:nome, :senha, :id_instituicao)
            ";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':senha', $senha);
            $stmt->bindParam(':id_instituicao', $id_instituicao);
            $stmt->execute();
            return true;

        } catch (Exception $e) {
            $erro = $e->getMessage();
            return $erro;
        }
    }
}