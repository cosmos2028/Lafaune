<?php   
session_start(); /*  Démarre une nouvelle session ou reprend une session existante*/

		/* on verifie si on a bien les informations qu'on attend et que le contenu ne soit pas vide tel que pdt_designation et qte */
if( isset($_POST['pdt_designation'])  && isset($_POST['qt']) && !empty($_POST['pdt_designation']) && !empty($_POST['qt'])) {

   /* puisque on a tout les informations on affiche un message de reussit*/
   $html = "<h3 style='color:green'>BRAVO : Enregistrement Effectué </h3>"; 

   if (count($_SESSION) == 0) { /* si la session est vide on remplit les informations dans la session*/
    $_SESSION['pdt_designation'][] = $_POST['pdt_designation'] ;
        $_SESSION['qt'][] = $_POST['qt'];
   }
  else{ 
    /* ici on verifie si le produit entré n'exciste pas déjà si c'est le cas on increment sa qt et on affecte 1 à la variable trouver*/
   $trouver =0;
   $cpt = count($_SESSION['pdt_designation']);

   for($i = 0; $i < $cpt ; $i++)
   {
  
   	if ( $_POST['pdt_designation'] == ($_SESSION['pdt_designation'][$i]) && $trouver ==0)
   {
	   $_SESSION['qt'][$i] = $_SESSION['qt'][$i] + $_POST['qt'] ;
	  $trouver =1;
   }
    
 }	
/* si les informations entrées n'exciste pas déjà on les ajoutent dans la session*/
 if (!$trouver) {
    	$_SESSION['pdt_designation'][] = $_POST['pdt_designation'];
        $_SESSION['qt'][] = $_POST['qt'];
     } 
     
  }
        /* ohtmln affiche un message d'erreur si les informations envoyées par le formulaire sont vide mais ici c'est plutot la quantité*/
}else   $html = "<h3 style='color:red'>ERREUR : il manque la quantité</h3>"; 
   echo $html;  

?>