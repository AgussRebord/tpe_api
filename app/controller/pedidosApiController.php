<?php
    require_once './app/controller/apiController.php';
    require_once './app/model/pedidosApiModel.php';
    
    class pedidosApiController extends ApiController {
        private $model;

        function __construct(){
            parent::__construct();
            $this->model = new pedidosApiModel();
        }
        
        function get($params = []) {
            if(empty($params)){
                $pedidos = $this->model->getPedidos();
                $this->view->response($pedidos,200);
            }
            else{
              $pedido = $this->model->getPedido($params[":ID"]);
              if(!empty($pedido)) {
                return $this->view->response($pedido,200);
              }else{
                $this->view->response('El pedido con el id='.$params[':ID'].'No existe.', 404);
              }
            }
        }


        public function listPedidos() {
            $order_by = isset($_GET['order_by']) ? $_GET['order_by'] : null;
            $order = isset($_GET['order']) ? $_GET['order'] : 'ASC';

            if(empty($order_by)){
                $this->view->response('Debe ingresar un valor para ordenar', 400);
                return;
            }
            else if(($order_by!="id_Pedido")&&($order_by!="id_producto")&&($order_by!="categoria")){
                $this->view->response('El valor ingresado no se encontro en la base de datos', 404);
                return;
            }
            else{
            $pedidos = $this->model->getPedidosXorden($order_by, $order);
            $this->view->response($pedidos, 200);
            }
        }

        public function filtroPedidos() {
            if (isset($_GET['valor']) && is_numeric($_GET['valor'])) {
                // La variable $_GET['valor'] es un número
                $valor = $_GET['valor'];
            
                $pedidos = $this->model->getPedidosByFiltro($valor);
                $this->view->response($pedidos, 200);
            }
            else{
                $this->view->response('El valor ingresado no es un numero',400);
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
    }
?>