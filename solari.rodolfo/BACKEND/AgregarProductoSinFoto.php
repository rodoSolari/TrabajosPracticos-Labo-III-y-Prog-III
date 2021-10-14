<?php

    include_once "./clases/ProductoEnvasado.php";
    $productoJson = isset($_POST["producto_json"]) ? $_POST["producto_json"] : NULL;
    $json = json_decode($productoJson);
    $objjson = new stdClass();
    $productoEncontrado = true;
    $arrayProd = ProductoEnvasado::Traer();

    foreach ($arrayProd as $Prod) {
        if ($Prod->origen != $json->origen && $Prod->nombre != $json->nombre) {
            $productoEncontrado = false;
            break;
        }
    }

    if(!$productoEncontrado){
        $productoAgregar = new ProductoEnvasado($json->nombre,$json->origen,null,$json->codigoBarra,$json->precio,null);
        if($productoAgregar->Agregar()){
            $objjson->exito = true;
            $objjson->mensaje = "El producto fue agregado con exito";
        }else{
            $objjson->exito = true;
            $objjson->mensaje = "Error al agregar el producto";
        }
    }else{
        $objjson->exito = false;
        $objjson->mensaje = "El producto ya se encuentra en la base de datos";
    }

    echo json_encode($objjson);
