<?php

require_once __DIR__ . '/../../config/database.php';

class RankingModel {

    public function getPontosRanking() {
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT pt.*, COUNT(a.id_agendamento) as total_visitas, SUM(a.quantidade_aluno) as total_alunos FROM ponto_turistico pt LEFT JOIN agendamento a ON pt.id_ponto_turistico = a.id_ponto_turistico GROUP BY pt.id_ponto_turistico ORDER BY total_visitas DESC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

    public function getEscolasRanking($limit = 10) {
        try {
            $pdo = Database::getConnection();
            $stmt = $pdo->prepare("SELECT i.*, COUNT(a.id_agendamento) as total_visitas, SUM(a.quantidade_aluno) as total_alunos FROM instituicao i LEFT JOIN agendamento a ON i.id_instituicao = a.id_instituicao GROUP BY i.id_instituicao ORDER BY total_visitas DESC LIMIT ?");
            $stmt->bindParam(1, $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }
}

?>
