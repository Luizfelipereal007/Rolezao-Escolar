-- Instituições (senhas hasheadas com password_hash)
-- senha: senha123
INSERT INTO instituicao (nome, localizacao, cnpj, senha)
VALUES ('IFMS Campo Grande', 'Campo Grande - MS', '00.000.000/0001-00', '$2y$10$YourHashedPasswordHere1');

-- senha: senha456
INSERT INTO instituicao (nome, localizacao, cnpj, senha)
VALUES ('Escola Municipal', 'São Paulo - SP', '11.111.111/0001-11', '$2y$10$YourHashedPasswordHere2');

-- Professores (senhas hasheadas)
-- Nome: João da Silva, Senha: prof123
INSERT INTO professor (id_instituicao, nome, senha)
VALUES (1, 'João da Silva', '$2y$10$YourHashedPasswordHere3');

-- Nome: Maria Oliveira, Senha: prof456
INSERT INTO professor (id_instituicao, nome, senha)
VALUES (1, 'Maria Oliveira', '$2y$10$YourHashedPasswordHere4');

-- Nome: Carlos Santos, Senha: prof789
INSERT INTO professor (id_instituicao, nome, senha)
VALUES (2, 'Carlos Santos', '$2y$10$YourHashedPasswordHere5');

-- Pontos Turísticos
INSERT INTO ponto_turistico (nome, local, descricao, custo, foto)
VALUES ('Trilha da Serra', 'Bonito - MS', 'Trilha leve com cachoeira', 20.00, 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=500&h=300&fit=crop');

INSERT INTO ponto_turistico (nome, local, descricao, custo, foto)
VALUES ('Cristo Redentor', 'Rio de Janeiro - RJ', 'Monumento icônico do Brasil', 50.00, 'https://images.unsplash.com/photo-1483729558449-99daa62f1dcd?w=500&h=300&fit=crop');

INSERT INTO ponto_turistico (nome, local, descricao, custo, foto)
VALUES ('Pão de Açúcar', 'Rio de Janeiro - RJ', 'Teleférico com vista panorâmica', 60.00, 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=500&h=300&fit=crop');