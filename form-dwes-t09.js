//chequeamos que el texto introducido sea correcto
$(document).ready(function () {
    $("#text").keyup(function () {
        console.log("keyup");
        var text=$("#text").val();
        var textRegex=/^[a-zA-Z\ \.]+$/;
        //comprobamos que el texto introducido cumple con los criterios de la expresión regular
        if (!textRegex.test(text)){
            $("#text").removeClass("is-valid");
            $("#text").addClass("is-invalid");
        }else{
            $("#text").removeClass("is-invalid");
            $("#text").addClass("is-valid");
            //se recargan los libros en el html
            loadLibros();
        }
    });
});

//función para crear la petición al servidor y pedir los libros a la Api
function loadLibros(){
    var xml=new XMLHttpRequest();
    xml.onreadystatechange=function(){
        if(this.readyState==4 && this.status==200){
            var libros = JSON.parse(this.response);
            // console.log(libros);
            injectLibros(libros);
        }
    };
    //guardamos el texto introducido por el usuario
    var lookFor=document.getElementById("text").value;
    var uri="api.php?action=get_lista_libros&autor=" + lookFor;
    xml.open("GET",uri,true);
    xml.send();
    return false;
}
//función para inyectar y escribir los libros en el HTML
function injectLibros(libros){
    var htmlLibros=document.getElementById("libros");
    //se eliminan los resultados de los libros escritos en la búsqueda anterior
    htmlLibros.innerHTML="";
    if(libros == null){
        //mostramos una adventencia cuando no se encuentran los libros
        var warning=document.createElement("div");
        warning.className="alert alert-warning d-flex align-items-center";
        warning.setAttribute("role","alert");
        var new_div=document.createElement("div");
        new_div.innerHTML="No se ha encontrado ningún libro";
        warning.appendChild(new_div);
        htmlLibros.appendChild(warning);
    }else{
        for (const libro of libros){
            //htmlLibros.innerHTML+=libro.titulo;
            //añadimos los libros como elemento de una lista
            var element=document.createElement("li");
            element.innerHTML=libro.titulo + " - " + libro.nombre + " " + libro.apellidos;
            htmlLibros.appendChild(element);
            //console.log(libro);
        }   
    }
}