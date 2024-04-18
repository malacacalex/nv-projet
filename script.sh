#!/bin/bash

# Construire l'image Docker pour le serveur Web Flask
docker build --tag python .

# Lancer le conteneur MySQL en tant que démon
docker run -d --name mysql_container -e MYSQL_ROOT_PASSWORD=root mysql

# Attendre quelques secondes pour laisser le serveur MySQL démarrer
sleep 10

# Créer la base de données et la table avec ses colonnes
docker exec -it mysql_container mysql -uroot -p"root" -e "CREATE DATABASE IF NOT EXISTS flask_db;"
docker exec -it mysql_container mysql -uroot -p"root" -e "USE flask_db; CREATE TABLE IF NOT EXISTS users (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(255), email VARCHAR(255), password_hash VARCHAR(255));"

# Lancer le conteneur Flask en liant le port souhaité (par exemple 5000) au port 5000 du conteneur
docker run -d --name flask_container -p 5000:5000 --link mysql_container:mysql python

