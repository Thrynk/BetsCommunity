<?php
$arrayCompets = array(
  'Bundesliga' => 452,
  'Ligue 1' => 450,
  'Premier League' => 445,
  'Liga' => 455,
  'Serie A' => 456,
  'Champion s League' => 464,
  'World Cup' => 467
);?>
<form method="post" action="index.php?page=creer-championnat2">
  <p><input type="checkbox" name="Ligue[]" value="<?=$arrayCompets['Bundesliga']?>"> Bundesliga</p>
  <p><input type="checkbox" name="Ligue[]" value="<?=$arrayCompets['Ligue 1']?>"> Ligue 1</p>
  <p><input type="checkbox" name="Ligue[]" value="<?=$arrayCompets['Premier League']?>"> Premier League</p>
  <p><input type="checkbox" name="Ligue[]" value="<?=$arrayCompets['Liga']?>"> Liga</p>
  <p><input type="checkbox" name="Ligue[]" value="<?=$arrayCompets['Serie A']?>"> Serie A</p>
  <p><input type="checkbox" name="Ligue[]" value="<?=$arrayCompets['Champion s League']?>"> Champion's League</p>
  <p><input type="checkbox" name="Ligue[]" value="<?=$arrayCompets['World Cup']?>"> Coupe du monde</p>
  <input class="valider" type="submit" value="Valider">
</form>
