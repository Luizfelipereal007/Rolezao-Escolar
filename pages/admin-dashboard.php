<?php
session_start();
require_once __DIR__ . '/../config/database.php';

// Verificar se é admin
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
    header('Location: login-admin.php');
    exit;
}

$erro = '';
$sucesso = '';

try {
    $pdo = getConnection();
    
    // Carregar todos os pontos turísticos
    $stmt = $pdo->prepare("SELECT * FROM ponto_turistico ORDER BY nome");
    $stmt->execute();
    $pontos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (Exception $e) {
    $erro = 'Erro ao carregar dados: ' . $e->getMessage();
    $pontos = [];
}

// Processar criação de novo ponto turístico
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao'])) {
    $acao = $_POST['acao'];
    
    if ($acao === 'criar') {
        $nome = $_POST['nome'] ?? '';
        $local = $_POST['local'] ?? '';
        $descricao = $_POST['descricao'] ?? '';
        $custo = $_POST['custo'] ?? '';
        
        if (empty($nome) || empty($local) || empty($descricao) || empty($custo)) {
            $erro = 'Todos os campos são obrigatórios.';
        } else {
            try {
                $stmt = $pdo->prepare("INSERT INTO ponto_turistico (nome, local, descricao, custo) VALUES (?, ?, ?, ?)");
                if ($stmt->execute([$nome, $local, $descricao, floatval($custo)])) {
                    $sucesso = 'Ponto turístico criado com sucesso!';
                    header('refresh:2;url=admin-dashboard.php');
                } else {
                    $erro = 'Erro ao criar ponto turístico.';
                }
            } catch (Exception $e) {
                $erro = 'Erro: ' . $e->getMessage();
            }
        }
    } elseif ($acao === 'editar') {
        $id = $_POST['id_ponto_turistico'] ?? '';
        $nome = $_POST['nome'] ?? '';
        $local = $_POST['local'] ?? '';
        $descricao = $_POST['descricao'] ?? '';
        $custo = $_POST['custo'] ?? '';
        
        if (empty($id) || empty($nome) || empty($local) || empty($descricao) || empty($custo)) {
            $erro = 'Todos os campos são obrigatórios.';
        } else {
            try {
                $stmt = $pdo->prepare("UPDATE ponto_turistico SET nome = ?, local = ?, descricao = ?, custo = ? WHERE id_ponto_turistico = ?");
                if ($stmt->execute([$nome, $local, $descricao, floatval($custo), $id])) {
                    $sucesso = 'Ponto turístico atualizado com sucesso!';
                    header('refresh:2;url=admin-dashboard.php');
                } else {
                    $erro = 'Erro ao atualizar ponto turístico.';
                }
            } catch (Exception $e) {
                $erro = 'Erro: ' . $e->getMessage();
            }
        }
    } elseif ($acao === 'deletar') {
        $id = $_POST['id_ponto_turistico'] ?? '';
        
        try {
            $stmt = $pdo->prepare("DELETE FROM ponto_turistico WHERE id_ponto_turistico = ?");
            if ($stmt->execute([$id])) {
                $sucesso = 'Ponto turístico deletado com sucesso!';
                header('refresh:2;url=admin-dashboard.php');
            } else {
                $erro = 'Erro ao deletar ponto turístico.';
            }
        } catch (Exception $e) {
            $erro = 'Erro: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Rolezão Escolar</title>
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
                <li><a href="admin-dashboard.php">Dashboard</a></li>
                <li><a href="../auth/logout.php">Sair</a></li>
            </ul>
        </div>
    </nav>

    <div class="page-container">
        <!-- Cabeçalho -->
        <div style="background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%); color: white; padding: 2rem; border-radius: 12px; margin-top: 2rem; margin-bottom: 2rem;">
            <h1 style="margin: 0; margin-bottom: 0.5rem;">Painel Administrativo</h1>
            <p style="margin: 0; opacity: 0.9;">Gerencie os pontos turísticos do sistema</p>
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

        <!-- Formulário para criar novo ponto turístico -->
        <div class="card" style="margin-bottom: 2rem;">
            <div class="card-header">
                <h2>➕ Novo Ponto Turístico</h2>
            </div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" name="acao" value="criar">
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                        <div class="form-group">
                            <label for="nome">Nome do Ponto Turístico *</label>
                            <input type="text" id="nome" name="nome" placeholder="Ex: Cristo Redentor" required>
                        </div>

                        <div class="form-group">
                            <label for="local">Localização *</label>
                            <input type="text" id="local" name="local" placeholder="Ex: Rio de Janeiro, RJ" required>
                        </div>

                        <div class="form-group">
                            <label for="custo">Custo por Aluno (R$) *</label>
                            <input type="number" id="custo" name="custo" placeholder="0.00" step="0.01" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="descricao">Descrição *</label>
                        <textarea id="descricao" name="descricao" placeholder="Descreva o ponto turístico..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-success">✓ Criar Ponto Turístico</button>
                </form>
            </div>
        </div>

        <!-- Lista de Pontos Turísticos -->
        <div class="card">
            <div class="card-header">
                <h2>📍 Pontos Turísticos Cadastrados</h2>
            </div>
            <div class="card-body">
                <?php if (empty($pontos)): ?>
                    <div class="alert alert-info">
                        ℹ️ Nenhum ponto turístico cadastrado ainda.
                    </div>
                <?php else: ?>
                    <div class="places-grid">
                        <?php foreach ($pontos as $ponto): ?>
                            <div class="card">
                                <div class="place-image" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); position: relative;">
                                    <div style="position: absolute; top: 10px; right: 10px;">
                                        <button class="btn btn-sm btn-warning" onclick="abrirEdicao(<?php echo $ponto['id_ponto_turistico']; ?>, '<?php echo htmlspecialchars($ponto['nome']); ?>', '<?php echo htmlspecialchars($ponto['local']); ?>', '<?php echo htmlspecialchars($ponto['descricao']); ?>', '<?php echo $ponto['custo']; ?>')">✏️</button>
                                    </div>
                                </div>
                                <div class="place-info">
                                    <h3><?php echo htmlspecialchars($ponto['nome']); ?></h3>
                                    <p class="location">📍 <?php echo htmlspecialchars($ponto['local']); ?></p>
                                    <p class="description"><?php echo htmlspecialchars(substr($ponto['descricao'], 0, 100)); ?>...</p>
                                    <p class="cost">💰 R$ <?php echo number_format($ponto['custo'], 2, ',', '.'); ?> por aluno</p>
                                    <button class="btn btn-danger btn-sm" style="width: 100%; margin-top: 1rem;" onclick="deletarPonto(<?php echo $ponto['id_ponto_turistico']; ?>)">🗑️ Deletar</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Rolezão Escolar. Todos os direitos reservados.</p>
    </footer>

    <!-- Modal para Editar -->
    <div id="modalEditar" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Editar Ponto Turístico</h2>
                <button class="modal-close" onclick="fecharModal('modalEditar')">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST" id="formEditar">
                    <input type="hidden" name="acao" value="editar">
                    <input type="hidden" name="id_ponto_turistico" id="id_ponto_turistico">

                    <div class="form-group">
                        <label for="nome_editar">Nome do Ponto Turístico</label>
                        <input type="text" id="nome_editar" name="nome" required>
                    </div>

                    <div class="form-group">
                        <label for="local_editar">Localização</label>
                        <input type="text" id="local_editar" name="local" required>
                    </div>

                    <div class="form-group">
                        <label for="custo_editar">Custo por Aluno (R$)</label>
                        <input type="number" id="custo_editar" name="custo" step="0.01" required>
                    </div>

                    <div class="form-group">
                        <label for="descricao_editar">Descrição</label>
                        <textarea id="descricao_editar" name="descricao" required></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="fecharModal('modalEditar')">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para Confirmar Deleção -->
    <div id="modalDeletar" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Confirmar Deleção</h2>
                <button class="modal-close" onclick="fecharModal('modalDeletar')">&times;</button>
            </div>
            <form method="POST" class="modal-body">
                <input type="hidden" name="acao" value="deletar">
                <input type="hidden" name="id_ponto_turistico" id="id_deletar">
                <p>Tem certeza que deseja deletar este ponto turístico? Esta ação não pode ser desfeita.</p>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="fecharModal('modalDeletar')">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Deletar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function abrirEdicao(id, nome, local, descricao, custo) {
            document.getElementById('id_ponto_turistico').value = id;
            document.getElementById('nome_editar').value = nome;
            document.getElementById('local_editar').value = local;
            document.getElementById('descricao_editar').value = descricao;
            document.getElementById('custo_editar').value = custo;
            document.getElementById('modalEditar').classList.add('active');
        }

        function deletarPonto(id) {
            document.getElementById('id_deletar').value = id;
            document.getElementById('modalDeletar').classList.add('active');
        }

        function fecharModal(id) {
            document.getElementById(id).classList.remove('active');
        }

        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.remove('active');
            }
        }
    </script>
</body>
</html>
