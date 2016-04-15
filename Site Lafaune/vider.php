
<?php   
session_start();/* Démarre une nouvelle session ou reprend une session existante*/
session_destroy(); /* supprimer la session*/ 	
/* j'afficher le message au client*/
echo "<h3 style='width:100%;margin-left:35%;margin-top:25%;color:green'><u>Le panier a été vidé avec succès<u> </h3>";
  ?>

<!DOCTYPE html>
<html>
    <head> <!-- chargement du css et le format -->
        <meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
    <link rel="stylesheet" href="../../../stylelafaune.css" />
    
    </head>

    <body bgcolor="#DEB887" style=" overflow:hidden;"><!-- supprime ou cache les barres de défilement horizontale-->

    </body>
</html>