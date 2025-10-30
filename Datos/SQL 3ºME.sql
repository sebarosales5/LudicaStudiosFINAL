create database Draftosaurio;

create table Usuario
(
Id_usuario int(6) not null auto_increment,
Nombre_jugador varchar(25) not null unique,
Contraseña varchar(255) not null,
Gmail varchar(25) not null unique,
Estado int(1),
Rol ENUM('admin','usuario') DEFAULT 'usuario',
primary key (Id_usuario)
);

create table Partida
(
Id_partida int(6) not null auto_increment,
primary key (Id_partida)
);

create table Dado
(
Id_cara int(2) not null,
Restrincion varchar(25) not null,
primary key (Id_cara) 
);

create table Dinosaurio
(
Id_dinosaurio int(2) not null,
Tipo_dino varchar(25) not null,
primary key (Id_dinosaurio) 
);

create table Juega
(
Punt_jug int(3),
Id_usuario int(6) not null,
Id_partida int(6) not null,
foreign key (Id_usuario) references Usuario (Id_usuario),
foreign key (Id_partida) references Partida (Id_partida)
);

create table Tablero
(
Id_tablero int(3) not null,
Id_usuario int(6) not null,
Id_partida int(6) not null,
foreign key (Id_usuario) references Juega (Id_usuario),
foreign key (Id_partida) references Juega (Id_partida),
primary key (Id_tablero)
); 

create table Recinto
(
Id_recinto int(3) not null,
Nombre_recin varchar(25) not null,
Id_tablero int (3) not null,
foreign key (Id_tablero) references Tablero (Id_tablero),
primary key (Id_recinto)
);

create table Ubica
(
Id_dinosaurio int(3) not null,
Id_recinto int(3) not null,
foreign key (Id_dinosaurio) references Dinosaurio (Id_dinosaurio),
foreign key (Id_recinto) references Recinto (Id_recinto)
);

create table Turno
(
Id_turno int(2) not null auto_increment,
Numero_turno int(2) not null,
Numero_rodas int (2),
Id_recinto int(3) not null,
Id_dinosaurio int(3) not null,
Id_cara int(2) not null,
foreign key (Id_dinosaurio) references Ubica (Id_dinosaurio),
foreign key (Id_recinto) references Ubica (Id_recinto),
foreign key (Id_cara) references Dado (Id_cara),
primary key (Id_turno)
);

create table Realiza
(
Id_turno int(2) not null,
Id_usuario int(6) not null,
Id_partida int(6) not null,
foreign key (Id_turno) references Turno (Id_turno),
foreign key (Id_jugador) references Juega (Id_usuario),
foreign key (Id_partida) references Juega (Id_partida)
); 
