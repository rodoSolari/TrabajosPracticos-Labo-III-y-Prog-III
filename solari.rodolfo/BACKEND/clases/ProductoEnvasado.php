<?php
    include_once "Producto.php";
    include_once "IParte1.php";
    include_once "IParte2.php";
    include_once "IParte3.php";
    include_once "accesoDatos.php";
    class ProductoEnvasado extends Producto implements IParte1,IParte2,IParte3{
        public $id;
        public $codigoBarra;
        public $precio;
        public $pathFoto;

        public function __construct($nombre,$origen,$id = null,$codigoBarra = null,$precio = null,$pathFoto = null){
            parent::__construct($nombre,$origen);
            $this->id = $id;
            $this->codigoBarra = $codigoBarra;
            $this->precio = $precio;
            $this->pathFoto = $pathFoto;
        }

        public function ToJSON()
        {
            $obj = new stdClass();
            $obj->nombre = $this->nombre;
            $obj->origen = $this->origen;
            $obj->id = $this->id;
            $obj->codigoBarra = $this->codigoBarra;
            $obj->precio = $this->precio;
            $obj->pathFoto = $this->pathFoto;
        
            return json_encode($obj);
        }

        public static function Traer(){
            $objetoAccesoDatos = AccesoDatos::DameUnObjetoAcceso();
            $consulta = $objetoAccesoDatos->RetornarConsulta("SELECT * FROM productos");
            $consulta->execute();
            $arrayObjetos = array();
            while($obj = $consulta->fetchObject()){
                $productoEnvasado = new ProductoEnvasado($obj->nombre,$obj->origen,$obj->id,$obj->codigo_barra,$obj->precio,$obj->foto);
                array_push($arrayObjetos,$productoEnvasado);
            }
            return $arrayObjetos;
        }

        public function Agregar(){
            $objetoAccesoDatos = AccesoDatos::DameUnObjetoAcceso();
            $consulta = $objetoAccesoDatos->RetornarConsulta("INSERT INTO productos (nombre, origen, codigo_barra,precio,foto) VALUES(:nombre, :origen, :codigo_barra,:precio,:foto)");
            $consulta->bindValue(':origen', $this->origen, PDO::PARAM_STR);
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':codigo_barra', $this->codigoBarra, PDO::PARAM_INT);
            $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
            $consulta->bindValue(':foto', $this->pathFoto, PDO::PARAM_STR);
            $success = $consulta->execute() == true ? true : false;
            return $success;
        }

        public static function Eliminar($id){
            $objetoAccesoDatos = AccesoDatos::DameUnObjetoAcceso();
            $consulta = $objetoAccesoDatos->RetornarConsulta("DELETE FROM productos where id = :id");

            $consulta->bindValue(':id',$id, PDO::PARAM_INT);

            return $consulta->execute();
        }

        public function Modificar(){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
            $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE productos SET nombre = :nombre, origen = :origen, 
                                                            codigo_barra = :codigo_barra, precio = :precio, foto = :foto
                                                            WHERE id = :id");

            $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':origen', $this->origen, PDO::PARAM_STR);
            $consulta->bindValue(':codigo_barra', $this->codigoBarra, PDO::PARAM_INT);
            $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
            $consulta->bindValue(':foto', $this->pathFoto, PDO::PARAM_STR);

            return $consulta->execute();
        }


        public function Existe($arrayProductos){
            $existe = false;
            foreach($arrayProductos as $producto){
                if($producto->nombre == $this->nombre && $producto->origen == $this->origen){
                    $existe = true;
                    break;
                }
            }
            return $existe;
        }

        public function GuardarEnArchivo(){
            $archivo = fopen("./archivos/productos_envasados_borrados.txt","a");

            $tipoArchivo = pathinfo("./productos/imagenes".$this->pathFoto, PATHINFO_EXTENSION);
            $fotoName = $this->id.'.'.$this->nombre.'.borrado.'.date('His').'.'.$tipoArchivo;
            //$linea = $this->nombre."-".$this->origen."-".$this->id."-".$this->codigoBarra."-".$this->precio."-".$fotoName;
            $ubicacionOriginal = "./productos/imagenes/".$this->pathFoto;
            $nuevaubicacion = "./productosBorrados/".$this->id.'.'.$this->nombre.'.borrado.'.date('His').'.'.$tipoArchivo;
            
            if(fwrite($archivo,$fotoName."\r\n")) {
                copy($ubicacionOriginal,$nuevaubicacion);
                unlink($ubicacionOriginal);

                //move_uploaded_file($ubicacionOriginal,$nuevaubicacion);
            }
            fclose($archivo);

        }

        public static function MostrarBorradosJSON(){
            $array = array();
            $archivo = fopen("./archivos/productos_eliminados.json", "r");
            $array = fread($archivo,filesize("./archivos/productos_eliminados.json"));
            fclose($archivo);
            return $array;
        }

        public static function MostrarModificados(){
            $directorio = opendir("productosModificados/");
            $retorno = array();
            while($elemento = readdir($directorio))
            {
                if($elemento != "." && $elemento != "..")
                {
                    array_push($retorno,$elemento);     
                }
            }
            return $retorno;
        }

    }