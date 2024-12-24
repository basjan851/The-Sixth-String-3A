<?php
session_start();
require_once '../../helpers/databaseconnector.php';

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['user']['id'])) {
    die(json_encode(['status' => 'error', 'message' => 'Gebruiker is niet ingelogd.']));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gebruiker_id = $_SESSION['user']['id'];
    $voornaam = $_POST['voornaam'] ?? '';
    $achternaam = $_POST['achternaam'] ?? '';
    $adres = $_POST['adres'] ?? '';
    $telefoon = $_POST['telefoon'] ?? '';
    $plaatsnaam = $_POST['plaatsnaam'] ?? '';
    $postcode = $_POST['postcode'] ?? '';
    $land = $_POST['land'] ?? '';
    $betaalmethode = $_POST['betaalmethode'] ?? '';
    $totaal_waarde = $_POST['totaal_waarde'] ?? 0;

    // Controleer of alle velden zijn ingevuld
    if (empty($voornaam) || empty($achternaam) || empty($adres) || empty($telefoon) || empty($plaatsnaam) || empty($postcode) || empty($land) || empty($betaalmethode)) {
        die(json_encode(['status' => 'error', 'message' => 'Vul alle verplichte velden in.']));
    }

    $db = connect_db();

    // Sla de bestelling op in de database
    $query = "INSERT INTO bestellingen (gebruiker_id, totaal_waarde, betaalmethode, voornaam, achternaam, adres, telefoon, plaatsnaam, postcode, land)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param(
        "idssssssss",
        $gebruiker_id,
        $totaal_waarde,
        $betaalmethode,
        $voornaam,
        $achternaam,
        $adres,
        $telefoon,
        $plaatsnaam,
        $postcode,
        $land
    );

    if ($stmt->execute()) {
        // Leeg de winkelwagen
        $query2 = "DELETE FROM winkelwagen WHERE gebruiker_id = ?";
        $stmt2 = $db->prepare($query2);
        $stmt2->bind_param("i", $gebruiker_id);
        $stmt2->execute();

        echo json_encode(['status' => 'success', 'message' => 'Bestelling succesvol geplaatst!']);
        exit;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Fout bij het plaatsen van de bestelling: ' . $stmt->error]);
        exit;
    }
}
?>