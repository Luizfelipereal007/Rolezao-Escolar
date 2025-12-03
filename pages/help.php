<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajuda - Rolezão Escolar</title>
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
                <li><a href="help.php">Ajuda</a></li>
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
            <h1>❓ Centro de Ajuda</h1>

            <!-- Seção Professor -->
            <div class="card" style="margin-bottom: 2rem;">
                <div class="card-header">
                    <h2>👨‍🏫 Para Professores</h2>
                </div>
                <div class="card-body">
                    <div style="background: var(--light); padding: 1.5rem; border-radius: 8px; margin-bottom: 1rem;">
                        <h3>1. Como me cadastrar?</h3>
                        <p>
                            Acesse a página de <strong>Cadastro de Professor</strong>, preencha seu nome, selecione sua instituição,
                            crie uma senha e confirme. Você receberá um ID de professor que será necessário para login.
                        </p>
                    </div>

                    <div style="background: var(--light); padding: 1.5rem; border-radius: 8px; margin-bottom: 1rem;">
                        <h3>2. Como agendar uma visita?</h3>
                        <p>
                            Após fazer login, clique em <strong>"Agendar Visita"</strong>. Escolha o ponto turístico desejado,
                            informe a quantidade de alunos, as datas de início e saída. O sistema calculará o custo total automaticamente.
                        </p>
                    </div>

                    <div style="background: var(--light); padding: 1.5rem; border-radius: 8px; margin-bottom: 1rem;">
                        <h3>3. Como visualizar minhas visitas?</h3>
                        <p>
                            Acesse <strong>"Minhas Visitas"</strong> para ver todas as visitas agendadas pela sua instituição.
                            Você poderá ver datas, local, número de alunos e custo total de cada visita.
                        </p>
                    </div>

                    <div style="background: var(--light); padding: 1.5rem; border-radius: 8px;">
                        <h3>4. O que significa a senha gerada?</h3>
                        <p>
                            Após o cadastro, você receberá um <strong>ID único</strong> que serve como seu identificador no sistema.
                            Guarde bem! Você precisará dele junto com sua senha para fazer login.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Seção Instituição -->
            <div class="card" style="margin-bottom: 2rem;">
                <div class="card-header">
                    <h2>🏫 Para Instituições</h2>
                </div>
                <div class="card-body">
                    <div style="background: var(--light); padding: 1.5rem; border-radius: 8px; margin-bottom: 1rem;">
                        <h3>1. Como me cadastrar?</h3>
                        <p>
                            Acesse <strong>"Cadastro de Instituição"</strong>, preencha o nome da sua escola, CNPJ,
                            localização e crie uma senha. Após cadastro, você poderá fazer login com seu CNPJ.
                        </p>
                    </div>

                    <div style="background: var(--light); padding: 1.5rem; border-radius: 8px; margin-bottom: 1rem;">
                        <h3>2. O que é o Dashboard?</h3>
                        <p>
                            O Dashboard é seu painel de controle onde você pode:
                            <br>✓ Ver estatísticas de visitas
                            <br>✓ Visualizar todas as visitas agendadas
                            <br>✓ Autorizar ou denunciar visitas
                            <br>✓ Gerenciar dados da instituição
                        </p>
                    </div>

                    <div style="background: var(--light); padding: 1.5rem; border-radius: 8px; margin-bottom: 1rem;">
                        <h3>3. Como autorizar uma visita?</h3>
                        <p>
                            No Dashboard, você verá todas as visitas agendadas. Use o botão <strong>"✓"</strong> para autorizar
                            uma visita que você aprova. A visita será então confirmada no sistema.
                        </p>
                    </div>

                    <div style="background: var(--light); padding: 1.5rem; border-radius: 8px;">
                        <h3>4. Como denunciar uma visita?</h3>
                        <p>
                            Se identificar irregularidades, use o botão <strong>"✗"</strong> e descreva o motivo da denúncia.
                            Os administradores serão notificados e tomarão as medidas necessárias.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Seção Admin -->
            <div class="card" style="margin-bottom: 2rem;">
                <div class="card-header">
                    <h2>🔐 Para Administradores</h2>
                </div>
                <div class="card-body">
                    <div style="background: var(--light); padding: 1.5rem; border-radius: 8px; margin-bottom: 1rem;">
                        <h3>1. Como faço login?</h3>
                        <p>
                            Acesse a página <strong>"Login Admin"</strong> e digite a senha de administrador fornecida pelo sistema.
                            (Senha padrão: <code style="background: white; padding: 2px 4px;">admin123</code>)
                        </p>
                    </div>

                    <div style="background: var(--light); padding: 1.5rem; border-radius: 8px; margin-bottom: 1rem;">
                        <h3>2. Como adicionar um ponto turístico?</h3>
                        <p>
                            No Dashboard Admin, preencha o formulário "Novo Ponto Turístico" com:
                            <br>• Nome do local
                            <br>• Localização (cidade, estado)
                            <br>• Descrição
                            <br>• Custo por aluno (em R$)
                            <br>Clique em "Criar Ponto Turístico" para salvar.
                        </p>
                    </div>

                    <div style="background: var(--light); padding: 1.5rem; border-radius: 8px; margin-bottom: 1rem;">
                        <h3>3. Como editar um ponto turístico?</h3>
                        <p>
                            Na seção "Pontos Turísticos Cadastrados", clique no ícone de lápis (✏️) do local desejado.
                            Atualize os dados no modal que aparecer e clique em "Salvar Alterações".
                        </p>
                    </div>

                    <div style="background: var(--light); padding: 1.5rem; border-radius: 8px;">
                        <h3>4. Como deletar um ponto turístico?</h3>
                        <p>
                            Clique no botão "🗑️ Deletar" do ponto turístico desejado. Uma confirmação aparecerá.
                            <strong>Atenção:</strong> Esta ação não pode ser desfeita!
                        </p>
                    </div>
                </div>
            </div>

            <!-- FAQ Geral -->
            <div class="card">
                <div class="card-header">
                    <h2>❓ Perguntas Frequentes</h2>
                </div>
                <div class="card-body">
                    <div style="background: var(--light); padding: 1.5rem; border-radius: 8px; margin-bottom: 1rem;">
                        <h3>O sistema calcula custos automaticamente?</h3>
                        <p>
                            Sim! O custo total é calculado como: <strong>custo por aluno × quantidade de alunos × dias de visita</strong>.
                            O sistema ajusta automaticamente conforme você muda os valores.
                        </p>
                    </div>

                    <div style="background: var(--light); padding: 1.5rem; border-radius: 8px; margin-bottom: 1rem;">
                        <h3>Posso cancelar uma visita agendada?</h3>
                        <p>
                            Atualmente o sistema não permite cancelamento direto. Entre em contato com o administrador para mais informações.
                        </p>
                    </div>

                    <div style="background: var(--light); padding: 1.5rem; border-radius: 8px; margin-bottom: 1rem;">
                        <h3>Como funciona o ranking?</h3>
                        <p>
                            O ranking mostra os pontos turísticos mais visitados e as escolas que fazem mais viagens.
                            Quanto mais visitas agendadas, maior o ranking!
                        </p>
                    </div>

                    <div style="background: var(--light); padding: 1.5rem; border-radius: 8px; margin-bottom: 1rem;">
                        <h3>Esqueci minha senha, o que faço?</h3>
                        <p>
                            Entre em contato com o administrador do sistema para resetar sua senha.
                        </p>
                    </div>

                    <div style="background: var(--light); padding: 1.5rem; border-radius: 8px;">
                        <h3>Posso usar o sistema em dispositivos móveis?</h3>
                        <p>
                            Sim! O sistema é totalmente responsivo e funciona perfeitamente em smartphones e tablets.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Contato -->
            <div class="card" style="margin-top: 2rem; background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%); color: white; border: none;">
                <div class="card-body" style="text-align: center;">
                    <h2 style="margin-top: 0; color: white;">Ainda precisa de ajuda?</h2>
                    <p>Entre em contato com o suporte técnico do Rolezão Escolar</p>
                    <p style="font-size: 1.1rem; margin: 1rem 0;">
                        📧 <strong>Email</strong>: suporte@rolezao-escolar.com<br>
                        📞 <strong>Telefone</strong>: (67) 3000-0000<br>
                        🕐 <strong>Horário</strong>: Segunda a Sexta, 8h às 18h
                    </p>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2025 Rolezão Escolar. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
