<?php
    include_once("clases/ProductoEnvasado.php");
    /*
    Se recibirán por POST los siguientes valores: producto_json (id,
codigoBarra, nombre, origen y precio, en formato de cadena JSON) y la foto (para modificar un producto
envasado en la base de datos. Invocar al método Modificar.
Nota: El valor del id, será el id del producto envasado 'original', mientras que el resto de los valores serán los del
producto envasado a ser modificado.
Si se pudo modificar en la base de datos, la foto original del registro modificado se moverá al subdirectorio
“./productosModificados/”, con el nombre formado por el nombre punto origen punto 'modificado' punto hora,
minutos y segundos de la modificación (Ejemplo: aceite.italia.modificado.105905.jpg).
Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
    */

    $json = isset($_POST["producto_json"]) ? json_decode($_POST["producto_json"]) : null;
    $foto = isset($_FILES["foto"]["name"]) ? $_FILES["foto"]["name"] : null;

    $stdClass = new stdClass();

    $array = ProductoEnvasado::Traer();
    $existe = false;
    $obj = null;
    $ubicacion = "";

    //compruebo si el producto a modificar existe
    foreach ($array as $producto) {
        if($producto->id == $json->id){
            $existe = true;
            $ubicacion = $producto->pathFoto;
            $obj = $producto;
            break;
        }
    }
    
    $tipoArchivo = pathinfo("./productos/imagenes/".$obj->pathFoto, PATHINFO_EXTENSION);
    $nuevaubicacion = "./productosModificados/".$obj->id.'.'.$obj->nombre.'.modificado.'.date('His').'.'.$tipoArchivo;
    $ubicacionOriginal = $obj->pathFoto;
    if ($existe) {  
        $obj = new ProductoEnvasado($json->nombre,$json->origen,$json->id,$json->codigoBarra,$json->precio,$nuevaubicacion);
        if ($obj->Modificar()) {
            copy($ubicacionOriginal,$nuevaubicacion);
            unlink($ubicacionOriginal);
            //move_uploaded_file($ubicacionOriginal,$nuevaubicacion);
            $stdClass->exito = true;
            $stdClass->mensaje = "Se ha modificado el producto de la BD";
        }else{
            $stdClass->exito = false;
            $stdClass->mensaje = "Error en la ejecucion de la consulta";
        }
    }else{
        $stdClass->exito = false;
        $stdClass->mensaje = "El producto que desea modificar no se encuentra en la base de datos";
    }    

    echo json_encode($stdClass);
    
