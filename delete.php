<?php
// Vérifie si le nom de fichier est passé en tant que paramètre
if (isset($_POST['fileName'])) {
    // Chemin du répertoire où se trouvent les fichiers à supprimer
    $dir = '/home/fabrino/partage/';

    // Nom du fichier à supprimer
    $fileName = $_POST['fileName'];

    // Chemin complet du fichier à supprimer
    $filePath = $dir . $fileName;

    // Vérifie si le fichier existe
    if (file_exists($filePath)) {
        // Supprime le fichier
        if (unlink($filePath)) {
            echo "Le fichier '$fileName' a été supprimé avec succès.";
        } else {
            echo "Erreur : Impossible de supprimer le fichier '$fileName'.";
        }
    } else {
        echo "Le fichier '$fileName' n'existe pas.";
    }
} else {
    echo "Erreur : Nom de fichier manquant.";
}

echo "<br><a href='index.php'>Retour</a>";
?>
