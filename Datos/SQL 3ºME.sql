create database draftosaurio;

create table usuario
(
Id_usuario int(6) not null auto_increment,
Nombre_jugador varchar(25) not null unique,
Contraseña varchar(255) not null,
Gmail varchar(25) not null unique,
Estado int(1),
Rol ENUM('admin','usuario') DEFAULT 'usuario',
primary key (Id_usuario)
);

create table partida
(
Id_partida int(6) not null auto_increment,
primary key (Id_partida)
);

create table dado
(
Id_cara int(2) not null,
Restrincion varchar(25) not null,
primary key (Id_cara) 
);

create table dinosaurio
(
Id_dinosaurio int(2) not null,
Tipo_dino varchar(25) not null,
primary key (Id_dinosaurio) 
);

create table juega
(
Punt_jug int(3),
Id_usuario int(6) not null,
Id_partida int(6) not null,
foreign key (Id_usuario) references usuario (Id_usuario),
foreign key (Id_partida) references partida (Id_partida)
);

create table tablero
(
Id_tablero int(3) not null,
Id_usuario int(6) not null,
Id_partida int(6) not null,
foreign key (Id_usuario) references juega (Id_usuario),
foreign key (Id_partida) references juega (Id_partida),
primary key (Id_tablero)
); 

create table recinto
(
Id_recinto int(3) not null,
Nombre_recin varchar(25) not null,
Id_tablero int (3) not null,
foreign key (Id_tablero) references tablero (Id_tablero),
primary key (Id_recinto)
);

create table ubica
(
Id_dinosaurio int(3) not null,
Id_recinto int(3) not null,
foreign key (Id_dinosaurio) references dinosaurio (Id_dinosaurio),
foreign key (Id_recinto) references recinto (Id_recinto)
);

create table turno
(
Id_turno int(2) not null auto_increment,
Numero_turno int(2) not null,
Numero_rodas int (2),
Id_recinto int(3) not null,
Id_dinosaurio int(3) not null,
Id_cara int(2) not null,
foreign key (Id_dinosaurio) references ubica (Id_dinosaurio),
foreign key (Id_recinto) references ubica (Id_recinto),
foreign key (Id_cara) references dado (Id_cara),
primary key (Id_turno)
);

create table realiza
(
Id_turno int(2) not null,
Id_usuario int(6) not null,
Id_partida int(6) not null,
foreign key (Id_turno) references turno (Id_turno),
foreign key (Id_jugador) references juega (Id_usuario),
foreign key (Id_partida) references juega (Id_partida)
); 
