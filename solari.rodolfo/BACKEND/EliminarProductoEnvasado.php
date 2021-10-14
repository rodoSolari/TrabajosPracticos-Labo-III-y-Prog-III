<?php
    include_once "./clases/ProductoEnvasado.php";

    $productoJson = isset($_POST["producto_json"]) ? $_POST["producto_json"] : NULL;
    $objetoProducto = json_decode($productoJson);
    $array = ProductoEnvasado::Traer();
    $existe = false;
    $json = new stdClass();
    $productoEliminar = null;

    foreach($array as $producto){
        if($producto->id == $objetoProducto->id){
            $existe = true;
            $productoEliminar = $producto;
            break;
        }
    }
    if($existe){
        if(ProductoEnvasado::Eliminar($objetoProducto->id)){
            $productoEliminar->GuardarJSON('./archivos/productos_eliminados.json');
            $json->exito =true;
            $json->mensaje = "Se ha eliminado exitosamente el producto";
        }else{
            $json->exito = false;
            $json->mensaje = "Error, no se pudo eliminar el producto";
        }
    }else{
        $json->exito =false;
        $json->mensaje = "No se ha encontrado el producto en la lista";
    }
    echo json_encode($json);
    