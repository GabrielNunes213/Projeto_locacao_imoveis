CREATE DATABASE locacao_imoveis;

USE locacao_imoveis;

CREATE TABLE anunciante (
id_anunciante INT AUTO_INCREMENT,
anunciante_email VARCHAR(50),
anunciante_nome VARCHAR(50),
anunciante_telefone VARCHAR(14),
anunciante_cpf VARCHAR(11),
PRIMARY KEY(id_anunciante)
);

CREATE TABLE imovel (
id_imovel INT AUTO_INCREMENT,
sobre_imovel VARCHAR(300),
diretorio_foto_imovel VARCHAR(50),
numero_quartos INT(2),
cep INT(8),
numero_imovel INT(6),
rua VARCHAR(50),
bairro VARCHAR(50),
cidade VARCHAR(30),
estado VARCHAR(2),
valor_imovel INT(20),
id_anunciante_id INT,
PRIMARY KEY(id_imovel),
FOREIGN KEY (id_anunciante_id) REFERENCES anunciante (id_anunciante)
);

#Abaixo alguns comandos para facilitar.
#SELECT * FROM imovel;
#SELECT * FROM anunciante;
#SELECT * FROM anunciante INNER JOIN imovel on (id_anunciante = id_anunciante_id);
#DROP DATABASE locacao_imoveis;