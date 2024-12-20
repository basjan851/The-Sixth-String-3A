<?php
//include(__DIR__ . '/../helpers/databaseconnector.php');
$dbcon = connect_db();
//Generate list with current pages
$result = $dbcon->query('SELECT id,title,actief FROM dynamische_pagina');
$pages = "";
while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    if (!empty($row["actief"])) {
        $actief = "Ja";
    } else {
        $actief = "Nee";
    }
    $pages = $pages . '<tr>
                    <th scope="row">' . $row["id"] . '</th>
                    <td>' . $row["title"] . '</td>
                    <td>' . $actief . '</td>
                    <td><a type="button" href="index.php?page=Paginaeditor&id=' . $row["id"] . '" class="btn btn-outline-primary btn-sm">Aanpassen</a></td>
                </tr>';
};
//Show page editor
if (!empty($_GET["id"])) {
    $id = $dbcon->real_escape_string($_GET["id"]);
    $query = sprintf("SELECT * FROM dynamische_pagina WHERE id = '%s'", $id);
    $result = $dbcon->query($query);
    if (mysqli_num_rows($result) > 0) {
        $pagina = $result->fetch_assoc();
        if (!empty($pagina["actief"])) {
            $checked = " checked";
        } else {
            $checked = "";
        }    
        ob_start();
        include "parts/Paginaeditor_detail.php";
        $editorcontent = ob_get_clean();    
    }
} else {
    $editorcontent = '<center><h2>Geen Pagina Geopend</h2></center>';
}
?>
<div class="container mx-auto">
    <div class="row justify-content-center p-3">
        <div class="col-auto">
            <table class="table text-center align-middle">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Paginatitel</th>
                        <th scope="col">Actief</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <!-- <tr>
                        <th scope="row">1</th>
                        <td>Algemene Voorwaarden</td>
                        <td>Ja</td>
                        <td><button type="button" class="btn btn-outline-primary btn-sm">Aanpassen</button></td>
                    </tr> -->
                    <?= $pages ?>
                </tbody>
            </table>
            <a type="button" class="btn btn-outline-primary btn-sm" href="/api/page/add.php" style="width: 100%;">Nieuwe Pagina</a>
        </div>
        <div class="col-auto" style="width: 50%;">
            <?= $editorcontent ?>
        </div>
    </div>
</div>
