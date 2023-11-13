<?php
    require_once './app/model/productApiModel.php';
    require_once './app/controller/apiController.php';
   

class productApiController extends ApiController  { 
    
    private $model;

    function __construct(){
        parent::__construct();
        $this->model = new productApiModel();
    }

    function get($params = []) {
        if(empty($params)){
          $productos = $this->model->getProductos();
          usort($productos, function($a, $b){
            return $b->id_productos - $a->id_productos;
          });
          return $this->view->response($productos,200);
        }
        else {
          $producto = $this->model->getProducto($params[":ID"]);
          if(!empty($producto)) {
            return $this->view->response($producto,200);
          }else{
            $this->view->response(
            [ 'msg' => 'El producto con el id='.$params[':ID'].'No existe.']
            , 404);
          }
        }
    }
    
 
    public function add($params = []) {
        // devuelve el objeto JSON enviado por POST     
         $body = $this->getData();
 
         // inserta el producto
         $producto = $body->nombre_producto;
         if(empty($producto)){
            $this->view->response('Debe ingresar todos los datos o ingresarlos por su tipo', 400);
        }else{
            $id = $this->model->insertProducto($producto);
            $this->view->response('El producto fue insertado con el id='.$id, 201);
        }
         
    }


    public function delete($params = []){
            
        $id = $params[':ID'];
        $producto = $this->model->getProducto($id);

        if($producto) {
            $this->model->deleteProducto($id);
            $this->view->response('El producto con id='.$id.' ha sido borrada.', 200);
        } else {
            $this->view->response('El producto con el id='.$id.' no existe ', 404);
        }
    }

    public function update($params = []) {    

        $id = $params[':ID'];
        $productos = $this->model->getProducto($id);

        if($productos) {
            $body = $this->getData();
            $productos = $body->nombre_producto;
            if(empty($producto)){
                $this->view->response('Debe ingresar todos los datos o ingresarlos por su tipo', 400);
                return;
            }
            $this->model->updateProducto($productos,$id);
       
            $this->view->response('El producto con id='.$id.' ha sido modificado.', 200);
        } else {
            $this->view->response('El producto con el id='.$id.' no existe ', 404);
        }
    }




}
?>