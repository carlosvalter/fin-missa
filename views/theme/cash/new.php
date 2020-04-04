<?php $v->layout("theme/layout"); ?>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="card-title">
          Caixa
        </div>
      </div>
      <form id="form" class="form" action="<?= $router->route("cash.new"); ?>" method="post" autocomplete="off">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
            <div class="form-group">
                <label for="inputName">Nome</label>
                <input type="hidden" name="id_cash" value="<?= $cash->id_cash ?>">
                <input type="text" class="form-control" id="inputName" name="name" placeholder="Nome para o caixa" value="<?= $cash->name ?>" required>
              </div>
              <div class="form-group">
                <label for="inputAmount">Saldo</label>
                <input type="text" class="form-control" id="inputAmount" name="amount" placeholder="Saldo inicial" required>
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