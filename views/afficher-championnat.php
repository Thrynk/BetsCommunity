<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Championnat</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="views/css/accueil.css">
        <link rel="stylesheet" href="views/css/header.css">
        <link rel="stylesheet" href="views/css/inscription-connexion.css">
        <link rel="stylesheet" href="views/css/afficher-championnat.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="icon" type="image/jpeg" href="img/football.jpg">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>

    <header>
      <?php include('header.php'); ?>
    </header>

    <body>
      <?php
      if(isset($message)){ ?>
        <div class="alert alert-info alert-dismissible fade in">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <?=$message?>
        </div>
      <?php }
      else{ ?>
        <button class="tablink" onclick="openPage('Match', this, 'red')" id="defaultOpen">Matchs</button>
        <button class="tablink" onclick="openPage('classement', this, 'green')">Classement</button>
      <div id="Match" class="tabcontent">
      <?php $j = 0;
      $boolligue1 = 0;
      $boolbundes = 0;
      $boolpl = 0;
      $boolliga = 0;
      $boolserieA = 0;
      $boolchampions = 0;
      $boolworldcup = 0; ?>
      <form method="post" action="index.php?page=parier">
        <?php for($i = 0; $i < $nombreCompets; $i++){ ?>
        <table>
          <thead>
            <?php if(!empty($ligue1) && $boolligue1 == 0){
              $champ = $ligue1;
              $boolligue1 = 1; ?>
              <tr>
                <th colspan="3">Ligue 1</th>
              </tr>
            <?php }
            else if(!empty($bundesliga) && $boolbundes == 0){
              $champ = $bundesliga;
              $boolbundes = 1; ?>
              <tr>
                <th colspan="3">Bundesliga</th>
              </tr>
            <?php }
            else if(!empty($premierleague) && $boolpl == 0){
              $champ = $premierleague;
              $boolpl = 1; ?>
              <tr>
                <th colspan="3">Premier League</th>
              </tr>
            <?php }
            else if(!empty($liga) && $boolliga == 0){
              $champ = $liga;
              $boolliga = 1;?>
              <tr>
                <th colspan="3">Liga</th>
              </tr>
            <?php }
            else if(!empty($serieA) && $boolserieA == 0){
              $champ = $serieA;
              $boolserieA = 1; ?>
              <tr>
                <th colspan="3">Serie A</th>
              </tr>
            <?php }
            else if(!empty($champions) && $boolchampions == 0){
              $champ = $champions;
              $boolchampions = 1; ?>
              <tr>
                <th colspan="3">Champion's League</th>
              </tr>
            <?php }
            else if(!empty($worldcup) && $boolworldcup == 0){
              $champ = $worldcup;
              $boolworldcup = 1; ?>
              <tr>
                <th colspan="3">Coupe du monde</th>
              </tr>
            <?php } ?>
            <tr>
              <th>Equipe Domicile</th>
              <th>Pari</th>
              <th>Equipe extérieure</th>
            </tr>
          </thead>

          <tbody>
            <?php
            $numberOfExactScores = 3;
            foreach ($champ as $key => $match) {
              $betScores = NULL;
              foreach($bets as $key => $bet){
                if($bet->id_match() == $match->id()){
                  $betScores = $bet;
                  break;
                }
              }
              if($betScores){
                if($betScores->score1() != NULL || $betScores->score2() != NULL){
                  $numberOfExactScores--;
                }
              }
            }
            foreach ($champ as $key => $match) { ?>
              <tr>
                <td>
                  <img src="<?=$match->logo1()?>" alt="logo <?=$match->equipe1()?>">
                  <?php echo $match->equipe1(); ?>
                </td>

                <td class="choix">
                  <?php
                  $betOfMatch = NULL;
                  foreach($bets as $key => $bet){
                    if($bet->id_match() == $match->id()){
                      $betOfMatch = $bet;
                      break;
                    }
                  }
                  $fini = false;
                  if($match->statut() == 'FINISHED'){
                    $fini = true;
                  }
                  if($betOfMatch){
                    if($betOfMatch->prono() == 3){
                      echo 'pari : 1';
                    }
                    else if($betOfMatch->prono() == 4){
                      echo 'pari : N';
                    }
                    else if($betOfMatch->prono() == 5){
                      echo 'pari : 2';
                    }

                    if($betOfMatch->score1() != NULL || $betOfMatch->score2() != NULL){
                      echo '<br>score exact : <br>';
                      if($betOfMatch->score1() != NULL){
                        echo $betOfMatch->score1();
                      }
                      else{
                        echo '0';
                      }
                      echo ' - ' ;
                      if($betOfMatch->score2() !=NULL){
                        echo $betOfMatch->score2();
                      }
                      else{
                        echo '0';
                      }
                    }
                  }
                  else if($fini == false && strtotime(date('Y-m-d H:i:s')) < strtotime($match->date())){ ?>
                  <input class="bouton_1" type="radio" id="bouton_1<?=$j?>" name="bouton<?=$j?>" value="3">
                  <label for="bouton_1<?=$j?>"></label>
                  <input class="bouton_2" type="radio" id="bouton_2<?=$j?>" name="bouton<?=$j?>" value="4">
                  <label for="bouton_2<?=$j?>"></label>
                  <input class="bouton_3" type="radio" id="bouton_3<?=$j?>" name="bouton<?=$j?>" value="5">
                  <label for="bouton_3<?=$j?>"></label> <br>
                  <p class="scoreexact">score exact :</p>
                  <input type="checkbox" value="score" onClick="clickCheck(this, <?=$numberOfExactScores?>);"><div class="test" id="divacacher" style="display:none;">
                    <input type="text" class="score" name="scoreEquipe1:<?=$j?>" maxlength="1"> - <input type="text" class="score" name="scoreEquipe2:<?=$j?>" maxlength="1">
                    <br>
                  </div>
                <?php }
                if($fini == true){
                  if($match->score1() == NULL){
                    echo '<br>score final : 0 - ' . $match->score2() . '<br>';
                  }
                  else if($match->score2() == NULL){
                    echo '<br>score final : '. $match->score1() . ' - 0<br>';
                  }
                  else if($match->score1() == NULL && $match->score2() == NULL){
                    echo '<br>score final : 0 - 0<br>';
                  }
                  else{
                    echo '<br>score final : '. $match->score1() . ' - ' . $match->score2() . '<br>';
                  }
                }
                ?>
                <p>Date : <?=$match->date()?></p>
                </td>

                <td>
                  <img src="<?=$match->logo2()?>" alt="logo <?=$match->equipe2()?>">
                  <?php
                  echo $match->equipe2();
                  ?>
                </td>
              </tr>
            <?php $j++; } ?>
          </tbody>
        </table>
      <?php } ?>
      <input class="valider" type="submit" value="Mettre à jour ma grille">
    </form>
  </div>

  <div id="classement" class="tabcontent">
    <table>
      <thead>
        <th>Rang</th>
        <th>Nom</th>
        <th>Points</th>
      </thead>

      <tbody>
        <?php $donnees = $managerBattleBettings->getClassement($_SESSION['battle']);
        for($k = 0; $k < sizeof($donnees); $k++) { ?>
          <tr>
            <td class="name"><?=$k+1?></td>
            <td class="name"><?=$donnees[$k]['pseudo']?></td>
            <td class="name">
              <?php if($donnees[$k]['points'] == NULL){
                echo '0';
              }
              else{
                echo $donnees[$k]['points'];
              } ?>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
  <?php } ?>
  </body>
</html>


<script type="text/javascript">
  var nbCheck = 0;

  function isChecked(elmt) {
      if( elmt.checked ) {
          return true;
      }
      else {
          return false;
      }
  }

  function clickCheck(elmt, number) {
      if( (nbCheck < number) || (isChecked(elmt) == false) ) {
          if( isChecked(elmt) == true ) {
              nbCheck += 1;
          }
          else {
              nbCheck -= 1;
          }
          var doc = elmt.nextSibling;
          if(doc.style.display == 'none')
            doc.style.display = 'block';
          else
            doc.style.display = 'none';
      }
      else {
          elmt.checked = '';
      }
  }

  function openPage(pageName,elmnt,color) {
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
          tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablink");
      for (i = 0; i < tablinks.length; i++) {
          tablinks[i].style.backgroundColor = "";
      }
      document.getElementById(pageName).style.display = "block";
      elmnt.style.backgroundColor = color;

  }
  // Get the element with id="defaultOpen" and click on it
  document.getElementById("defaultOpen").click();
</script>
