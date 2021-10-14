<?php
    require_once "./clases/Producto.php";

    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : NULL;
    $origen = isset($_POST["origen"]) ? $_POST["origen"] : NULL;
    if($nombre !=NULL && $origen != NULL){
        $producto = new Producto($nombre,$origen);
        echo $producto->GuardarJSON("./archivos/productos.json");
    }


