
<?php
$target_dir = "/home/fabrino/partage/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
$message = "";

// Vérifie la taille du fichier
if ($_FILES["fileToUpload"]["size"] > 500000000000) {  // Limite à 5 Mo
    $message = "Désolé, votre fichier est trop volumineux.";
    $uploadOk = 0;
}


// Vérifie si $uploadOk est défini à 0 par une erreur
if ($uploadOk == 0) {
    $message .= " Désolé, votre fichier n'a pas été téléchargé.";
} else {
    // Vérifie si le fichier existe déjà
    if (file_exists($target_file)) {
        // Supprime le fichier existant pour le remplacer
        unlink($target_file);
    }
    
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $message = "Le fichier ". htmlspecialchars(basename($_FILES["fileToUpload"]["name"])). " a été téléchargé.";
    } else {
        $message = "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
    }
}

echo $message;
?>
