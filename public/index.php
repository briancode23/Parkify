<?php
require_once __DIR__ . '/../app/helpers/session.php';

$page = $_GET['page'] ?? 'dashboard';

switch ($page) {

    case 'login':
        require_once __DIR__ . '/../app/views/auth/login.php';
        break;

    case 'logout':
        require_once __DIR__ . '/../app/controllers/LogoutController.php';
        break;

    case 'dashboard':
        require_once __DIR__ . '/../app/helpers/auth_helper.php';
        require_once __DIR__ . '/../app/views/dashboard/index.php';
        break;

    default:
        http_response_code(404);
        echo "404 - Halaman tidak ditemukan";
}
