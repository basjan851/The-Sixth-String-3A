<?php
function render_alerts($alerts) {
    foreach ($alerts as $alert) {
        if (!empty($_GET[$alert["trigger"]])) {
            echo '<div class="vanillaalert '. $alert["type"] .'" role="alert">
                ' . $alert["melding"] . '
            </div>';
        }
    }
}
?>