--base de datos--------------------------------------------------------------------------------------------------------------------------------
CREATE DATABASE tupperwaring;

--tablas--------------------------------------------------------------------------------------------------------------------------------
CREATE TABLE tupperwaring.usuarios(id int(7) auto_increment PRIMARY KEY, password VARCHAR(30) NOT NULL, nombre varchar(30) UNIQUE NOT NULL, dni varchar(9) UNIQUE NOT NULL, email varchar(30), foto varchar(30));
CREATE TABLE tupperwaring.tupper(id_tupper int(7) auto_increment PRIMARY KEY, id_usuario int(7), nombre varchar(30) NOT NULL, descripcion varchar(1000) NOT NULL, foto varchar(30) NOT NULL, tipo varchar (15) NOT NULL, vegano boolean, vegetariano boolean, sin_gluten boolean, id_solicitante int(7), solicitado boolean, constraint FK_ID_USUARIO foreign key (id_usuario) references tupperwaring.usuarios(id),constraint FK_ID_SOLICITANTE foreign key (id_solicitante) references tupperwaring.usuarios(id));



CREATE TABLE tupperwaring.mensajes(id_e int(7),id_r int(7) NOT NULL,fecha date,hora varchar(5),mensaje varchar(100) NOT NULL,constraint PK_VIAJES primary key (id_e,fecha,hora),constraint FK_ID_ENVIADOR foreign key (id_e) references tupperwaring.usuarios(id),constraint FK_ID_RECIBIDOR foreign key (id_r) references tupperwaring.usuarios(id));


--datos de la tabla usuarios--------------------------------------------------------------------------------------------------------------------------------
insert into tupperwaring.usuarios (password, nombre, apellidos) values('lorena','Lorena','Marchan');
insert into tupperwaring.usuarios (password, nombre, apellidos) values('julia','Julia','Bustos');
insert into tupperwaring.usuarios (password, nombre, apellidos) values('alejandro','Alejandro','Montoya');

--datos de la tabla tupper--------------------------------------------------------------------------------------------------------------------------------

--carnes
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(1,'Carne con Brocoli','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','carne',0,0,0);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(2,'Milanesa de Pollo','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','carne',0,0,1);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(3,'Pastel de Carne Gratinado','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','carne',0,0,0);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(1,'Burritos Mexicanos','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','carne',0,0,1);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(2,'Carne Mechada','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','carne',0,0,0);

--pescados
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(3,'Salmon con Salsa de Limon','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','pescado',0,0,1);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(1,'Cazon en Adobo','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','pescado',0,0,0);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(2,'Ceviche de Verdel','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','pescado',0,0,1);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(3,'Chipirones Rellenos','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','pescado',0,0,0);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(1,'Lubina con Guisantes','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','pescado',0,0,1);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(2,'Rape al Vapor','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','pescado',0,0,0);

--arroces
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(3,'Arroz con Cilantro y Perejil','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','arroz',1,1,0);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(2,'Arroz frito Cubano','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','arroz',0,0,1);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(1,'Arroz con Jamon y Pimientos','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','arroz',0,0,0);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(2,'Arroz con Pollo','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','arroz',0,0,1);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(2,'Arroz Basmati y Cordero','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','arroz',0,0,0);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(3,'Risotto negro con aceitunas','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','arroz',0,1,1);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(2,'Paella de Marisco','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','arroz',0,0,1);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(3,'Salteado de Arroz','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','arroz',1,1,1);

--entrantes
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(2,'Patatas Bravas','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','entrantes',1,1,0);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(2,'Croquetas de Jamon','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','entrantes',0,0,1);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(2,'Croquetas de Setas','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','entrantes',0,1,0);

--pucheros
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(2,'Lentejas','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','pucheros',0,0,1);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(3,'Habas','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','pucheros',1,1,0);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(1,'Fabada asturiana','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','pucheros',1,1,1);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(1,'Cocido madrileño','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','pucheros',0,0,1);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(2,'Callos a la Andaluza','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','pucheros',0,0,0);

--postres
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(2,'Pastel de Flan','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','postres',0,1,0);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(3,'Pay de Limon','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','postres',0,1,1);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(2,'Brazo Gitano','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','postres',0,1,0);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(1,'Gelatina de Fresa','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','postres',1,0,1);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(2,'Tiramisu','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','postres',0,1,0);

--pastas
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(3,'Pasta con Gorgonzola','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','pasta',0,1,0);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(2,'Macarrones con Bacon','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','pasta',0,0,1);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(1,'Canelones con Pavo y Esparragos','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','pasta',0,0,1);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(2,'Tallarines con Verduras','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','pasta',0,1,0);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(3,'Lasaña de Atun','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','pasta',0,0,1);

--verduras
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(3,'Pisto de Verduras','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','verduras',1,1,1);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(2,'Salteado de Verduras y Setas','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','verduras',1,1,1);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(1,'Tomates Rellenos','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','verduras',0,0,1);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(2,'Crema de Verduras','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','verduras',0,1,1);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(3,'Alcachofas al Horno','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','verduras',1,1,1);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(3,'Berenjenas a la Parmesana','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','verduras',0,1,1);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(2,'Ensalada Clasica','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','verduras',1,1,1);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(1,'Acelgas con Patatas','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','verduras',1,1,0);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(2,'Crema de Calabaza','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','verduras',0,1,1);
insert into tupperwaring.tupper (id_usuario, nombre, descripcion, foto, tipo, vegano, vegetariano, sin_gluten) values(3,'Milhojas de Calabacin','Descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion decripcion descripcion descripcion.','foto.jpg','verduras',0,1,0);



--reseteo--------------------------------------------------------------------------------------------------------------------------------
--DELETE FROM tupperwaring.usuarios;
--DELETE FROM tupperwaring.mensajes;
--DELETE FROM tupperwaring.tupper;
--DROP DATABASE tupperwaring;
--DROP TABLE tupperwaring.usuarios;
--DROP TABLE tupperwaring.tupper;
--update tupperwaring.tupper set id_solicitante=null;