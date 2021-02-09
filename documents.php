<?php
require_once 'utils.php';


$result = "";



$target_dir = "uploads/";
$uploadOk = 1;

if(isset($_FILES["document"])){
    $target_file = $target_dir . basename($_FILES["document"]["name"]);
    $check = file_exists($target_file);
    if($check !== false){
        $result= "Ce fichier PDF existe déja";
    } else {
        $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    // verifier que le fichier est bien un pdf?
    if(isset($_POST["submit"])) {
        $check = mime_content_type($_FILES["document"]["tmp_name"]);
        if($check == 'application/pdf') {
            $uploadOk = 1;
        }else{
                $result= "File is not a pdf";
                $uploadOk = 0;
            }
        
        
        
        
        
        // verifier si le fichier existe deja
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // verifier la taille du fichier
        if ($_FILES["document"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        
        // interdire certain type de fichier
        if($fileType != "pdf") {
            echo "Sorry, only PDF files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["document"]["tmp_name"], $target_file)) {
                $result = "The file ". htmlspecialchars( basename( $_FILES["document"]["name"])). " has been uploaded.";
            } else {
                $result = "Sorry, there was an error uploading your file.";
            }
        }
    }
    
    
    
       
    }
}


function lister_fichiers($rep) {
	if(is_dir($rep)) {
        $data ="";
		if($iteration = opendir($rep)) {
			while(($fichier = readdir($iteration)) !== false) {
				if($fichier != "." && $fichier != "..") {
					$data = $data . '<a href="'.$rep.$fichier.'" target="_blank">'.$fichier.'</a><br />'."\n";  
				}  
			}  
			closedir($iteration);
            return $data;
		}
	}
    else {
        return false;
    }
} 

$data = lister_fichiers("uploads/");
Render('documents.twig',["result" => $result , "data" => $data]);
    