<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

if ($_SESSION['profil'] != 'PDG') {
    header("Location: acceuil.php");
    exit();
}

try {
    $bdd = new PDO('mysql:host=localhost;dbname=citeda', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Récupération des imprimantes
$imprimantes = $bdd->query("SELECT idimpr, nomimpr FROM imprimente")->fetchAll(PDO::FETCH_ASSOC);

// Initialisation des filtres
$imprimante_id = isset($_GET['imprimante_id']) ? $_GET['imprimante_id'] : '';
$date_debut = isset($_GET['date_debut']) ? $_GET['date_debut'] : '';
$date_fin = isset($_GET['date_fin']) ? $_GET['date_fin'] : '';

// Création de la requête SQL avec les filtres
$query = "SELECT h.date_his, i.nomimpr AS imprimante, h.d_i_phbn, h.n_i_phbn, h.d_i_phclr, 
          h.n_i_phclr, h.d_i_impbn, h.n_i_impbn, h.d_i_impclr, h.n_i_impclr,
          i.prixphbn, i.priximbn, i.prixphclr, i.priximclr
          FROM historique h
          JOIN imprimente i ON h.idimpr = i.idimpr
          WHERE 1";

$params = array();

if ($imprimante_id) {
    $query .= " AND h.idimpr = ?";
    $params[] = $imprimante_id;
}
if ($date_debut) {
    $query .= " AND h.date_his >= ?";
    $params[] = $date_debut;
}
if ($date_fin) {
    $query .= " AND h.date_his <= ?";
    $params[] = $date_fin;
}

$stmt = $bdd->prepare($query);
$stmt->execute($params);
$enregistrements = $stmt->fetchAll(PDO::FETCH_ASSOC);

include('header.php');
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <link rel="shortcut icon" href="logo.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="header.css">
    <link rel="stylesheet" type="text/css" href="bilan.css">
    <title>Bilan des Imprimantes</title>
</head>
<body>
    <h1>Bilan des Imprimantes</h1>

    <form method="GET" action="bilan.php">
        <label for="imprimante_id">Imprimante :</label>
        <select name="imprimante_id" id="imprimante_id">
            <option value="">Toutes</option>
            <?php foreach ($imprimantes as $imprimante): ?>
                <option value="<?= $imprimante['idimpr'] ?>" <?= ($imprimante_id == $imprimante['idimpr']) ? 'selected' : '' ?>>
                    <?= $imprimante['nomimpr'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        
        <label for="date_debut">Date de début :</label>
        <input type="date" name="date_debut" id="date_debut" value="<?= $date_debut ?>">
        
        <label for="date_fin">Date de fin :</label>
        <input type="date" name="date_fin" id="date_fin" value="<?= $date_fin ?>">
    </form>

    <table border="1">
        <thead>
            <tr>
                <th rowspan='2'>Date</th>
                <th rowspan='2'>Imprimante</th>
                <th colspan='2'>Photocopies Blanc/Noir</th>
                <th colspan='2'>Photocopies Couleur</th>
                <th colspan='2'>Impressions Blanc/Noir</th>
                <th colspan='2'>Impressions Couleur</th>
                <th rowspan='2'>Total Photocopies Blanc/Noir</th>
                <th rowspan='2'>Total Photocopies Couleur</th>
                <th rowspan='2'>Total Impressions Blanc/Noir</th>
                <th rowspan='2'>Total Impressions Couleur</th>
                <th rowspan='2'>Total</th>
            </tr>
            <tr>
                <th>i_d</th>
                <th>i_n</th>
                <th>i_d</th>
                <th>i_n</th>
                <th>i_d</th>
                <th>i_n</th>
                <th>i_d</th>
                <th>i_n</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $total_general = 0;
            foreach ($enregistrements as $enregistrement): 
                $total_phbn = ($enregistrement['n_i_phbn'] - $enregistrement['d_i_phbn']) * $enregistrement['prixphbn'];
                $total_phclr = ($enregistrement['n_i_phclr'] - $enregistrement['d_i_phclr']) * $enregistrement['prixphclr'];
                $total_impbn = ($enregistrement['n_i_impbn'] - $enregistrement['d_i_impbn']) * $enregistrement['priximbn'];
                $total_impclr = ($enregistrement['n_i_impclr'] - $enregistrement['d_i_impclr']) * $enregistrement['priximclr'];
                $total = $total_phbn + $total_phclr + $total_impbn + $total_impclr;
                $total_general += $total;
            ?>
                <tr>
                    <td rowspan='2'><?= $enregistrement['date_his'] ?></td>
                    <td rowspan='2'><?= $enregistrement['imprimante'] ?></td>
                    <td colspan='2'><?= ($enregistrement['n_i_phbn'] - $enregistrement['d_i_phbn']) ?></td>
                    <td colspan='2'><?= ($enregistrement['n_i_phclr'] - $enregistrement['d_i_phclr']) ?></td>
                    <td colspan='2'><?= ($enregistrement['n_i_impbn'] - $enregistrement['d_i_impbn']) ?></td>
                    <td colspan='2'><?= ($enregistrement['n_i_impclr'] - $enregistrement['d_i_impclr']) ?></td>
                    <td rowspan='2'><?= number_format($total_phbn, 2) ?> FCFA</td>
                    <td rowspan='2'><?= number_format($total_phclr, 2) ?> FCFA</td>
                    <td rowspan='2'><?= number_format($total_impbn, 2) ?> FCFA</td>
                    <td rowspan='2'><?= number_format($total_impclr, 2) ?> FCFA</td>
                    <td rowspan='2'><?= number_format($total, 2) ?> FCFA</td>
                </tr>
                <tr>
                <th><?= $enregistrement['d_i_phbn'] ?></th>
                <th><?= $enregistrement['n_i_phbn'] ?></th>
                <th><?= $enregistrement['d_i_phclr'] ?></th>
                <th><?= $enregistrement['n_i_phclr'] ?></th>
                <th><?= $enregistrement['d_i_impbn'] ?></th>
                <th><?= $enregistrement['n_i_impbn'] ?></th>
                <th><?= $enregistrement['d_i_impclr'] ?></th>
                <th><?= $enregistrement['n_i_impclr'] ?></th>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="14">Total Général</td>
                <td><?= number_format($total_general, 2) ?> FCFA</td>
            </tr>
        </tfoot>
    </table>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var selectImprimante = document.getElementById('imprimante_id');
            var dateDebut = document.getElementById('date_debut');
            var dateFin = document.getElementById('date_fin');

            function fetchResults() {
                var imprimanteId = selectImprimante.value;
                var debut = dateDebut.value;
                var fin = dateFin.value;

                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'bilan.php?imprimante_id=' + imprimanteId + '&date_debut=' + debut + '&date_fin=' + fin, true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var parser = new DOMParser();
                        var doc = parser.parseFromString(xhr.responseText, 'text/html');
                        var newTbody = doc.querySelector('tbody');
                        var newTfoot = doc.querySelector('tfoot');
                        
                        document.querySelector('tbody').innerHTML = newTbody.innerHTML;
                        document.querySelector('tfoot').innerHTML = newTfoot.innerHTML;
                    }
                };
                xhr.send();
            }

            selectImprimante.addEventListener('change', fetchResults);
            dateDebut.addEventListener('change', fetchResults);
            dateFin.addEventListener('change', fetchResults);
        });
    </script>
</body>
</html>
