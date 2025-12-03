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
    $nome_professor = $_POST['nome_professor'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (empty($nome_professor) || empty($senha)) {
        $erro = 'Nome do professor e senha são obrigatórios.';
    } else {
        $auth = new AuthController();
        $usuario = $auth->loginProfessorByName($nome_professor, $senha);
        if ($usuario === false) {
            $erro = 'Nome ou senha incorretos.';
        } else {
            $_SESSION['tipo_usuario'] = 'professor';
            $_SESSION['id_usuario'] = $usuario['id_professor'];
            $_SESSION['id_instituicao'] = $usuario['id_instituicao'];
            $_SESSION['nome_usuario'] = $usuario['nome'];
            $_SESSION['instituicao_nome'] = $usuario['instituicao_nome'];
            header('Location: agendar-visita.php');
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
    <title>Login Professor - Rolezão Escolar</title>
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
                <h2>Login - Professor</h2>
            </div>
            <div class="card-body">
                <?php if ($erro): ?>
                    <div class="alert alert-error">
                        ❌ <?php echo htmlspecialchars($erro); ?>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <label for="nome_professor">Nome do Professor</label>
                        <input type="text" id="nome_professor" name="nome_professor" required>
                    </div>

                    <div class="form-group">
                        <label for="senha">Senha</label>
                        <input type="password" id="senha" name="senha" required>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">Entrar</button>
                </form>

                <p style="text-align: center; margin-top: 1rem;">
                    Não possui cadastro? <a href="cadastro-professor.php" style="color: var(--primary);">Cadastre-se aqui</a>
                </p>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Rolezão Escolar. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
