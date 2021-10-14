<?php
/*Se recibe el parámetro producto_json (id, codigoBarra, nombre, origen, precio y
pathFoto en formato de cadena JSON) por POST. Se deberá borrar el producto envasado (invocando al método
Eliminar).
Si se pudo borrar en la base de datos, invocar al método GuardarEnArchivo.
Retornar un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
Si se invoca por GET (sin parámetros), se mostrarán en una tabla (HTML) la información de todos los productos
envasados borrados y sus respectivas imagenes.*/
    include "./clases/ProductoEnvasado.php";

    $producto = isset($_POST["producto_json"]) ? $_POST["producto_json"] : NULL;
    $json = json_decode($producto);

    $array = ProductoEnvasado::Traer();
    $stdClass = new stdClass();
    $existe = false;
    $objjson = null;

    if ($producto != null) {
        foreach ($array as $obj) {
            if($obj->id == $json->id){
                $existe = true;
                //$ubicacion = $obj->pathFoto;
                break;
            }
        }

       // $tipoArchivo = pathinfo("productos/imagenes".$obj->pathFoto, PATHINFO_EXTENSION);
       // $nuevaubicacion = "productosBorrados/".$obj->id.'.'.$obj->nombre.'.borrado.'.date('His').'.'.$tipoArchivo;
        if($existe){
            if(ProductoEnvasado::Eliminar($json->id)){
                $producto = new ProductoEnvasado($json->nombre,$json->origen,$json->id,$json->codigoBarra,$json->precio,$json->pathFoto);//nueva ubicacion
                $producto->GuardarEnArchivo();
                $stdClass->exito = true;
                $stdClass->mensaje = "Producto Eliminado";
            }else{
                $stdClass->exito = false;
                $stdClass->mensaje = "No se ha podido eliminar el producto";
            }
        }else{
            $stdClass->exito = false;
            $stdClass->mensaje = "El producto a eliminar no se encuentra en la base de datos";
        }
        echo json_encode($stdClass);
    }else{
        echo "<table>
            <tr>
                <td>ID</td>
                <td>NOMBRE</td>
                <td>ORIGEN</td>
                <td>CODIGO</td>
                <td>PRECIO</td>
                <td>FOTO</td>
            </tr>";

        $archivo = fopen("archivos/productos_envasados_borrados.txt", "r");

        while(!feof($archivo)){
        $cadena = fgets($archivo);
        //$cadena = is_string($cadena) ? trim($cadena) : false;
        $cadena = trim($cadena);
        if($cadena != false) 
        {
            $prod = explode("-", $cadena);
            if ($prod[0] != "" && $prod[0] != "\r\n") 
            {
                $producto = new ProductoEnvasado($prod[0], $prod[1], $prod[2], $prod[3], $prod[4], $prod[5]);
                echo "
                        <tr>
                            <td>$producto->id</td>
                            <td>$producto->nombre</td>
                            <td>$producto->origen</td>
                            <td>$producto->codigoBarra</td>
                            <td>$producto->precio</td>
                            <td><img src='{$producto->pathFoto}' width='50px' height='50px'></td>
                        </tr>";
            }
        }
    }
    echo '</table>';
    fclose($archivo);
    }