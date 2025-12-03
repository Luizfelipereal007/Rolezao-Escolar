<?php
require_once 'database.php';

echo "<h2>Teste Banco</h2>";

try {
    $pdo = getConnection();
    echo "<p>Conexão OK!</p>";
    
    $stmt = $pdo->query("SELECT * FROM ponto_turistico");
    $pontos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<p>Registros: " . count($pontos) . "</p>";
    
    foreach ($pontos as $ponto) {
        echo "<p>" . $ponto['nome'] . " - " . $ponto['local'] . " - " . $ponto['descricao'] . " - R$ " . $ponto['custo'] . "</p>";
    }
    
} catch (Exception $e) {
    echo "<p>Erro: " . $e->getMessage() . "</p>";
}
?>