# 🚀 Guia Rápido de Inicialização

## ⚡ 5 Passos para Começar

### Passo 1️⃣: Criar o Banco de Dados

1. Abra o phpMyAdmin: `http://localhost/phpmyadmin`
2. Crie um novo banco de dados chamado `rolezao_escolar`
3. Selecione o banco e vá para "SQL"
4. Cole o conteúdo de `database/ddl.sql`
5. Execute (Ctrl+Enter)

**Ou via terminal:**
```bash
mysql -u root -p < database/ddl.sql
```

### Passo 2️⃣: Testar

Acesse: `http://localhost/Rolezao-Escolar/test/app/model/testDbModels.php`

Você deve ver:
- ✅ Todos os arquivos
- ✅ PHP 7.4+
- ✅ PDO disponível
- ✅ Conexão com banco funcionando

### Passo 3️⃣: Acessar a Página Inicial

Abra em seu navegador:
```
http://localhost/Rolezao-Escolar/index.php
```

### Passo 4️⃣: Testar os Fluxos

#### Como Professor:
1. Cadastro: `pages/cadastro-professor.php`
2. Selecione uma instituição (você pode criar primeiro)
3. Login: `pages/login-professor.php` (use o ID fornecido)
4. Agende uma visita
5. Veja suas visitas

#### Como Instituição:
1. Cadastro: `pages/cadastro-instituicao.php`
2. Login: `pages/login-instituicao.php`
3. Veja o dashboard
4. Autorize ou denuncie visitas

#### Como Admin:
1. Login: `pages/login-admin.php`
2. Senha: `admin123`
3. Gerencie pontos turísticos (criar, editar, deletar)

### Passo 5️⃣: Explorar Funcionalidades

- 📊 Ver ranking: `pages/ranking.php`
- ❓ Ver ajuda: `pages/help.php`
- 📱 Testar responsividade (abra em mobile)
- 🎨 Explore a interface

---

## 📱 Testar em Mobile

### Usando Chrome DevTools:
1. Pressione F12
2. Clique no ícone de celular (top esquerdo)
3. Selecione um dispositivo (iPhone, Galaxy, etc)
4. Teste a navegação e interação

---

## 🔑 Credenciais Padrão

### ADMIN
- **URL**: `pages/login-admin.php`
- **Senha**: `admin123`

### INSTITUIÇÃO (Exemplo)
- **URL**: `pages/login-instituicao.php`
- **CNPJ**: Após cadastro
- **Senha**: Que você definir

### PROFESSOR (Exemplo)
- **URL**: `pages/login-professor.php`
- **ID**: Fornecido após cadastro
- **Senha**: Que você definir

---

## 📋 Checklist de Verificação

- [ ] Banco de dados criado
- [ ] Arquivo `teste.php` passa em todas verificações
- [ ] Página inicial carrega corretamente
- [ ] Consigo fazer cadastro de instituição
- [ ] Consigo fazer cadastro de professor
- [ ] Consigo fazer login de admin
- [ ] Consigo agendar uma visita
- [ ] Ranking carrega corretamente
- [ ] Responsividade funciona em mobile
- [ ] APIs retornam JSON corretamente

---

## 🐛 Solução Rápida de Problemas

### "Erro de conexão com banco"
```
✓ Abra config/database.php
✓ Verifique usuário, senha, host
✓ Certifique-se que MySQL está rodando
✓ Certifique-se que banco foi criado
```

### "Páginas em branco"
```
✓ Ative erros no PHP:
  - Abra config/database.php
  - Adicione: ini_set('display_errors', 1);
✓ Veja o erro no browser console (F12)
```

### "Sessão expirada"
```
✓ Limpe cookies do navegador
✓ Faça login novamente
✓ Verifique se PHP sessions está habilitado
```

### "Botões não funcionam"
```
✓ Abra console (F12)
✓ Procure por erros em JavaScript
✓ Certifique-se que main.js foi carregado
```

---

## 📊 Dados de Teste Sugeridos

Para testar melhor, crie:

### Instituições
- Escola Municipal ABC
- Colégio XYZ
- Instituto de Ensino DEF

### Pontos Turísticos
- Cristo Redentor - R$ 50
- Iguazu Falls - R$ 45
- Pão de Açúcar - R$ 40
- Ouro Preto - R$ 35

### Professores
- João da Silva
- Maria Santos
- Pedro Oliveira

---

## 🔗 Links Importantes

| Página | URL |
|--------|-----|
| Início | `index.php` |
| Teste | `teste.php` |
| Ajuda | `pages/help.php` |
| Admin | `pages/admin-dashboard.php` |
| Ranking | `pages/ranking.php` |
| API Pontos | `api/pontos-populares.php` |
| API Stats | `api/estatisticas.php` |

---

## 📚 Documentação Disponível

1. **README.md** - Documentação geral
2. **SETUP_COMPLETO.md** - Setup e configuração
3. **FRONTEND_SUMMARY.md** - Sumário do frontend
4. **API_DOCUMENTATION.md** - Documentação de APIs
5. **GUIA_RAPIDO.md** - Este arquivo

---

## 🎓 Próximos Passos (Opcional)

Depois que estiver funcionando:

1. Customize cores no `public/css/style.css`
2. Adicione mais pontos turísticos
3. Implemente notificações por email
4. Teste em um servidor real
5. Configure HTTPS/SSL
6. Implemente backups automáticos

---

## 📞 Suporte

Se encontrar problemas:

1. Verifique o arquivo `teste.php`
2. Veja a documentação relevante
3. Procure na central de ajuda (`pages/help.php`)
4. Verifique logs do PHP e MySQL

---

## ✨ Você está pronto para usar!

Parabéns! Seu sistema Rolezão Escolar está instalado e pronto para uso.

**Aproveite! 🎉**

---

**Guia Rápido - Rolezão Escolar v1.0.0**  
**Data: 3 de Dezembro de 2025**
