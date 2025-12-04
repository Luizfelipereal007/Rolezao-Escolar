# 🎒 Rolezão Escolar - Sistema de Turismo Escolar

Sistema web completo para gerenciamento de visitas turísticas escolares, permitindo que professores agmendem visitas a pontos turísticos, instituições gerenciem as visitas e administradores cadastrem novos pontos turísticos.

## 📋 Características Principais

### Para Professores
- ✅ Cadastro e login
- ✅ Agendar visitas a pontos turísticos
- ✅ Informar dados da visita (instituição, número de alunos, datas)
- ✅ Visualizar histórico de visitas
- ✅ Ver ranking de lugares mais visitados

### Para Instituições (Escolas)
- ✅ Cadastro e login
- ✅ Dashboard com estatísticas
- ✅ Visualizar todas as visitas agendadas
- ✅ Autorizar ou denunciar visitas
- ✅ Ver informações completas da instituição

### Para Administradores
- ✅ Login com senha
- ✅ Cadastrar novos pontos turísticos
- ✅ Editar pontos turísticos
- ✅ Deletar pontos turísticos
- ✅ Gerenciar custos dos pontos

### Para Usuários (Públicos)
- ✅ Ver página inicial com pontos populares
- ✅ Visualizar ranking de lugares mais visitados
- ✅ Visualizar ranking de escolas com mais visitas
- ✅ Ver estatísticas gerais do sistema

## 🛠️ Instalação

### Pré-requisitos
- PHP 7.4+
- MySQL 5.7+
- XAMPP ou servidor Apache com PHP

### Passo 1: Clonar o Repositório
```bash
git clone https://github.com/Luizfelipereal007/Rolezao-Escolar.git
cd Rolezao-Escolar
```

### Passo 2: Criar Banco de Dados
1. Abra o phpMyAdmin em `http://localhost/phpmyadmin`
2. Execute os comandos SQL em `database/ddl.sql` e `database/dml.sql`

Ou via linha de comando:
```bash
mysql -u root -p < database/ddl.sql
mysql -u root -p rolezao_escolar < database/dml.sql
```

### Passo 3: Configurar Banco de Dados
Edite `config/database.php` com suas credenciais MySQL:
```php
private static $host = 'localhost';
private static $user = 'root';
private static $password = '';
private static $dbname = 'rolezao_escolar';
```

### Passo 4: Acessar a Aplicação
Abra em seu navegador:
```
http://localhost/Rolezao-Escolar/index.php
```

## 📁 Estrutura do Projeto

```
Rolezao-Escolar/
├── index.php                          # Página inicial
├── config/
│   └── database.php                   # Configuração do banco de dados
├── app/
│   ├── controller/                    # Controllers da aplicação
│   │   └── cadastrarInstituicaoController.php
│   ├── model/                         # Models do banco de dados
│   │   ├── agendamentoModel.php
│   │   ├── instituicaoModel.php
│   │   ├── pontoTuristicoModel.php
│   │   └── professorModel.php
│   └── view/
│       └── view.php
├── pages/                             # Páginas da aplicação
│   ├── cadastro-instituicao.php
│   ├── cadastro-professor.php
│   ├── login-instituicao.php
│   ├── login-professor.php
│   ├── login-admin.php
│   ├── agendar-visita.php
│   ├── minhas-visitas.php
│   ├── ranking.php
│   ├── dashboard-instituicao.php
│   └── admin-dashboard.php
├── auth/
│   └── logout.php
├── api/                               # APIs para requisições AJAX
│   ├── pontos-populares.php
│   └── estatisticas.php
├── public/
│   ├── css/
│   │   └── style.css                  # Estilos da aplicação
│   ├── js/
│   │   └── main.js
│   └── img/
├── database/
│   ├── ddl.sql                        # Script de criação das tabelas
│   └── dml.sql                        # Script de dados iniciais
└── test/
    └── config/
        └── testeBanco.php
```

## 🔐 Credenciais de Teste

### Admin e Instituicao
- **Senha**: `123`

## 🔄 Fluxo de Uso

### Professor
1. Cadastro → Login → Agendar Visita → Ver Minhas Visitas → Ver Ranking

### Instituição
1. Cadastro → Login → Dashboard → Visualizar Visitas → Autorizar/Denunciar

### Admin
1. Login → Dashboard Admin → Cadastrar/Editar/Deletar Pontos Turísticos

## 🎨 Design

- Interface responsiva e moderna
- Paleta de cores profissional (Roxo e Azul)
- Totalmente compatível com dispositivos móveis
- Animações suaves e feedback visual

## 📊 Funcionalidades em Detalhes

### Agendamento de Visitas
- Seleção do ponto turístico
- Número de alunos
- Datas de início e saída
- Cálculo automático de custo total

### Dashboard da Instituição
- Estatísticas de visitas
- Lista de visitas programadas
- Opções de autorizar ou denunciar
- Informações da instituição

### Admin Dashboard
- Interface para gerenciar pontos turísticos
- CRUD completo de pontos turísticos
- Modal para edição rápida
- Confirmação antes de deletar

### Ranking
- Pontos turísticos mais visitados
- Escolas com mais visitas
- Total de alunos viajados
- Estatísticas gerais

### Erro de conexão com banco de dados
- Verifique se o MySQL está rodando
- Confirme as credenciais em `config/database.php`
- Certifique-se que o banco de dados foi criado

### Páginas em branco
- Verifique os erros no `php-error.log`
- Certifique-se que o PHP está instalado corretamente
- Ative o debug no código

### Erro 404 nas páginas
- Verifique se os arquivos estão no diretório correto
- Confirme que a URL está correta
- Reinicie o servidor Apache

- **Repositório**: https://github.com/Luizfelipereal007/Rolezao-Escolar