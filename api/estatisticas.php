<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/database.php';

try {
    $pdo = getConnection();
    
    // Calcular estatísticas
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM agendamento");
    $stmt->execute();
    $total_visitas = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM instituicao");
    $stmt->execute();
    $total_escolas = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    $stmt = $pdo->prepare("SELECT COALESCE(SUM(quantidade_aluno), 0) as total FROM agendamento");
    $stmt->execute();
    $total_alunos = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM ponto_turistico");
    $stmt->execute();
    $total_lugares = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    echo json_encode([
        'total_visitas' => $total_visitas,
        'total_escolas' => $total_escolas,
        'total_alunos' => $total_alunos,
        'total_lugares' => $total_lugares
    ]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
