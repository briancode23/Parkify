<?php
/*function isLogin(): bool
{
    return isset($_SESSION['id_user']);
}

function isRole($roles): bool
{
    if (!isset($_SESSION['role'])) {
        return false;
    }

    if (is_string($roles)) {
        $roles = [$roles];
    }

    return in_array($_SESSION['role'], $roles);
}*/

function isLogin() {
    return isset($_SESSION['id_user']);
}

function requireLogin() {
    if (!isLogin()) {
        header("Location: /parkify/public/?page=login");
        exit;
    }
}

function requireRole(array $roles) {
    if (!in_array($_SESSION['role'] ?? '', $roles)) {
        http_response_code(403);
        exit('403 Akses ditolak');
    }
}

