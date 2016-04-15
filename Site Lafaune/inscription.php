
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
    <link rel="stylesheet" href="../../../stylelafaune.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
        <!-- Inclure la librairie Jquery -->
    <script src="http://code.jquery.com/jquery-2.1.3.min.js" type="text/javascript"></script>
    
    </head>

    <body bgcolor="#DEB887" style=" overflow-x:hidden; overflow-y:auto;">
     <u> <h2 style="margin-left: 35%;width:100%"> INSCRIPTION</h2></u>
    <form autocomplete="off" method="post" action="inscriptionn.php" id="ContactForm" onsubmit="return submitForm();" 
      style = "margin-left:35%; margin-top:6%">
    <!--  lorsque on appui sur enregistrer le formulaire appel la fonction submitForm() pour executer la requete ajaxs -->
                  
                  <input style = "width:25%;" type="text"  id="nom_cli" name="nom_cli" /> 
                  <label for="nom_cli"> Nom </label><br/><br/>
                  <input style = "width:25%;" type="text"  id="rue_cli" name="rue_cli" /> 
                  <label for="rue_cli"> Rue </label><br/><br/>
                  <input style = "width:25%;" type="number" id="cp" name ="cp" /> 
                  <label for="cp"> CP</label><br/><br/>
                  <input style = "width:25%;" type="text" id="ville" name ="ville" /> 
                  <label for="ville"> Ville</label><br/><br/>
                  <input style = "width:25%;" type="number" id="cli_tel"  name ="cli_tel"/> 
                  <label for="cli_tel">  Tel </label><br/><br/>
                  <input style = "width:25%;" type="email" id="cli_mail"  name ="cli_mail"/>
                  <label for="cli_mail"> Email </label> <br/><br/>
                  <input style = "width:25%;" type="password" id="cli_mdp"  name ="cli_mdp"/> 
                  <label for="cli_mdp"> Mot de passe </label><br/><br/>
                  <input style = "width:25%;" type="password" id="cli_cmdp"  name ="cli_cmdp"/> 
                  <label for="cli_cmdp">Confirmer le mot de passe </label><br/><br/>

                  <span style="width:50%;">
                 <input type="submit" value="Enregistrer" class="floattant"style = "width:26%;" /> 
      
                 <div class="form_result" style = "margin-top: -5mm; width:100%;"> </div><br/><br/>
                </span>
        </form>

    <script>
            /*  cette  fonction JavaScript   exécute le code jQuery pour transmettre les donnees de maniere serialize () cela permet de facilite la  transmise au serveur. */
        function submitForm() {
            $.ajax({type:'POST', url: 'inscriptionn.php', data:$('#ContactForm').serialize(), success: function(response) {

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
               },3000);
            }

    </script>
    </body>
</html>