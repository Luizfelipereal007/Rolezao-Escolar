<?php

require_once __DIR__ . '/../../config/database.php';

class InstituicaoModel
{
    private $conn;

    private $tabela = "instituicao";

    public function criarInstituicao($nome, $localizacao, $cnpj)
    {
        try {
            $query = "INSERT INTO $this->tabela (nome, localizacao, cnpj)
                VALUE (:nome, :localizacao, :cnpj)
            ";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':localizacao', $localizacao);
            $stmt->bindParam(':cnpj', $cnpj);
            $stmt->execute();
            return true;

        } catch (Exception $e) {
            $erro = $e->getMessage();
            return $erro;
        }
    }
}