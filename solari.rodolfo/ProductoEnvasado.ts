/*hereda de Producto, posee como atributos id(numérico), codigoBarra(cadena),
precio(numérico) y pathFoto(cadena). Un constructor para inicializar los atributos (con todos sus
parámetros opcionales). Un método ToJSON(), que retornará la representación del objeto en
formato JSON. Reutilizar código. */
/// <reference path="./producto.ts" /> 
namespace Entidades{
    export class ProductoEnvasado extends Producto{
        id : number;
        codigoBarra : any;
        precio : number;
        pathFoto : string;

        public constructor (nombre : string, origen : string, id : number = 0, codigoBarra : any = null, precio : number = 0, pathFoto : string = ""){
            super(nombre, origen);
            this.id = id;
            this.codigoBarra = codigoBarra;
            this.precio = precio;
            this.pathFoto = pathFoto;
        }

        public ToJSON(){
            return `{${super.ToString()}, "id" : ${this.id}, "codigoBarra" : ${this.codigoBarra}, "precio" : ${this.precio} , "pathFoto" : "${this.pathFoto}"}`;
        }
    }
}