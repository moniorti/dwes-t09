--CREATE USER 'dwes-t06'@'localhost' IDENTIFIED BY 'dwes-t06-pass';
--CREATE DATABASE Libros;
--GRANT ALL ON Libros.* TO 'dwes-t06'@'localhost';

--USE Libros;
CREATE TABLE Autor(
    id INT(6),
    nombre VARCHAR(15) NOT NULL,
    apellidos VARCHAR(25)NOT NULL,
    nacionalidad VARCHAR(10),
    PRIMARY KEY (id)
);

INSERT INTO Autor(id,nombre,apellidos,nacionalidad) VALUES ('0','J.R.R.','Tolkien','Inglaterra');
INSERT INTO Autor(id,nombre,apellidos,nacionalidad) VALUES ('1','Isaac','Asimov','Rusia');

CREATE TABLE Libro(
    id INT(6),
    titulo VARCHAR(50) NOT NULL,
    f_publicacion VARCHAR(10),
    id_autor INT(6),
    PRIMARY KEY (id),
    FOREIGN KEY (id_autor) REFERENCES Autor(id)
    ON DELETE CASCADE
);
INSERT INTO Libro(id,titulo,f_publicacion,id_autor) VALUES ('0','El Hobbit','21/09/1937','0');
INSERT INTO Libro(id,titulo,f_publicacion,id_autor) VALUES ('1','La Comunidad del Anillo','29/07/1954','0');
INSERT INTO Libro(id,titulo,f_publicacion,id_autor) VALUES ('2','Las dos torres','11/11/1954','0');
INSERT INTO Libro(id,titulo,f_publicacion,id_autor) VALUES ('3','El retorno del rey','20/10/1955','0');
INSERT INTO Libro(id,titulo,f_publicacion,id_autor) VALUES ('4','Un guijarro en el cielo','19/01/1950','1');
INSERT INTO Libro(id,titulo,f_publicacion,id_autor) VALUES ('5','Fundación','01/06/1951','1');
INSERT INTO Libro(id,titulo,f_publicacion,id_autor) VALUES ('6','Yo, robot','02/12/1950','1');



