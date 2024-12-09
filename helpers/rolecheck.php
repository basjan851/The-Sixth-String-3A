<?php
function set_header($redirect_to_login) {
    if ($redirect_to_login) {
        header('Location: /index.php?page=Login', true, 302);
    } else {
        header('HTTP/1.1 401 Unauthorized', true, response_code: 401);
        echo "<h1>401 Unauthorized</h1>";
    }
}
function check_role($roles, $redirect_to_login) {
    session_start();
    if (isset($_SESSION["user"]["rol"])) {
        $role = $_SESSION["user"]["rol"];
        if (!in_array($role, $roles)) {
            set_header($redirect_to_login);
            exit();
        }
    } else {
        set_header($redirect_to_login);
        exit();
    }
}
?>