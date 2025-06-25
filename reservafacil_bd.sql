CREATE DATABASE reservafacil

CREATE TABLE usuarios (
  id_usuario int(11) NOT NULL AUTO_INCREMENT,
  nome varchar(100) NOT NULL,
  email varchar(100) NOT NULL,
  telefone varchar(20) DEFAULT NULL,
  senha varchar(255) NOT NULL,
  cidade varchar(100) DEFAULT NULL,
  bairro varchar(100) DEFAULT NULL,
  universidade varchar(100) DEFAULT NULL,
  tipo_usuario tinyint(4) NOT NULL,  -- 1 = Administrador, 2 = Motorista, 3 = Passageiro   
  status tinyint(1) NOT NULL DEFAULT 1, -- 1 = Ativo, 0 = Inativo
  PRIMARY KEY (id_usuario),
  UNIQUE KEY email (email)
)

CREATE TABLE reservas (
  id_reserva int(11) NOT NULL AUTO_INCREMENT,
  id_usuario int(11) NOT NULL,
  data_viagem DATE NOT NULL DEFAULT (CURDATE()),
  ida tinyint(1) NOT NULL DEFAULT 0,
  volta tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (id_reserva),
  KEY id_usuario (id_usuario),
  CONSTRAINT reservas_ibfk_1 FOREIGN KEY (id_usuario) REFERENCES usuarios (id_usuario)
)