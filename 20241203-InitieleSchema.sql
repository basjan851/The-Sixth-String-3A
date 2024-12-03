create table betaalmethodes
(
    id   int auto_increment
        primary key,
    naam varchar(255) not null
);

create table categorie
(
    id   int auto_increment
        primary key,
    naam varchar(50) not null
);

create table dynamische_pagina
(
    id     int auto_increment
        primary key,
    title  varchar(50) not null,
    inhoud longtext    null,
    actief tinyint(1)  not null
);

create table kortingscode
(
    id               int auto_increment
        primary key,
    code             varchar(50) not null,
    percentage       int         null,
    bedrag           int         null,
    eenmalig_gebruik tinyint(1)  not null,
    actief           tinyint(1)  not null
);

create table nieuwsbrief
(
    id    int auto_increment
        primary key,
    email varchar(255) not null
);

create table producten
(
    id           int auto_increment
        primary key,
    productnaam  varchar(255) not null,
    prijs        int          not null,
    beschrijving varchar(255) null,
    voorraad     int          not null,
    actief       tinyint(1)   not null
);

create table koppeltabel_product_categorie
(
    id           int auto_increment
        primary key,
    product_id   int not null,
    categorie_id int not null,
    constraint koppeltabel_product_categorie_ibfk_1
        foreign key (product_id) references producten (id),
    constraint koppeltabel_product_categorie_ibfk_2
        foreign key (categorie_id) references categorie (id)
);

create index categorie_id
    on koppeltabel_product_categorie (categorie_id);

create index product_id
    on koppeltabel_product_categorie (product_id);

create table korting
(
    id                 int auto_increment
        primary key,
    product_id         int        not null,
    korting_percentage int        not null,
    actief             tinyint(1) not null,
    constraint korting_ibfk_1
        foreign key (product_id) references producten (id)
);

create index product_id
    on korting (product_id);

create table product_assets
(
    id         int auto_increment
        primary key,
    product_id int          not null,
    url        varchar(255) null,
    constraint product_assets_ibfk_1
        foreign key (product_id) references producten (id)
);

create index product_id
    on product_assets (product_id);

create table rollen
(
    id           int auto_increment
        primary key,
    naam         varchar(50)  not null,
    beschrijving varchar(255) null
);

create table gebruikers
(
    id         int auto_increment
        primary key,
    email      varchar(255) not null,
    wachtwoord varchar(50)  not null,
    rol        int          not null,
    actief     tinyint(1)   not null,
    constraint gebruikers_ibfk_1
        foreign key (rol) references rollen (id)
);

create table bestelling
(
    id             int auto_increment
        primary key,
    gebruiker_id   int         not null,
    adres          varchar(50) not null,
    postcode       varchar(10) not null,
    plaats         varchar(20) not null,
    land           varchar(20) not null,
    telefoonnummer varchar(13) null,
    naam           varchar(50) not null,
    constraint bestelling_ibfk_1
        foreign key (gebruiker_id) references gebruikers (id)
);

create index gebruiker_id
    on bestelling (gebruiker_id);

create table betaling
(
    id            int auto_increment
        primary key,
    bestelling_id int        not null,
    methode       int        not null,
    bedrag        int        not null,
    voldaan       tinyint(1) not null,
    constraint betaling_ibfk_1
        foreign key (bestelling_id) references bestelling (id),
    constraint methode
        foreign key (methode) references betaalmethodes (id)
);

create index bestelling_id
    on betaling (bestelling_id);

create index rol
    on gebruikers (rol);

create table koppeltabel_bestelling_kortingscode
(
    id              int auto_increment
        primary key,
    bestelling_id   int not null,
    kortingscode_id int not null,
    constraint koppeltabel_bestelling_kortingscode_ibfk_1
        foreign key (bestelling_id) references bestelling (id)
            on delete cascade,
    constraint koppeltabel_bestelling_kortingscode_ibfk_2
        foreign key (kortingscode_id) references kortingscode (id)
            on delete cascade
);

create index bestelling_id
    on koppeltabel_bestelling_kortingscode (bestelling_id);

create index kortingscode_id
    on koppeltabel_bestelling_kortingscode (kortingscode_id);

create table koppeltabel_bestelling_product
(
    id            int auto_increment
        primary key,
    bestelling_id int not null,
    producten_id  int not null,
    constraint koppeltabel_bestelling_product_ibfk_1
        foreign key (bestelling_id) references bestelling (id),
    constraint koppeltabel_bestelling_product_ibfk_2
        foreign key (producten_id) references producten (id)
);

create index bestelling_id
    on koppeltabel_bestelling_product (bestelling_id);

create index producten_id
    on koppeltabel_bestelling_product (producten_id);

create table winkelwagen
(
    id              int auto_increment
        primary key,
    gebruiker_id    int      not null,
    laatst_geupdate datetime not null,
    constraint winkelwagen_ibfk_1
        foreign key (gebruiker_id) references gebruikers (id)
);

create table koppeltabel_winkelwagen_product
(
    id             int auto_increment
        primary key,
    winkelwagen_id int not null,
    product_id     int not null,
    constraint koppeltabel_winkelwagen_product_ibfk_1
        foreign key (winkelwagen_id) references winkelwagen (id)
            on delete cascade,
    constraint koppeltabel_winkelwagen_product_ibfk_2
        foreign key (product_id) references producten (id)
            on delete cascade
);

create index product_id
    on koppeltabel_winkelwagen_product (product_id);

create index winkelwagen_id
    on koppeltabel_winkelwagen_product (winkelwagen_id);

create index gebruiker_id
    on winkelwagen (gebruiker_id);


