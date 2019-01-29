
      <div id="id01" class="ouvert">
        <form class="place" action="index.php?page=inscription" method="post">
          <span onclick="document.getElementById('id01').style.display='none'" class="croix" title="Close Modal">&times;</span>
          <div class="inscription">
            <h1>S'inscrire</h1>
            <hr>
            <label for="pseudo"><h3>Pseudo</h3></label>
            <input class="inputconnexion" type="text" placeholder="Entrez votre pseudo" name="login" required>

            <label for="email"><h3>Email</h3></label>
            <input class="inputconnexion" type="text" placeholder="Entrez votre Email" name="mail" required>

            <label for="password1"><h3>Mot de passe</h3></label>
            <input class="inputconnexion" type="password" placeholder="Entrez votre mot de passe" name="password1" required>

            <label for="password2"><h3>Confirmation du mot de passe</h3></label>
            <input class="inputconnexion" type="password" placeholder="Confirmez votre mot de passe" name="password2" required>
            <div>
              <input type="checkbox" checked="checked" name="remember" id="souvenir"> Se souvenir de moi
            </div>

            <button type="submit" class="valider">S'inscrire</button>
          </div>
        </form>
      </div>

      <script>
        var modal = document.getElementById('id01');
        window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
      </script>
