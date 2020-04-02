<label>Missas <?= (true) ? 'Especiais' : 'Comum'; ?></label><br>
<?php
if ($typesMass) :
  foreach ($typesMass as $typeMass) :
    if ($typeMass->date) {
      $dataFormatada = DateTime::createFromFormat('Y-m-d', $typeMass->date);
      $dataFormatada = $dataFormatada->format('d/m/Y');
    } else {
      $dataFormatada = "";
    }
?>
    <label class="form-radio-label col-md-4">
      <input class="form-radio-input" type="radio" name="id_type_mass" value="<?= $typeMass->id_type_mass ?>" data-date="<?= $dataFormatada ?>" data-price="<?= $typeMass->price ?>" onclick="getDataTypeMass(this)">
      <span class="form-radio-sign"><?= $typeMass->title ?></span>
      <span class="col-1"> - </span>
      <span class="form-radio-sign"><?= substr($typeMass->hour, 0, 5) ?> hs</span>
    </label>
  <?php
  endforeach;
else :
  notify("warning", "Não existe missas cadastrada!");
  echo notify();
  ?>
  <div class="alert alert-warning" role="alert">
    Não existe missas cadastrada!
  </div>
<?php
endif;
?>