<?php

require_once 'config.php'; 
class pedidosApiModel {

    private $db;

    function __construct(){
        //1.  abro conexión
        $this->db = new PDO('mysql:host='.MYSQL_HOST.';dbname='. MYSQL_DB .';charset=utf8', MYSQL_USER, MYSQL_PASS);
    }
    
    function getPedidos(){
        //2.  ejecuto consulta SQL
        $query = $this->db->prepare('SELECT a.*, b.nombre_categoria FROM pedidos a LEFT JOIN categorias b ON a.categoria = b.id_categoria');
        $query->execute();

        //3. Obtener datos de la consulta

        return $query->fetchAll(PDO::FETCH_OBJ); // devuelve un arreglo con todos los pedidos

    }
    function getPedido($id){
        $query = $this->db->prepare('SELECT * FROM pedidos WHERE id_pedido = ?');
        $query->execute(array($id));

        $pedido = $query->fetch(PDO::FETCH_OBJ);

        return $pedido;
    }

    public function getPedidosXorden($order_by, $order) {
        // Crear la consulta SQL con dos marcadores de posición
        $query = $this->db->prepare("SELECT * FROM pedidos ORDER BY $order_by $order");
    
        // Enlazar los valores a los marcadores de posición utilizando execute
        $query->execute();
    
        return $query->fetchAll(PDO::FETCH_OBJ);

    }


    public function getPedidosByFiltro($valor) {
        $query = $this->db->prepare("SELECT * FROM pedidos WHERE categoria = ?");

        // Ejecutar la consulta y obtener los resultados de la base de datos
        $query->execute([$valor]);
        
        return $query->fetchAll(PDO::FETCH_OBJ);

    }


    function insertPedidos($producto,$categoria){
        $query = $this->db->prepare('SELECT id_productos FROM producto WHERE nombre_producto = ?');
        $query->execute([$producto]);

        $id_producto = $query->fetch(PDO::FETCH_OBJ);
            

        $query = $this->db->prepare('INSERT INTO pedidos(id_producto, producto, categoria) VALUES(?,?,?)');
        
        $query->execute(array($id_producto->id_productos,$producto,$categoria));
    
        return $this->db->lastInsertId();

    }
    
    function deletePedido($id){
        $query = $this->db->prepare('DELETE FROM pedidos WHERE id_pedido = ?');
        $query->execute([$id]);
        
        
    }
    function updatePedido($id_pedido,$producto,$id_producto, $categoria){
            
        $query = $this->db->prepare('UPDATE pedidos SET id_producto = ?, producto = ?, categoria = ? WHERE id_pedido = ?');
        $query->execute(array($id_producto, $producto, $categoria, $id_pedido));
    }
    
}

















?>