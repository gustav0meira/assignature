<?php
$url = isset($_GET['url']) ? $_GET['url'] : '';
$domain = $_SERVER['HTTP_HOST'];

$routes = array(
    // config
    '' => 'pages/login/index',
    'login' => 'pages/login/index',
    'newPP' => 'pages/minha-conta/newPP',
    'logout' => 'config/logout',

    // pages
    'painel' => 'pages/painel/index',
    'minha-conta' => 'pages/minha-conta/index',
);

if (array_key_exists($url, $routes)) {
    include_once($routes[$url] . '.php');
} else {
    require('pages/404/index.php');
    exit;
}
?>