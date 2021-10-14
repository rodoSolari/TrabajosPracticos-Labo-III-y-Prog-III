<?php
    /*Se recibe por POST el origen, se mostrarán en una tabla (HTML) los productos envasados
    cuyo origen coincidan con el pasado por parámetro.
    Si se recibe por POST el nombre, se mostrarán en una tabla (HTML) los productos envasados cuyo nombre
    coincida con el pasado por parámetro.
    Si se recibe por POST el nombre y el origen, se mostrarán en una tabla (HTML) los productos envasados cuyo
    nombre y origen coincidan con los pasados por parámetro. */
    include_once "clases/ProductoEnvasado.php";

    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : NULL;
    $origen = isset($_POST["origen"]) ? $_POST["origen"] : NULL;

    $array = ProductoEnvasado::Traer();
    $arrayFiltrados = array();

    $tabla = '<table class="table" border="1" align="center">
        <thead>
            <tr>
                <th>  Nombre     </th>
                <th>  origen     </th>
                <th>  id         </th>
                <th>Codigo de barra</th>
                <th>  Precio     </th>
                <th>  Foto       </th>
            </tr> 
        </thead>';  
    

    if($nombre == NULL && $origen != NULL){
        foreach($array as $producto){
            if($producto->origen == $origen){
                array_push($arrayFiltrados,$producto);
            }
        }
    }
    else if($nombre != NULL && $origen == NULL){
        foreach($array as $producto){
            if($producto->nombre == $nombre){
                array_push($arrayFiltrados,$producto);
            }
        }
    }
    else if($nombre != NULL && $origen != NULL){
        foreach($array as $producto){
            if($producto->nombre == $nombre && $producto->origen == $origen){
                array_push($arrayFiltrados,$producto);
            }
        }
    }
    foreach($arrayFiltrados as $productoEnvasado){
        $tabla .= "<tr>
            <td>".$productoEnvasado->nombre."</td>
            <td>".$productoEnvasado->origen."</td>
            <td>".$productoEnvasado->id."</td>
            <td>".$productoEnvasado->codigoBarra."</td>
            <td>".$productoEnvasado->precio."</td>
            <td>"."<img src='{$productoEnvasado->pathFoto}' width='90px' height='90px'></td>
        </tr>";
    }
    $tabla .= "</table>";

    echo $tabla;