<?php
require_once __DIR__ . '/../helpers/middleware.php';
require_once __DIR__ . '/../helpers/auth_helper.php';
require_once __DIR__ . '/../helpers/session.php';

$basePath = '/parkify/public';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$route = str_replace($basePath, '', $uri);

if ($route === '') {
    $route = '/';
}

switch ($route) {
    case '/':
        isLogin()
        ? require __DIR__ . '/../views/dashboard/index.php'
        : require __DIR__ . '/../views/auth/login.php';
        break;

    case '/dashboard':
        auth();
        require __DIR__ . '/../views/dashboard/index.php';
        break;

    case '/parkir/masuk':
        auth();
        role(['petugas', 'admin']);
        require __DIR__ . '/../views/parkir/masuk.php';
        break;

    case '/parkir/keluar':
        auth();
        role(['petugas', 'admin']);
        require __DIR__ . '/../views/parkir/keluar.php';

    case '/user':
        auth();
        role(['admin']);
        require __DIR__ . '/../views/laporan/index.php';
        break;

    case '/laporan':
        auth();
        role(['owner', 'admin']);
        require __DIR__ . '/../views/laporan/index.php';
        break;

    default:
        http_response_code(404);
        echo "404 - Halaman tidak ditemukan";
    }