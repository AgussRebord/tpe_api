<?php

class Estuding{

    
    public static function init() {
            if (session_status() != PHP_SESSION_ACTIVE) {
                session_start();
            }
        }

    public static function login($user) {
        AuthHelper::init();
        $_SESSION['USER_ID'] = $user->id;
        $_SESSION['USER_NAME'] = $user->userName; 
    }

    public static function logout() {
        AuthHelper::init();
        session_destroy();
    }

    public static function verify() {
        AuthHelper::init();
        if (!isset($_SESSION['USER_ID'])) {
            header('Location: ' . BASE_URL . '/login');
            die();
        }
    }

    function get($params = []) {
        
        if(empty($params)){
            $pedidos = $this->model->getPedidos();
            usort($pedidos, function($a, $b){
                return $a->id_pedido - $b->id_pedido;
            });
            $this->view->response($pedidos,200);
        }
        else{
          $pedido = $this->model->getPedido($params[":ID"]);
          if(!empty($pedido)) {
            return $this->view->response($pedido,200);
          }else{
            $this->view->response(
            [ 'msg' => 'El pedido con el id='.$params[':ID'].'No existe.']
            , 404);
          }
        }
    }
    public function add($params = []) {
        // devuelve el objeto JSON enviado por POST     
        $body = $this->getData();

        // inserta el pedido
        $producto = $body->producto;
        $categoria = $body->categoria;
        if(empty($producto) || empty($categoria)){
            $this->view->response('Debe ingresar todos los datos o ingresarlos por su tipo', 400);
        }else{
            $id = $this->model->insertPedidos($producto, $categoria);
            $this->view->response('El pedido fue insertado con el id='.$id, 201);
        }
    }
    
    public function delete($params = []){
        
        $id = $params[':ID'];
        $pedido = $this->model->getPedido($id);

        if($pedido) {
            $this->model->deletePedido($id);
            $this->view->response('El pedido con id='.$id.' ha sido borrada.', 200);
        } else {
            $this->view->response('El pedido con el id='.$id.' no existe ', 404);
        }
    }

    public function update($params = []) {    

        $id_pedido = $params[':ID'];
        $pedido = $this->model->getPedido($id_pedido);

        if($pedido) {
            $body = $this->getData();
            $producto = $body->producto;
            $id_producto = $body->id_producto;
            $categoria = $body->categoria;
            if(empty($producto) || empty($id_producto) || empty($categoria)){
                $this->view->response('Debe ingresar todos los datos o ingresarlos por su tipo', 400);
                return;
            }
            $this->model->updatePedido($id_pedido,$producto,$id_producto, $categoria);
       
            $this->view->response('El pedido con id='.$id_pedido.' ha sido modificado.', 200);
        } else {
            $this->view->response('El pedido con el id='.$id_pedido.' no existe ', 404);
        }
    }

    function getPedidos(){
        //2.  ejecuto consulta SQL
        $query = $this->db->prepare('SELECT a.*, b.nombre_categoria FROM pedidos a LEFT JOIN categorias b ON a.categoria = b.id_categoria');
        $query->execute();

        //3. Obtener datos de la consulta

        return $query->fetchAll(PDO::FETCH_OBJ); // devuelve un arreglo con todos los pedidos

    }
}