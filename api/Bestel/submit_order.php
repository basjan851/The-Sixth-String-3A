<?php

require_once(__DIR__ . '/../helpers/databaseconnector.php');
require_once(__DIR__ . '/../helpers/winkelwagen.php');

session_start();
$dbcon = connect_db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF-token valideren
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die(json_encode(["status" => "error", "message" => "Ongeldig CSRF-token."]));
    }

    // Gegevens valideren
    $required_fields = ['voornaam', 'achternaam', 'adres', 'telefoon', 'plaatsnaam', 'postcode', 'land', 'betaalmethode'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            die(json_encode(["status" => "error", "message" => "Veld '$field' is verplicht."]));
        }
    }

    // Winkelwagen ophalen
    $winkelwagen = get_winkelwagen($dbcon, $_SESSION['user']['id']);
    if (!$winkelwagen || empty($winkelwagen['producten'])) {
        die(json_encode(["status" => "error", "message" => "Winkelwagen is leeg."]));
    }

    // Factuurgegevens
    $naam = htmlspecialchars($_POST['voornaam']) . ' ' . htmlspecialchars($_POST['achternaam']);
    $adres = htmlspecialchars($_POST['adres']);
    $postcode = htmlspecialchars($_POST['postcode']);
    $plaats = htmlspecialchars($_POST['plaatsnaam']);
    $land = htmlspecialchars($_POST['land']);
    $telefoon = htmlspecialchars($_POST['telefoon']);
    $betaalmethode = htmlspecialchars($_POST['betaalmethode']);
    $totaalbedrag = $winkelwagen['totale_prijs']; // Ophalen uit winkelwagen

    try {
        $dbcon->begin_transaction();

        // Bestelling opslaan
        $stmt = $dbcon->prepare("INSERT INTO bestelling (gebruiker_id, adres, postcode, plaats, land, telefoonnummer, naam) 
                                  VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "issssss",
            $_SESSION['user']['id'],
            $adres,
            $postcode,
            $plaats,
            $land,
            $telefoon,
            $naam
        );
        $stmt->execute();
        $bestelling_id = $stmt->insert_id;

        // Betaling opslaan
        $stmt = $dbcon->prepare("INSERT INTO betaling (bestelling_id, methode, bedrag, voldaan) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isii", $bestelling_id, $betaalmethode, $totaalbedrag, $voldaan = 0);
        $stmt->execute();

        // Producten uit winkelwagen aan bestelling koppelen
        $stmt = $dbcon->prepare("INSERT INTO koppeltabel_bestelling_product (bestelling_id, producten_id) VALUES (?, ?)");
        foreach ($winkelwagen['producten'] as $product_id => $product) {
            $stmt->bind_param("ii", $bestelling_id, $product_id);
            $stmt->execute();
        }

        // Winkelwagen leegmaken
        nuke_winkelwagen($dbcon, $_SESSION['user']['id']);

        $dbcon->commit();
        echo json_encode(["status" => "success", "message" => "Bestelling geplaatst!", "order_id" => $bestelling_id]);
    } catch (Exception $e) {
        $dbcon->rollback();
        die(json_encode(["status" => "error", "message" => "Fout bij plaatsen bestelling: " . $e->getMessage()]));
    }
} else {
    die(json_encode(["status" => "error", "message" => "Ongeldige aanvraagmethode."]));
}
?>