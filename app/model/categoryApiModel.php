<?php
require_once 'config.php'; 

class categoryApiModel{

    private $db;
    function __construct(){
        $this->db = new PDO('mysql:host='.MYSQL_HOST.';dbname='. MYSQL_DB .';charset=utf8', MYSQL_USER, MYSQL_PASS);
    }


    function getCategorias(){
        $query = $this->db->prepare('SELECT * FROM categorias');
        $query->execute();

        $categorias = $query->fetchAll(PDO::FETCH_OBJ);

        return $categorias;
    }

    function getCategoria($id){
        $query = $this->db->prepare('SELECT * FROM categorias WHERE id_categoria = ?');
        $query->execute(array($id));
        
        $categoria = $query->fetch(PDO::FETCH_OBJ);

        return $categoria;
    }
    
    function deleteCategoria($id){
        $query = $this->db->prepare('DELETE FROM categorias WHERE id_categoria = ?');
        $query->execute([$id]);
        
    }
    
    function insertCategoria($nombre_categoria){
        $query = $this->db->prepare('INSERT INTO categorias(nombre_categoria) VALUES(?)');
        
        $query->execute(array($nombre_categoria));
    
        return $this->db->lastInsertId();
    }

    function updateCategoria($nombre_categoria,$id_categoria){
        $query = $this->db->prepare('UPDATE categorias SET nombre_categoria = ? WHERE id_categoria = ?');
        $query->execute(array($nombre_categoria, $id_categoria));
    }
        
}

?>