/*Producto: nombre(cadena) y origen(cadena) como atributos. Un constructor que reciba dos
parámetros.
Un método, ToString(), que retorne la representación de la clase en formato cadena (preparar la
cadena para que, al juntarse con el método ToJSON, forme una cadena JSON válida).
Un método de instancia, ToJSON(), que retorne la representación de la instancia en formato de
cadena JSON válido. Reutilizar código*/ 
namespace Entidades{
    export class Producto{

        public nombre : string;
        public origen : string;

        public constructor(nombre : string, origen : string){
            this.nombre = nombre;
        }

        public ToString(){
            return `"nombre":"${this.nombre}","origen" : "${this.origen}"`;
        }

        public ToJSON(){
            return `{${this.ToString()}}`;
        }
    }
}