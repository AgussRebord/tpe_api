# TPE_WEB2

NOMBRE: Agustin Leonel Rebord
email: agussrebord@hotmail.com
Nombre: Lucas Agustin Garcia
email: tfchook@hotmail.com
Tematica TPE: 

El proposito de esta pagina es hacer una pagina de venta de productos de heladeria.

listar todos los pedidos:

--GET: pedidos

listar todas las categorias:

--GET: categorias

listar todos los productos:

--GET productos

Cuando listamos cualquiera de los antes mencionados podemos especificar el orden, ya sea ascendente o descendente. El orden por defecto es ascendete.

Ejemplos.

--GET: pedidos?order_by={String}&ASC
--GET: pedidos?order_by={String}&DESC

Para agregar un nuevo producto,pedido o categoria lo hacemos de la siguiente manera.

--POST: pedidos
--POST: categorias
--POST: productos

Para poder agregar cualquiera de los antes mencionados necesitaremos.
Para pedidos:

POST: {"id_pedido":int , "id_producto": int , "producto": varchar, "categoria":int}

Para categorias:

POST: {"id_categoria":int , "nombre_categoria": varchar}

Para productos:

POST: {"id_productos":int , "nombre_producto": varchar}


Si queremos listar un producto,pedido o categoria por su id lo hacemos de la siguiente manera.

--GET: pedidos/:id
--GET: categorias/:id
--GET: productos/:id


Para poder modificar cualquiera de los antes mencionados necesitaremos.
Para pedidos:

-- PUT : pedidos/:id
-- PUT : categorias/:id
-- PUT : productos/:id

Para pedidos:

PUT: {"id_pedido":int , "id_producto": int , "producto": varchar, "categoria":int}

Para categorias:

PUT: {"id_categoria":int , "nombre_categoria": varchar}

Para productos:

PUT: {"id_productos":int , "nombre_producto": varchar}


Tambien contamos con la opcion de filtrar por categorias en los pedidos. Se buscara todos los pedidos en los cuales su categoria sea igual a la recibida por $_GET:

--GET: pedidos?categoria={int}
