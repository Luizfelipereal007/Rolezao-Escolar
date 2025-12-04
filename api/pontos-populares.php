<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/database.php';

try {
    $pdo = getConnection();
    
    // Carregar pontos turísticos com contagem de visitas
    $stmt = $pdo->prepare("
        SELECT pt.*, COUNT(a.id_agendamento) as visitas
        FROM ponto_turistico pt
        LEFT JOIN agendamento a ON pt.id_ponto_turistico = a.id_ponto_turistico
        GROUP BY pt.id_ponto_turistico
        ORDER BY visitas DESC
        LIMIT 6
    ");
    $stmt->execute();
    $pontos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($pontos);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
