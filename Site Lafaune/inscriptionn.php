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
       /* on verifie si on a bien les informations qu'on attend et que le contenu ne soit pas vide  */
	if(isset($_POST['nom_cli']) && isset($_POST['rue_cli']) && isset($_POST['cp']) && isset($_POST['ville']) && isset($_POST['cli_tel']) 
	 && $_POST['cli_mail'] && $_POST['cli_mdp'] && $_POST['cli_cmdp'] && !empty($_POST['nom_cli']) && !empty($_POST['rue_cli']) 
	 && !empty($_POST['cp']) && !empty($_POST['ville']) && !empty($_POST['cli_tel']) && !empty($_POST['cli_mail']) && !empty($_POST['cli_mdp'])
	 && !empty($_POST['cli_cmdp']))
	{
		$trouver=0;
		if($_POST['cli_mdp'] == $_POST['cli_cmdp'])
		{
			$alphanum = 'C0000';
			/*on recupere toute la ligne de la table produit pour cat_code = 'pay'*/
              $reponse = $bdd->query("SELECT clt_email FROM client ");

            if ($reponse->fetch() != false) 
              {
              	   $repons = $bdd->query("SELECT clt_email FROM client ");
                   // On affiche chaque entrée une à une
                   while ($donnees = $repons->fetch() )
                    {      
                      $tableau[] = $donnees['clt_email'];
                     } 
                    
                     for ($i=0; $i <count($tableau) && $trouver!==1  ; $i++) 
                     { 
                       if ($tableau[$i] == $_POST['cli_mail'])
                        $trouver=1;
                     }

                      if (!$trouver) 
                     {
            	      $rep = $bdd->query("SELECT clt_code FROM client ORDER BY clt_code  DESC LIMIT 1");
            	    // On affiche chaque entrée une à une
                      while ($donnes = $rep->fetch() )
                     { 
                         $alphanum = $donnes['clt_code'];
              	         $val = $_POST['nom_cli'];$val1= $_POST['rue_cli'];$val2= $_POST['cp'];$val3=$_POST['ville'] ;$val4=$_POST['cli_tel'];
              	         $val5=$_POST['cli_mail'];$val6=$_POST['cli_mdp']; $alphanum= ++$alphanum;

                  /*j'effectue les requete insert into pour introduire tous les informations du formulaire à la  table client */
 				         $bdd->query("INSERT INTO client(clt_code,clt_nom,rue,cp,ville ,clt_tel,clt_email,clt_motPasse) 
 				          VALUES('$alphanum', '$val','$val1','$val2','$val3','$val4','$val5','$val6')");
                       } 

                      $html = "<h3 style='color:green'>BRAVO : Vous êtes enregistré </h3>"; 


                 }else $html = "<h3 style='color:red'>Erreur :le mail existe déjà</h3>"; 
              }
              else
              {
              	$val = $_POST['nom_cli'];$val1= $_POST['rue_cli'];$val2= $_POST['cp'];$val3=$_POST['ville'] ;$val4=$_POST['cli_tel'];
              	$val5=$_POST['cli_mail'];$val6=$_POST['cli_mdp']; $alphanum= ++$alphanum;

                  /*j'effectue les requete insert into pour introduire tous les informations du formulaire à la  table client */
 				 $bdd->query("INSERT INTO client(clt_code,clt_nom,rue,cp,ville ,clt_tel,clt_email,clt_motPasse) 
 				 VALUES('$alphanum', '$val','$val1','$val2','$val3','$val4','$val5','$val6')");

 				 $html = "<h3 style='color:green'>BRAVO : Vous êtes enregistré </h3>"; 

              }

		} else $html = "<h3 style='color:red'>Erreur :mot de passe different</h3>"; 

	}

	else $html = "<h3 style='color:red'>Erreur : un ou plusieurs champs non renseignés</h3>"; 

echo $html;

?>