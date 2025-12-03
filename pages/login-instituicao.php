<?php
session_start();
require_once __DIR__ . '/../app/controller/authController.php';

// Se já está logado, redireciona
if (isset($_SESSION['tipo_usuario'])) {
    header('Location: ../index.php');
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cnpj = $_POST['cnpj'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (empty($cnpj) || empty($senha)) {
        $erro = 'CNPJ e senha são obrigatórios.';
    } else {
        $auth = new AuthController();
        $instituicao = $auth->loginInstituicao($cnpj, $senha);
        if ($instituicao === false) {
            $erro = 'CNPJ ou senha incorretos.';
        } else {
            $_SESSION['tipo_usuario'] = 'instituicao';
            $_SESSION['id_usuario'] = $instituicao['id_instituicao'];
            $_SESSION['nome_usuario'] = $instituicao['nome'];
            header('Location: dashboard-instituicao.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Instituição - Rolezão Escolar</title>
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
            </ul>
        </div>
    </nav>

    <div class="page-container" style="max-width: 500px;">
        <div class="card" style="margin-top: 2rem;">
            <div class="card-header">
                <h2>Login - Instituição</h2>
            </div>
            <div class="card-body">
                <?php if ($erro): ?>
                    <div class="alert alert-error">
                        ❌ <?php echo htmlspecialchars($erro); ?>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <label for="cnpj">CNPJ</label>
                        <input type="text" id="cnpj" name="cnpj" placeholder="00.000.000/0000-00" required>
                    </div>

                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="password" id="senha" name="senha" required>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">Entrar</button>
                </form>

                <p style="text-align: center; margin-top: 1rem;">
                    Não possui cadastro? <a href="cadastro-instituicao.php" style="color: var(--primary);">Cadastre-se aqui</a>
                </p>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Rolezão Escolar. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
