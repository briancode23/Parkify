<?php

if (!isset($_SESSION['id_user'])) {
    header("Location: /parkify/public/?page=login&error=auth");
    exit;
}
?>