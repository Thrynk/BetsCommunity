<div class="main_block">
  <div id="myNav" class="menu">
    <a href="javascript:void(0)" class="close" onclick="closeNav()">&times;</a>
    <div class="sous_menu">
      <a href="index.php?page=creer-championnat">Créer</a>
      <a href="index.php?page=rejoindre-championnat">Rejoindre</a>
    </div>
  </div>

  <i style="font-size:30px;cursor:pointer;margin-top:auto;margin-bottom:auto;" class="fa fa-bars" onclick="openNav()"></i>
  <a href="index.php" class="logo"> BetsC<i id="ballon" class="fa fa-futbol-o"></i>mmunity</a>

  <?php
  if(isset($_SESSION['user'])){
    $user = $_SESSION['user']; ?>
  <div class="bienvenue">
    <?php echo $user->pseudo(); ?>
    <a class="linkbutton" href="index.php?page=deconnexion">Déconnexion</a>
  </div>
  <div class="forphone">
    <a href="index.php?page=deconnexion"><i class="fa fa-power-off"></i></a>
  </div>
  <?php }
  else{ ?>
  <i id="signup" class="fa fa-user-plus" onclick="document.getElementById('id01').style.display='block'" ></i>
  <i id="signin" class="fa fa-sign-in" onclick="document.getElementById('id02').style.display='block'" ></i>
  <button class="connexionbutton" onclick="document.getElementById('id01').style.display='block'" style="width:auto;">S'inscrire</button>
  <button class="connexionbutton" onclick="document.getElementById('id02').style.display='block'" style="width:auto;">Se connecter</button>
  <?php
  include('inscription.php');
  include('connexion.php');
  } ?>
</div>
    <script>
        function openNav() {
            document.getElementById("myNav").style.width = "100%";
        }

        function closeNav() {
            document.getElementById("myNav").style.width = "0%";
        }
    </script>
