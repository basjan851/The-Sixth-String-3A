<?php
    function mutate_product($dbcon, $gebruikerid, $productid, $amount) {
        /*
        Muteer een product in de winkelwagen database
        accepteert een databaseconnectie, gebruikerid, productid en amount als argumenten, amount argument werkt als volgt:
        "remove": Item wordt geupdate zodat huidige aantal 1 minder is
        "append": Item wordt geupdate zodat huidige aantal 1 meer is. Als het item niet bestaat vind er een INSERT statement plaats ipv update
        anders: aantal in tabel wordt naar $amount aangepast
        returnt een boolean die aangeeft of de operatie geslaagd is
        */
        if (!empty($dbcon) && !empty($gebruikerid) && !empty($productid) && isset($amount)) {
            $gebruikerid = $dbcon->real_escape_string($gebruikerid);
            $productid = $dbcon->real_escape_string($productid);
            $amount = $dbcon->real_escape_string($amount);

            if ($amount == "remove") {
                $query = "UPDATE winkelwagen SET aantal = aantal - 1 WHERE gebruiker_id = '" . $gebruikerid . "' AND product_id = '" . $productid . "'"; 
            } elseif ($amount == 0) {
                $query = "DELETE FROM winkelwagen WHERE gebruiker_id = '" . $dbcon->real_escape_string($gebruikerid) . "' AND product_id = '" . $productid . "'";
            } else {
                $result = $dbcon->query("SELECT id FROM winkelwagen WHERE gebruiker_id = '". $gebruikerid . "' AND product_id = '" . $productid . "'");
                if ($result->num_rows == 0) {
                    if ($amount == "append") { $amount = 1; }
                    $query = "INSERT winkelwagen (gebruiker_id, laatst_geupdate, product_id, aantal) VALUES ('" . $gebruikerid . "', NOW(), '" . $productid . "', '" .  $amount . "')";
                } else {
                    if ($amount == "append") { $amount = "aantal + 1"; }
                    $query = "UPDATE winkelwagen SET aantal = " . $amount . " WHERE gebruiker_id = '" . $gebruikerid . "' AND product_id = '" . $productid . "'"; 
                }
            }
            $dbcon->query($query);
            return true;
        } else {
            return false;
        }
    }

    function get_winkelwagen($dbcon, $gebruikerid) {
        /*
        Haal de winkelwagen op
        accepteert een databaseconnectie en gebruikerid als argumenten, returnt het volgende 
        {
            totale_prijs: Totale prijs
            totale_korting: Totale prijs met korting
            producten: {
                id:
                productnaam:
                prijs: prijs zonder korting (prijs*aantal)
                korting: prijs met korting ((prijs/korting)*aantal)
                aantal: Aantal producten in winkelwagen
            }
        }
        // */
        $gebruikerid = $dbcon->real_escape_string($gebruikerid);
        if (!empty($dbcon) && !empty($gebruikerid)) {
            $totaal = $dbcon->query("SELECT SUM(p.prijs*w.aantal) as totale_prijs, SUM((p.prijs*(p.kortingspercentage/100))*w.aantal) as totale_korting  from winkelwagen w INNER JOIN producten p ON w.product_id = p.id WHERE w.gebruiker_id = '" . $gebruikerid . "' GROUP BY gebruiker_id");
            if ($totaal->num_rows > 0) {
                $totaal = $totaal->fetch_assoc();
                $producten = $dbcon->query("SELECT p.id as id, p.productnaam as productnaam, p.prijs*w.aantal as prijs, (p.prijs*(p.kortingspercentage/100))*w.aantal as korting, w.aantal from winkelwagen w INNER JOIN producten p ON w.product_id = p.id WHERE w.gebruiker_id = '" . $gebruikerid . "'");
                $p = array();
                while ($row = $producten->fetch_assoc()) {
                    $p[] = $row;
                }
                return Array("totale_prijs" => $totaal["totale_prijs"], "totale_korting" => $totaal["totale_korting"], "producten" => $p);    
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function nuke_winkelwagen($dbcon, $gebruikerid) {
        /*
        Verwijder alles uit de winkelwagen
        accepteert een databaseconnectie en gebruikerid als argumenten, returnt een boolean die aangeeft of de operatie geslaagd is
        */
        if (!empty($dbcon) && !empty($gebruikerid)) {
            $dbcon->query("DELETE FROM winkelwagen WHERE gebruiker_id = '" . $dbcon->real_escape_string($gebruikerid) . "'");
        } else {
            return false;
        }
    }
?>