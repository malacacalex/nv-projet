docker-compose up --build
echo "Démarrage des conteneurs..."
sleep 10
#Création de la table Utilisateurs
#echo "Récupération de l'IP du conteneur MariaDB et insertion de la table Utilisateurs..."

host=$(docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' mariadb)
mysql -u root -p'foo' -h $host < ~/data.sql

echo "OK !"
