CREATE DATABASE lovebook CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

use lovebook;
CREATE TABLE lovebook_tb_usuario(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	nome CHAR(30) NOT NULL,
	sobrenome VARCHAR(30) NULL,
	usuario VARCHAR(50) NOT NULL,
	email VARCHAR(150) NOT NULL,
	cpf CHAR(14) NOT NULL,
	cep VARCHAR(9) NULL,
	numero VARCHAR(15) NOT NULL,
	senha VARCHAR(40) NOT NULL
);

CREATE TABLE lovebook_tb_administradores(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	nome CHAR(30) NOT NULL,
	sobrenome VARCHAR(30) NULL,
	usuario VARCHAR(50) NOT NULL,
	email VARCHAR(150) NOT NULL,
	senha VARCHAR(40) NOT NULL
);

INSERT INTO lovebook_tb_administradores(
	nome, sobrenome, usuario, email, senha
) VALUES(
	'love',
    'book',
    '#admin',
    'lovebook@admin.com.br',
    'MTIzNDU2Nzg='
);

CREATE TABLE lovebook_tb_autores (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	nome VARCHAR(50) NOT NULL,
	img VARCHAR(150) NOT NULL DEFAULT 'default.png',
	desc_autor VARCHAR(100) NOT NULL,
	data_nascimento DATE NOT NULL DEFAULT CURRENT_DATE,
	estado_civil VARCHAR(30) NULL
);

CREATE TABLE lovebook_tb_books (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	titulo VARCHAR(150) NOT NULL,
	img VARCHAR(200) NOT NULL DEFAULT 'default.png',
	desc_book TEXT NOT NULL,
	paginas INT NOT NULL,

	id_autor INT NOT NULL,
	FOREIGN KEY(id_autor) REFERENCES lovebook_tb_autores(id),

	data_lancamento DATE NOT NULL,
	preco FLOAT NOT NULL
);

CREATE TABLE lovebook_tb_favoritos(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,

	id_usuario INT NOT NULL,
	FOREIGN KEY(id_usuario) REFERENCES lovebook_tb_usuario(id),

	id_book INT NOT NULL,
	FOREIGN KEY(id_book) REFERENCES lovebook_tb_books(id),

	id_autor INT NOT NULL,
	FOREIGN KEY(id_autor) REFERENCES lovebook_tb_autores(id)
);

CREATE TABLE lovebook_tb_pay(
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,

	id_usuario INT NOT NULL,
	FOREIGN KEY(id_usuario) REFERENCES lovebook_tb_usuario(id),

	id_book INT NOT NULL,
	FOREIGN KEY(id_book) REFERENCES lovebook_tb_books(id),

	id_autor INT NOT NULL,
	FOREIGN KEY(id_autor) REFERENCES lovebook_tb_autores(id)
);