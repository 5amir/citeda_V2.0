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



?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caisse</title>
</head>
<body>
    <h1>Totaux des Imprimantes</h1>

    <table border="1">
        <thead>
            <tr>
                <th>Imprimante</th>
                <th>Total Général (FCFA)</th>
            </tr>
        </thead>
        <tbody id="totalsBody">    
        <?php
        
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

                foreach ($enregistrements as $enregistrement): 
                    $total_phbn = ($enregistrement['n_i_phbn'] - $enregistrement['d_i_phbn']) * $enregistrement['prixphbn'];
                    $total_phclr = ($enregistrement['n_i_phclr'] - $enregistrement['d_i_phclr']) * $enregistrement['prixphclr'];
                    $total_impbn = ($enregistrement['n_i_impbn'] - $enregistrement['d_i_impbn']) * $enregistrement['priximbn'];
                    $total_impclr = ($enregistrement['n_i_impclr'] - $enregistrement['d_i_impclr']) * $enregistrement['priximclr'];
                    $total = $total_phbn + $total_phclr + $total_impbn + $total_impclr;
                    $total_general += $total;
                endforeach; 
         
         
             ?> 
             <tr>
             <td><?= $imprimante['nomimpr'] ?></td>
             <td><?= number_format($total_general, 2) ?> FCFA</td>
             </tr>
             <?php
          }

        ?>
            
            </tbody>
        <tfoot>
        </tfoot>
    </table>

</body>
</html>
