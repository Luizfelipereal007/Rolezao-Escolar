<?php
require_once __DIR__ . '/../model/agendamentoModel.php';

class AgendamentoController {
    private $model;

    public function __construct() {
        $this->model = new AgendamentoModel();
    }

    public function criar($id_instituicao, $id_ponto_turistico, $data_visita, $data_saida, $quantidade_aluno) {
        return $this->model->criarAgendamento($id_instituicao, $id_ponto_turistico, $data_visita, $data_saida, $quantidade_aluno);
    }

    public function listarPorInstituicao($id_instituicao) {
        return $this->model->listarPorInstituicao($id_instituicao);
    }

    public function getStatsForInstituicao($id_instituicao) {
        return $this->model->getStatsForInstituicao($id_instituicao);
    }
}

?>
