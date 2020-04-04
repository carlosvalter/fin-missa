<?php $v->layout("theme/layout"); ?>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="card-title">
          Caixa <?= $cash->name ?>
        </div>
      </div>
      <form id="form" class="form" action="<?= $router->route("cash.withdrawNew"); ?>" method="post" autocomplete="off">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <?php
                $classAmount = ($cash->amount < 0.0) ? 'text-danger' : 'text-info';
                ?>
                <h3>Saldo: <span class="<?= $classAmount ?> fw-bold"><?= 'R$ ' . number_format($cash->amount, 2, ',', '.'); ?></span></h3>
              </div>
              <div class="form-group">
                <label for="inputWithdraw">Retirar</label>
                <input type="hidden" name="id_cash" value="<?= $cash->id_cash ?>">
                <input type="text" class="form-control" id="inputWithdraw" name="withdraw" placeholder="Valor para retirar do caixa" required>
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
<?php $v->end(); ?>