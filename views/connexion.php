<div id="id02" class="ouvert">

      <form class="place" action="index.php?page=connexion" method="post">

    <div class="connexion">
      <span onclick="document.getElementById('id02').style.display='none'" class="croix" title="Close Modal">&times;</span>
      <h1>Connexion</h1>
      <hr>
      <label for="login"><b>Pseudo</b></label>
      <input class="inputconnexion" type="text" placeholder="Pseudo" name="login" required>

      <label for="password"><b>Mot de passe</b></label>
      <input class="inputconnexion" type="password" placeholder="Mot de passe" name="password" id="myInput" required>
      <div class="container">
        <input type="checkbox" onclick="myFunction()" > Montrer le mot de passe
      </div>
      <div class="container">
        <input type="checkbox" checked="checked" id="check" name="remember" value="oui"> Se souvenir de moi
      </div>
    </div>

      <button type="submit" class="valider">Login</button>
  </form>
</div>

<script>

  var modal = document.getElementById('id02');

  window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
function myFunction() {
    var x = document.getElementById("myInput");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
</script>
