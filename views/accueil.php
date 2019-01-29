<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Accueil</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="views/css/accueil.css">
        <link rel="stylesheet" href="views/css/header.css">
        <link rel="stylesheet" href="views/css/inscription-connexion.css">
        <link rel="stylesheet" href="views/css/afficher-mes-championnats.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="icon" type="image/jpeg" href="img/football.jpg">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
        <script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js"></script>
    </head>

    <body>
        <header>
          <?php include('header.php'); ?>
        </header>
        <section>
          <?php
         if(isset($message)){ ?>
           <div class="alert <?=$alert?> alert-dismissible fade in">
             <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
             <?=$message?>
           </div>
         <?php }
         if(isset($_SESSION['user'])){
           include('controllers/afficher-mes-championnats.php');
         }
         else { ?>
           <!--<img src="check.png" class="check" alt="pari">
           Pronostique les matchs des cinqs grands championnats Européens chaque week-end <br> <br>
           <img src="friend.png" class="ami" alt="Ami">
           Défie tes amis et des dizaines de joueurs chaque week-end <br> <br>
           <img src="classement.png" class="classement" alt="classement">
           Compare ton classement avec les autres joueurs et devient le meilleur pronostiqueur-->
        <?php
         }
         ?>
        </section>
    </body>
</html>

<script>
window.addEventListener("load", function(){
window.cookieconsent.initialise({
  "palette": {
    "popup": {
      "background": "#252e39"
    },
    "button": {
      "background": "#14a7d0"
    }
  },
  "theme": "edgeless",
  "content": {
    "message": "Ce site utilise les cookies pour vous garantir la meilleure expérience utilisateur.",
    "dismiss": "Compris"
  }
})});
</script>
