<?php $v->layout("theme/layout"); ?>

<!-- Button -->
<div class="d-flex">
  <a class="btn btn-primary btn-round ml-auto mb-3" href="<?= $router->route("cash.new"); ?>">
    <i class="fa fa-plus"></i>
    Adicionar
  </a>
</div>

<div class="table-responsive">
  <table id="datatablesList" class="display table table-striped table-hover" cellspacing="0" width="100%">
    <thead>
      <tr>
        <th>Nome</th>
        <th>Saldo</th>
        <th>Ação</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <th>Nome</th>
        <th>Saldo</th>
        <th>Ação</th>
      </tr>
    </tfoot>
    <tbody>
      <?php
      if ($cashFlow) :
        foreach ($cashFlow as $cash) :
      ?>
          <tr>
            <td><?= $cash->name ?></td>
            <td>
              <?php
              $classAmount = ($cash->amount < 0.0) ? 'text-danger' : 'text-info';
              ?>
              <span class="<?= $classAmount ?>"><?= 'R$ ' . number_format($cash->amount, 2, ',', '.'); ?></span>
            </td>
            <td>
              <div class="form-button-action">
                <a class="btn btn-link btn-primary btn-lg disabled" href="<?= $router->route("cash.update", ["id_cash" => $cash->id_cash]); ?>" data-toggle="tooltip" data-original-title="Editar">
                  <i class="fa fa-edit"></i>
                </a>
                <a class="btn btn-link btn-primary btn-lg" href="<?= $router->route("cash.withdraw", ["id_cash" => $cash->id_cash]); ?>" data-toggle="tooltip" data-original-title="Retirar">
                  <i class="fa fa-hand-holding-usd"></i>
                </a>
              </div>
            </td>
          </tr>
      <?php
        endforeach;
      endif;
      ?>
    </tbody>
  </table>
</div>

<?php $v->start("scripts"); ?>
<?php $v->end(); ?>