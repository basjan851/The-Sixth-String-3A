CREATE TABLE bestellingen (
                              id INT AUTO_INCREMENT PRIMARY KEY,
                              gebruiker_id INT NOT NULL,
                              totaal_waarde DECIMAL(10, 2) NOT NULL,
                              betaalmethode VARCHAR(50) NOT NULL,
                              voornaam VARCHAR(100) NOT NULL,
                              achternaam VARCHAR(100) NOT NULL,
                              adres VARCHAR(255) NOT NULL,
                              telefoon VARCHAR(15) NOT NULL,
                              plaatsnaam VARCHAR(100) NOT NULL,
                              postcode VARCHAR(10) NOT NULL,
                              land VARCHAR(50) NOT NULL,
                              datum DATETIME DEFAULT CURRENT_TIMESTAMP,
                              status ENUM('in behandeling', 'betaald', 'verzonden', 'geannuleerd') DEFAULT 'in behandeling'
);
