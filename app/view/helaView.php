<?php

class helaView{

    function __construct(){
        
    }


    function showHome($pedidos, $categorias, $productos){ 
        require './templates/pedidos.phtml';
        require './templates/categorias.phtml';
        require './templates/productos.phtml';

    }
    function showHomeAdmin($pedidos, $categorias, $productos){ 
        require './templates/pedidosAdmin.phtml';
        require './templates/categoriasAdmin.phtml';
        require './templates/productosAdmin.phtml';

    }
    function showCategory($categoria){
        require './templates/categoria.phtml';
    }
    function showProduct($productos, $categorias){
        require './templates/producto.phtml';
    }
    function showError($error){
        echo "<h1>ERROR</h1>";
        echo $error;
    }
    function showFiltro($pedidos){
        require './templates/filtro.phtml';
    }
}

?>