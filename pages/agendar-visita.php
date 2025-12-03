<?php
session_start();
require_once __DIR__ . '/../app/controller/pontoTuristicoController.php';
require_once __DIR__ . '/../app/controller/agendamentoController.php';

// Verificar se é professor
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'professor') {
    header('Location: login-professor.php');
    exit;
}

$erro = '';
$sucesso = '';

// Carregar pontos turísticos via controller
$pontoCtrl = new PontoTuristicoController();
try {
    $pontos = $pontoCtrl->listar();
} catch (Exception $e) {
    $erro = 'Erro ao carregar pontos turísticos: ' . $e->getMessage();
    $pontos = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_ponto_turistico = $_POST['id_ponto_turistico'] ?? '';
    $data_visita = $_POST['data_visita'] ?? '';
    $data_saida = $_POST['data_saida'] ?? '';
    $quantidade_aluno = $_POST['quantidade_aluno'] ?? '';

    // Validações
    if (empty($id_ponto_turistico) || empty($data_visita) || empty($data_saida) || empty($quantidade_aluno)) {
        $erro = 'Todos os campos são obrigatórios.';
    } elseif (strtotime($data_visita) >= strtotime($data_saida)) {
        $erro = 'A data de saída deve ser posterior à data de visita.';
    } elseif ($quantidade_aluno <= 0) {
        $erro = 'A quantidade de alunos deve ser maior que zero.';
    } else {
        try {
            $agendamentoCtrl = new AgendamentoController();
            $resultado = $agendamentoCtrl->criar($_SESSION['id_instituicao'], $id_ponto_turistico, $data_visita, $data_saida, $quantidade_aluno);
            if ($resultado === true) {
                $sucesso = 'Visita agendada com sucesso!';
                $_POST = []; // Limpar formulário
            } else {
                $erro = 'Erro ao agendar visita: ' . $resultado;
            }
        } catch (Exception $e) {
            $erro = 'Erro ao agendar visita: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Visita - Rolezão Escolar</title>
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
                <li><a href="agendar-visita.php">Agendar Visita</a></li>
                <li><a href="minhas-visitas.php">Minhas Visitas</a></li>
                <li><a href="ranking.php">Ranking</a></li>
                <li><a href="../auth/logout.php">Sair</a></li>
            </ul>
        </div>
    </nav>

    <div class="page-container">
        <!-- Cabeçalho -->
        <div class="schedule-header">
            <h1>📅 Agendar Nova Visita</h1>
            <p>Instituição: <?php echo htmlspecialchars($_SESSION['instituicao_nome']); ?></p>
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

        <!-- Layout 2 Colunas -->
        <div class="schedule-container">
            <!-- COLUNA 1: Formulário -->
            <div class="schedule-form">
                <div class="card">
                    <div class="card-header">
                        <h2>Dados da Visita</h2>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group">
                                <label for="id_ponto_turistico">Ponto Turístico *</label>
                                <select id="id_ponto_turistico" name="id_ponto_turistico" required>
                                    <option value="">-- Selecione um ponto turístico --</option>
                                    <?php foreach ($pontos as $ponto): ?>
                                        <option value="<?php echo $ponto['id_ponto_turistico']; ?>">
                                            <?php echo htmlspecialchars($ponto['nome']); ?> - R$ <?php echo number_format($ponto['custo'], 2, ',', '.'); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="quantidade_aluno">Número de Alunos *</label>
                                <input type="number" id="quantidade_aluno" name="quantidade_aluno" min="1" required>
                            </div>

                            <div class="form-group">
                                <label for="data_visita">Data de Início *</label>
                                <input type="date" id="data_visita" name="data_visita" required>
                            </div>

                            <div class="form-group">
                                <label for="data_saida">Data de Saída *</label>
                                <input type="date" id="data_saida" name="data_saida" required>
                            </div>

                            <div class="form-actions">
                                <button type="submit" class="btn btn-success">✓ Agendar Visita</button>
                                <a href="minhas-visitas.php" class="btn btn-secondary">← Minhas Visitas</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- COLUNA 2: Pontos Populares -->
            <div class="schedule-sidebar">
                <div class="card">
                    <div class="card-header">
                        <h2>📍 Pontos Populares</h2>
                    </div>
                    <div class="card-body">
                        <div class="popular-points">
                            <?php foreach ($pontos as $ponto): ?>
                                <div class="point-card-small">
                                    <div class="point-img-small">
                                        <?php if (!empty($ponto['foto'])): ?>
                                            <img src="<?php echo htmlspecialchars($ponto['foto']); ?>" alt="<?php echo htmlspecialchars($ponto['nome']); ?>">
                                        <?php else: ?>
                                            <div class="img-placeholder">🏛️</div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="point-info-small">
                                        <h4><?php echo htmlspecialchars($ponto['nome']); ?></h4>
                                        <p class="location-small">📍 <?php echo htmlspecialchars($ponto['local']); ?></p>
                                        <p class="cost-small">R$ <?php echo number_format($ponto['custo'], 2, ',', '.'); ?>/aluno</p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Rolezão Escolar. Todos os direitos reservados.</p>
    </footer>

    <script>
        // Definir data mínima para hoje
        const hoje = new Date().toISOString().split('T')[0];
        document.getElementById('data_visita').setAttribute('min', hoje);
        document.getElementById('data_saida').setAttribute('min', hoje);

        // Quando data_visita mudar, atualizar mínimo de data_saida
        document.getElementById('data_visita').addEventListener('change', function() {
            document.getElementById('data_saida').setAttribute('min', this.value);
        });
    </script>
</body>
</html>
