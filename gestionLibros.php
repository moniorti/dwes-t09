<?php
class gestionLibros{
    private ?mysqli $mysqli=null;
    /**
     * Función de conexión a la base de datos Libros
     * @param string $servidor dirección del servidor a conectar
     * @param string $usuario usuario de la base de datos
     * @param string $passwd contraseña del usuario de la base de datos
     * @param string $dataBase nombre de la base de datos
     * @return mysqli|null conexión a la base de datos
     */
    function conexion($servidor, $usuario, $passwd,$dataBase){
        @$mysqli= new mysqli($servidor,$usuario,$passwd,$dataBase);
        if (!$mysqli->connect_errno){
            //echo "Conexión Establecida";
            $this->mysqli=$mysqli;
            $mysqli->set_charset("utf8");
            return $mysqli;
        }else{
            echo "No se ha podido establecer la conexión"; 
            return null;
        };
    }

    function __destruct(){
        if ($this->mysqli!==null){
            $this->mysqli->close();
        } 
    }
    /**
     * Función para consultar los autores de los libros según el id del autor solicitado
     * @param mysqli $mysqli conexión a la base de datos
     * @param int $id_autor
     * @return array|null autores que cumplen la condición
     */
    function consultarAutores($mysqli,$id_autor=null){
        if ($id_autor===null){
            $sql="SELECT * FROM Autor";
        }else{
            $sql="SELECT * FROM Autor WHERE id='$id_autor'";
        }
        $result_set= $mysqli->query($sql);
        if ($result_set->num_rows>0 && !$mysqli->error){
            $result=$result_set->fetch_all(MYSQLI_ASSOC);
            $result_set->free();
            return $result;
        }else{
            return null;
        }
    }

    /**
     * Función para consultar los libros según el id del autor solicitado y/o título del libro
     * @param mysqli $mysqli conexión a la base de datos
     * @param int $id_autor
     * @param string $titulo
     * @return array|null libros que cumplen la condición
     */
    function consultarLibros_summary($mysqli,$id_autor=null,$titulo=null){
        if ($id_autor===null){
            $sql="SELECT id, titulo FROM Libro WHERE titulo LIKE '%$titulo%'";
        }else{
            $sql="SELECT id, titulo FROM Libro WHERE id_autor='$id_autor' AND titulo LIKE '%$titulo%'";
        }
        $result_set= $mysqli->query($sql);
        if ($result_set->num_rows>0 && !$mysqli->error){
            $result=$result_set->fetch_all(MYSQLI_ASSOC);
            $result_set->free();
            return $result;
        }else{
            return null;
        }

    }
    
    /**
     * Función para consultar los libros asociados a su autor, según el autor solicitado
     * @param mysqli $mysqli conexión a la base de datos
     * @param string $text texto a buscar en el nombre o apellido del autor
     * @return array|null libros que cumplen la condición
     */
    function consultarLibrosbyAutor($mysqli, $text){
        $sql="SELECT titulo, nombre, apellidos FROM Libro LEFT JOIN Autor ON Libro.id_autor=Autor.id WHERE CONCAT(nombre,' ', apellidos) LIKE '%$text%'";
        $result_set=$mysqli->query($sql);
        if ($result_set->num_rows>0 && !$mysqli->error){
            $result=$result_set->fetch_all(MYSQLI_ASSOC);
            $result_set->free();
            return $result;
        }else{
            return null;
        }
    }
    

    /**
     * Función para consultar los detalles de los libros según el id del libro solicitado
     * @param mysqli $mysqli conexión a la base de datos
     * @param int $id_libro
     * @return array|null datos del id de los libros que cumplen la condición
     */
    function consultarDatosLibro_details($mysqli,$id_libro=null){
        if($id_libro===null){
            $sql="SELECT titulo, f_publicacion,nombre,apellidos FROM Libro LEFT JOIN Autor ON Libro.id_autor = Autor.id";

        }else{
            $sql="SELECT titulo, f_publicacion,nombre,apellidos,id_autor FROM Libro LEFT JOIN Autor ON Libro.id_autor = Autor.id WHERE Libro.id=$id_libro";

        }
        $result_set= $mysqli->query($sql);
        if ($result_set->num_rows>0 && !$mysqli->error){
            $result=$result_set->fetch_array(MYSQLI_ASSOC);
            $result_set->free();
            return $result;
        }else{
            return null;
        }
    }
    /**
     * Función para consultar los datos de los libros según el id del libro solicitado
     * @param mysqli $mysqli conexión a la base de datos
     * @param int $id_libro
     * @return array|null datos del id de los libros que cumplen la condición
     */
    function consultarDatosLibro($mysqli,$id_libro=null){
        $sql="SELECT * FROM Libro WHERE id='$id_libro'";
        $result_set= $mysqli->query($sql);
        if ($result_set->num_rows>0 && !$mysqli->error){
            $result=$result_set->fetch_array(MYSQLI_ASSOC);
            $result_set->free();
            return $result;
        }else{
            return null;
        }
    }
    
}
?>