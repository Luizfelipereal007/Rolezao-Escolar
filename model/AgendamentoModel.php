<?php

require_once __DIR__ . '/../config/database.php';

class AgendamentoModel
{
    private $conn;

    private $tabela = "agendamento";

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
}
