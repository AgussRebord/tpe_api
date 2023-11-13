<?php
    require_once './app/controller/apiController.php';
    require_once './app/model/categoryApiModel.php';

class categoryApiController extends ApiController{ 
    
    private $model;

    function __construct(){
        parent::__construct();
        $this->model = new categoryApiModel();
    }

    function get($params = []) {
        if(empty($params)){
          $categorias = $this->model->getCategorias();
          usort($categorias, function($a, $b){
            return $b->id_categoria - $a->id_categoria;
          });
          return $this->view->response($categorias,200);
        }
        else {
          $categoria = $this->model->getCategoria($params[":ID"]);
          if(!empty($categoria)) {
            return $this->view->response($categoria,200);
          }else{
            $this->view->response(
            [ 'msg' => 'La categoria con el id='.$params[':ID'].'No existe.']
            , 404);
          }
        }
    }
    
 
    public function add($params = []) {
        // devuelve el objeto JSON enviado por POST     
        $body = $this->getData();
 
        // inserta el producto
        
        $categoria = $body->nombre_categoria;
        if(empty($categoria)){
           $this->view->response('Debe ingresar todos los datos o ingresarlos por su tipo', 400);

        }else{
            $id = $this->model->insertCategoria($categoria);
            $this->view->response('La categoria fue insertado con el id='.$id, 201);
        }
         
    }


    public function delete($params = []){
            
        $id = $params[':ID'];
        $Categoria = $this->model->getCategoria($id);

        if($Categoria) {
            $this->model->deleteCategoria($id);
            $this->view->response('La Categoria con id='.$id.' ha sido borrada.', 200);
        } else {
            $this->view->response('La Categoria con el id='.$id.' no existe ', 404);
        }
    }

    public function update($params = []) {    

        $id_Categoria = $params[':ID'];
        $Categoria = $this->model->getCategoria($id_Categoria);

        if($Categoria) {
            $body = $this->getData();
            $categoria = $body->nombre_categoria;
            if(empty($categoria)){
                $this->view->response('Debe ingresar todos los datos o ingresarlos por su tipo', 400);
                return;
            }
            $this->model->updateCategoria($categoria,$id_Categoria);
       
            $this->view->response('La categoria con id='.$id_Categoria.' ha sido modificado.', 200);
        }else {
            $this->view->response('La categoria con el id='.$id_Categoria.' no existe ', 404);
        }
    }




}
?>