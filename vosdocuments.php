<?php
session_start();
// Vérifier si le formulaire a été soumis
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Vérifie si le fichier a été uploadé sans erreur.
    if(isset($_FILES["pdf"]) && $_FILES["pdf"]["error"] == 0){
        $allowed = array("pdf" => "application/pdf");
        $filename = $_FILES["pdf"]["name"];
        $filetype = $_FILES["pdf"]["type"];
        $filesize = $_FILES["pdf"]["size"];

        // Vérifie l'extension du fichier
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)) die("Erreur : Veuillez sélectionner un format de fichier valide.");

        // Vérifie la taille du fichier - 5Mo maximum
        $maxsize = 5 * 1024 * 1024;
        if($filesize > $maxsize) die("Error: La taille du fichier est supérieure à la limite autorisée.");

        // Vérifie le type MIME du fichier
        if(in_array($filetype, $allowed)){
            /*// Vérifie si le fichier existe avant de le télécharger.
            if(file_exists("upload/" . $_FILES["pdf"]["name"])){
                echo $_FILES["pdf"]["name"] . " existe déjà.";
            } else{
                move_uploaded_file($_FILES["pdf"]["tmp_name"], "upload/" . $_FILES["pdf"]["name"]);
                echo "Votre fichier a été téléchargé avec succès.";
            } */
        } else{
            echo "Error: Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer."; 
        }
    } else{
        echo "Error: " . $_FILES["pdf"]["error"];
    }
}




$titre = $_GET["titre"];
$files = $_GET["document"];

echo "Titre : ",$titre, "<br>" , "<br>";

echo "Nom du fichier : ",$files, "<br>" , "<br>";

















?>
