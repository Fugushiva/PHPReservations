<?php
require("require/dbAccess.php");
//connexion à la base de données
$dsn = "mysql:host=" . HOST . ";dbname=" . DB_NAME;
$dbh = new PDO($dsn, USER, PASSWORD);
var_dump($dbh);




echo ("<hr>");
// Série 1
// 1.	Afficher le nom de la première personne
$query = "SELECT nom FROM personnes WHERE id=1 ";
$query = $dbh->query($query); //effectue la query
$personne = $query->fetch(); //avoir la data (UNE SEULE) dans un tableau 
echo ($personne[0]);
echo ("<hr>");

// 2.	Afficher le nom de toutes les personnes
$query = "SELECT nom FROM personnes";
$query = $dbh->query($query);
$personnes = $query->fetchAll(); // résucpère toutes les datas du tableau
foreach ($personnes as $personne) {
    echo ("<p>$personne[0]</p>");
}
echo ("<hr>");
// 3.	Afficher la rue du premier lieu
$query = "SELECT adresse FROM lieux";
$query = $dbh->query($query);
$rue = $query->fetchAll();
echo ($rue[0]["adresse"]); // fonctionne aussi avec echo($rue[0][0])
echo ("<hr>");

// 4.	Afficher l’id de tous les spectacles
$query = "SELECT id FROM spectacles";
$query = $dbh->query($query);
$idSpecs = $query->fetchAll();
foreach ($idSpecs as $idSpec) {
    echo ("<p>$idSpec[0]</p>");
}
echo ("<hr>");
// 5.	Afficher tous les noeuds enfants de l'adresse du deuxième lieu
$query = "SELECT adresse, localite FROM lieux";
$result = $dbh->query($query);
$lines = $result->fetchAll(); //var_dump($lines); ->
echo ("{$lines[1]['adresse']} - {$lines[1]['localite']}");
echo ("<hr>");
// 6.	Afficher tous les spectacles non réservables
$query = "SELECT id FROM spectacles WHERE reservable = 1 ";
$result = $dbh->query($query);
$lines = $result->fetchAll();
foreach ($lines as $line) {
    echo ("<p>{$line['id']}</p>");
}
echo ("<hr>");
// 7.	Afficher la personne qui s'appelle Hirogawa
$query = "SELECT prenom, nom FROM personnes WHERE nom = 'Hirogawa'";
$result = $dbh->query($query);
$line = $result->fetch();
echo ("<p>{$line['prenom']} {$line['nom']}</p>");
echo ("<hr>");
// 8.	Afficher la photo du premier spectacle
$query = "SELECT img FROM spectacles";
$result = $dbh->query($query);
$line = $result->fetch();
$img = trim($line['img'], "/");
echo ("<img src='$img'>");

echo ("<hr>");
// 9.	Afficher l'adresse du troisième lieu
$tabAdresse = [];
$query = "SELECT adresse FROM lieux";
$result = $dbh->query($query);
$lines = $result->fetchAll();
foreach ($lines as $line) {
    array_push($tabAdresse, $line);
}

echo ("<p>{$tabAdresse[3][0]}</p>");
echo ("<hr>");

// Série 3
//1.	Afficher la liste des personnes (nom et prénom)

$query = "SELECT nom, prenom FROM personnes";
$result = $dbh->query($query);
$lines = $result->fetchAll();

foreach ($lines as $line) {
    echo ("<p>{$line[0]} - {$line[1]}</p>");
}
echo ("<hr>");
//2.	Afficher le 2ème lieu (désignation)
$query = "SELECT designation FROM lieux";
$result = $dbh->query($query);
$lines = $result->fetchAll();

echo ("<p>{$lines[1]["designation"]}</p>");
echo ("<hr>");
//3.	Afficher l'id des spectacles réservables
$query = "SELECT id FROM spectacles WHERE reservable = 1";
$result = $dbh->query($query);
$lines = $result->fetchAll();
foreach ($lines as $line) {
    echo ("<p>{$line['id']}</p>");
}
//4.	Afficher les images des spectacles
$query = "SELECT img FROM spectacles";
$result = $dbh->query($query);
$lines = $result->fetchAll();
foreach ($lines as $line) {
    $line = trim($line[0], "/");
    echo ("<img src='$line'>");
}
echo ("<hr>");
//5.	Afficher les spectacles dont le scénographe fait partie de la distribution
$query = "SELECT title, auteur, scenographie FROM spectacles";
$result = $dbh->query($query);
$spectacles = $result->fetchAll();
foreach ($spectacles as $spectacle) {
    if (str_contains($spectacle['scenographie'], $spectacle['auteur'])) {
        echo ("<p>{$spectacle['title']}</p>");
    }
}
echo ("<hr>");
//6.	Afficher les lieux qui n'ont pas de site Web
$query = "SELECT designation FROM lieux WHERE website = ''"; //website = '' --> no data
$result = $dbh->query($query);
$lieux = $result->fetchAll();
foreach ($lieux as $lieu) {
    echo ("<p>{$lieu['designation']}</p>");
}

echo ("<hr>");
//7.	Afficher les personnes (nom et prénom) qui ont réservé pour la première représentation du premier spectacle

$query = "SELECT nom, prenom FROM personnes, spectacles, representations WHERE spectacles.id = representations.id_spectacle AND representations.id = personnes.id";
$result = $dbh->query($query);
$personnes = $result->fetchAll();
foreach ($personnes as $personne) {
    echo ("<p>{$personne['nom']} {$personne['prenom']}</p>");
}
echo ("<hr>");
//8.	Afficher les spectacles qui proposent plus de 5 représentations (j'ai fait 3)
$query = "SELECT s.title, COUNT(r.id) AS nombre_de_representations FROM spectacles s INNER JOIN representations r ON s.id = r.id_spectacle GROUP BY s.id HAVING COUNT(r.id) > 3"; // <-- galère ! *[è_é]*
$result = $dbh->query($query);
$spectacles = $result->fetchAll();
foreach ($spectacles as $spectacle) {
    echo ("<p>{$spectacle['title']}</p>");
}
