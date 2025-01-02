<?php

require_once 'helpers/rolecheck.php';

$conn = connect_db();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update_actief"])) {
    $id = intval($_POST["id"]);
    $actief = isset($_POST["actief"]) ? 1 : 0;

    $stmt = $conn->prepare("UPDATE producten SET Actief = ? WHERE Id = ?");
    $stmt->bind_param("ii", $actief, $id);

    if (!$stmt->execute()) {
        echo "<script>console.error('Fout bij bijwerken: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "delete") {
    $id = intval($_POST["id"]);

    $stmt = $conn->prepare("DELETE FROM producten WHERE Id = ?");
    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
        echo "<script>console.error('Fout bij verwijderen: " . $stmt->error . "');</script>";
    } else {
        echo "<script>console.log('Product succesvol verwijderd');</script>";
    }

    $stmt->close();
}

$result = $conn->query("SELECT * FROM producten");
if (!$result) {
    echo "<script>console.error('Fout bij ophalen productenlijst: " . $conn->error . "');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        main {
            padding: 20px;
            flex: 1;
        }
        table {
            width: 75%;
            margin: 20px;
            margin-left: auto;
            margin-right: auto;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
        .button {
            padding: 10px 15px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            height: 40px;
            width: 110px;
            display: inline-block;
            text-align: center;
        }
        .button-delete {
            background-color: #d9534f;
        }
        .button-edit {
            background-color: #0275d8;
        }
        .button-add {
            background-color: #5cb85c;
            padding: 10px 15px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            height: 40px;
            width: 110px;
            display: inline-block;
            text-align: center;

        }
        .button-delete:hover {
            background-color: #c9302c;
        }
        .button-edit:hover {
            background-color: #025aa5;
        }
        .button-add:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>
    <main>
        <h6>Home > Beheer > Producten</h6>
            <div>
                <table>
                    <tr>
                        <th>Naam</th>
                        <th>Prijs</th>
                        <th>Voorraad</th>
                        <th>Korting</th>
                        <th>Actief</th>
                        <th>Acties</th>
                    </tr>
                    <?php if ($result) { while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= htmlspecialchars($row["productnaam"]) ?></td>
                            <td>€<?= htmlspecialchars($row["prijs"]) ?>,-</td>
                            <td><?= htmlspecialchars($row["voorraad"]) ?></td>
                            <td><?= htmlspecialchars($row["kortingspercentage"]) ?>%</td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                    <input type="checkbox" name="actief" <?= $row["actief"] ? "checked" : "" ?> onchange="this.form.submit()">
                                    <input type="hidden" name="update_actief" value="1">
                                </form>
                            </td>
                            <td>
                                <form method="post" style="display:inline;" onsubmit="return confirm('Weet u zeker dat u dit product wilt verwijderen?');">
                                    <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                    <button type="submit" name="action" value="delete" class="button button-delete">Verwijderen</button>
                                </form>
                                <a href="index.php?page=beheerpaginas/productwijzig&id=<?= $row['id'] ?>" class="button button-edit">Bewerken</a>
                            </td>
                        </tr>
                    <?php } } ?>
                </table>
                <a href="index.php?page=beheerpaginas/Producttoevoegen" class="button-add">Toevoegen</a>
            </div>
    </main>
</body>
</html>
