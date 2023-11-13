<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

<?php
    echo "<h1> LISTA DE PEDIDOS</h1>";
    function showHome(){ ?>
        <form method="post" action="agregar">
            <label for="">Ingrese el producto que desea</label>
            <input id="producto" name="producto" type="text">       
            <select name="categoria" id="categoria">
                <option value="servido">servido</option>
                <option value="envasado">envasado</option>
                <option value="postres">postres</option>
                <option value="otros">otros</option>
                
            </select>
            <label for="">Ingrese el precio</label>
            <input type="text" id="precio" name="precio">
            <label for="">Ingrese su nombre</label>
            <input type="text" id="cliente" name="cliente">
            <button type="submit">COMPRAR</button>
            
        </form>
        
        <?php 
            $db = new PDO('mysql:host=localhost;'.'dbname=tpe_heladeria;charset=utf8', 'root', '');


            $id = $db->prepare('SELECT MAX(id) FROM datos_producto');
            var_dump($id);

        }
    function getPedidos(){
        $db = new PDO('mysql:host=localhost;'.'dbname=tpe_heladeria;charset=utf8', 'root', '');
        //2.  ejecuto consulta SQL
        $query = $db->prepare('SELECT * FROM datos_producto');
        $query->execute();

        //3. Obtener datos de la consulta

        $pedidos = $query->fetchAll(PDO::FETCH_OBJ); // devuelve un arreglo con todos los pedidos
        
        return $pedidos;
    }   
    $pedidos = getPedidos();
    

    echo '<table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>id</th>
                    <th>producto</th>
                    <th>categoria</th>
                    <th>precio</th>
                    <th>cliente</th>            
                </tr>
            </thead>';
    foreach ($pedidos as $pedido){
    echo   "<tbody>
                <tr>
                    <td>$pedido->id</td>                    
                    <td>$pedido->producto</td>   
                    <td>$pedido->categoria</td> 
                    <td>$pedido->precio</td> 
                    <td>n°$pedido->cliente</td>                      

                </tr>
            </tbody>"; 
    }
    echo "</table>";
    
    function insertPedidos(){
        
        $db = new PDO('mysql:host=localhost;'.'dbname=tpe_heladeria;charset=utf8', 'root', '');
        
        $query = $db->prepare("INSERT INTO datos_producto(producto, categoria, precio, cliente) VALUES(?,?,?,?)");
        
        $query->execute(array($_POST['producto'],$_POST['categoria'],$_POST['precio'],$_POST['cliente']));
        header("Location: http://".$_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']));
    }
    ?>


