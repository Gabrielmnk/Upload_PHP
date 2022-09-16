DROP DATABASE IF EXISTS uploadimage;

CREATE DATABASE  uploadimage CHARACTER SET utf8 COLLATE utf8_general_ci;

USE uploadimage;


CREATE TABLE relogios (
    id_relogio int primary key auto_increment,
    name varchar(255) not null,
    preco float,
    qtd_estoque int not null,
    img varchar(255) not null,
    descr text not null
);