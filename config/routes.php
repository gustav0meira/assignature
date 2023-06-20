<?php

// Definindo as rotas
$routes = [
    '/' => 'HomeController@index',
    '/about' => 'AboutController@index',
    '/contact' => 'ContactController@index',
];

// Obtendo a URL atual
$currentUrl = $_SERVER['REQUEST_URI'];

// Verificando se a rota existe
if (array_key_exists($currentUrl, $routes)) {
    // Obtendo o controlador e método da rota
    $routeParts = explode('@', $routes[$currentUrl]);
    $controllerName = $routeParts[0];
    $methodName = $routeParts[1];

    // Incluindo o arquivo do controlador
    require_once 'controllers/' . $controllerName . '.php';

    // Criando uma instância do controlador
    $controller = new $controllerName();

    // Chamando o método da rota
    $controller->$methodName();
} else {
    // Rota não encontrada, redirecionar para a página 404
    require_once 'pages/404/index.php';
}
