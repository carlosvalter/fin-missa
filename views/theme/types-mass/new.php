<?php $v->layout("theme/layout"); ?>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="card-title">
          Tipos de Missas
        </div>
      </div>
      <form id="form" class="form" action="<?= $router->route("typesmass.new"); ?>" method="post" autocomplete="off">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-check">
                <label>Tipo de missa</label><br>
                <label class="form-radio-label">
                  <input class="form-radio-input" type="radio" name="typeMass" id="radioMassCommon" value="0" <?= ($typeMass->mass_special === '0' || $typeMass->mass_special == null) ? 'checked' : '' ?>>
                  <span class="form-radio-sign">Missa Comum</span>
                </label>
                <label class="form-radio-label ml-3">
                  <input class="form-radio-input" type="radio" name="typeMass" id="radioMassSpecial" value="1" <?= ($typeMass->mass_special === '1') ? 'checked' : '' ?>>
                  <span class="form-radio-sign">Missa Especial</span>
                </label>
              </div>
              <div class="form-group">
                <label for="inputTitle">Título</label>
                <input type="hidden" name="id_type_mass" value="<?= $typeMass->id_type_mass ?>">
                <input type="text" class="form-control" id="inputTitle" name="title" placeholder="Título da missa" value="<?= ($typeMass->title) ? $typeMass->title : 'Missa Comum'; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="inputHour">Horário da missa</label>
                <input type="time" class="form-control" id="inputHour" name="hour" value="<?= $typeMass->hour ?>" <?= ($update) ? 'readonly' : '' ?>>
              </div>
              <div id="divDate" class="form-group" style="display: none">
                <label for="selectWeek">Data da missa</label>
                <input type="date" class="form-control" id="inputDate" name="date" aria-describedby="dateHelp" value="<?= $typeMass->date ?>" <?= ($update) ? 'readonly' : '' ?>>
                <small id="dateHelp" class="form-text text-muted">Somente para missas especiais.</small>
              </div>
              <div class="form-group">
                <label for="inputHour">Preço do pedido</label>
                <input type="text" class="form-control" id="inputPrice" name="price" placeholder="R$" value="<?= number_format($typeMass->price, 2, ',', '.') ?>">
              </div>
              <div class="form-check">
                <label class="form-check-label">
                  <input class="form-check-input" type="checkbox" name="enable" value="1" <?= ($typeMass->enable === '1' || $typeMass->enable == null) ? 'checked' : '' ?>>
                  <span class="form-check-sign">Ativo</span>
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="card-action">
          <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php $v->start("scripts"); ?>
<script src="<?= asset("js/form.js"); ?>"></script>
<script>
  $('input[name=typeMass]').change(() => {
    if ($('#radioMassCommon').is(':checked')) {
      $('#divDate').slideUp('slow');
      $('#inputTitle').prop('readonly', true).val('Missa Comum');
    } else {
      $('#divDate').slideDown('slow');
      $('#inputTitle').prop('readonly', false).focus().select();
    }
  });
  <?= ($update) ?
    "$(':radio:not(:checked)').attr('disabled', true);"
    : '';
  ?>
</script>
<?php $v->end(); ?>