ALTER TABLE koppeltabel_bestelling_product
DROP FOREIGN KEY koppeltabel_bestelling_product_ibfk_1;

ALTER TABLE koppeltabel_bestelling_product
    ADD CONSTRAINT fk_bestellingen FOREIGN KEY (bestellingen_id) REFERENCES bestellingen(id) ON DELETE CASCADE ON UPDATE CASCADE;
