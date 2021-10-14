<?php
    include_once "./clases/ProductoEnvasado.php";
    /*Muestra (en una tabla HTML) todas las imagenes (50px X 50px) de los
    productos envasados registrados en el directorio “./productosModificados/”. Para ello, agregar un método
    estático (en ProductoEnvasado), llamado MostrarModificados.*/
    $fotos = ProductoEnvasado::MostrarModificados();
    $tabla = "<table>";
    foreach($fotos as $foto){
        $tabla .= "<tr>
            <td>
                <img src= productosModificados/$foto alt=fotoProd width=50px height=50px>
            </td>
            </tr>";
    }
    $tabla .= "</table>";
    echo $tabla;