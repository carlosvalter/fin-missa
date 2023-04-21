<?php $v->layout("theme/layout"); ?>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="card-title">
          Tipos de Intenções
        </div>
      </div>
      <form id="form" class="form" action="<?= $router->route("typesintention.new"); ?>" method="post" autocomplete="off">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="inputTitle">Título</label>
                <input type="hidden" name="id_type_intention" value="<?= $typeIntention->id_type_intention ?>">
                <input type="text" class="form-control" id="inputTitle" name="title" placeholder="Título da intenção" value="<?= $typeIntention->title ?>">
              </div>
              <div class="form-group">
                <label for="inputEmptyLines">Linhas em branco</label>
                <input type="text" class="form-control" id="inputEmptyLines" name="empty_lines" placeholder="Quantidade de linhas em branco no relatório" value="<?= $typeIntention->empty_lines ?>">
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