<?php
require_once 'config.php'; 

class productApiModel{


    private $db;
    function __construct(){
        $this->db = new PDO('mysql:host='.MYSQL_HOST.';dbname='. MYSQL_DB .';charset=utf8', MYSQL_USER, MYSQL_PASS);

    }

    function getProductos(){
        $query = $this->db->prepare('SELECT * FROM producto');
        $query->execute();

        $productos = $query->fetchAll(PDO::FETCH_OBJ);

        return $productos;
    }
    
    function getProducto($id){
        $query = $this->db->prepare('SELECT * FROM producto WHERE id_productos = ?');
        $query->execute(array($id));

        $producto = $query->fetch(PDO::FETCH_OBJ);

        return $producto;
    }
    
    function deleteProducto($id){
        $query = $this->db->prepare('DELETE FROM producto WHERE id_productos = ?');
        $query->execute([$id]);
        
    }
    
    function insertProducto($nombre_producto){
        $query = $this->db->prepare('INSERT INTO producto(nombre_producto) VALUES(?)');
        
        $query->execute(array($nombre_producto));
    
        return $this->db->lastInsertId();
    }
    function updateProducto($nombre_producto,$id_productos){
        $query = $this->db->prepare('UPDATE producto SET nombre_producto = ? WHERE id_productos = ?');
        $query->execute(array($nombre_producto, $id_productos));
    }








}
?>