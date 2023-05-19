create database if not exists tp9;

use tp9;

create table if not exists login (
    id_login int AUTO_INCREMENT UNIQUE NOT NULL,
    token varchar(50),
    username varchar(50),
    mail varchar(50),
    mdp text,
    privilege int,
    primary key (id_login)
);

create table if not exists client (
    id_client int AUTO_INCREMENT UNIQUE NOT NULL,
    nom varchar(50),
    prenom varchar(50),
    adresse varchar(100),
    complement_adresse varchar(50),
    code_postal varchar(10),
    ville varchar(100),
    pays varchar(100),
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
    primary key (id_commande),
    foreign key (from_client) references client (id_client) on delete cascade on update cascade
);

create table if not exists contenu_commande (
    id_contenue int AUTO_INCREMENT UNIQUE NOT NULL,
    num_commande int,
    num_produit int,
    quantite int,
    primary key(id_contenue),
    foreign key (num_commande) references commande (id_commande) on delete cascade on update cascade,
    foreign key (num_produit) references produit (id_produit) on delete cascade on update cascade
);