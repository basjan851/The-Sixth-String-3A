<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestelling Plaatsen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-9">
            <form method="POST" action="/submit_order" class="needs-validation" novalidate>
                <!-- Voeg CSRF-token toe -->
                <input type="hidden" name="csrf_token" value="PLACEHOLDER_FOR_CSRF_TOKEN">

                <!-- Factuurgegevens -->
                <div class="card mb-4">
                    <div class="card-header"><h4>Factuurgegevens</h4></div>
                    <div class="card-body">
                        <div class="row gx-3 gy-2">
                            <!-- Voornaam -->
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="voornaam" name="voornaam" placeholder="Voornaam" pattern="^[A-Za-z\s]+$" required aria-label="Voornaam">
                                <div class="invalid-feedback">Voer een geldige voornaam in (alleen letters).</div>
                            </div>
                            <!-- Achternaam -->
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="achternaam" name="achternaam" placeholder="Achternaam" pattern="^[A-Za-z\s]+$" required aria-label="Achternaam">
                                <div class="invalid-feedback">Voer een geldige achternaam in (alleen letters).</div>
                            </div>
                            <!-- Adres -->
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="adres" name="adres" placeholder="Adres" pattern="^[A-Za-z0-9\s,]+$" required aria-label="Adres">
                                <div class="invalid-feedback">Voer een geldig adres in.</div>
                            </div>
                            <!-- Telefoon -->
                            <div class="col-md-6">
                                <input type="tel" class="form-control" id="telefoon" name="telefoon" placeholder="Telefoonnummer" pattern="^[0-9]{10}$" required aria-label="Telefoonnummer">
                                <div class="invalid-feedback">Voer een geldig telefoonnummer in (10 cijfers).</div>
                            </div>
                            <!-- Plaatsnaam -->
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="plaatsnaam" name="plaatsnaam" placeholder="Plaatsnaam" pattern="^[A-Za-z\s]+$" required aria-label="Plaatsnaam">
                                <div class="invalid-feedback">Voer een geldige plaatsnaam in.</div>
                            </div>
                            <!-- Postcode -->
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="postcode" name="postcode" placeholder="Postcode" pattern="^[0-9]{4}[A-Z]{2}$" required aria-label="Postcode">
                                <div class="invalid-feedback">Voer een geldige postcode in (bijv. 1234AB).</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Verzendgegevens -->
                <div class="card mb-4">
                    <div class="card-header"><h4>Verzendgegevens</h4></div>
                    <div class="card-body">
                        <div class="row gx-3 gy-2">
                            <!-- Land -->
                            <div class="col-md-6">
                                <select class="form-select" id="land" name="land" required aria-label="Land">
                                    <option selected disabled value="">Selecteer een land</option>
                                    <option value="Nederland">Nederland</option>
                                    <option value="België">België</option>
                                    <option value="Duitsland">Duitsland</option>
                                </select>
                                <div class="invalid-feedback">Selecteer een land.</div>
                            </div>
                            <!-- Straatnaam -->
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="straatnaam" name="straatnaam" placeholder="Straatnaam" pattern="^[A-Za-z\s]+$" required aria-label="Straatnaam">
                                <div class="invalid-feedback">Voer een geldige straatnaam in.</div>
                            </div>
                            <!-- Plaatsnaam verzending -->
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="plaatsnaam_verzending" name="plaatsnaam_verzending" placeholder="Plaatsnaam" pattern="^[A-Za-z\s]+$" required aria-label="Plaatsnaam verzending">
                                <div class="invalid-feedback">Voer een geldige plaatsnaam in.</div>
                            </div>
                            <!-- Postcode verzending -->
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="postcode_verzending" name="postcode_verzending" placeholder="Postcode" pattern="^[0-9]{4}[A-Z]{2}$" required aria-label="Postcode verzending">
                                <div class="invalid-feedback">Voer een geldige postcode in.</div>
                            </div>
                            <!-- Huisnummer -->
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="huisnummer_verzending" name="huisnummer_verzending" placeholder="Huisnummer" pattern="^[0-9]+[A-Za-z]?$" required aria-label="Huisnummer verzending">
                                <div class="invalid-feedback">Voer een geldig huisnummer in.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Betaalopties -->
                <div class="card mb-4">
                    <div class="card-header"><h5>Betaalmethode Selecteren</h5></div>
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="betaalmethode" id="paypal" value="PayPal" required>
                            <label class="form-check-label" for="paypal">PayPal</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="betaalmethode" id="ideal" value="iDeal" required>
                            <label class="form-check-label" for="ideal">iDeal</label>
                        </div>
                        <div class="invalid-feedback">Selecteer een betaalmethode.</div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Bestelling Plaatsen</button>
            </form>
        </div>

        <div class="col-md-3">
            <!-- Samenvatting Bestelling -->
            <div class="card mb-4">
                <div class="card-header"><h5>Samenvatting Bestelling</h5></div>
                <div class="card-body">
                    <p>Toegepaste korting: €20,-</p>
                    <p>Prijs exclusief BTW: €79,-</p>
                    <hr class="border-3">
                    <p>Subtotaal: €80,- (incl. BTW)</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Bootstrap validation script
    (function () {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>
</body>
</html>
