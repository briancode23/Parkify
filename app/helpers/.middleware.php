<?php
require_once __DIR__ . '/auth.php';

function auth()
{
    if (!isLogin()) {
        header("Location: /perkify/public/");
        exit;
    }
}

function role($roles = [])
{
    if (!in_array(userRole(), $roles)) {
        http_response_code(403);
        die("403 - Akses ditolak");
    }
}