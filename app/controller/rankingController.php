<?php
require_once __DIR__ . '/../model/rankingModel.php';

class RankingController {
    private $model;

    public function __construct() {
        $this->model = new RankingModel();
    }

    public function getPontosRanking() {
        return $this->model->getPontosRanking();
    }

    public function getEscolasRanking($limit = 10) {
        return $this->model->getEscolasRanking($limit);
    }
}

?>
