
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Fab Sender</title>
</head>
<body>

    <div class="containerHead">
        <h1 class="title">Fab Sender</h1>
        <h3 class="subtitle">Partage de fichiers</h3>

        <div class="container">
        

            <div class="titre">
                <h2>Uploader un fichier</h2>
            </div>
            <form id="uploadForm" method="post" enctype="multipart/form-data" class="formulaire">
                <input type="file" name="fileToUpload" id="fileToUpload" required class="form1">
                <button type="submit" name="submit" class="btn" >Uploader</button>
            </form>
        </div>
    </div>
    

    <div id="progressBarContainer">
        <div class="conatinerProgress">
            <h3>Téléchargement en cours ...</h3>
            <div id="progressBar"></div>
        </div>
    </div>

    <div id="message"></div>

    
    <div class="titre1">
        <h2>Fichiers disponibles</h2>
    </div>
    <!-- Code PHP pour afficher les fichiers disponibles -->
    <?php
    $dir = '/home/fabrino/partage/';
    $fileCategories = array(
        'Images' => array('icon' => '🖼️', 'files' => array(), 'totalSize' => 0),
        'Documents' => array('icon' => '📄', 'files' => array(), 'totalSize' => 0),
        'Videos' => array('icon' => '🎥', 'files' => array(), 'totalSize' => 0),
        'Audio' => array('icon' => '🎵', 'files' => array(), 'totalSize' => 0),
        'Autres' => array('icon' => '📁', 'files' => array(), 'totalSize' => 0)
    );

    if ($handle = opendir($dir)) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {
                $filePath = $dir . $entry;
                $fileType = strtolower(pathinfo($entry, PATHINFO_EXTENSION));

                // Classer le fichier en fonction de son type
                if (in_array($fileType, array("jpg", "jpeg", "png", "gif"))) {
                    $fileCategories['Images']['files'][] = array('name' => $entry, 'size' => filesize($filePath));
                    $fileCategories['Images']['totalSize'] += filesize($filePath);
                } elseif (in_array($fileType, array("pdf", "doc", "docx"))) {
                    $fileCategories['Documents']['files'][] = array('name' => $entry, 'size' => filesize($filePath));
                    $fileCategories['Documents']['totalSize'] += filesize($filePath);
                } elseif (in_array($fileType, array("mp4", "avi", "mov"))) {
                    $fileCategories['Videos']['files'][] = array('name' => $entry, 'size' => filesize($filePath));
                    $fileCategories['Videos']['totalSize'] += filesize($filePath);
                } elseif (in_array($fileType, array("mp3", "wav", "ogg"))) {
                    $fileCategories['Audio']['files'][] = array('name' => $entry, 'size' => filesize($filePath));
                    $fileCategories['Audio']['totalSize'] += filesize($filePath);
                } else {
                    $fileCategories['Autres']['files'][] = array('name' => $entry, 'size' => filesize($filePath));
                    $fileCategories['Autres']['totalSize'] += filesize($filePath);
                }
            }
        }
        closedir($handle);
    }

     ?>
     <div class="container1">
 <?php
    // Afficher les fichiers dans chaque catégorie
    foreach ($fileCategories as $category => $data) {
        if (!empty($data['files'])) {
            ?>
                <div class="item">

                
            <?php
            echo "<h3 class='categorie'> $category</h3>";
            // echo "<ul>";
            foreach ($data['files'] as $file) {
                $fileSize = $file['size'];
                // Convertir la taille en Ko ou Mo
                if ($fileSize >= 1048576) {
                    $fileSizeFormatted = number_format($fileSize / 1048576, 2) . ' Mo';
                } elseif ($fileSize >= 1024) {
                    $fileSizeFormatted = number_format($fileSize / 1024, 2) . ' Ko';
                } else {
                    $fileSizeFormatted = $fileSize . ' octets';
                }
                // Obtenir les 20 premiers caractères du nom de fichier
                $fileNameShort = substr($file['name'], 0, 20) . (strlen($file['name']) > 20 ? "..." : "");
                echo "<div class='itemFile'>

                    <div class='itemContainer'>
                    <div class='nameFile'>
                        <div class='icon'>
                            {$data['icon']}
                        </div>
                        <div class='nameTitle'>
                            <h3>{$fileNameShort}</h3>
                            <h6> Taille: $fileSizeFormatted </h6>
                        </div>
                        
                    </div>
                   

                    
                    <a href='/partage/{$file['name']}' download>
                        <button  class='telecharger'>Télécharger</button>

                    
                    </a>
                

                    <form method='post' action='delete.php' style='display:inline;' >
                    <input type='hidden' name='fileName' value='{$file['name']}'>
                    <button type='submit' class='delete'  onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer le fichier '{$file['name']}' ?\");'>Supprimer</button>
                    </form>
                    </div>
                    
                    
                    </div>";
            }
            // Afficher le nombre total de fichiers et leur taille totale dans la catégorie
            $totalFiles = count($data['files']);
            $totalSize = $data['totalSize'];
            if ($totalSize >= 1048576) {
                $totalSizeFormatted = number_format($totalSize / 1048576, 2) . ' Mo';
            } elseif ($totalSize >= 1024) {
                $totalSizeFormatted = number_format($totalSize / 1024, 2) . ' Ko';
            } else {
                $totalSizeFormatted = $totalSize . ' octets';
            }
            echo "<div class='total'>Total: $totalFiles fichiers, $totalSizeFormatted</div>";
            // echo "</ul>";
            ?>
            </div>
            <?php
        }
    }
    ?>
   
    
    </div>
    <script src="app.js"></script>
</body>
</html>
