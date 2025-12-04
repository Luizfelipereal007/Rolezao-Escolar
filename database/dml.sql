-- Instituições 
INSERT INTO instituicao (nome, localizacao, cnpj, senha)
VALUES ('IFMS Campo Grande', 'Campo Grande - MS', '00.000.000/0001-00', '$2y$10$.HyNOnHSxKD4EAJ4gjiNf.5HiDRGngQIoPgZXyHF4PobeLQn3RU7u');

INSERT INTO instituicao (nome, localizacao, cnpj, senha)
VALUES ('Escola Municipal', 'Campo Grande - MS', '11.111.111/0001-11', '$2y$10$.HyNOnHSxKD4EAJ4gjiNf.5HiDRGngQIoPgZXyHF4PobeLQn3RU7u');

-- Professores
INSERT INTO professor (id_instituicao, nome, senha)
VALUES (1, 'João da Silva', '$2y$10$.HyNOnHSxKD4EAJ4gjiNf.5HiDRGngQIoPgZXyHF4PobeLQn3RU7u');

INSERT INTO professor (id_instituicao, nome, senha)
VALUES (1, 'Maria Oliveira', '$2y$10$.HyNOnHSxKD4EAJ4gjiNf.5HiDRGngQIoPgZXyHF4PobeLQn3RU7u');

INSERT INTO professor (id_instituicao, nome, senha)
VALUES (2, 'Carlos Santos', '$2y$10$.HyNOnHSxKD4EAJ4gjiNf.5HiDRGngQIoPgZXyHF4PobeLQn3RU7u');

-- Pontos Turísticos
INSERT INTO ponto_turistico (nome, local, descricao, custo, foto)
VALUES ('Trilha da Serra', 'Bonito - MS', 'Trilha leve com cachoeira', 20.00, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQMEwLjrB-qlj8dx4khAIUByorEgVCNTRr2_g&s');

INSERT INTO ponto_turistico (nome, local, descricao, custo, foto)
VALUES ('Gruta do Lago Azul', 'Bonito - MS', 'Caverna com lago subterrâneo de água azul cristalina, um dos cartões-postais de Bonito.', 80.00, 'https://images.squarespace-cdn.com/content/v1/628cdf23e74da0654141fc99/1d40521c-f8a1-4dd3-82cf-746806579782/lagoa+azul.jpg');

INSERT INTO ponto_turistico (nome, local, descricao, custo, foto)
VALUES ('Rio da Prata', 'Jardim - MS', 'Flutuação em águas cristalinas com grande diversidade de peixes.', 150.00, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcToErTMU61PaUAAu8r6tiRpbqapCvAWzEym4Q&s');

INSERT INTO ponto_turistico (nome, local, descricao, custo, foto)
VALUES ('Buraco das Araras', 'Jardim - MS', 'Enorme dolina natural onde vivem diversas araras vermelhas.', 60.00, 'https://upload.wikimedia.org/wikipedia/commons/8/88/Buraco_das_Araras_Jardim_MS_Brazil.jpg');

INSERT INTO ponto_turistico (nome, local, descricao, custo, foto)
VALUES ('Boca da Onça', 'Bodoquena - MS', 'Cachoeira mais alta do Mato Grosso do Sul, com 156 metros de queda.', 120.00, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS9La1N1mkktGJF3RY8bNTuHBXXaKc0LP1yOg&s');

INSERT INTO ponto_turistico (nome, local, descricao, custo, foto)
VALUES ('Pantanal Sul', 'Corumbá - MS', 'Região ideal para safáris fotográficos, observação de animais e passeios de barco.', 200.00, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ13Ld3haMbOMTbLrxfe0QsKQd98mYZjwp2og&s');


-- Administrador
INSERT INTO administrador (senha)
VALUES ('$2y$10$.HyNOnHSxKD4EAJ4gjiNf.5HiDRGngQIoPgZXyHF4PobeLQn3RU7u');