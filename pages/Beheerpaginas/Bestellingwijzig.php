<?php
// Controleer of 'id' in de URL aanwezig is
if (isset($_GET['id'])) {
    // Haal de waarde van 'id' op uit de URL
    $id = htmlspecialchars($_GET['id']);

    // Toon de waarde in een H1-tag
    echo "<h1>Het ID is: $id</h1>";
} else {
    // Toon een bericht als 'id' niet is meegegeven
    echo "<h1>Geen ID opgegeven!</h1>";
}
?>