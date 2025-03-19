create database ReservaFacil;

CREATE TABLE Usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    telefone VARCHAR(20),
    senha VARCHAR(255) NOT NULL,
    cidade VARCHAR(100),
    bairro VARCHAR(100),
    universidade VARCHAR(100),
    tipo_usuario TINYINT NOT NULL -- 1 = Administrador, 2 = Motorista, 3 = Passageiro   
);


CREATE TABLE Reservas (
    id_reserva INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    data_viagem DATE NOT NULL DEFAULT CURRENT_DATE,
    ida BOOLEAN NOT NULL DEFAULT FALSE,
    volta BOOLEAN NOT NULL DEFAULT FALSE,
    FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario)
);

