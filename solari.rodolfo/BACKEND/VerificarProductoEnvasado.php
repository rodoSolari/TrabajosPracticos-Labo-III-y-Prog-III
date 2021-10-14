<?php
    include_once "./clases/ProductoEnvasado.php";

    $cadenaJson = isset($_POST["obj_producto"]) ? $_POST["obj_producto"] : NULL;
    $objetoProducto = json_decode($cadenaJson);
    $array = ProductoEnvasado::Traer();

    $json = new stdClass();
    $productoEliminar = null;
    $existe = false;
    $json = json_encode("{[]}");
    if($cadenaJson !=NULL){
        $producto = new ProductoEnvasado($objetoProducto->nombre,$objetoProducto->origen);
        if($producto->Existe($array)){    
            /*foreach($array as $prod){
                if($prod->nombre == $objetoProducto->nombre && $prod->origen == $objetoProducto->origen)
                $existe = true;
                break;
            }
        }
        if($existe){*/
            $json = $producto->ToJSON();
        }/*else{
            $json = "{[]}";
        }*/
    }
    echo $json;
