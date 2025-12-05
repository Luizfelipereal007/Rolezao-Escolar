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
        <!-- Cabeçalho -->
        <div class="visits-header">
            <h1>📋 Minhas Visitas</h1>
            <p>Acompanhe todas as visitas agendadas</p>
        </div>

        <?php if (empty($visitas)): ?>
            <div class="alert alert-info">
                ℹ️ Você ainda não possui visitas agendadas.
                <?php if ($_SESSION['tipo_usuario'] === 'professor'): ?>
                    <a href="agendar-visita.php" style="color: var(--primary); font-weight: bold;">→ Agendar uma visita agora</a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <!-- Layout: Lista à esquerda + Resumo à direita -->
            <div class="visits-main-layout">
                <!-- COLUNA 1: Lista de Visitas -->
                <div class="visits-list-section">
                    <div class="card">
                        <div class="card-header">
                            <h2>Visitas Agendadas</h2>
                        </div>
                        <div class="card-body">
                            <div class="visits-list-cards">
                                <?php foreach ($visitas as $visita): ?>
                                    <?php
                                    $dataInicio = new DateTime($visita['data_visita']);
                                    $dataFim = new DateTime($visita['data_saida']);
                                    $dias = $dataInicio->diff($dataFim)->days + 1;
                                    $custoTotal = $visita['custo'] * $visita['quantidade_aluno'] * $dias;
                                    ?>
                                    <div class="visit-list-item">
                                        <div class="visit-item-header">
                                            <h3><?php echo htmlspecialchars($visita['ponto_nome']); ?></h3>
                                            <span class="visit-cost">R$ <?php echo number_format($custoTotal, 2, ',', '.'); ?></span>
                                        </div>
                                        <p class="visit-item-location">📍 <?php echo htmlspecialchars($visita['local']); ?></p>
                                        
                                        <!-- Status da Visita -->
                                        <div style="margin-bottom: 0.5rem;">
                                            <?php if ($visita['status'] === 'aprovado'): ?>
                                                <span style="background: #d4edda; color: #155724; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; font-weight: bold;">
                                                    ✅ Aprovado
                                                </span>
                                            <?php elseif ($visita['status'] === 'rejeitado'): ?>
                                                <span style="background: #f8d7da; color: #721c24; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; font-weight: bold;">
                                                    ❌ Rejeitado
                                                </span>
                                                <?php if (!empty($visita['motivo_rejeicao'])): ?>
                                                    <br><small style="color: #666; font-style: italic;">Motivo: <?php echo htmlspecialchars($visita['motivo_rejeicao']); ?></small>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span style="background: #fff3cd; color: #856404; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; font-weight: bold;">
                                                    ⏳ Pendente
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <div class="visit-item-dates">
                                            <span>🗓️ <?php echo date('d/m/Y', strtotime($visita['data_visita'])); ?></span>
                                            <span>→</span>
                                            <span><?php echo date('d/m/Y', strtotime($visita['data_saida'])); ?></span>
                                        </div>
                                        <div class="visit-item-info">
                                            <span>👥 <?php echo $visita['quantidade_aluno']; ?> alunos</span>
                                            <span>📅 <?php echo $dias; ?> dia(s)</span>
                                            <span>💵 R$ <?php echo number_format($visita['custo'], 2, ',', '.'); ?>/aluno</span>
                                        </div>
                                        <button class="btn btn-sm btn-primary" style="width: 100%; margin-top: 0.75rem;" onclick="verDetalhes(<?php echo $visita['id_agendamento']; ?>)">Ver Detalhes</button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- COLUNA 2: Resumo de Estatísticas -->
                <div class="visits-summary-section">
                    <div class="card">
                        <div class="card-header">
                            <h2>📊 Resumo</h2>
                        </div>
                        <div class="card-body">
                            <div class="summary-stats">
                                <div class="summary-stat-item">
                                    <p>Total de Visitas</p>
                                    <h3><?php echo count($visitas); ?></h3>
                                </div>
                                <div class="summary-stat-item">
                                    <p>Alunos Viajados</p>
                                    <h3><?php echo array_sum(array_map(fn($v) => $v['quantidade_aluno'], $visitas)); ?></h3>
                                </div>
                                <div class="summary-stat-item">
                                    <p>Investimento Total</p>
                                    <h3>
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
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Rolezão Escolar. Todos os direitos reservados.</p>
    </footer>

    <!-- Modal de Detalhes da Visita -->
    <div id="modalDetalhes" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Detalhes da Visita</h2>
                <button class="modal-close" onclick="fecharModal('modalDetalhes')">&times;</button>
            </div>
            <div class="modal-body">
                <div id="detalhesContent" style="display: flex; flex-direction: column; gap: 1rem;">
                    <!-- Preenchido dinamicamente -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Armazenar dados das visitas para rápido acesso
        const visitasData = <?php
        $data_for_js = [];
        foreach ($visitas as $visita) {
            $dataInicio = new DateTime($visita['data_visita']);
            $dataFim = new DateTime($visita['data_saida']);
            $dias = $dataInicio->diff($dataFim)->days + 1;
            $custoTotal = $visita['custo'] * $visita['quantidade_aluno'] * $dias;
            
            $data_for_js[$visita['id_agendamento']] = [
                'ponto_nome' => $visita['ponto_nome'],
                'local' => $visita['local'],
                'descricao' => $visita['descricao'],
                'data_visita' => date('d/m/Y', strtotime($visita['data_visita'])),
                'data_saida' => date('d/m/Y', strtotime($visita['data_saida'])),
                'dias' => $dias,
                'quantidade_aluno' => $visita['quantidade_aluno'],
                'custo_unitario' => number_format($visita['custo'], 2, ',', '.'),
                'custo_total' => number_format($custoTotal, 2, ',', '.'),
                'status' => isset($visita['status']) ? $visita['status'] : 'pendente',
                'motivo_rejeicao' => isset($visita['motivo_rejeicao']) ? $visita['motivo_rejeicao'] : ''
            ];
        }
        echo json_encode($data_for_js);
        ?>;

        function verDetalhes(id) {
            const visita = visitasData[id];
            if (!visita) return;

            let statusHtml = '';
            if (visita.status === 'aprovado') {
                statusHtml = '<span style="background: #d4edda; color: #155724; padding: 0.5rem 1rem; border-radius: 8px; font-weight: bold; font-size: 1.1rem;">✅ Aprovado</span>';
            } else if (visita.status === 'rejeitado') {
                statusHtml = '<div><span style="background: #f8d7da; color: #721c24; padding: 0.5rem 1rem; border-radius: 8px; font-weight: bold; font-size: 1.1rem;">❌ Rejeitado</span>';
                if (visita.motivo_rejeicao) {
                    statusHtml += '<p style="margin: 0.5rem 0 0 0; color: #666; font-style: italic;"><strong>Motivo:</strong> ' + visita.motivo_rejeicao + '</p>';
                }
                statusHtml += '</div>';
            } else {
                statusHtml = '<span style="background: #fff3cd; color: #856404; padding: 0.5rem 1rem; border-radius: 8px; font-weight: bold; font-size: 1.1rem;">⏳ Pendente</span>';
            }

            const html = `
                <div style="display: grid; gap: 1rem;">
                    <div style="border-bottom: 2px solid var(--light); padding-bottom: 1rem;">
                        <h3 style="margin: 0 0 0.5rem 0; color: var(--primary);">${visita.ponto_nome}</h3>
                        <p style="margin: 0; color: #666;">📍 ${visita.local}</p>
                    </div>

                    <div>
                        <label style="font-weight: bold; color: var(--primary);">Status da Visita</label>
                        <div style="margin-top: 0.5rem;">${statusHtml}</div>
                    </div>

                    <div>
                        <label style="font-weight: bold; color: var(--primary);">Descrição</label>
                        <p style="margin: 0.5rem 0 0 0; color: #666; line-height: 1.6;">${visita.descricao}</p>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div style="background: var(--light); padding: 1rem; border-radius: 8px;">
                            <p style="margin: 0 0 0.5rem 0; color: #666; font-size: 0.9rem;">Data de Início</p>
                            <h4 style="margin: 0; color: var(--primary);">📅 ${visita.data_visita}</h4>
                        </div>
                        <div style="background: var(--light); padding: 1rem; border-radius: 8px;">
                            <p style="margin: 0 0 0.5rem 0; color: #666; font-size: 0.9rem;">Data de Saída</p>
                            <h4 style="margin: 0; color: var(--primary);">📅 ${visita.data_saida}</h4>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                        <div style="background: var(--light); padding: 1rem; border-radius: 8px; text-align: center;">
                            <p style="margin: 0 0 0.5rem 0; color: #666; font-size: 0.9rem;">Duração</p>
                            <h4 style="margin: 0; color: var(--success);">${visita.dias} dia(s)</h4>
                        </div>
                        <div style="background: var(--light); padding: 1rem; border-radius: 8px; text-align: center;">
                            <p style="margin: 0 0 0.5rem 0; color: #666; font-size: 0.9rem;">Alunos</p>
                            <h4 style="margin: 0; color: var(--success);">👥 ${visita.quantidade_aluno}</h4>
                        </div>
                        <div style="background: var(--light); padding: 1rem; border-radius: 8px; text-align: center;">
                            <p style="margin: 0 0 0.5rem 0; color: #666; font-size: 0.9rem;">Custo/Aluno</p>
                            <h4 style="margin: 0; color: var(--success);">R$ ${visita.custo_unitario}</h4>
                        </div>
                    </div>

                    <div style="background: linear-gradient(135deg, var(--success) 0%, #059669 100%); padding: 1.5rem; border-radius: 8px; text-align: center; color: white;">
                        <p style="margin: 0 0 0.5rem 0; opacity: 0.9;">Custo Total da Viagem</p>
                        <h2 style="margin: 0; font-size: 2rem;">R$ ${visita.custo_total}</h2>
                    </div>
                </div>
            `;

            document.getElementById('detalhesContent').innerHTML = html;
            document.getElementById('modalDetalhes').classList.add('active');
        }

        function fecharModal(id) {
            document.getElementById(id).classList.remove('active');
        }

        // Fechar modal ao clicar fora
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.remove('active');
            }
        }
    </script>
</body>

</html>