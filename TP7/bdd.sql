create database if not exists tp7;

use tp7;

create table if not exists client (
    id_client int AUTO_INCREMENT UNIQUE NOT NULL,
    nom varchar(50),
    prenom varchar(50),
    adresse text,
    code_postal varchar(10),
    ville varchar(100),
    primary key (id_client)
);

create table if not exists produit (
    id_produit int AUTO_INCREMENT UNIQUE NOT NULL,
    code_produit varchar(50),
    libelle varchar(100),
    prix_unitaire float,
    primary key (id_produit)
);

create table if not exists commande (
    id_commande int AUTO_INCREMENT UNIQUE NOT NULL,
    from_client int,
    date timestamp,
    adresse_livraison text,
    num_produit int,
    quantite int,
    primary key (id_commande),
    foreign key (from_client) references client (id_client) on delete cascade on update cascade,
    foreign key (num_produit) references produit (id_produit) on delete cascade on update cascade
);