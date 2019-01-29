<html lang="fr">
  <head>
    <title>Rejoindre un championnat</title>
    <link rel="stylesheet" href="views/css/accueil.css">
    <link rel="stylesheet" href="views/css/creer_championnat.css">
    <link rel="stylesheet" href="views/css/header.css">
    <link rel="stylesheet" href="views/css/inscription-connexion.css">
    <link rel="icon" type="image/jpeg" href="img/football.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
    function aff() {
      document.getElementById("sectionpassword").style.display = "block";
    }

    function cac() {
      document.getElementById("sectionpassword").style.display = "none";
    }
    </script>
  </head>
  <body>
    <header>
      <?php include('header.php'); ?>
    </header>

    <section>
      <?php if(isset($message)){ ?>
        <div class="alert alert-danger alert-dismissible fade in">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Attention!</strong> <?=$message?>
        </div>
      <?php } ?>
      <h2 class="creer">Rejoindre un championnat</h2>
      <form action="index.php?page=rejoindre-championnat" method="post">
        <label class="labelchamp" for="nom"><h3>Nom du championnat :</h3></label> <br> <input type="text" id="nom" name="nom">

        <div class="radio">
          <p><input type="radio" name="acces" onClick="cac()" value="ouvert">  Ouvert</p>
          <p><input type="radio" name="acces" onClick="aff()" value="mdp">  Sur invitation</p>
        </div>
        <div id="sectionpassword">
          <label class="labelchamp" for="password"><h3>Mot de passe :</h3></label> <br> <input type="password" id="password" name="password">
        </div>
        <input class="valider" type="submit" value="Rejoindre" />
      </form>
    </section>
  </body>
</html>
