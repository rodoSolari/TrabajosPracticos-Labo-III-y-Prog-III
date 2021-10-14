<?php

    include_once "./clases/Producto.php";   

    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : NULL;
    $origen = isset($_POST["origen"]) ? $_POST["origen"] : NULL;
    if($nombre!=NULL && $origen !=NULL){
        $producto = new Producto($nombre,$origen);
        
        $objjson = Producto::VerificarProductoJSON($producto);
        if($objjson->exito == true){
            setcookie($nombre."_".$origen,date("his"));
        }
        echo json_encode($objjson);
    }

