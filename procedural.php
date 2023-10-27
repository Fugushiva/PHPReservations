<?php
//connexion à la base de données
require("require/dbAccess.php");
$db = mysqli_connect(HOST, USER, PASSWORD, DB_NAME);


// Série 1
// 1.	Afficher le nom de la première personne
$query = "SELECT nom FROM personnes WHERE id = 1";
$result = mysqli_query($db, $query);
$line = mysqli_fetch_row($result); //retourne un tableau avec une seule valeur
if ($line) {
        echo "$line[0]";
        //var_dump($line);
        mysqli_free_result($result); // Libère la mémoire utilisée par le résultat
} else {
        echo "Aucune sortie";
}

echo "<hr>";

// 2.	Afficher le nom de toutes les personnes
$query = "SELECT nom FROM personnes";
$result = mysqli_query($db, $query);
$lines = mysqli_fetch_all($result); //var_dump($lines);
if ($lines) {
        foreach ($lines as $line) {
                echo ("<p>$line[0]</p>");
        }
        mysqli_free_result($result); // Libère la mémoire utilisée par le résultat
} else {
        echo "Aucune sortie";
}
echo ("<hr>");
// 3.	Afficher la rue du premier lieu
$query = "SELECT adresse FROM lieux";
$result = mysqli_query($db, $query);
$line = mysqli_fetch_row($result);

if ($line) {
        echo ($line[0]);
} else {
        echo "Aucune sortie";
}
echo ("<hr>");
// 4.	Afficher l’id de tous les spectacles
$query = "SELECT id FROM spectacles";
$result = mysqli_query($db, $query);
$lines = mysqli_fetch_all($result);
if ($lines) {
        foreach ($lines as $line) {
                echo ("<p>$line[0]</p>");
        }
        mysqli_free_result($result); // Libère la mémoire utilisée par le résultat
} else {
        echo "Aucune sortie";
}

echo ("<hr>");
// 5.	Afficher tous les noeuds enfants de l'adresse du deuxième lieu
$query = "SELECT adresse, localite FROM lieux";
$result = mysqli_query($db, $query);
$lines = mysqli_fetch_all($result);
echo ("{$lines[1][0]} - {$lines[1][1]}");
mysqli_free_result($result);
echo ("<hr>");
// 6.	Afficher tous les spectacles non réservables
$query = "SELECT id FROM spectacles WHERE reservable = 1 ";
$result = mysqli_query($db, $query);
$lines = mysqli_fetch_all($result);
if ($lines) {
        foreach ($lines as $line) {
                echo ("<p>$line[0]</p>");
        }
        mysqli_free_result($result);
} else {
        echo "Aucune sortie";
}



echo ("<hr>");
// 7.	Afficher la personne qui s'appelle Hirogawa
$query = "SELECT prenom, nom FROM personnes WHERE nom = 'Hirogawa'";
$result = mysqli_query($db, $query);
$lines = mysqli_fetch_row($result);
if ($lines) {
        echo ("$lines[0] $lines[1]");
        mysqli_free_result($result);
} else {
        echo "Aucune sortie";
}
echo ("<hr>");
// 8.	Afficher la photo du premier spectacle -> afficher toutes les images pour le fun 
$query = "SELECT img FROM spectacles";
$result = mysqli_query($db, $query);
$lines = mysqli_fetch_all($result);
if ($lines) {
        for ($i = 0; $i < sizeof($lines); $i++) {
                $img = trim($lines[$i][0], "/");
                echo ("<img src='$img'>");
        }
        mysqli_free_result($result);
} else {
        echo "Aucune sortie";
}


echo ("<hr>");
// 9.	Afficher l'adresse du troisième lieu
//méthode casse tête
$query = "SELECT adresse FROM lieux";
$result = mysqli_query($db, $query);
$lines = mysqli_fetch_all($result);

