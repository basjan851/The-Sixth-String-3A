<?php
require_once(__DIR__ . '/../helpers/currency.php');
require_once(__DIR__ . '/../helpers/winkelwagen.php');
//get winkelwagen content
if(session_status() !== PHP_SESSION_ACTIVE) session_start();
$dbcon = connect_db();
$result = get_winkelwagen($dbcon, $_SESSION["user"]["id"]);
//Put code above in helper
// var_dump($result["producten"]);
$winkelwageninhoud = "";
if (isset($result["producten"])) {
foreach ($result["producten"] as &$item) {
    if (!empty($item["korting"])) {
        $prijs = '<s style="color: red">' . printcurrency($item["prijs"]) . '</s> ' . printcurrency((int) $item["korting"]);
    } else {
        $prijs = printcurrency($item["prijs"]);
    }
    $winkelwageninhoud = $winkelwageninhoud . sprintf('
    <h4>%s</h4>
    <div class="row mb-3 align-items-center">
        <div class="input-group col">
            <a type="button" class="btn btn-outline-danger" href="/api/winkelwagen.php?action=mutate&product_id=%s&amount=0">X</a>
            <div class="input-group-prepend">
                <a class="input-group-text text-decoration-none" href="/api/winkelwagen.php?action=remove&product_id=%s">-</a>
            </div>
            <input type="text" class="form-control amount" style="max-width: 6ch; text-align: center;" aria-label="Aantal" productid="%s" value="%s">
            <div class="input-group-append">
                <a class="input-group-text text-decoration-none" href="/api/winkelwagen.php?action=append&product_id=%s">+</a>
            </div>
        </div>
        <div class="col">
            <p class="text-end fs-4">%s</p>
        </div>
    </div>
    ', $item['productnaam'], $item['id'], $item['id'], $item['id'], $item['aantal'], $item['id'], $prijs);
    $buttondisabled = "";
}
} else {
    $buttondisabled = " disabled";
    $winkelwageninhoud = "<center><h3>Geen producten in de winkelwagen</h3></center>";
}
//Set prices in frontend
$subtotal = $result["totale_prijs"] ?? 0;
$bezorging = 0;
$btw = round($subtotal*21/121, 2);
$total = $subtotal+$bezorging;
?>
<div class="container mx-auto">
    <div class="row justify-content-center p-3">
        <div class="col-6">
            <div class="row">
                <div class="col">
                    <a type="button" class="btn btn-outline-secondary" href="/index.php?page=Producten">Verder Winkelen</a>
                </div>
                <div class="col">
                    <a type="button" href="/api/winkelwagen.php?action=nuke" class="btn btn-outline-secondary float-end">Winkelwagen Legen</a>
                </div>
            </div>
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
            <a type="button" class="btn btn-outline-secondary<?= $buttondisabled ?>" href="/index.php?page=Bestelpagina" style="width: 100%">Bestellen</a>
        </div>
    </div>
</div>
<script>
document.querySelectorAll("[productid]").forEach((element => element.addEventListener("change", (event) => {
    window.location.href = "/api/winkelwagen.php?action=mutate&product_id="+event.target.getAttribute("productid")+"&amount="+event.target.value
})))
</script>