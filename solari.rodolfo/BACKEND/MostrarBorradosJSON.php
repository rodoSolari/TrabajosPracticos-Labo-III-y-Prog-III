<?php
    include_once "./clases/ProductoEnvasado.php";
    /*Muestra todo lo registrado en el archivo “productos_eliminados.json”. Para ello,
    agregar un método estático (en ProductoEnvasado), llamado MostrarBorradosJSON. */
    echo ProductoEnvasado::MostrarBorradosJSON();
