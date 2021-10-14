<?php
    $nombre = isset($_GET["nombre"]) ? $_GET["nombre"] : NULL;
    $origen = isset($_GET["origen"]) ? $_GET["origen"] : NULL;
    $obj = new stdClass();
    $obj->exito = false;
    $obj->mensaje = "No se ha ingresado correctamente los valres nombre/origen";
    if($nombre !=NULL && $origen != NULL){
        if(isset($_COOKIE[$nombre."_".$origen])){
            $obj->exito = true;
            $obj->mensaje = "cookie: ".$_COOKIE[$nombre."_".$origen];
        }else{
            $obj->exito = false;
            $obj->mensaje = "No se ha encontrado la cookie";
        }
    }
    echo json_encode($obj);

