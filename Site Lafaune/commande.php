<?php   
session_start(); /*  Démarre une nouvelle session ou reprend une session existante*/
/* connection a la base de donnée*/
   try
                {
                   $bdd = new PDO('mysql:host=localhost;dbname=lafaune;charset=utf8', 'root', '',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                }
                catch(Exception $e)
                {
                     die('Erreur : '.$e->getMessage()); /* renvoi un message d'erreur si la connection est impossible*/
                }
    
?>


<!DOCTYPE html>
<html>
    <head> <!-- chargement du css,du type de format et de la librairie jquery -->
        <meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
    <link rel="stylesheet" href="../../../stylelafaune.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <!-- Inclure la librairie Jquery -->
    <script src="http://code.jquery.com/jquery-2.1.3.min.js" type="text/javascript"></script>
    
    </head>

    <body bgcolor="#DEB887" style=" overflow-x:hidden; overflow-y:auto;"> <!-- permet de cacher ou supprimer la barre de défilement horizontale -->
    
    <?php  
    if (count($_SESSION) == 0) { /* affiche un message d'erreur si la session est vide*/
   echo "<h3 style='width:100%;margin-left:35%;margin-top:25%;color:red'><u>DÉSOLÉ: le panier est vide <u></h3>";

   }else

   {
     $somme = 0;
   ?>
    <!-- permet d'afficher les différents commande du clients avec possibilité de validation-->
    <u> <h2 style="text-align:center;margin-top:6%;">Récapitulatif des articles commandés</h2></u>
    <table border="1px;" cellspacing="0;"text-align="center;"  style="width:50%;margin-left:25%;margin-top:10%;">
      <tr>
        <td>Référence</td>
        <td>Désignation</td>
        <td>PU</td>
        <td>Qté</td>
        <td>Montant</td>
      </tr>
    <?php 
        $rep=$bdd->query("SELECT * FROM produit"); /* on recupere tout le contenu de la table produit qu'on affect à l'objet $rep*/
        while ($donnes = $rep->fetch()) /* on affiche chaque ligne de l'objet à la variable $données*/
        {
                $cpt = count($_SESSION['pdt_designation']); /* on compte le nombre d'element qu'on a dans la session*/
                $cpt=$cpt-1; /*on décrement de -1 puisque le contenu de la session commence à zero */
                $trouver=0; /* initialistion de la variable $trouver à 0*/
          /* on recommence tant que on a un element dans la session et que on ne l'est pas encore retrouvé*/
          while ( $cpt>=0 && !$trouver) 
          {
            /* permet de comparer les informations de la base de donnée et celle de la session*/
            if ($donnes['pdt_designation'] == $_SESSION['pdt_designation'][$cpt]) 
            {  /* si c'est le cas on affiche chaque ligne en multipliant la quantité et le prix */
                $montant =  $donnes['pdt_prix'] * $_SESSION['qt'][$cpt] ; 
                $somme = $somme + $montant; /* on fait la somme des différents articles commandés*/
              ?>
                  
              <tr>
              <td><?php echo $donnes['pdt_ref'] ;?></td>
              <td><?php echo $donnes['pdt_designation'] ;?></td>
              <td><?php echo $donnes['pdt_prix']; ?> € </td>
              <td><?php echo $_SESSION['qt'][$cpt] ;?></td>
              <td><?php echo $donnes['pdt_prix'] * $_SESSION['qt'][$cpt] ;?> € </td>
              </tr>
              <?php
              $trouver=1;
              }

            $cpt--; /* decrementation il faut qu'il s'arret un jour*/
          }
          
        }
    ?>
    <!--permet d'affcher la somme à payer -->
    </table >
    <table style="margin-left:55%">
      <tr>
        <td> <h3>SOMME A PAYER </h3> </td>
         <td><h3> <?php echo $somme;?> € </h3> </td>
      </tr>
    </table>

<!-- un formulaire d'authentification pour eviter  plaisantins-->
<form autocomplete="off" method="post" action="commandee.php" id="ContactForm" onsubmit="return submitForm();">
  
    <table style="margin-left:30%">
      <tr>

        <td> 
          <label for="cli_mail">Email </label> 
         <input type="email" id="cli_mail"  name ="cli_mail"/>
         </td>
         <td>
         <input type="password" id="cli_mdp"  name ="cli_mdp"/>
         <label for="cli_mdp">Mot de passe </label> 

         </td>
      </tr>
    </table>
      <span><!-- permet d'afficher le message à coté du bouton ajouter -->
    <input type="submit" value="Envoyer la commande" class="floattant"style = "width:14%;margin-left:44%;margin-top: 10mm" />

    <!--  j'ai inclus un élément div à laquelle que je vais  mettre à jour dynamiquement la réponse du serveur -->
    <div class="form_result" style = "margin-top: -5mm; width:100%;margin-left:44%"> </div><br/><br/>
    </span>
</form>
<?php   
 }
?>

 <script>
            /*  cette  fonction JavaScript   exécute le code jQuery pour transmettre les donnees de maniere serialize () cela permet de facilite la  transmise au serveur. */
        function submitForm() {
            $.ajax({type:'POST', url: 'commandee.php', data:$('#ContactForm').serialize(), success: function(response) {

            $('#ContactForm').find('.form_result').html(response);
            supMsg();
            
        }});

        return false; /* ce false permet de signaler la fin de la requette et arret de regenerer la page*/
    }

           // On l'efface 8 secondes plus tard
           function supMsg()
           {
             setTimeout(function() {
             $('#ContactForm').find('.form_result').html(" ")
               },9000);
            }

    </script>

    </body>
</html>