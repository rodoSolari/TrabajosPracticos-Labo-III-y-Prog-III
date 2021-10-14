<?php
    include_once "./clases/ProductoEnvasado.php";

    $productoJson = isset($_POST["producto_json"]) ? $_POST["producto_json"] : NULL;
    $objetoProducto = json_decode($productoJson);
    
    //json que se retorna como resultado de la modificacion
    $json = new stdClass();
    $json->exito = false;
    $json->mensaje = "Error, no se pudo modificar el producto";

    $array = ProductoEnvasado::Traer();
    $existe = false;
    $productoModificado = null;

    foreach($array as $producto){
        if($producto->id == $objetoProducto->id){
            $productoModificado = $producto;
            $existe = true;

        }
    }

    if($existe){
        $productoModificado = new ProductoEnvasado($objetoProducto->nombre,
                                                $objetoProducto->origen,
                                                $objetoProducto->id,
                                                $objetoProducto->codigoBarra,
                                                $objetoProducto->precio,
                                                null);
        if($productoModificado->Modificar()){
            $json->exito = true;
            $json->mensaje = "Se ha modificado el producto con exito";
        }else{
            $json->exito = false;
            $json->mensaje = "Error, no se pudo modificar";
        }
    }
    echo json_encode($json);