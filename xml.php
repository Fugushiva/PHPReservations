<?php
//Charger le fichier XML
$reservations = simplexml_load_file('data/reservations.xml');

echo "<hr>";

// Série 1
// 1.	Afficher le nom de la première personne
echo ($reservations->personne->nom[0]);
echo "<hr>";
// 2.	Afficher le nom de toutes les personnes
foreach ($reservations->personne as $personne) {
    echo ("<p>  {$personne['id']} - {$personne->nom} - {$personne->prenom} </p>");
}
echo ('<hr>');
// 3.	Afficher la rue du premier lieu
echo ($reservations->lieu->adresse->rue[0]);
echo ('<hr>');
// 4.	Afficher l’id de tous les spectacles
foreach ($reservations->spectacle as $spectacle) {
    echo ("<p>" . $spectacle["id"] . "</p>");
}
echo ("<hr>");
// 5.	Afficher tous les noeuds enfants de l'adresse du deuxième lieu
foreach ($reservations->lieu[1]->adresse->children() as $data) {
    echo ("<p>$data</p>");
}
echo ("<hr>");
// 6.	Afficher tous les spectacles non réservables
foreach ($reservations->spectacle as $spectacle) {
    if ($spectacle["reservable"] == "1") { // "1" défini que le specatcle est réservable
        echo ("<p>" . $spectacle["id"] . "</p>");
    }
}
echo ("<hr>");
// 7.	Afficher la personne qui s'appelle Hirogawa
foreach ($reservations->personne as $personne) {
    if ($personne->nom == "Hirogawa") {
        echo ("<p> {$personne->nom} - {$personne->prenom} </p");
    }
}

echo ("<hr>");
echo ("<hr>");
// 8.	Afficher la photo du premier spectacle
$link = trim($reservations->spectacle->img["src"], "/"); // enlever le premier "/";
echo ("<img src='$link'>");

echo ("<hr>");
// 9.	Afficher l'adresse du troisième lieu
$lieux = [];
foreach ($reservations->lieu as $lieu) {
    array_push($lieux, $lieu);
}
foreach ($lieux[2]->adresse->children() as $data) {
    echo ("<p>$data</p>");
}
echo ("<hr>");
echo ("<hr>");
// Série 2
// 1.	Afficher tous les lieux (description complète)


//void printLieux(SimpleXMLElement xml)
//Ex.: printLieux($xml)

//a.	Format: titre et paragraphes

foreach ($reservations->lieu as $value) {
    echo ("<h1>{$value['id']}</h1>");
    foreach ($value as $key => $data) {
        if ($key == "adresse") {
            echo ("<p>$key : {$data->rue}, {$data->localite}</p>");
        } else {
            echo ("<p>$key : $data</p>");
        }
    }
}
echo ("<hr>");
//b.	Format: liste

//c.	Format: tableau

//2.	Créer une fonction de recherche d'un lieu précis
//SimpleXMLElement getLieu(SimpleXMLElement xml, String id)
//Ex.: print_r( getLieu($xml,'espacemagh') );
/**
 * Récupère les informations d'un lieu spécifique à partir d'un fichier XML.
 *
 * @param string $filePath Le chemin du fichier XML.
 * @param string $lieuId L'ID du lieu à rechercher.
 * @throws InvalidArgumentException Si le fichier XML n'existe pas.
 */
function getLieu(string $filePath, string $lieuId)
{
    $xml = simplexml_load_file($filePath);
    //si il existe
    if ($xml) {
        foreach ($xml->lieu as $value) {
            //Si ID est bien le lieu recherché
            if ($value["id"] == $lieuId) {
                foreach ($value as $key => $value) {
                    if ($key == "adresse") {
                        echo ("<p>$key : {$value->rue}, {$value->localite}</p>");
                    } else {
                        echo ("<p>$key : $value</p>");
                    }
                }
                break;
            }
        }
        //si n'existe pas
    } else {
        throw new InvalidArgumentException("XML innexistant");
    }
}

getLieu("data/reservations.xml", "espacemagh");

echo ("<hr>");

//3.	Créer une fonction de recherche d'information sur un lieu précis
//String getLieuInfo(SimpleXMLElement xml, String id, String info)
//Ex.: echo getLieuInfo($xml,'espacemagh','website');

/**
 * "Obtenir des informations spécifiques sur un emplacement à partir d'un fichier XML.
 *
 * @param string $filePath Le chemin vers le fichier XML.
 * @param string $lieuId L'ID de l'emplacement à rechercher.
 * @param string $info L'information spécifique à récupérer.
 * @return mixed La valeur de l'information demandée, ou null si elle n'est pas trouvée
 * @throws InvalidArgumentException si le XML n'existe pas
 */

function getLieuInfo(string $filePath, string $lieuId, string $info)
{
    $xml = simplexml_load_file($filePath);
    if ($xml) {
        foreach ($xml->lieu as $value) {
            if ($value['id'] == $lieuId) {
                if ($value->$info === $value->adresse) { // pk avec "==" il met les autres data dans un tableau ?
                    print_r($value->$info);
                } else {
                    echo ($value->$info);
                }
            }
        }
    } else {
        throw new InvalidArgumentException("XML innexistant");
    }
}
getLieuInfo("data/reservations.xml", "dexia", "tel");
echo ("<hr>");
//4.	Rechercher tous les spectacles réservables
//Array getReservables(SimpleXMLElement xml)
//Ex.: echo '<pre>'; var_dump(getReservables($xml)); echo '</pre>';
//5.	Rechercher les représentations d'un spectacle précis

//Array getRepresentations(SimpleXMLElement xml, String id)
//Ex.: echo '<pre>'; var_dump(getRepresentations($xml,'ayiti')); echo '</pre>';

// Série 4
// 1.	Afficher les dates de représentation du 2e spectacle

// 2.	Afficher les spectacles complets

// 3.	Afficher le titre des spectacles et les dates de représentation de tous les spectacles qui ont des représentations complètes

// 4.	Afficher l'adresse du lieu du spectacle intitulé Cible Mouvante
$place = "";
foreach ($reservations->spectacle as $data) {
    if ($data->title == "Cible mouvante") {
        foreach ($data as $key => $value) {
            if ($key == "lieu") {
                $place = $value['ref'];
            }
        }
    }
}
foreach ($reservations->lieu as $lieu) {

    if ($lieu['id'] == trim($place)) {
        echo ($lieu->adresse->rue);
    }
}






// 5.	Ajouter une date et une heure de représentation au spectacle Ayiti
        // addChild()
// 6.	Marquer le spectacle Ayiti comme non réservable
        
// 7.	Marquer la première représentation du spectacle Ayiti comme complète

// 8.	Compter le nombre de représentations du spectacle Wayburn

// 9.	Supprimer la représentation du 27/10/2012 à 20h30 du spectacle chanteurbelge
        //=null
