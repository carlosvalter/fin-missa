<?php $v->layout("theme/layout"); ?>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="card-title">
          Pedidos de Missa
        </div>
      </div>
      <form id="form" class="form" action="<?= $router->route("masses.new"); ?>" method="post" autocomplete="off">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="selectTypesIntention">Intenção</label>
                <select class="form-control" id="selectTypesIntention" name="id_type_intention" required>
                  <option value=""></option>
                  <?php
                  foreach ($typesIntention as $typeIntention) :
                  ?>
                    <option value="<?= $typeIntention->id_type_intention ?>"><?= $typeIntention->title ?></option>
                  <?php
                  endforeach;
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="inputTitle">Fiel</label>
                <input type="text" class="form-control" id="inputFaithful" name="faithful" placeholder="Nome do fiel" value="<?= $mass->faithful ?>" required>
              </div>
              <div class="form-check">
                <input type="hidden" name="id_mass" value="<?= $mass->id_mass ?>">
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
                <input type="text" class="form-control" id="inputDate" name="date" value="<?= $mass->date ?>" readonly required>
                <input type="hidden" class="form-control" id="inputPrice" name="price">
              </div>
              <div>
                <div class="form-check" id="divTypeDate">
                  <label>Datas</label><br>
                  <label class="form-radio-label">
                    <input class="form-radio-input" type="radio" name="typeDate" id="radioVariadas" value="variadas" checked>
                    <span class="form-radio-sign">Variadas</span>
                  </label>
                  <label class="form-radio-label ml-3">
                    <input class="form-radio-input" type="radio" name="typeDate" id="radioContinua" value="continua">
                    <span class="form-radio-sign">Contínua</span>
                  </label>
                </div>
                <div class="datepicker input-group" id="divCalendarDatepicker" data-provide="datepicker">
                  <!-- Show Caledar DatePicker -->
                </div>
              </div>
              <div class="form-group">
                <label for="selectCashier">Caixa</label>
                <select class="form-control" id="selectCashier" name="id_cash" required>
                  <option value=""></option>
                  <?php
                  foreach ($cashier as $cash) :
                  ?>
                    <option value="<?= $cash->id_cash ?>"><?= $cash->name ?></option>
                  <?php
                  endforeach;
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="inputTitle">Valor Total</label>
                <input type="text" class="form-control" id="inputAmount" name="amount" placeholder="R$" required>
              </div>
            </div>
          </div>
          <div class="card-action">
            <button id="submit" type="submit" class="btn btn-primary">Salvar</button>
          </div>
      </form>
    </div>
  </div>
</div>

<?php $v->start("scripts"); ?>
<script src="<?= asset("js/form.js"); ?>"></script>
<script src="<?= asset("js/plugin/datepicker/jquery.plugin.js"); ?>"></script>
<script src="<?= asset("js/plugin/datepicker/jquery.datepick.min.js"); ?>"></script>
<script src="<?= asset("js/plugin/datepicker/jquery.datepick-pt-BR.js"); ?>"></script>
<script>
  $(document).ready(function() {
    $('#selectTypesIntention').focus();
  });

  $('#submit').click(function() {
    // Recarrega a página atual usando o cache
    // document.location.reload(false);
    $('#selectTypesIntention').focus();
  });

  // Config calendar
  $('#divCalendarDatepicker').datepick({
    altField: '#inputDate',
    multiSeparator: ', ',
    rangeSelect: false,
    multiSelect: 360,
    monthsToShow: [2, 3],
    minDate: 'new Date()'
  });

  // Alter type of select date in datepick
  $('input[name=typeDate]').change(() => {
    if ($('#radioVariadas').is(':checked')) {
      $('#divCalendarDatepicker').datepick('option', {
        rangeSelect: false,
        multiSelect: 360
      });
      $('#divCalendarDatepicker').datepick('setDate', null);
    } else {
      $('#divCalendarDatepicker').datepick('option', {
        rangeSelect: true,
        multiSelect: false
      });
      $('#divCalendarDatepicker').datepick('setDate', null);
    }
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

  // Calc total amount
  $('#inputAmount').click(function() {
    var dates = $('#divCalendarDatepicker').datepick('getDate');
    var quantDates;

    if ($('#radioContinua').is(':checked')) {
      // For select continuo dates
      const DAY = 24 * 60 * 60 * 1000; // Day em miliseconds
      quantDates = ((dates[1] - dates[0]) / DAY) + 1;
    } else {
      // For multi select dates
      quantDates = (dates.length) ? dates.length : '1';
    }

    var price = $('#inputPrice').val();
    var amountTotal = (quantDates * price).toFixed(2);
    $(this).val(converteFloatMoeda(amountTotal));
  });

  function getDataTypeMass(radioTypeMass) {

    var data = $(radioTypeMass).data();

    if (data.date != '')
      $('#inputDate').val(data.date);
    if (data.price != '')
      $('#inputPrice').val(data.price);
  };

  /*@brief Converte uma string em formato moeda para float
    @param valor(string) - o valor em moeda
    @return valor(float) - o valor em float
    */
  function converteMoedaFloat(valor) {

    if (valor === "") {
      valor = 0;
    } else {
      valor = valor.replace(".", "");
      valor = valor.replace(",", ".");
      valor = parseFloat(valor);
    }
    return valor.toFixed(2);
  }

  /*@brief Converte um float em uma string em formato moeda
  @param valor.toFixed(2) - o valor em float
  @return valor(string) - o valor em string
  */
  function converteFloatMoeda(valor) {
    valor = valor.toString().replace(/\D/g, "");
    valor = valor.toString().replace(/(\d)(\d{8})$/, "$1.$2");
    valor = valor.toString().replace(/(\d)(\d{5})$/, "$1.$2");
    valor = valor.toString().replace(/(\d)(\d{2})$/, "$1,$2");
    return valor
  }

  /**@brief Reloads the page to clear and hide fields
   * This function is called by ajax in form.js, if it exists.
   */
  function reLoad() {
    document.location.reload(false); 
  }
</script>
<?php $v->end(); ?>