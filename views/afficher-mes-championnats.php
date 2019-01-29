<section>
  <h2> Mes championnats </h2>
  <?php foreach($championnats as $key => $object){ ?>

    <div id="logo" onClick="AfficherMasquer(this)">
      <i class="fa fa-info-circle"  style="font-size:28px"></i>
      <a href="index.php?page=afficher-championnat&championnat=<?=$key?>">
        <h3><?=$object->name()?></h3>
      </a>
    </div><div id="divacacher" style="display:none; ">
      <div id="box">
        <div id="box-inner">
          Date début : <?=$object->start_date()?> <br>
          Date Fin : <?=$object->end_date()?> <br>
          Fondateur : ... <br>
          Nombre de participant : ... <br>
        </div>
      </div>
    </div>
  <?php } ?>
</section>

<script type="text/javascript">
  function AfficherMasquer(elmt)  {
    divInfo = elmt.nextSibling;
 
    if (divInfo.style.display == 'none')
    divInfo.style.display = 'block';
    else
    divInfo.style.display = 'none';
}
</script>
