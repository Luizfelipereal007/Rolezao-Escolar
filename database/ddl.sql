CREATE DATABASE rolezao_escolar;
USE rolezao_escolar;

CREATE TABLE instituicao(
  id_instituicao INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  localizacao VARCHAR(150) NOT NULL,
  cnpj VARCHAR(20) NOT NULL,
  senha VARCHAR(255) NOT NULL
);

CREATE TABLE professor(
  id_professor INT PRIMARY KEY AUTO_INCREMENT,
  id_instituicao INT NOT NULL,
  nome VARCHAR(100) NOT NULL,
  senha VARCHAR(255) NOT NULL,
  FOREIGN KEY(id_instituicao) REFERENCES instituicao(id_instituicao)
);

CREATE TABLE ponto_turistico(
  id_ponto_turistico INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(100),
  local VARCHAR(150),
  descricao TEXT,
  custo DECIMAL(10,2),
  foto VARCHAR(500)
);

CREATE TABLE agendamento(
  id_agendamento INT PRIMARY KEY AUTO_INCREMENT,
  id_instituicao INT,
  id_ponto_turistico INT,
  data_visita DATE,
  data_saida DATE,
  quantidade_aluno INT,
  FOREIGN KEY(id_instituicao) REFERENCES instituicao(id_instituicao),
  FOREIGN KEY(id_ponto_turistico) REFERENCES ponto_turistico(id_ponto_turistico)
);

CREATE TABLE administrador (
  id_administrador INT PRIMARY KEY AUTO_INCREMENT,
  senha VARCHAR(255)
);