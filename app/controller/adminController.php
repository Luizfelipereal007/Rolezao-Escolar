<?php
// Controller básico para ações administrativas
require_once __DIR__ . '/../model/rankingModel.php';

class AdminController {
    private $rankingModel;

    public function __construct() {
        $this->rankingModel = new RankingModel();
    }

    public function obterEstatisticasBasicas() {
        // Exemplo simples: reusar ranking para estatísticas
        return [
            'pontos' => $this->rankingModel->getPontosRanking(),
            'escolas' => $this->rankingModel->getEscolasRanking(10)
        ];
    }
}

?>
