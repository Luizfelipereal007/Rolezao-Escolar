<?php
session_start();
require_once __DIR__ . '/../app/controller/rankingController.php';

$rankingController = new RankingController();
$pontos_ranking = $rankingController->getPontosRanking();
$escolas_ranking = $rankingController->getEscolasRanking(10);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ranking - Rolezão Escolar</title>
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
                <li><a href="ranking.php">Ranking</a></li>
                <?php if (isset($_SESSION['tipo_usuario'])): ?>
                    <li><a href="../auth/logout.php">Sair</a></li>
                <?php else: ?>
                    <li><a href="login-professor.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="page-container">
        <div style="margin-top: 2rem;">
            <!-- Ranking de Pontos Turísticos -->
            <div class="card" style="margin-bottom: 2rem;">
                <div class="card-header">
                    <h2>🏆 Ranking: Pontos Turísticos Mais Visitados</h2>
                </div>
                <div class="card-body">
                    <?php if (empty($pontos_ranking)): ?>
                        <p class="text-center">Nenhum ponto turístico cadastrado ainda.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th style="width: 60px;">#</th>
                                        <th>Local Turístico</th>
                                        <th>Localização</th>
                                        <th style="width: 100px;">Visitas</th>
                                        <th style="width: 120px;">Alunos</th>
                                        <th style="width: 100px;">Custo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pontos_ranking as $index => $ponto): ?>
                                        <tr>
                                            <td>
                                                <?php 
                                                    $posicao = $index + 1;
                                                    if ($posicao === 1) echo '🥇 1º';
                                                    elseif ($posicao === 2) echo '🥈 2º';
                                                    elseif ($posicao === 3) echo '🥉 3º';
                                                    else echo $posicao . 'º';
                                                ?>
                                            </td>
                                            <td><strong><?php echo htmlspecialchars($ponto['nome']); ?></strong></td>
                                            <td><?php echo htmlspecialchars($ponto['local']); ?></td>
                                            <td><?php echo $ponto['total_visitas'] ?? 0; ?></td>
                                            <td><?php echo $ponto['total_alunos'] ?? 0; ?></td>
                                            <td>R$ <?php echo number_format($ponto['custo'], 2, ',', '.'); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Ranking de Escolas -->
            <div class="card">
                <div class="card-header">
                    <h2>🏫 Ranking: Escolas com Mais Visitas</h2>
                </div>
                <div class="card-body">
                    <?php if (empty($escolas_ranking)): ?>
                        <p class="text-center">Nenhuma escola com visitas ainda.</p>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th style="width: 60px;">#</th>
                                        <th>Instituição</th>
                                        <th>Localização</th>
                                        <th style="width: 100px;">Visitas</th>
                                        <th style="width: 120px;">Alunos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($escolas_ranking as $index => $escola): ?>
                                        <tr>
                                            <td>
                                                <?php 
                                                    $posicao = $index + 1;
                                                    if ($posicao === 1) echo '🥇 1º';
                                                    elseif ($posicao === 2) echo '🥈 2º';
                                                    elseif ($posicao === 3) echo '🥉 3º';
                                                    else echo $posicao . 'º';
                                                ?>
                                            </td>
                                            <td><strong><?php echo htmlspecialchars($escola['nome']); ?></strong></td>
                                            <td><?php echo htmlspecialchars($escola['localizacao']); ?></td>
                                            <td><?php echo $escola['total_visitas'] ?? 0; ?></td>
                                            <td><?php echo $escola['total_alunos'] ?? 0; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Rolezão Escolar. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
