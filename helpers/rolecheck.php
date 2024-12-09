<?php
function check_role($roles) {
    session_start();
    if (isset($_SESSION["user"]["rol"])) {
        $role = $_SESSION["user"]["rol"];
        if (!in_array($role, $roles)) {
            header('HTTP/1.1 401 Unauthorized', true, response_code: 401);
            exit();
        }
    } else {
        header('HTTP/1.1 401 Unauthorized', true, response_code: 401);
        exit();
    }

}
?>