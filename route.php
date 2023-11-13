<?php
    require_once './libs/routerA.php';
    require_once './app/controller/pedidosApiController.php';
    require_once './app/controller/productApiController.php';
    require_once './app/controller/categoryApiController.php';

    // crea el router
    $router = new Router();

    // define la tabla de ruteo
    $router->addRoute('pedidos', 'GET', 'pedidosApiController', 'get');
    $router->addRoute('pedidos', 'POST', 'pedidosApiController', 'add');
    $router->addRoute('pedidos/:ID', 'GET', 'pedidosApiController', 'get');
    $router->addRoute('pedidos/:ID', 'PUT', 'pedidosApiController', 'update');
    $router->addRoute('pedidos/:ID', 'DELETE', 'pedidosApiController', 'delete');
    $router->addRoute('filtrar', 'GET', 'pedidosApiController', 'filtroPedidos');
    $router->addRoute('orden', 'GET', 'pedidosApiController', 'listPedidos' );
    // define tabla de ruteo productos
    $router->addRoute('productos', 'GET', 'productApiController', 'get');
    $router->addRoute('productos', 'POST', 'productApiController', 'add');
    $router->addRoute('productos/:ID', 'GET', 'productApiController', 'get');
    $router->addRoute('productos/:ID', 'PUT', 'productApiController', 'update');
    $router->addRoute('productos/:ID', 'DELETE', 'productApiController', 'delete');
    // define tabla de ruteo categoria
    $router->addRoute('categorias', 'GET', 'categoryApiController', 'get');
    $router->addRoute('categorias', 'POST', 'categoryApiController', 'add');
    $router->addRoute('categorias/:ID', 'GET', 'categoryApiController', 'get');
    $router->addRoute('categorias/:ID', 'PUT', 'categoryApiController', 'update');
    $router->addRoute('categorias/:ID', 'DELETE', 'categoryApiController', 'delete');
    // rutea
    $router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);



?>