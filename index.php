<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="logo.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se connecter</title>

    <style>
        body {
            background:linear-gradient(250deg, #8EC5FC 0%, #E0C3FC 100%);    
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .formulaire {
            width: 400px;
            background-color: whitesmoke;
            border: 2px solid black;
            border-radius: 5px;
            padding: 30px;
            box-shadow: inset 5px 5px 5px rgba(0, 0, 0, 0.7), 5px 5px 5px rgba(0, 0, 0, 0.7);
        }

        label {
            font-weight: bold;
        }

        

        .inp {
            width: 200px;
            margin-left: 20px;
            border:none;
            outline:none;
            border-radius:20px;
            text-align:center;
            padding:3px;
            box-shadow: inset 3px 3px 3px rgba(0, 0, 0, 0.5), 5px 5px 5px rgba(0, 0, 0, 0.5);
        }

        .ligne {
            margin: 20px;
            display: flex;
            justify-content: space-between;
        }

        .bas {
            margin: 20px;
        }

        .btn {
            margin-top: 20px;
            display: flex;
            justify-content:center;
        }
        button{
            height: 30px;
            background-color: green;
            color:white;
            font-weight: bold;
            cursor: pointer;
            border:none;
        }

        
        .titre{
            display:flex;
            justify-content:space-between;
            align-items:center;
        }
        
    </style>
</head>

<body>
<?php  
session_start();
// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['id'])) {
    header("Location: acceuil.php");
    exit();
}

?>
    <div>
     <form method="post" action="auth.php">

        
        <div class="formulaire">
            <center class="titre">
                <img src="logo.jpg" width="150" height="150" alt="">
                <div style="width:100%;">
                    <center><h3 style="font-size:30px;">CITeDA</h3></center>
                </div>
            </center>
            <div>
            
                <div class="ligne">
                    <label>Email : </label>
                    <input type="email" name="email" class="inp" required>
                </div>
                <div class="ligne">
                    <label>Mot de passe : </label>
                    <input type="password" name="password" class="inp" required>
                </div>
                <?php 

                    if (isset($_GET['error'])) {
                        ?>
                        
                            <h3 style="color:red;text-align:center;">Information incorrecte</h3>
                        
                        <?php
                    }

                ?>
                <div class="btn">
                    <button class="btn2" name="connecter"> Se connecter</button>
                </div>
            </div>
        </div>
    </form>
    </div>

</body>

</html>