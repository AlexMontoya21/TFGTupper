CREATE TABLE tupperwaring.tupper(
id_tupper int(7) PRIMARY KEY,
id_usario int (7) NOT NULL,
nombre varchar(30) NOT NULL,
descripcion varchar(1000) NOT NULL,
foto varchar(30) NOT NULL,
tipo varchar (15) NOT NULL,
vegano boolean,
vegetariano boolean ,
id_solicitante int(7),
solicitado boolean
);
