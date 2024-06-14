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

$req = $bdd->prepare('SELECT * FROM imprimente');
$req->execute();


include"header.php";
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="logo.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="header.css">
    <title>Caisse</title>
</head>
<body>
    <h1>Totaux des Imprimantes</h1>

    <table border="1">
        <thead>
            <tr>
                <th>Imprimante</th>
                <th>Photocopie Blanc/Noir</th>
                <th>Photocopie Clr</th>
                <th>Impression Blanc/Noir</th>
                <th>Impression Clr</th>
                <th>Total Général (FCFA)</th>
            </tr>
        </thead>
        <tbody id="totalsBody">    
        <?php
        $total_caisse_impr = 0;
         while ($imprimante = $req->fetch()) {
            // Création de la requête SQL avec les filtres
                $query = "SELECT h.date_his, i.nomimpr AS imprimante, h.d_i_phbn, h.n_i_phbn, h.d_i_phclr, 
                h.n_i_phclr, h.d_i_impbn, h.n_i_impbn, h.d_i_impclr, h.n_i_impclr,
                i.prixphbn, i.priximbn, i.prixphclr, i.priximclr
                FROM historique h
                JOIN imprimente i ON h.idimpr = i.idimpr
                WHERE 1";

                $params = array();

                if ($imprimante['idimpr']) {
                $query .= " AND h.idimpr = ?";
                $params[] = $imprimante['idimpr'];
                }

                $stmt = $bdd->prepare($query);
                $stmt->execute($params);
                $enregistrements = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $total_general = 0;
                $bilan_phbn = 0;
                    $bilan_phclr = 0;
                    $bilan_impbn = 0;
                    $bilan_impclr = 0;

                foreach ($enregistrements as $enregistrement): 
                    $total_phbn = ($enregistrement['n_i_phbn'] - $enregistrement['d_i_phbn']) * $enregistrement['prixphbn'];
                    $total_phclr = ($enregistrement['n_i_phclr'] - $enregistrement['d_i_phclr']) * $enregistrement['prixphclr'];
                    $total_impbn = ($enregistrement['n_i_impbn'] - $enregistrement['d_i_impbn']) * $enregistrement['priximbn'];
                    $total_impclr = ($enregistrement['n_i_impclr'] - $enregistrement['d_i_impclr']) * $enregistrement['priximclr'];
                    $total = $total_phbn + $total_phclr + $total_impbn + $total_impclr;
                    $total_general += $total;
                    $bilan_phbn += $total_phbn;
                    $bilan_phclr += $total_phclr;
                    $bilan_impbn += $total_impbn;
                    $bilan_impclr += $total_impclr;
                endforeach; 
         
         
             ?> 
             <tr>
             <td><?= $imprimante['nomimpr'] ?></td>
             <td><?= number_format($bilan_phbn, 2) ?> FCFA</td>
             <td><?= number_format($bilan_phclr, 2) ?> FCFA</td>
             <td><?= number_format($bilan_impbn, 2) ?> FCFA</td>
             <td><?= number_format($bilan_impclr, 2) ?> FCFA</td>
             <td><?= number_format($total_general, 2) ?> FCFA</td>
             </tr>
             <?php
           $total_caisse_impr += $total_general;
          }
        ?>
            
            </tbody>
        <tfoot>
            <tr>
                <td colspan="5">Toute les Imprimantes </td>
                <td><?= number_format($total_caisse_impr, 2) ?> FCFA</td>
            </tr>
        </tfoot>
    </table>

</body>
</html>
