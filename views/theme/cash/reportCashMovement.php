<?php $v->layout("theme/layout"); ?>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="card-title">
          Relatório de Movimento de Caixa
        </div>
      </div>
      <form id="form" class="form" action="<?= $router->route("cash.reportCashMovement"); ?>" method="post" autocomplete="off" target="_blank">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="inputDate">Data do caixa</label>
                <input type="text" class="form-control" id="inputDate" name="created_at" required>
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

</script>
<?php $v->end(); ?>