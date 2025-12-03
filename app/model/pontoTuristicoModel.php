<?php

require_once __DIR__ . '/../../config/database.php';

class PontoTuristicoModel
{
    private $conn;

    private $tabela = "ponto_turistico";

    public function criarPontoTuristico($local, $nome, $descricao, $custo)
    {
        try {
            $query = "INSERT INTO $this->tabela (local, nome, descricao, custo)
                VALUE (:local, :nome, :descricao, :custo)
            ";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':local', $local);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':custo', $custo);
            $stmt->execute();
            return true;

        } catch (Exception $e) {
            $erro = $e->getMessage();
            return $erro;
        }
    }
}