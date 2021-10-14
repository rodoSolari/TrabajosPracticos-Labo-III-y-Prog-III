<?php
    include_once("clases/ProductoEnvasado.php");

    $tabla = isset($_GET["mostrar"]) ? $_GET["mostrar"] : NULL;
    $arrayProductos = ProductoEnvasado::Traer();
    if($tabla == "mostrar"){
        $tablahtml = '<table class="table" border="1" align="center">
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
        foreach($arrayProductos as $productoEnvasado){
            $tablahtml .= "<tr>
                <td>".$productoEnvasado->nombre."</td>
                <td>".$productoEnvasado->origen."</td>
                <td>".$productoEnvasado->id."</td>
                <td>".$productoEnvasado->codigoBarra."</td>
                <td>".$productoEnvasado->precio."</td>
                <td>"."<img src='{$productoEnvasado->pathFoto}' width='90px' height='90px'></td>
            </tr>";
        }
        $tablahtml .= "</table>";
        echo $tablahtml."<br/>";
        echo json_encode($arrayProductos);
    }else{
        echo json_encode($arrayProductos);
    }