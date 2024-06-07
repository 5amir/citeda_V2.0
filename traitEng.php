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
  
    $req = $bdd->prepare('INSERT INTO historique(idimpr,d_i_phbn,n_i_phbn,d_i_phclr,n_i_phclr,d_i_impbn,n_i_impbn,d_i_impclr,n_i_impclr,date_his) VALUES(?,?,?,?,?,?,?,?,?,?)');
    $req->execute(Array($idimpr,$lastindex['i_phbn'],$_POST['indexphotocopieBn'],$lastindex['i_phclr'],$_POST['indexphotocopieClr'],
    $lastindex['i_impbn'],$_POST['indeximpressionBn'],$lastindex['i_impclr'],$_POST['indeximpressionClr'],$datee));

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