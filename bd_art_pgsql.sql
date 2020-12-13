-- Database: artclick

-- DROP DATABASE artclick;


CREATE DATABASE art
    WITH 
    OWNER = postgres
    ENCODING = 'UTF8'
    LC_COLLATE = 'Spanish_Spain.1252'
    LC_CTYPE = 'Spanish_Spain.1252'
    TABLESPACE = pg_default
    CONNECTION LIMIT = -1;
	

-- -----------------------------------------------------
-- Table `Users`
-- -----------------------------------------------------
CREATE TABLE tablename (
   colname SERIAL
);

CREATE  TABLE  Users (
  idUsers     SERIAL primary key unique,
  email VARCHAR(45) NOT NULL unique,
  name VARCHAR(45) NOT NULL ,
  role INT NOT NULL ,
  user_name VARCHAR(25) NOT NULL unique,
  password VARCHAR(255) NOT NULL ,
  profile_photo VARCHAR(45) NOT NULL ,
  user_premium INT NOT NULL ,
  biography  varchar(255) NULL ,
  location varchar(50) NOT NULL ,
  instagram varchar(150)  NULL ,
  facebook varchar(150) NULL ,
  twitter varchar(150) NULL )
,
entry_date date NOT NULL,
  
image_layout varchar(200) NOT NULL,
web varchar(175) NULL,
  
about varchar(250) NULL);


-- -----------------------------------------------------
-- Table `Categories`
-- -----------------------------------------------------
CREATE  TABLE  Categories (
  idCategorie serial unique primary key ,
  name  varchar(20) NOT NULL );


-- -----------------------------------------------------
-- Table `Posts`
-- -----------------------------------------------------
CREATE  TABLE Posts (
  idPost serial unique primary key,
  image_path VARCHAR(45) NOT NULL ,
  title  varchar(55) NOT NULL ,
  description VARCHAR(80) NOT NULL ,
  date_create DATE NOT NULL ,
  likes INT NOT NULL ,
  price INT NULL ,
  Category serial,
  Users_idUsers serial ,
 CONSTRAINT fk_category
      FOREIGN KEY(Category) 
	  REFERENCES Categories(idCategorie),
  
   CONSTRAINT fk_user
      FOREIGN KEY(Users_idUsers) 
	  REFERENCES Users(idUsers));


-- -----------------------------------------------------
-- Table `Followers`
-- -----------------------------------------------------
CREATE  TABLE Followers(
  id_user serial,
  id_follower serial,	
   PRIMARY KEY (id_user, id_follower),
	CONSTRAINT fk_user
      FOREIGN KEY(id_user) 
	  REFERENCES Users(idUsers),
	CONSTRAINT fk_follower
      FOREIGN KEY(id_follower) 
	  REFERENCES Users(idUsers)
  );


-- -----------------------------------------------------
-- Table `Comments`
-- -----------------------------------------------------
CREATE  TABLE Comments (
  idUser serial,
  idPost serial ,
  idComment serial unique primary key ,
  date  timestamp NOT NULL ,
  text varchar(100) NOT NULL ,
	CONSTRAINT fk_user
      FOREIGN KEY(idUser) 
	  REFERENCES Users(idUsers),
	CONSTRAINT fk_post
      FOREIGN KEY(idPost) 
	  REFERENCES Posts(idPost));

CREATE TABLE likes (
  
Users_idUsers serial,
   
Posts_idPost serial,
PRIMARY KEY(Users_idUsers, Posts_idPost),

   CONSTRAINT fk_user
      
FOREIGN KEY(Users_idUsers) 
	  
REFERENCES users(idUsers),
  
CONSTRAINT fk_post
      
FOREIGN KEY(Posts_idPost) 
	  
REFERENCES posts(idPost)
) ;




CREATE TABLE notifications (
  
idNotification serial primary Key,
  
message varchar(150) NOT NULL,
  
date date NOT NULL,
  
Users_idUsers serial,
  
image_path varchar(200) NOT NULL,
  
readed int(1) NOT NULL,
  
CONSTRAINT fk_user
      
FOREIGN KEY(Users_idUsers) 
	  
REFERENCES users(idUsers)
);