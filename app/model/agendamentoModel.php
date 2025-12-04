<?php

require_once __DIR__ . '/../../config/database.php';

class AgendamentoModel
{
    private $conn;

    private $tabela = "agendamento";

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    public function criarAgendamento($id_instituicao, $id_ponto_turistico, $data_visita, $data_saida, $quantidade_aluno)
    {
        try {
            $query = "INSERT INTO $this->tabela (id_instituicao, id_ponto_turistico, data_visita, data_saida, quantidade_aluno)
                VALUE (:id_instituicao, :id_ponto_turistico, :data_visita, :data_saida, :quantidade_aluno)
            ";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_instituicao', $id_instituicao);
            $stmt->bindParam(':id_ponto_turistico', $id_ponto_turistico);
            $stmt->bindParam(':data_visita', $data_visita);
            $stmt->bindParam(':data_saida', $data_saida);
            $stmt->bindParam(':quantidade_aluno', $quantidade_aluno);
            $stmt->execute();
            return true;
            
        } catch (Exception $e) {
            $erro = $e->getMessage();
            return $erro;
        }
    }

    public function listarPorInstituicao($id_instituicao)
    {
        try {
            $query = "SELECT a.*, pt.nome as ponto_nome, pt.local, pt.descricao, pt.custo FROM $this->tabela a JOIN ponto_turistico pt ON a.id_ponto_turistico = pt.id_ponto_turistico WHERE a.id_instituicao = :id_instituicao ORDER BY a.data_visita DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_instituicao', $id_instituicao);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    public function getStatsForInstituicao($id_instituicao)
    {
        try {
            $query = "SELECT COUNT(*) as total_visitas, SUM(quantidade_aluno) as total_alunos, SUM(CASE WHEN data_visita >= CURDATE() THEN 1 ELSE 0 END) as futuras_visitas FROM $this->tabela WHERE id_instituicao = :id_instituicao";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_instituicao', $id_instituicao);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['total_visitas' => 0, 'total_alunos' => 0, 'futuras_visitas' => 0];
        }
    }
}
