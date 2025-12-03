<?php
// Script de diagnóstico para testar models e conexão
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h2>Teste de Models e Conexão</h2>";

try {
    require_once __DIR__ . '/../app/model/authModel.php';
    require_once __DIR__ . '/../app/model/rankingModel.php';
    require_once __DIR__ . '/../app/model/pontoTuristicoModel.php';
    require_once __DIR__ . '/../app/model/agendamentoModel.php';

    echo "Requisições de arquivos OK.<br>";

    // Testar conexão direta
    require_once __DIR__ . '/../config/database.php';
    $pdo = Database::getConnection();
    if ($pdo) echo "Conexão com DB OK.<br>";

    // Instanciar modelos
    $auth = new AuthModel();
    echo "AuthModel instanciado com sucesso.<br>";

    $ranking = new RankingModel();
    echo "RankingModel instanciado com sucesso.<br>";

    $ponto = new PontoTuristicoModel();
    echo "PontoTuristicoModel instanciado com sucesso.<br>";

    $agendamento = new AgendamentoModel();
    echo "AgendamentoModel instanciado com sucesso.<br>";

    echo "<p style='color:green;'>Todos os testes executaram sem lançar exceções.</p>";

} catch (Throwable $t) {
    echo "<p style='color:red;'><strong>Erro detectado:</strong> " . htmlspecialchars($t->getMessage()) . "</p>";
    echo "<pre>" . htmlspecialchars($t->getTraceAsString()) . "</pre>";
}

?>
