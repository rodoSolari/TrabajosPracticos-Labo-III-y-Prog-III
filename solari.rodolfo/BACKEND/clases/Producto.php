<?php

class Producto{
    public $nombre;
    public $origen;

    public function __construct($nombre,$origen){
        $this->nombre = $nombre;
        $this->origen = $origen;
    }

 

    public function ToJSON(){
        $productoJson = new stdClass();
        $productoJson->nombre = $this->nombre;
        $productoJson->origen = $this->origen;
        
        return json_encode($productoJson);
    }

    //agregará al producto en el path recibido por parámetro.
    //Retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.
    public function GuardarJSON($path){
        $obj = new stdClass();
        $obj->exito = false;
        $obj->mensaje = "No se ha agregado el producto";

        $arrayProductos = self::TraerJSON($path);
        array_push($arrayProductos,$this);

        //$array = $arrayProductos;
        if(file_exists($path)){
            $archivoJson = fopen($path,"w");
            if(fwrite($archivoJson,json_encode($arrayProductos))){
                $obj->exito = true;
                $obj->mensaje = "agregado con exito";
            }
            fclose($archivoJson);
        }

        return json_encode($obj);
    }

    //retornará un array de objetos de tipo producto.
    public static function TraerJSON($path){
        $arrayProductos = array();
        $archivoJson = fopen($path,"r");
        $lenghtFile = filesize($path);

        if($lenghtFile>0){
            $productos = fread($archivoJson,$lenghtFile);
            $array = json_decode($productos);
            foreach($array as $objeto){
                $producto = new Producto($objeto->nombre,$objeto->origen);
                array_push($arrayProductos,$producto);
            }
        }
        fclose($archivoJson);
        return $arrayProductos;
    }


    public static function VerificarProductoJSON($producto){
        $productos = Producto::TraerJSON("./archivos/productos.json");
        $obj = new stdClass();
        $obj->exito = false;
        $obj->mensaje = "No se ha agregado el producto";

        $contadorOrigen = 0;
        $arrayNombres = array();
        $arrayPopulares = array();
        foreach($productos as $prod){
            if($prod->nombre == $producto->nombre && $prod->origen == $producto->origen){
                array_push($arrayNombres,$prod->nombre);
                $obj->exito = true;
                $obj->mensaje = "Producto verificado exitosamente";

                $origenBuscar = $prod->origen;
                //$contadorOrigen++;
            }
        }

        if($obj->exito){
            foreach($productos as $prod){
                if($prod->origen == $origenBuscar){
                    $origenBuscar = $prod->origen;
                    $contadorOrigen++;
                }
            }
            $obj->mensaje = "El origen se ha encontrado ".$contadorOrigen." veces";
        }else{
            $arrayContadorNombres = array_count_values($arrayNombres);
            $arrayPopulares = array();
            $max = max($arrayContadorNombres);

            foreach($arrayContadorNombres as $nombre => $contador){
                if($max == $contador){
                    array_push($arrayPopulares,$nombre);
                }
            }

            $nombresPopulares = "";
            foreach($arrayPopulares as $nombre){
                $nombresPopulares .= $nombre;
                $nombresPopulares .= " ";

            }

            $obj->mensaje = "Los productos mas populares son ".$nombresPopulares." .";
        }
        return $obj;
        
    }

}

?>