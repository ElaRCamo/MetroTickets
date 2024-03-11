const DOM = function (){
    this.id = str => document.getElementById(str);
    this.query = (regla_css, one=false) =>
        one === true ?
            document.querySelector(regla_css) :
            document.querySelectorAll(regla_css);
    this.create =  (str,props ={})=> Object.assign(document.createElement(str),props);
    /* -----------------------Forma larga:-------------------------
    const create = (str,props ={})=>{ //props corresponde a las propiedades(name,type,etc)
        const etiqueta = document.createElement(str); //se crea el elemento
        Object.assign(etiqueta, props)
        return etiqueta;
    }*/

    this.append = (hijos, padre=document.body) =>{
        if(hijos.length){ //Array
            for(let hijo of hijos) padre.appendChild(hijo);
        }else{ //un solo elemento
            padre.appendChild(hijos);
        }
    }

    this.remove = function (HTMLElement){
        HTMLElement.remove( );
        //HTMLElement.parentNode.removeChild(HTMLElement)
    }
}
const D = new DOM( );