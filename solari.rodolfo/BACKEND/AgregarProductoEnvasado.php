<?php
    include_once "./clases/ProductoEnvasado.php";
    /*Se recibirán por POST los valores: codigoBarra, nombre, origen, precio y la foto
    para registrar un producto envasado en la base de datos.
    Verificar la previa existencia del producto envasado invocando al método Existe. Se le pasará como parámetro el
    array que retorna el método Traer.
    Si el producto envasado ya existe en la base de datos, se retornará un mensaje que indique lo acontecido.
    Si el producto envasado no existe, se invocará al método Agregar. La imagen se guardará en
    “./productos/imagenes/”, con el nombre formado por el nombre punto origen punto hora, minutos y segundos
    del alta (Ejemplo: tomate.argentina.105905.jpg).
    Se retornará un JSON que contendrá: éxito(bool) y mensaje(string) indicando lo acontecido.*/
    
    $codigoBarra = isset($_POST["codigoBarra"]) ? $_POST["codigoBarra"] : NULL;
    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : NULL;
    $origen = isset($_POST["origen"]) ? $_POST["origen"] : NULL;
    $precio = isset($_POST["precio"]) ? $_POST["precio"] : NULL;
    $file = isset($_FILES["foto"]) ? $_FILES["foto"] : NULL;

    $tipoArchivo = pathinfo($file["name"],PATHINFO_EXTENSION);
    $destino = "./productos/imagenes/".$nombre.'.'.$origen.'.'.date("His").'.'.$tipoArchivo;
    $fotoName = $nombre.'.'.$origen.'.'.date('His').'.'.$tipoArchivo;
    $producto = new ProductoEnvasado($nombre,$origen,null,$codigoBarra,$precio,$destino);

    $stdClass = new stdClass();
    $array = ProductoEnvasado::Traer();

    if($producto->Existe($array)){
        $stdClass->mensaje = "El producto ya existe en la base de datos";
        $stdClass->exito = false;
    }else{
        if($producto->Agregar()){

            move_uploaded_file($file["tmp_name"],$destino);
            $stdClass->mensaje = "El producto fue agregado exitosamente";
            $stdClass->exito = true;
        }
    }


    echo json_encode($stdClass);
