<?php
session_start();
require_once __DIR__ . '/../app/controller/authController.php';
require_once __DIR__ . '/../app/controller/instituicaoController.php';

// Se já está logado, redireciona
if (isset($_SESSION['tipo_usuario'])) {
    header('Location: ../index.php');
    exit;
}

$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $id_instituicao = $_POST['id_instituicao'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';

    // Validações
    if (empty($nome) || empty($id_instituicao) || empty($senha)) {
        $erro = 'Todos os campos são obrigatórios.';
    } elseif (strlen($senha) < 6) {
        $erro = 'A senha deve ter no mínimo 6 caracteres.';
    } elseif ($senha !== $confirmar_senha) {
        $erro = 'As senhas não conferem.';
    } else {
        $auth = new AuthController();
        $instCtrl = new InstituicaoController();

        // Verificar instituição
        $instituicoes = $instCtrl->listar();
        $found = false;
        foreach ($instituicoes as $i) {
            if ($i['id_instituicao'] == $id_instituicao) { $found = true; break; }
        }

        if (!$found) {
            $erro = 'Instituição não encontrada.';
        } else {
            $resultado = $auth->registerProfessor($nome, $senha, $id_instituicao);
            if ($resultado === true) {
                $sucesso = 'Professor cadastrado com sucesso! Redirecionando...';
                header('refresh:2;url=login-professor.php');
            } else {
                $erro = 'Erro ao cadastrar professor: ' . $resultado;
            }
        }
    }
}

// Carregar instituições para select
$instCtrl = new InstituicaoController();
$instituicoes = $instCtrl->listar();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Professor - Rolezão Escolar</title>
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
                <li><a href="login-professor.php">Login</a></li>
            </ul>
        </div>
    </nav>

    <div class="page-container" style="max-width: 500px;">
        <div class="card" style="margin-top: 2rem;">
            <div class="card-header">
                <h2>Cadastro de Professor</h2>
            </div>
            <div class="card-body">
                <?php if ($erro): ?>
                    <div class="alert alert-error">
                        ❌ <?php echo htmlspecialchars($erro); ?>
                    </div>
                <?php endif; ?>

                <?php if ($sucesso): ?>
                    <div class="alert alert-success">
                        ✅ <?php echo htmlspecialchars($sucesso); ?>
                    </div>
                <?php else: ?>
                    <form method="POST">
                        <div class="form-group">
                            <label for="nome">Nome do Professor</label>
                            <input type="text" id="nome" name="nome" required>
                        </div>

                        <div class="form-group">
                            <label for="id_instituicao">Instituição</label>
                            <select id="id_instituicao" name="id_instituicao" required>
                                <option value="">-- Selecione uma instituição --</option>
                                <?php foreach ($instituicoes as $inst): ?>
                                    <option value="<?php echo $inst['id_instituicao']; ?>">
                                        <?php echo htmlspecialchars($inst['nome']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="senha">Senha</label>
                            <input type="password" id="senha" name="senha" required>
                        </div>

                        <div class="form-group">
                            <label for="confirmar_senha">Confirmar Senha</label>
                            <input type="password" id="confirmar_senha" name="confirmar_senha" required>
                        </div>

                        <button type="submit" class="btn btn-primary" style="width: 100%;">Cadastrar</button>
                    </form>

                    <p style="text-align: center; margin-top: 1rem;">
                        Já possui cadastro? <a href="login-professor.php" style="color: var(--primary);">Faça login aqui</a>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Rolezão Escolar. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
