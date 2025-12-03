<?php
session_start();
require_once __DIR__ . '/../config/database.php';

// Verificar se está logado
if (!isset($_SESSION['tipo_usuario'])) {
    header('Location: login-professor.php');
    exit;
}

try {
    $pdo = getConnection();
    
    if ($_SESSION['tipo_usuario'] === 'professor') {
        // Para professores, mostrar visitas da instituição
        $stmt = $pdo->prepare("
            SELECT a.*, pt.nome as ponto_nome, pt.local, pt.descricao, pt.custo, 
                   i.nome as instituicao_nome
            FROM agendamento a
            JOIN ponto_turistico pt ON a.id_ponto_turistico = pt.id_ponto_turistico
            JOIN instituicao i ON a.id_instituicao = i.id_instituicao
            WHERE a.id_instituicao = ?
            ORDER BY a.data_visita DESC
        ");
        $stmt->execute([$_SESSION['id_instituicao']]);
    } elseif ($_SESSION['tipo_usuario'] === 'instituicao') {
        // Para instituições, mostrar todas as visitas da instituição
        $stmt = $pdo->prepare("
            SELECT a.*, pt.nome as ponto_nome, pt.local, pt.descricao, pt.custo
            FROM agendamento a
            JOIN ponto_turistico pt ON a.id_ponto_turistico = pt.id_ponto_turistico
            WHERE a.id_instituicao = ?
            ORDER BY a.data_visita DESC
        ");
        $stmt->execute([$_SESSION['id_usuario']]);
    }
    
    $visitas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $visitas = [];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Visitas - Rolezão Escolar</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <div class="navbar-brand">
                <a href="../index.php" style="text-decoration: none; color: white;">
                    <h1>🎒 Rolezão Escolar</h1>
                </a>
            </div>
            <ul class="navbar-menu">
                <li><a href="../index.php">Início</a></li>
                <?php if ($_SESSION['tipo_usuario'] === 'professor'): ?>
                    <li><a href="agendar-visita.php">Agendar Visita</a></li>
                    <li><a href="minhas-visitas.php">Minhas Visitas</a></li>
                <?php elseif ($_SESSION['tipo_usuario'] === 'instituicao'): ?>
                    <li><a href="dashboard-instituicao.php">Dashboard</a></li>
                    <li><a href="minhas-visitas.php">Visitas</a></li>
                <?php endif; ?>
                <li><a href="ranking.php">Ranking</a></li>
                <li><a href="../auth/logout.php">Sair</a></li>
            </ul>
        </div>
    </nav>

    <div class="page-container">
        <div class="card" style="margin-top: 2rem;">
            <div class="card-header">
                <h2>📋 Minhas Visitas</h2>
            </div>
            <div class="card-body">
                <?php if (empty($visitas)): ?>
                    <div class="alert alert-info">
                        ℹ️ Você ainda não possui visitas agendadas.
                        <?php if ($_SESSION['tipo_usuario'] === 'professor'): ?>
                            <a href="agendar-visita.php" style="color: var(--primary);">Agendar uma visita</a>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Local Turístico</th>
                                    <th>Localização</th>
                                    <th>Data de Início</th>
                                    <th>Data de Saída</th>
                                    <th>Alunos</th>
                                    <th>Custo Total</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($visitas as $visita): ?>
                                    <?php 
                                        $dataInicio = new DateTime($visita['data_visita']);
                                        $dataFim = new DateTime($visita['data_saida']);
                                        $dias = $dataInicio->diff($dataFim)->days + 1;
                                        $custoTotal = $visita['custo'] * $visita['quantidade_aluno'] * $dias;
                                    ?>
                                    <tr>
                                        <td>
                                            <strong><?php echo htmlspecialchars($visita['ponto_nome']); ?></strong>
                                        </td>
                                        <td><?php echo htmlspecialchars($visita['local']); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($visita['data_visita'])); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($visita['data_saida'])); ?></td>
                                        <td><?php echo $visita['quantidade_aluno']; ?></td>
                                        <td><strong>R$ <?php echo number_format($custoTotal, 2, ',', '.'); ?></strong></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" onclick="verDetalhes(<?php echo $visita['id_agendamento']; ?>)">Ver</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Resumo de estatísticas -->
                    <div style="margin-top: 2rem; background: var(--light); padding: 1.5rem; border-radius: 8px;">
                        <h3 style="margin-top: 0; color: var(--primary);">📊 Resumo</h3>
                        <div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));">
                            <div style="background: white; padding: 1rem; border-radius: 8px; text-align: center;">
                                <p style="margin: 0; color: #666; font-size: 0.9rem;">Total de Visitas</p>
                                <h4 style="margin: 0.5rem 0 0 0; color: var(--primary);"><?php echo count($visitas); ?></h4>
                            </div>
                            <div style="background: white; padding: 1rem; border-radius: 8px; text-align: center;">
                                <p style="margin: 0; color: #666; font-size: 0.9rem;">Alunos Viajados</p>
                                <h4 style="margin: 0.5rem 0 0 0; color: var(--success);"><?php echo array_sum(array_map(fn($v) => $v['quantidade_aluno'], $visitas)); ?></h4>
                            </div>
                            <div style="background: white; padding: 1rem; border-radius: 8px; text-align: center;">
                                <p style="margin: 0; color: #666; font-size: 0.9rem;">Investimento Total</p>
                                <h4 style="margin: 0.5rem 0 0 0; color: var(--danger);">
                                    R$ <?php 
                                        $total = 0;
                                        foreach ($visitas as $v) {
                                            $d1 = new DateTime($v['data_visita']);
                                            $d2 = new DateTime($v['data_saida']);
                                            $dias = $d1->diff($d2)->days + 1;
                                            $total += $v['custo'] * $v['quantidade_aluno'] * $dias;
                                        }
                                        echo number_format($total, 2, ',', '.');
                                    ?>
                                </h4>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Rolezão Escolar. Todos os direitos reservados.</p>
    </footer>

    <script>
        function verDetalhes(id) {
            alert('Detalhes da visita ID: ' + id);
        }
    </script>
</body>
</html>
