-- Beschrijving: Aanpassen van kolom "voldaan" naar ENUM

ALTER TABLE betaling
    MODIFY COLUMN voldaan ENUM('ja', 'nee') DEFAULT 'nee';
