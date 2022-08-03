# MovieStar 🚀
#### Projeto desenvolvido durante o curso PHP do Zero a Maestria + 4 Projetos incríveis com o professor Matheus Battisti.

## Stacks utilizadas
**Front-end:** HTML5, CSS3 e BOOTSTRAP

**Back-end:** PHP

## Banco de dados
Rode os seguintes comando no seu banco de dados:
```
CREATE DATABASE moviestar;
```
```
USE moviestar;
```
```
CREATE TABLE users(
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(100),
	lastname VARCHAR(100),
	email VARCHAR(200),
	password VARCHAR(200),
	image VARCHAR(200),
	token VARCHAR(200),
	bio TEXT
);
```
```
CREATE TABLE movies(
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	description TEXT,
    image VARCHAR(200),
    trailer VARCHAR(150),
	category VARCHAR(50),
	length VARCHAR(50),
    user_id INT UNSIGNED,
    FOREIGN KEY(user_id) REFERENCES users(id)
);
```
```
CREATE TABLE reviews(
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	rating INT,
	review TEXT,
    user_id INT UNSIGNED,
    movie_id INT UNSIGNED,
	FOREIGN KEY(user_id) REFERENCES users(id),
    FOREIGN KEY(movie_id) REFERENCES movies(id)
);
```

## Acessando a aplicação
Para ter acesso a aplicação inicie seu servidor na porta 8000 e acesse a rota no seu navegador.