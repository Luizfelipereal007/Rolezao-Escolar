# Rolezao-Escolar
Rolezão Escolar é uma plataforma criada para facilitar a reserva e organização de visitas a pontos turísticos por escolas. O sistema permite que instituições agendem passeios, consultem disponibilidade, gerenciem turmas e automatizem todo o processo de planejamento dos roteiros. Ideal para tornar excursões mais práticas, seguras e divertidas.









https://github.com/user-attachments/assets/079dd62b-7364-4985-8154-c265eec8a368





instituicao(
  id_instituicao INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(100),
  localizacao VARCHAR(150),
  cnpj VARCHAR(20)
)

professor(
  id_professor INT PRIMARY KEY AUTO_INCREMENT,
  id_instituicao INT,
  nome VARCHAR(100),
  FOREIGN KEY(id_instituicao) REFERENCES instituicao(id_instituicao)
)

ponto_turistico(
  id_ponto_turistico INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(100),
  local VARCHAR(150),
  descricao TEXT,
  custo DECIMAL(10,2)
)

agendamento(
  id_agendamento INT PRIMARY KEY AUTO_INCREMENT,
  id_instituicao INT,
  id_ponto_turistico INT,
  data_visita DATE,
  data_saida TIME,
  quantidade_aluno INT,
  FOREIGN KEY(id_instituicao) REFERENCES instituicao(id_instituicao),
  FOREIGN KEY(id_ponto_turistico) REFERENCES ponto_turistico(id_ponto_turistico)
)


/INSTITUICAO:/

INSERT INTO instituicao (nome, localizacao, cnpj)
VALUES ('IFMS Campo Grande', 'Campo Grande - MS', '00.000.000/0001-00');

SELECT * FROM instituicao;

UPDATE instituicao 
SET nome = 'IFMS Coxim', localizacao = 'Coxim - MS'
WHERE id_instituicao = 1;

DELETE FROM instituicao
WHERE id_instituicao = 1;


/PROFESSOR:/

INSERT INTO professor (id_instituicao, nome)
VALUES (1, 'João da Silva');


SELECT * FROM professor;

UPDATE professor
SET nome = 'João Batista'
WHERE id_professor = 1;


DELETE FROM professor
WHERE id_professor = 1;


/PONTO TURISTICO/

INSERT INTO ponto_turistico (nome, local, descricao, custo)
VALUES ('Trilha da Serra', 'Bonito - MS', 'Trilha leve com cachoeira', 20.00);


SELECT * FROM ponto_turistico;


UPDATE ponto_turistico
SET custo = 25.00
WHERE id_ponto_turistico = 1;


DELETE FROM ponto_turistico
WHERE id_ponto_turistico = 1;
