<form action="/api/page/update.php" method="POST">
    <div class="mb-3 row align-items-center">
        <label for="id" class="col-auto col-form-label">ID</label>
        <div class="col-auto">
            <input type="text" readonly class="form-control-plaintext" name="id" id="id" value="<?= $pagina["id"] ?>" size="2">
        </div>
        <label for="title" class="col-auto col-form-label">Paginatitel</label>
        <div class="col-auto">
            <input type="text" class="form-control" name="title" id="title" required value="<?= $pagina["title"] ?>">
        </div>
        <!-- <label for="inputActive" class="col-auto col-form-label">Actief</label>
                            <div class="col-auto">
                              <input type="checkbox" class="form-check-input" id="inputActive">
                            </div> -->
        <div class="form-check col-auto">
            <label class="form-check-label" for="actief">Actief</label>
            <input class="form-check-input" type="checkbox" name="actief" id="actief" <?= $checked ?>>
        </div>
    </div>
    <div class="mb-3 row">
    </div>
    <div class="form-group">
        <label for="inhoud">Paginacontent</label>
        <textarea class="form-control" name="inhoud" id="inhoud" rows="5"><?= $pagina["inhoud"] ?></textarea>
        <button type="submit" formaction="/api/page/delete.php" method="POST" class="btn btn-danger" style="float: left; margin-top: 10px">Verwijderen</button>
        <button type="submit" class="btn btn-primary" style="float: right; margin-top: 10px">Opslaan</button>
    </div>
</form>