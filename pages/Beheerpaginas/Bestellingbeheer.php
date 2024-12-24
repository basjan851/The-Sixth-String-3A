<?php
require_once 'helpers/databaseconnector.php';
if (!isset($_SESSION['user']['id'])) {
    die("Gebruiker is niet ingelogd.");
}
$gebruiker_id = $_SESSION['user']['id'];
$db = connect_db();
$query = "select * from bestellingen";
$stmt = $db->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

?>
<table class="table">
    <thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Totaal</th>
        <th scope="col">Betaalmethode</th>
        <th scope="col">voornaam</th>
        <th scope="col">achternaam</th>
        <th scope="col">Address</th>
        <th scope="col">stad en postcode</th>
        <th scope="col">Land</th>
        <th scope="col">Tel</th>
        <th scope="col">Datum</th>
        <th scope="col">Status</th>
        <th scope="col">Edit</th>
    </tr>
    </thead>
    <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>

        <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td>€<?= number_format($row['totaal_waarde'], 2, ',', '.') ?></td>
            <td><?= htmlspecialchars($row['betaalmethode']) ?></td>
            <td><?= htmlspecialchars($row['voornaam']) ?></td>
            <td><?= htmlspecialchars($row['achternaam']) ?></td>
            <td><?= htmlspecialchars($row['adres']) ?></td>
            <td><?= htmlspecialchars($row['postcode']) . ' ' . htmlspecialchars($row['plaatsnaam']) ?></td>
            <td><?= htmlspecialchars($row['land']) ?></td>
            <td><?= htmlspecialchars($row['telefoon']) ?></td>
            <td><?= htmlspecialchars($row['datum']) ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
            <td>
                <a href="index.php?page=Beheerpaginas/Bestellingwijzig&id=<?= htmlspecialchars($row['id']) ?>" title="Edit">
                    <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.88 121.51" width="24" height="24">
                        <title>edit</title>
                        <path d="M28.66,1.64H58.88L44.46,16.71H28.66a13.52,13.52,0,0,0-9.59,4l0,0a13.52,13.52,0,0,0-4,9.59v76.14H91.21a13.5,13.5,0,0,0,9.59-4l0,0a13.5,13.5,0,0,0,4-9.59V77.3l15.07-15.74V92.85a28.6,28.6,0,0,1-8.41,20.22l0,.05a28.58,28.58,0,0,1-20.2,8.39H11.5a11.47,11.47,0,0,1-8.1-3.37l0,0A11.52,11.52,0,0,1,0,110V30.3A28.58,28.58,0,0,1,8.41,10.09L8.46,10a28.58,28.58,0,0,1,20.2-8.4ZM73,76.47l-29.42,6,4.25-31.31L73,76.47ZM57.13,41.68,96.3.91A2.74,2.74,0,0,1,99.69.38l22.48,21.76a2.39,2.39,0,0,1-.19,3.57L82.28,67,57.13,41.68Z"/>
                    </svg>
                </a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
