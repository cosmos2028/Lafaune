
<?php  

/* connection a la base de donnée*/
   try
                {
                    $bdd = new PDO('mysql:host=localhost;dbname=lafaune;charset=utf8', 'root', '',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                }
                catch(Exception $e)
                {
                        die('Erreur : '.$e->getMessage());
                }
    /* cette fonction me permet d'ajouter les differentes ligne des produits*/
   function ligne_tableau($donnees ){
?>

          <tr >
          <td style="width:25%;" ><img src="<?php echo $donnees['pdt_image'];?>" height="50%" width="auto" alt="<?php echo $donnees['pdt_designation'];?>"></td>
          <td style="width:25%;" align="center"> <?php echo $donnees['pdt_ref'];?> </td>
          <td style="width:25%;" align="center"> <?php echo $donnees['pdt_designation'];?></td>
          <td style="width:25%;" align="center"> <?php echo $donnees['pdt_prix'];?>€</td>
          </tr>
<?PHP
      }
      /* permet de d'afficher la liste déroulante*/
      function liste_deroulant($tableau) {

  foreach ($tableau  as $element) {
    ?>
  
    <option value="<?php echo $element?>"> <?php echo $element; ?></option>    

  <?php
}

}
?>
      
<!DOCTYPE html>
<html>
    <head> <!-- chargement du css,du type de format et les libreries de jquery -->
        <meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
    <link rel="stylesheet" href="../../../stylelafaune.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <!-- Inclure la librairie Jquery -->
        <script src="http://code.jquery.com/jquery-2.1.3.min.js" type="text/javascript"></script>
    
    </head>

    <body bgcolor="#DEB887">
    <script>
            /*  cette  fonction JavaScript   exécute le code jQuery pour transmettre les donnees de maniere serialize () cela permet de facilite la  transmise au serveur. */
        function submitForm() {
            $.ajax({type:'POST', url: 'oiseauxx.php', data:$('#ContactForm').serialize(), success: function(response) {

            $('#ContactForm').find('.form_result').html(response);
            supMsg(); /* fonction permet de supprimer le message aprés 3 secondes*/
            
        }});

        return false; /* ce false permet de signaler la fin de la requette et arret de regenerer la page*/
    }

           // On l'efface 3 secondes plus tard
           function supMsg()
           {
             setTimeout(function() {
             $('#ContactForm').find('.form_result').html(" ")
               },2000);
            }

    </script>

    <table><!-- l'netete du tableau-->
    <caption>Photos autres mammifère</caption>
      <tr align = "middle">
        <td style="width:25%;" > Photo</td>
                <td style="width:25%;"> Référence</td>
                <td style="width:25%; "> Désignation</td>
                <td style="width:25%;"> Prix</td>
      </tr>

  <?php  
      /*on recupere toute la ligne de la table produit pour cat_code = 'ois*/
      $reponse = $bdd->query("SELECT * FROM produit WHERE  cat_code = 'ois' ");


    // On affiche chaque entrée une à une
      while ($donnees = $reponse->fetch() )
    {        
    
      ligne_tableau($donnees) ;
      $tab[] = $donnees['pdt_designation']; /* stocke chaque entrée dans un tableau */
    }
    ?>
    </table><br/><br/>

<form autocomplete="off" method="POST" action=" oiseauxx.php" id="ContactForm" onsubmit="return submitForm();">
    <!--  lorsque on appui sur enregistrer le formulaire appel la fonction submitForm() pour executer la requete ajaxs -->

    
       <table  class="tab1" style = "margin-top: -10mm;"> <!-- délimitation du tableau en fonction de la hauteur de la page -->
    <tr >
       <td style="width:50%;" class="tab1td" >
         <select name="pdt_designation" id="pdt_designation" size="1" style="width:35%;">

             <?php liste_deroulant( $tab); ?>   <!-- permet d'afficher la liste déroulante -->
               
             </select>
          </td>
          <td style="width:50%;" class="tab1td">

             <label for="qt"  class="qte" style="width:30%;"> quantité</label>

             <input  type="number" name="qt" id="qt" size="1" style="width:30%;"/><br/><br/>
          </td>
          </tr>
          <tr >

          <td style="width:50%;"class="tab1td">
            <span style="width:50%;">  <!-- permet d'afficher le message à coté du bouton ajouter -->
            <input type="submit" value="Ajouter au panier" class="floattant"style = "margin-top: -3mm; width:25%;" /> 

             <!--  j'ai inclus un élément div à laquelle que je vais  mettre à jour dynamiquement la réponse du serveur -->
            <div class="form_result" style = "margin-top: -6mm; width:100%;"> </div><br/><br/>
            
       </span>
          </td>
        </tr>

      </table>
    </form>

    </body>
</html>

