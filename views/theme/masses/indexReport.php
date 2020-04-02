<?php $v->layout("theme/layout"); ?>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="card-title">
          Relatório de Pedidos de Missa
        </div>
      </div>
      <form id="form" class="form" action="<?= $router->route("masses.report"); ?>" method="post" autocomplete="off" target="_blank">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-check">
                <label>Tipo de missa</label><br>
                <label class="form-radio-label">
                  <input class="form-radio-input" type="radio" name="typeMass" id="radioMassCommon" value="0" data-action="<?= $router->route("masses.ajaxTypesMass") ?>" data-mass-special="0" required>
                  <span class="form-radio-sign">Missa Comum</span>
                </label>
                <label class="form-radio-label ml-3">
                  <input class="form-radio-input" type="radio" name="typeMass" id="radioMassSpecial" value="1" data-action="<?= $router->route("masses.ajaxTypesMass") ?>" data-mass-special="1" required>
                  <span class="form-radio-sign">Missa Especial</span>
                </label>
              </div>
              <div class="form-group" id="divTypesMass">
                <!-- Preencher via ajax -->
              </div>
              <div class="form-group">
                <label for="inputDate">Data das missas</label>
                <input type="text" class="form-control" id="inputDate" name="date" required>
              </div>
              <div>
                <div class="datepicker input-group" id="divCalendarDatepicker" data-provide="datepicker">
                  <!-- Show Caledar DatePicker -->
                </div>
              </div>
            </div>
          </div>
          <div class="card-action">
            <button id="submit" type="submit" class="btn btn-primary">Gerar</button>
          </div>
      </form>
    </div>
  </div>
</div>

<?php $v->start("scripts"); ?>
<!-- <script src="<?= asset("js/form.js"); ?>"></script> -->
<script src="<?= asset("js/plugin/datepicker/jquery.plugin.js"); ?>"></script>
<script src="<?= asset("js/plugin/datepicker/jquery.datepick.min.js"); ?>"></script>
<script src="<?= asset("js/plugin/datepicker/jquery.datepick-pt-BR.js"); ?>"></script>
<script>

  // Config calendar
  $('#divCalendarDatepicker').datepick({
    altField: '#inputDate',
    // minDate: 'new Date()'
  });

  // Hide/Show datepicker based type mass
  $('input[name=typeMass]').change(function() {
    var data = $(this).data(); // Pega todas propriedata data- do link/botao clicado
    var divTypesMass = $('#divTypesMass');

    // Limpa form data
    $('#divCalendarDatepicker').datepick('setDate', null);

    if ($('#radioMassCommon').is(':checked')) {
      $('#divCalendarDatepicker').slideDown('slow');
      $('#divTypeDate').slideDown('slow');
    } else {
      $('#divCalendarDatepicker').slideUp('slow');
      $('#divTypeDate').slideUp('slow');
    }

    $.ajax({
      url: data['action'],
      data: data,
      type: "POST",
      dataType: "json",
      beforeSend: function() {
        // load("open");
        // MOSTRAR ANIMACAO CARREGANDO
      },
      success: function(callback) {
        if (callback.empty) {
          $('button[type=submit]').attr('disabled', true);
        } else
          $('button[type=submit]').attr('disabled', false);

        // Exibe o resultado que do ajax
        divTypesMass.html(callback.typesMass);
      },
      complete: function() {
        // load("close");
      }
    });

  });

  function getDataTypeMass(radioTypeMass) {

    var data = $(radioTypeMass).data();

    if (data.date != '')
      $('#inputDate').val(data.date);
    if (data.price != '')
      $('#inputPrice').val(data.price);
  };

</script>
<?php $v->end(); ?>