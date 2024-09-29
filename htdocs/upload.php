<?php
// Dosya yükleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;

        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "<p>Dosya ". htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " başarıyla yüklendi.</p>";
        } else {
            echo '<span style="font-size: 24px; font-weight: bold;">Dosya Yüklerken Bir Hata Oldu</span>';
          
        }
}         else {
    echo '<span style="font-size: 24px; font-weight: bold;">Yüklenen Dosyalar</span>';
        
}
}
// Yüklü dosyaları listele, indirme ve silme butonları ekle
$files = scandir('uploads/');
foreach ($files as $file) {
    if ($file !== '.' && $file !== '..') {
        echo "<li>$file 
            <a class='button' href='uploads/$file' download>İndir</a>
            <a class='button delete-button' href='upload.php?delete=$file' onclick='return confirmDelete(\"$file\");'>Sil</a>
        </li>"; // İndirme ve silme butonları
    }
}

// Dosya silme işlemi
if (isset($_GET['delete'])) {
    $fileToDelete = 'uploads/' . $_GET['delete'];
    if (file_exists(filename: $fileToDelete)) {
        unlink(filename: $fileToDelete); // Dosyayı sil
        echo "<p>Dosya ". htmlspecialchars(string: basename(path: $_GET['delete'])) . " başarıyla silindi.</p>";
        // Sayfayı yenileyin, böylece silinen dosya listeden kaybolur
        header(header: "Refresh:1");
    } else {
        header(header: "Location: upload.html");
        exit();
    }
}

?>
