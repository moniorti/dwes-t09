<?php
include "gestionLibros.php";
// Esta API tiene dos posibilidades; Mostrar una lista de autores o mostrar la información de un autor específico.
   /**
     * Función de conexión a la base de datos Libros
     * @param gestionLibros $o objeto sobre el que se va a crear la conexión
     * @return mysqli|null conexión a la base de datos
     */
function get_conexion($o)
{
    $HerokuDB = getenv("CLEARDB_DATABASE_URL");
    if ($HerokuDB === false) {
        $Servidor = "127.0.0.1";
        $Usuario = "dwes-t06";
        $Password = "dwes-t06-pass";
        $DataBase = "Libros";
    } else {
        $parsedHerokuDB = parse_url($HerokuDB);
        $Servidor = $parsedHerokuDB["host"];
        $Usuario = $parsedHerokuDB["user"];
        $Password = $parsedHerokuDB["pass"];
        $DataBase = substr($parsedHerokuDB["path"], 1);
    }
    $mysqli = $o->conexion($Servidor, $Usuario, $Password, $DataBase);
    return $mysqli;
}
  /**
     * Función para conseguir la lista de autores de la base de datos
     * @return array lista de autores
     */
function get_lista_autores()
{
    $o = new gestionLibros();
    $mysqli = get_conexion($o);
    $result = $o->consultarAutores($mysqli);
    return $result;
}
  /**
     * Función para conseguir los datos del autor según su id
     * @param int $id id del autor
     * @return array autores que cumplen la condición
     */
function get_datos_autor($id)
{
    $o = new gestionLibros();
    $mysqli = get_conexion($o);
    $result = array();
    $autores = $o->consultarAutores($mysqli, $id);
    if ($autores !== null) {
        $result["datos"] = $autores[0];
        $result["libros"] = $o->consultarLibros_summary($mysqli, $id);
    }
    return $result;
}
    /**
     * Función para obtener los libros según el texto introducido
     * @param string $text texto a buscar en el nombre o apellidos del autor
     * @return array libros que cumplen la condición
     */
function get_lista_libros($text){
    $o= new gestionLibros();
    $mysqli=get_conexion($o);
    $result=$o->consultarLibrosbyAutor($mysqli,$text);
    return $result;

}
    /**
     * Función para obtener la lista de libros según el id del libro solicitado
     * @param int $id id del libro
     * @return array libros que cumplen la condición
     */
function get_datos_libros($id){
    $o=new gestionLibros();
    $mysqli=get_conexion($o);
    $result=$o->consultarDatosLibro_details($mysqli,$id);
    return $result;
}

$posibles_URL = array("get_lista_autores", "get_datos_autor","get_lista_libros","get_datos_libros");

$valor = "Ha ocurrido un error";

if (isset($_GET["action"]) && in_array($_GET["action"], $posibles_URL)) {
    switch ($_GET["action"]) {
        case "get_lista_autores":
            $valor = get_lista_autores();
            break;
        case "get_datos_autor":
            if (isset($_GET["id"]))
                $valor = get_datos_autor($_GET["id"]);
            else
                $valor = "Argumento no encontrado";
            break;
        case "get_lista_libros":
            $valor=get_lista_libros($_GET["autor"]);
            break;
        case "get_datos_libros":
            if (isset($_GET["id"]))
                $valor=get_datos_libros($_GET["id"]);
            else
                $valor = "Argumento no encontrado";
            break;
    }
}

//devolvemos los datos serializados en JSON
exit(json_encode($valor));
