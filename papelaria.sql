create database papelaria1;
use papelaria1;

create table vendas(
idvenda int primary key auto_increment,
data_venda varchar(10) not null,
nome_cliente varchar(50) not null,
produto varchar(100) not null,
quantidade int not null,
valor int not null);

select * from vendas;

create table produtos(
idproduto int primary key auto_increment,
nomep varchar(50) not null,
fabricante varchar(50) not null,
preco decimal(10,2) not null,
estoque int not null);

select * from produtos;