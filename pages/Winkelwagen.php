<?php
require_once(__DIR__ . '/../helpers/currency.php');
require_once(__DIR__ . '/../helpers/winkelwagen.php');
//get winkelwagen content
session_start();
$dbcon = connect_db();
$result = get_winkelwagen($dbcon, $_SESSION["user"]["id"]);
// var_dump($result);
$items = $result;
//Put code above in helper
// var_dump($result["producten"]);
$winkelwageninhoud = "";
foreach ($result["producten"] as &$item) {
    var_dump($item);
    if (!empty($item["korting"])) {
        $prijs = '<s style="color: red">' . printcurrency($item["prijs"]) . '</s> ' . printcurrency($item["korting"]);
    } else {
        $prijs = printcurrency($item["prijs"]);
    }
    $winkelwageninhoud = $winkelwageninhoud . sprintf('
    <tr>
        <h4>%s</h4>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">-</span>
            </div>
            <input type="text" class="form-control" style="max-width: 6ch; text-align: center;" aria-label="Aantal" value="%s">
            <div class="input-group-append">
                <span class="input-group-text">+</span>
            </div>
        </div>
        <h4 style="text-align: right">%s</h4>
    </tr>
    ', $item['productnaam'], $item['aantal'], $prijs);
}
//Set prices in frontend
$subtotal = 22;
$bezorging = 0;
$btw = round($subtotal*21/121, 2);
$total = $subtotal+$bezorging;
?>
<div class="container mx-auto">
    <div class="row justify-content-center p-3">
        <div class="col-6">
            <table>
                <br>
                <?= $winkelwageninhoud ?>
            </table>
        </div>
        <div class="col-4">
            <h3>Samenvatting</h3>
            <!-- <p>Subtotaal (incl. BTW)<br>Bezorging<br>BTW</p><p class="fw-bold">Totaal (incl. BTW) <span style="span: right"><?= $btw ?></span></p> -->
            <table id="prijsopgave" style="width: 100%;">
                <tr>
                    <td class="text-start">Subtotaal (incl. BTW)</td>
                    <td class="text-end"><?= printcurrency($subtotal) ?></td>
                </tr>
                <tr>
                    <td class="text-start">Bezorging</td>
                    <td class="text-end"><?= printcurrency($bezorging) ?></td>
                </tr>
                <tr>
                    <td class="text-start">BTW</td>
                    <td class="text-end"><?= printcurrency($btw) ?></td>
                </tr>
                <tr>
                <tr>
                    <td class="text-start fw-bold">Totaal (incl. BTW)</td>
                    <td class="text-end fw-bold"><?= printcurrency($total) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>