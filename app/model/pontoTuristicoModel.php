<?php

require_once __DIR__ . '/../../config/database.php';

class PontoTuristicoModel
{
    private $conn;

    private $tabela = "ponto_turistico";

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

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
    public function listarPontosTuristicos()
    {
        try {
            $query = "SELECT * FROM $this->tabela ORDER BY nome";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            $erro = $e->getMessage();
            return $erro;
        }
    }

    public function atualizarPontoTuristico($id_ponto_turistico, $local, $nome, $descricao, $custo)
    {
        try {
            $query = "UPDATE $this->tabela 
                SET local = :local, nome = :nome, descricao = :descricao, custo = :custo 
                WHERE id_ponto_turistico = :id_ponto_turistico
            ";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_ponto_turistico', $id_ponto_turistico);
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

    public function excluirPontoTuristico($id_ponto_turistico)
    {
        try {
            $query = "DELETE FROM $this->tabela WHERE id_ponto_turistico = :id_ponto_turistico";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_ponto_turistico', $id_ponto_turistico);
            $stmt->execute();
            return true;

        } catch (Exception $e) {
            $erro = $e->getMessage();
            return $erro;
        }
    }
}