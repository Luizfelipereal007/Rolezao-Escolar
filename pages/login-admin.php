<?php
session_start();
require_once __DIR__ . '/../app/controller/authController.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senha_admin = $_POST['senha'] ?? '';
    $auth = new AuthController();
    if ($auth->loginAdmin($senha_admin)) {
        $_SESSION['tipo_usuario'] = 'admin';
        $_SESSION['id_usuario'] = 1;
        $_SESSION['nome_usuario'] = 'Admin';
        header('Location: admin-dashboard.php');
        exit;
    } else {
        $erro = 'Senha de administrador incorreta.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Rolezão Escolar</title>
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
                <h2>Login - Administrador</h2>
            </div>
            <div class="card-body">
                <?php if ($erro): ?>
                    <div class="alert alert-error">
                        ❌ <?php echo htmlspecialchars($erro); ?>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <label for="senha">Senha de Administrador</label>
                        <input type="password" id="senha" name="senha" placeholder="Digite a senha" required>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">Entrar</button>
                </form>

                <p style="text-align: center; margin-top: 1rem; color: #666; font-size: 0.9rem;">
                    Acesso restrito a administradores
                </p>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Rolezão Escolar. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
