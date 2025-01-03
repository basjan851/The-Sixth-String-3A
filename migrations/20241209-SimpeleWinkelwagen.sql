drop table koppeltabel_winkelwagen_product;

alter table winkelwagen
    add product_id int null;

alter table winkelwagen
    add constraint winkelwagen_ibfk_2
        foreign key (product_id) references producten (id);