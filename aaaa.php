<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="logo.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="header.css">
    <title>Choix de bilan</title>
</head>
<body>
<?php
session_start();

include('header.php');

try {
    $bdd = new PDO('mysql:host=localhost;dbname=citeda', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Récupération des imprimantes
$imprimantes = $bdd->query("SELECT idimpr, nomimpr FROM imprimente")->fetchAll(PDO::FETCH_ASSOC);

foreach ($imprimantes as $imprimante): ?>
   <a href="prebilan.php?imprimante_id=<?= $imprimante['idimpr'] ?>"> 
    <button>
        <?= $imprimante['nomimpr'] ?>
    </button>
    </a>
<?php endforeach; 
?>
<a href="bilan.php">
<button>Toute les imprimantes</button>
</a>
</body>
</html>