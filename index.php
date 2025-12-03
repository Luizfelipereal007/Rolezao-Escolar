<?php
session_start();

// Página inicial com navegação
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rolezão Escolar - Turismo para Escolas</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <!-- Navegação Principal -->
    <nav class="navbar">
        <div class="navbar-container">
            <div class="navbar-brand">
                <a href="index.php" style="text-decoration: none; color: white;">
                    <h1>🎒 Rolezão Escolar</h1>
                </a>
            </div>
            <ul class="navbar-menu">
                <li><a href="index.php">Início</a></li>
                <li><a href="pages/ranking.php">Ranking</a></li>
                <?php if (isset($_SESSION['tipo_usuario'])): ?>
                    <?php if ($_SESSION['tipo_usuario'] === 'instituicao'): ?>
                        <li><a href="pages/dashboard-instituicao.php">Dashboard</a></li>
                        <li><a href="pages/minhas-visitas.php">Minhas Visitas</a></li>
                        <li><a href="auth/logout.php">Sair</a></li>
                    <?php elseif ($_SESSION['tipo_usuario'] === 'professor'): ?>
                        <li><a href="pages/agendar-visita.php">Agendar Visita</a></li>
                        <li><a href="pages/minhas-visitas.php">Minhas Visitas</a></li>
                        <li><a href="auth/logout.php">Sair</a></li>
                    <?php elseif ($_SESSION['tipo_usuario'] === 'admin'): ?>
                        <li><a href="pages/admin-dashboard.php">Admin</a></li>
                        <li><a href="auth/logout.php">Sair</a></li>
                    <?php endif; ?>
                <?php else: ?>
                    <li>
                        <a href="#" onclick="abrirModal('authModal'); switchAuthTab('login'); return false;">Entrar ▼</a>
                    </li>
                    <li>
                        <a href="#" onclick="abrirModal('authModal'); switchAuthTab('register'); return false;">Cadastro ▼</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h2>Bem-vindo ao Rolezão Escolar</h2>
            <p>Explore os melhores pontos turísticos com sua escola</p>
            <?php if (!isset($_SESSION['tipo_usuario'])): ?>
                <div class="hero-buttons">
                    <a href="pages/cadastro-instituicao.php" class="btn btn-primary">Cadastrar Instituição</a>
                    <a href="pages/login-instituicao.php" class="btn btn-secondary">Entrar como Instituição</a>
                </div>
            <?php elseif ($_SESSION['tipo_usuario'] === 'professor'): ?>
                <div class="hero-buttons">
                    <a href="pages/agendar-visita.php" class="btn btn-primary">Agendar uma Visita</a>
                    <a href="pages/ranking.php" class="btn btn-secondary">Ver Ranking</a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Seção de Pontos Turísticos Populares -->
    <section class="popular-places">
        <div class="container">
            <h2>Pontos Turísticos Mais Visitados</h2>
            <div class="places-grid" id="placesGrid">
                <div class="loading">Carregando...</div>
            </div>
        </div>
    </section>

    <!-- Seção de Estatísticas -->
    <section class="statistics">
        <div class="container">
            <h2>Estatísticas</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <h3 id="totalVisitas">0</h3>
                    <p>Visitas Totais</p>
                </div>
                <div class="stat-card">
                    <h3 id="totalEscolas">0</h3>
                    <p>Escolas Participantes</p>
                </div>
                <div class="stat-card">
                    <h3 id="totalAlunos">0</h3>
                    <p>Alunos Viajados</p>
                </div>
                <div class="stat-card">
                    <h3 id="totalLugares">0</h3>
                    <p>Pontos Turísticos</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2025 Rolezão Escolar. Todos os direitos reservados.</p>
    </footer>

    <!-- Modal de Autenticação / Cadastro -->
    <div id="authModal" class="modal" role="dialog" aria-modal="true" aria-hidden="true">
        <div class="modal-content" role="document">
            <div class="modal-header">
                <h2 id="authModalTitle">Entrar</h2>
                <button class="modal-close" aria-label="Fechar" onclick="fecharModal('authModal')">×</button>
            </div>
            <div class="modal-body">
                <div style="display:flex; gap:1rem; margin-bottom:1rem;">
                    <button class="btn btn-sm btn-primary" id="tabLogin" onclick="switchAuthTab('login')">Entrar</button>
                    <button class="btn btn-sm btn-secondary" id="tabRegister" onclick="switchAuthTab('register')">Cadastro</button>
                    <button class="btn btn-sm btn-secondary" id="tabAdmin" onclick="switchAuthTab('admin')">Admin</button>
                </div>

                <div id="authLogin" class="auth-panel">
                    <!-- Login Professor -->
                    <form method="POST" action="pages/login-professor.php">
                        <div class="form-group">
                            <label for="modal_nome_professor">Nome do Professor</label>
                            <input type="text" id="modal_nome_professor" name="nome_professor" required>
                        </div>
                        <div class="form-group">
                            <label for="modal_senha_prof">Senha</label>
                            <input type="password" id="modal_senha_prof" name="senha" required>
                        </div>
                        <div style="display:flex; gap:8px;">
                            <button type="submit" class="btn btn-primary">Entrar como Professor</button>
                            <a href="pages/login-instituicao.php" class="btn btn-secondary">Entrar como Instituição</a>
                        </div>
                    </form>
                </div>

                <div id="authRegister" class="auth-panel" style="display:none;">
                    <p style="margin-bottom:1rem;">Escolha uma opção de cadastro:</p>
                    <div style="display:flex; flex-direction:column; gap:0.75rem;">
                        <a href="pages/cadastro-instituicao.php" class="btn btn-primary">Cadastrar Instituição</a>
                        <a href="pages/cadastro-professor.php" class="btn btn-secondary">Cadastrar Professor</a>
                    </div>
                </div>

                <div id="authAdmin" class="auth-panel" style="display:none;">
                    <!-- Login Admin -->
                    <form method="POST" action="pages/login-admin.php">
                        <div class="form-group">
                            <label for="modal_senha_admin">Senha de Administrador</label>
                            <input type="password" id="modal_senha_admin" name="senha" placeholder="Digite a senha" required>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%;">Entrar como Admin</button>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="fecharModal('authModal')">Fechar</button>
            </div>
        </div>
    </div>

    <script src="public/js/main.js"></script>

    <script>
        // Carregar pontos turísticos populares
        document.addEventListener('DOMContentLoaded', function() {
            carregarPontosPopulares();
            carregarEstatisticas();
        });

        function carregarPontosPopulares() {
            fetch('api/pontos-populares.php')
                .then(response => response.json())
                .then(data => {
                    const grid = document.getElementById('placesGrid');
                    grid.innerHTML = '';
                    
                    if (data.length === 0) {
                        grid.innerHTML = '<p>Nenhum ponto turístico cadastrado ainda.</p>';
                        return;
                    }

                    data.forEach(ponto => {
                        const card = document.createElement('div');
                        card.className = 'place-card';
                        const fotoUrl = ponto.foto || 'https://via.placeholder.com/300x200?text=' + encodeURIComponent(ponto.nome);
                        card.innerHTML = `
                            <div class="place-image" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.7), rgba(118, 75, 162, 0.7)), url('${fotoUrl}'); background-size: cover; background-position: center;">
                                <span class="visit-count">👥 ${ponto.visitas || 0} visitas</span>
                            </div>
                            <div class="place-info">
                                <h3>${ponto.nome}</h3>
                                <p class="location">📍 ${ponto.local}</p>
                                <p class="description">${ponto.descricao}</p>
                                <p class="cost">💰 R$ ${parseFloat(ponto.custo).toFixed(2)}</p>
                            </div>
                        `;
                        grid.appendChild(card);
                    });
                })
                .catch(error => {
                    console.error('Erro:', error);
                    document.getElementById('placesGrid').innerHTML = '<p>Erro ao carregar pontos turísticos.</p>';
                });
        }

        function carregarEstatisticas() {
            fetch('api/estatisticas.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('totalVisitas').textContent = data.total_visitas || 0;
                    document.getElementById('totalEscolas').textContent = data.total_escolas || 0;
                    document.getElementById('totalAlunos').textContent = data.total_alunos || 0;
                    document.getElementById('totalLugares').textContent = data.total_lugares || 0;
                })
                .catch(error => console.error('Erro ao carregar estatísticas:', error));
        }
    </script>
</body>
</html>
