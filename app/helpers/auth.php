<?php
session_start();

function isLogin()
{
    return isset($_SESSION['id_user']);
}

function userRole($roles = [])
{
    return $_SESSION['role'] ?? null;
}
?>