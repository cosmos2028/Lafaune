<?php 
session_start(); /*  Démarre une nouvelle session ou reprend une session existante*/
  $html = " "; 
/* connection a la base de donnée*/
   try
                {
                   $bdd = new PDO('mysql:host=localhost;dbname=lafaune;charset=utf8', 'root', '',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                }
                catch(Exception $e)
                {
                     die('Erreur : '.$e->getMessage()); /* affiche un message d'erreur en cas de connection impossible*/
                }
       /* on verifie si on a bien les informations qu'on attend et que le contenu ne soit pas vide tel que cli_mdp et cli_mail */
   if (isset($_POST['cli_mail']) && isset($_POST['cli_mdp']) && !empty($_POST['cli_mail']) && !empty($_POST['cli_mdp']) ) {

   	 $rep = $bdd->query("SELECT clt_email,clt_motPasse,clt_code FROM client ");/* on recupere tout le contenu de la table produit qu'on affect à l'objet $rep*/
   	 $trouver=0;
            	    // On affiche chaque entrée une à une
                      while ($donnes = $rep->fetch() )
                     { 
                         if($donnes['clt_email'] == $_POST['cli_mail']  && $donnes['clt_motPasse'] == $_POST['cli_mdp'] && !$trouver)
                         {
                          if (count($_SESSION) != 0)
                            {
                              
                         	  $datee = new DateTime();
                            $tmp = $datee->getTimestamp();
                            $val = $donnes['clt_code'];
                            $numCom = "$val/$tmp";
                         	$date = new DateTime(); /* on crée un objet de type date*/
                            $date=$date->format('d-m-Y'); /* on le convertit au format francais*/
                            /*j'effectue les requete preparés pour introduire dans ma table commande le numCom,date et clt_code*/
                            $bd = $bdd->prepare('INSERT INTO commande(numCom,dateCom ,clt_code) VALUES(:numCom,:dateCom,:clt_code)');
                            $bd->execute(array (':numCom' =>$numCom , ':dateCom' => $date, ':clt_code' =>$val ));
                            $bd->closeCursor(); /* termine la requete*/

                            /*j'effectue les requete preparés pour introduire dans ma table contenir le numCom,$pdt_ref et $quantite*/
                            $b = $bdd->prepare('INSERT INTO contenir(numCom,pdt_ref ,qte ) VALUES(:numCom,:pdt_ref,:qte)');
                            $b->bindParam('numCom', $numCom , PDO::PARAM_STR);
                            $b->bindParam('pdt_ref',$pdt_ref, PDO::PARAM_STR);
                            $b->bindParam('qte', $quantite, PDO::PARAM_INT);

                            
                            	/* si le session n'est pas vide on excecute la requete preparé*/
 							              $cpt = count($_SESSION['pdt_designation']);
 							              /* cette boucle permet d'executer la requete preparé ci-dessous et introduire dans la table contenir les valeurs
 							               tel que pdt_ref et qt*/
  	                        for($i = 0; $i < $cpt ; $i++)
                            {
                                $repo = $bdd->query("SELECT pdt_designation,pdt_ref FROM produit ");

                              while ($donne = $repo->fetch() ) 
                              {

                              	if ($_SESSION['pdt_designation'][$i] == $donne['pdt_designation']  ) 
                              	{

                              		$pdt_ref = $donne['pdt_ref'];
                                    $quantite = $_SESSION['qt'][$i];
                                    $b->execute();
                              	 }

                              }
     	                   
                             }

                             $trouver=1;
                         	echo "<h3 style='color:green'>BRAVO : Vous êtes enregistré sous la référence </h3>"."<h3><font color='green'>$numCom</font></h3>";
                         	session_destroy();/* on supprime la session apres enregistrement de la commande*/
                         }else 
                         {         /* si l'individu s'amuse à appuyer sur le bouton aprés enregistrement de celles-ci on affiche un message 
                                   d'erreur */
                         	      echo "<h3 style='color:red'>ERREUR : La commande a été enregistrée</h3>";
                         	      $trouver=1; /* on affecte 1 à $trouver pour eviter qu'il affiche encore le message du dessous */

                         }
                         	

                         }
                     } 

                     if (!$trouver) {
                     	/* si les identifiant ne corresponde pas on affiche ce message d'erreur*/
                     	$html = "<h3 style='color:red'>Identifiant erroné</h3>";
                     }

    	
    } else $html = "<h3 style='color:red'>ERREUR : champs non renseignés</h3>"; /* si les informations ne sont pas saisies*/
   echo $html;  

?>