<?php
function requireLogin()
{
    if (!isLogin()) {
        header("Location: /parkify/public/login.php");
        exit;
    }
}

function requireRole(array $roles)
{
    if (!isRole($roles)) {
        http_response_code(403);
        exit('403 Akses ditolak');
    }
}
