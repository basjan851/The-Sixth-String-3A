-- Beschrijving: Toevoegen van datum en status aan de bestelling-tabel

ALTER TABLE bestelling
    ADD COLUMN datum DATETIME DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN status ENUM('in behandeling', 'betaald', 'verzonden', 'geannuleerd') DEFAULT 'in behandeling';
