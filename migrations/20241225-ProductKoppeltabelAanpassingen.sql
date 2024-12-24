-- Beschrijving: Toevoegen van aantal en prijs aan koppeltabel_bestelling_product

ALTER TABLE koppeltabel_bestelling_product
    ADD COLUMN aantal INT NOT NULL,
ADD COLUMN prijs DECIMAL(10, 2) NOT NULL;