if ($lines) {
        $tabAdresse = [];
foreach ($lines as $line) {
        array_push($tabAdresse, $line[0]);
}

$firstElement = $tabAdresse[2];

foreach ($tabAdresse as $key => $value) {
        if ($value !== $firstElement) {
                unset($tabAdresse[$key]);
        }
}
$adresse = implode($tabAdresse);
for ($i = 0; $i < strlen($adresse); $i++) {
        echo ($adresse[$i]);
}
} else {
        echo "Aucune sortie";
}
echo ("<hr>");


// Série 4
// 1.	Afficher les dates de représentation du 2e spectacle

/*
$query = "SELECT date, spectacles.id FROM representations, spectacles WHERE representations.id_spectacle = spectacles.id AND spectacles.id = 'cible';";
$result = mysqli_query($db, $query);
$spectacles = mysqli_fetch_all($result);
var_dump($spectacles);
*/

$query = "SELECT id FROM spectacles";
$result = mysqli_query($db, $query);
$spectacles = mysqli_fetch_all($result);
$spectacle = implode($spectacles[2]); //chanteurbelge
mysqli_free_result($result);

$query = "SELECT date, spectacles.id FROM representations, spectacles WHERE representations.id_spectacle = spectacles.id AND spectacles.id = '$spectacle'"; // aucune
$result = mysqli_query($db, $query);
$dates = mysqli_fetch_all($result);
if ($dates) {
        foreach ($dates as $date) {
                echo ("<p>{$date[0]}</p>");
        }
        mysqli_free_result($result);
} else {
        echo "Aucune sortie";
}
/*
$query = "SELECT date FROM representations, spectacles WHERE spectacles.id = '$spectacle'";
$result = mysqli_query($db, $query);
$dates = mysqli_fetch_all($result);
*/

echo ('<hr>');
// 2.	Afficher les spectacles complets
$query = 'SELECT id FROM spectacles WHERE reservable = 0';
$result = mysqli_query($db, $query);
$spectacles = mysqli_fetch_all($result);
foreach ($spectacles as $spectacle) {
        echo ("<p>" . implode($spectacle) . "</p>");
}
echo ("<hr>");
// 3.	Afficher le titre des spectacles et les dates de représentation de tous les spectacles qui ont des représentations complètes
$query = "SELECT spectacles.title, representations.date FROM representations, spectacles WHERE representations.id_spectacle = spectacles.id AND spectacles.reservable = 1";
$result = mysqli_query($db, $query);
$spectacles = mysqli_fetch_all($result);
$spectacles = array_map('serialize', $spectacles); //convertir sous tableau en string
$spectacles = array_unique($spectacles); // élimine les doublons
$spectacles = array_map('unserialize', $spectacles); // reconstruit le tableau
if ($spectacles) {
        foreach ($spectacles as $spectacle) {
                echo ("<p>{$spectacle[0]} : {$spectacle[1]}</p>");
        }
        mysqli_free_result($result);
} else {
        echo "Aucune sortie";
}
echo ("<hr>");
// 4.	Afficher l'adresse du lieu du spectacle intitulé Cible Mouvante
$query = "SELECT lieux.adresse FROM lieux, spectacles WHERE lieux.id = spectacles.lieu AND spectacles.title ='Cible mouvante'";
$result = mysqli_query($db, $query);
$adresse = mysqli_fetch_row($result);
echo ($adresse[0]);
// 5.	Ajouter une date et une heure de représentation au spectacle Ayiti
$spectacleId = 'ayiti';
$date = mktime('20', '30', '0', '6', '25', '2012');
$hour = date("H:i", $date);
$date = date("Y-m-d", $date);

$query = "INSERT INTO representations (id_spectacle, date, heure, id_lieu)
VALUES (
    '$spectacleId',
    '$date',
    '$hour',
    null
  );";
$result = mysqli_query($db, $query);



// 6.	Marquer le spectacle Ayiti comme non réservable
        
// 7.	Marquer la première représentation du spectacle Ayiti comme complète

// 8.	Compter le nombre de représentations du spectacle Wayburn

// 9.	Supprimer la représentation du 27/10/2012 à 20h30 du spectacle chanteurbelge
