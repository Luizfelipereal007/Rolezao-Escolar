<?php
/**
 * Script para popular banco de dados com dados de teste
 * Execute via terminal: php seed.php
 */

require_once __DIR__ . '/../config/database.php';

try {
    $pdo = Database::getConnection();
    
    // Dados de teste
    $dados = [
        'instituicoes' => [
            ['nome' => 'IFMS Campo Grande', 'localizacao' => 'Campo Grande - MS', 'cnpj' => '00.000.000/0001-00', 'senha' => 'senha123'],
            ['nome' => 'Escola Municipal', 'localizacao' => 'São Paulo - SP', 'cnpj' => '11.111.111/0001-11', 'senha' => 'senha456'],
        ],
        'professores' => [
            ['id_instituicao' => 1, 'nome' => 'João da Silva', 'senha' => 'prof123'],
            ['id_instituicao' => 1, 'nome' => 'Maria Oliveira', 'senha' => 'prof456'],
            ['id_instituicao' => 2, 'nome' => 'Carlos Santos', 'senha' => 'prof789'],
        ],
        'pontos_turisticos' => [
            ['nome' => 'Trilha da Serra', 'local' => 'Bonito - MS', 'descricao' => 'Trilha leve com cachoeira', 'custo' => 20.00, 'foto' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=500&h=300&fit=crop'],
            ['nome' => 'Cristo Redentor', 'local' => 'Rio de Janeiro - RJ', 'descricao' => 'Monumento icônico do Brasil', 'custo' => 50.00, 'foto' => 'https://images.unsplash.com/photo-1483729558449-99daa62f1dcd?w=500&h=300&fit=crop'],
            ['nome' => 'Pão de Açúcar', 'local' => 'Rio de Janeiro - RJ', 'descricao' => 'Teleférico com vista panorâmica', 'custo' => 60.00, 'foto' => 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=500&h=300&fit=crop'],
        ],
    ];
    
    // Limpar tabelas (desabilitar FK temporariamente)
    $pdo->exec("SET FOREIGN_KEY_CHECKS=0");
    $pdo->exec("TRUNCATE TABLE agendamento");
    $pdo->exec("TRUNCATE TABLE professor");
    $pdo->exec("TRUNCATE TABLE instituicao");
    $pdo->exec("TRUNCATE TABLE ponto_turistico");
    $pdo->exec("SET FOREIGN_KEY_CHECKS=1");
    
    // Inserir instituições
    $stmt = $pdo->prepare("INSERT INTO instituicao (nome, localizacao, cnpj, senha) VALUES (?, ?, ?, ?)");
    foreach ($dados['instituicoes'] as $inst) {
        $senhaHash = password_hash($inst['senha'], PASSWORD_DEFAULT);
        $stmt->execute([$inst['nome'], $inst['localizacao'], $inst['cnpj'], $senhaHash]);
    }
    echo "✓ " . count($dados['instituicoes']) . " instituições inseridas\n";
    
    // Inserir professores
    $stmt = $pdo->prepare("INSERT INTO professor (id_instituicao, nome, senha) VALUES (?, ?, ?)");
    foreach ($dados['professores'] as $prof) {
        $senhaHash = password_hash($prof['senha'], PASSWORD_DEFAULT);
        $stmt->execute([$prof['id_instituicao'], $prof['nome'], $senhaHash]);
    }
    echo "✓ " . count($dados['professores']) . " professores inseridos\n";
    
    // Inserir pontos turísticos
    $stmt = $pdo->prepare("INSERT INTO ponto_turistico (nome, local, descricao, custo, foto) VALUES (?, ?, ?, ?, ?)");
    foreach ($dados['pontos_turisticos'] as $ponto) {
        $stmt->execute([$ponto['nome'], $ponto['local'], $ponto['descricao'], $ponto['custo'], $ponto['foto']]);
    }
    echo "✓ " . count($dados['pontos_turisticos']) . " pontos turísticos inseridos\n";
    
    echo "\n✅ Banco de dados populado com sucesso!\n\n";
    
    // Exibir credenciais de teste
    echo "📝 CREDENCIAIS DE TESTE:\n";
    echo str_repeat("-", 60) . "\n";
    echo "🏫 INSTITUIÇÕES:\n";
    foreach ($dados['instituicoes'] as $inst) {
        echo "  • CNPJ: {$inst['cnpj']} | Senha: {$inst['senha']}\n";
    }
    
    echo "\n👨‍🏫 PROFESSORES:\n";
    foreach ($dados['professores'] as $prof) {
        echo "  • Nome: {$prof['nome']} | Senha: {$prof['senha']}\n";
    }
    
    echo "\n🏞️  PONTOS TURÍSTICOS:\n";
    foreach ($dados['pontos_turisticos'] as $ponto) {
        echo "  • {$ponto['nome']} ({$ponto['local']}) - R$ {$ponto['custo']}\n";
    }
    echo "\n👤 Admin:\n";
    echo "  • Senha: admin123\n";
    echo str_repeat("-", 60) . "\n";
    
} catch (Exception $e) {
    echo "❌ Erro: " . $e->getMessage() . "\n";
    exit(1);
}
?>
