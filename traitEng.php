<?php 
session_start();

try
   {
   $bdd = new PDO('mysql:host=localhost;dbname=citeda', 'root', '');
  
   }
   catch (Exception $e)
   {
   die('Erreur : ' . $e->getMessage());
   }

if (isset($_POST['enregistrer'])) {

    $idimpr = $_POST['imprimante'];
    $datee = date("Y-m-d");

   
    $query =$bdd->prepare("SELECT * FROM index_imp WHERE idimpr = ? ORDER BY date_index DESC LIMIT 1");
    $query ->execute(array($idimpr));
    $lastindex = $query->fetch();

    $nbrphbn = $_POST['indexphotocopieBn'] - $lastindex['i_phbn'];
    $nbrphclr = $_POST['indexphotocopieClr'] - $lastindex['i_phclr'];
    $nbrimpbn = $_POST['indeximpressionBn'] - $lastindex['i_impbn'];
    $nbrimpclr = $_POST['indeximpressionClr'] - $lastindex['i_impclr'];
  
    $req = $bdd->prepare('INSERT INTO enregistrer(idimpr,dateajout,nbrphbn,nbrphclr,nbrimpbn,nbrimpclr) VALUES(?,?,?,?,?,?)');
    $req->execute(Array($idimpr,$datee,$nbrphbn,$nbrphclr,$nbrimpbn,$nbrimpclr));

    $requete = $bdd->prepare('INSERT INTO index_imp(idimpr,i_phbn,i_phclr,i_impbn,i_impclr,date_index) VALUES(?,?,?,?,?,?)');
    $requete->execute(Array($idimpr,$_POST['indexphotocopieBn'],$_POST['indexphotocopieClr'],$_POST['indeximpressionBn'],$_POST['indeximpressionClr'],$datee));
    
    if ($req && $requete) {
        header("Location: acceuil.php?enr=yes");
    }
    else {
        header("Location: acceuil.php?enr=no");
    }
   
}


?>