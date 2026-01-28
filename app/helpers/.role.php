<?php
function requireRole(array $roles)
{
    if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $roles)) {
        http_response_code(403);
        echo "403 - Akses ditolak";
        exit;
    }
}
