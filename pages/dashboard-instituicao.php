<?php
session_start();
require_once __DIR__ . '/../config/database.php';

// Verificar se é instituição
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'instituicao') {
    header('Location: login-instituicao.php');
    exit;
}

$erro = '';
$sucesso = '';

try {
    $pdo = getConnection();
    
    // Carregar visitas pendentes/futuras da instituição
    $stmt = $pdo->prepare("
        SELECT a.*, pt.nome as ponto_nome, pt.local, pt.descricao, pt.custo
        FROM agendamento a
        JOIN ponto_turistico pt ON a.id_ponto_turistico = pt.id_ponto_turistico
        WHERE a.id_instituicao = ? AND a.data_visita >= CURDATE()
        ORDER BY a.data_visita ASC
    ");
    $stmt->execute([$_SESSION['id_usuario']]);
    $visitas_pendentes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Carregar estatísticas
    $stmt = $pdo->prepare("
        SELECT 
            COUNT(*) as total_visitas,
            SUM(quantidade_aluno) as total_alunos,
            SUM(CASE WHEN data_visita >= CURDATE() THEN 1 ELSE 0 END) as futuras_visitas
        FROM agendamento
        WHERE id_instituicao = ?
    ");
    $stmt->execute([$_SESSION['id_usuario']]);
    $stats = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Informações da instituição
    $stmt = $pdo->prepare("SELECT * FROM instituicao WHERE id_instituicao = ?");
    $stmt->execute([$_SESSION['id_usuario']]);
    $instituicao = $stmt->fetch(PDO::FETCH_ASSOC);
    
} catch (Exception $e) {
    $erro = 'Erro ao carregar dados: ' . $e->getMessage();
}

// Processar ação de autorizar/denunciar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';
    $id_agendamento = $_POST['id_agendamento'] ?? '';
    
    if ($acao === 'autorizar') {
        // Aqui você pode adicionar lógica de autorização
        $sucesso = 'Visita autorizada com sucesso!';
    } elseif ($acao === 'denunciar') {
        // Aqui você pode adicionar lógica de denúncia
        $sucesso = 'Denúncia registrada com sucesso!';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Instituição - Rolezão Escolar</title>
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
                <li><a href="dashboard-instituicao.php">Dashboard</a></li>
                <li><a href="minhas-visitas.php">Visitas</a></li>
                <li><a href="ranking.php">Ranking</a></li>
                <li><a href="../auth/logout.php">Sair</a></li>
            </ul>
        </div>
    </nav>

    <div class="page-container">
        <!-- Cabeçalho do Dashboard -->
        <div style="background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); color: white; padding: 2rem; border-radius: 12px; margin-top: 2rem; margin-bottom: 2rem;">
            <h1 style="margin: 0; margin-bottom: 0.5rem;">Bem-vindo, <?php echo htmlspecialchars($_SESSION['nome_usuario']); ?></h1>
            <p style="margin: 0; opacity: 0.9;">Gerencie as visitas de sua instituição</p>
        </div>

        <?php if ($erro): ?>
            <div class="alert alert-error">
                ❌ <?php echo htmlspecialchars($erro); ?>
            </div>
        <?php endif; ?>

        <?php if ($sucesso): ?>
            <div class="alert alert-success">
                ✅ <?php echo htmlspecialchars($sucesso); ?>
            </div>
        <?php endif; ?>

        <!-- Estatísticas -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3><?php echo $stats['total_visitas'] ?? 0; ?></h3>
                <p>Total de Visitas</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $stats['total_alunos'] ?? 0; ?></h3>
                <p>Alunos Viajados</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $stats['futuras_visitas'] ?? 0; ?></h3>
                <p>Visitas Futuras</p>
            </div>
            <div class="stat-card">
                <h3><?php echo htmlspecialchars($instituicao['localizacao'] ?? ''); ?></h3>
                <p>Localização</p>
            </div>
        </div>

        <!-- Visitas Pendentes -->
        <div class="card" style="margin-top: 2rem;">
            <div class="card-header">
                <h2>📅 Visitas Programadas</h2>
            </div>
            <div class="card-body">
                <?php if (empty($visitas_pendentes)): ?>
                    <div class="alert alert-info">
                        ℹ️ Nenhuma visita programada para o futuro.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Local Turístico</th>
                                    <th>Data de Início</th>
                                    <th>Data de Saída</th>
                                    <th>Alunos</th>
                                    <th>Custo Total</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($visitas_pendentes as $visita): ?>
                                    <?php 
                                        $dataInicio = new DateTime($visita['data_visita']);
                                        $dataFim = new DateTime($visita['data_saida']);
                                        $dias = $dataInicio->diff($dataFim)->days + 1;
                                        $custoTotal = $visita['custo'] * $visita['quantidade_aluno'] * $dias;
                                    ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($visita['ponto_nome']); ?></strong></td>
                                        <td><?php echo date('d/m/Y', strtotime($visita['data_visita'])); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($visita['data_saida'])); ?></td>
                                        <td><?php echo $visita['quantidade_aluno']; ?></td>
                                        <td><strong>R$ <?php echo number_format($custoTotal, 2, ',', '.'); ?></strong></td>
                                        <td>
                                            <button class="btn btn-sm btn-success" onclick="autorizar(<?php echo $visita['id_agendamento']; ?>)">✓</button>
                                            <button class="btn btn-sm btn-danger" onclick="denunciar(<?php echo $visita['id_agendamento']; ?>)">✗</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Informações da Instituição -->
        <div class="card" style="margin-top: 2rem; margin-bottom: 2rem;">
            <div class="card-header">
                <h2>🏫 Informações da Instituição</h2>
            </div>
            <div class="card-body">
                <div class="form-group" style="max-width: none;">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;">
                        <div>
                            <label style="font-weight: bold; color: var(--primary);">Nome</label>
                            <p><?php echo htmlspecialchars($instituicao['nome']); ?></p>
                        </div>
                        <div>
                            <label style="font-weight: bold; color: var(--primary);">CNPJ</label>
                            <p><?php echo htmlspecialchars($instituicao['cnpj']); ?></p>
                        </div>
                        <div>
                            <label style="font-weight: bold; color: var(--primary);">Localização</label>
                            <p><?php echo htmlspecialchars($instituicao['localizacao']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Rolezão Escolar. Todos os direitos reservados.</p>
    </footer>

    <!-- Modal para Autorizar -->
    <div id="modalAutorizar" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Autorizar Visita</h2>
                <button class="modal-close" onclick="fecharModal('modalAutorizar')">&times;</button>
            </div>
            <form method="POST" class="modal-body">
                <input type="hidden" name="id_agendamento" id="id_agendamento_autorizar">
                <input type="hidden" name="acao" value="autorizar">
                <p>Tem certeza que deseja autorizar esta visita?</p>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="fecharModal('modalAutorizar')">Cancelar</button>
                    <button type="submit" class="btn btn-success">Confirmar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para Denunciar -->
    <div id="modalDenunciar" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Denunciar Visita</h2>
                <button class="modal-close" onclick="fecharModal('modalDenunciar')">&times;</button>
            </div>
            <form method="POST" class="modal-body">
                <input type="hidden" name="id_agendamento" id="id_agendamento_denunciar">
                <input type="hidden" name="acao" value="denunciar">
                <div class="form-group">
                    <label for="motivo">Motivo da Denúncia</label>
                    <textarea id="motivo" name="motivo" placeholder="Descreva o motivo da denúncia..." required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="fecharModal('modalDenunciar')">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Denunciar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function autorizar(id) {
            document.getElementById('id_agendamento_autorizar').value = id;
            document.getElementById('modalAutorizar').classList.add('active');
        }

        function denunciar(id) {
            document.getElementById('id_agendamento_denunciar').value = id;
            document.getElementById('modalDenunciar').classList.add('active');
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
