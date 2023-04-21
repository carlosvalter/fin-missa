<?php $v->layout("theme/layout"); ?>

<!-- Button -->
<div class="d-flex">
  <a class="btn btn-primary btn-round ml-auto mb-3" href="<?= $router->route("typesintention.new"); ?>">
    <i class="fa fa-plus"></i>
    Adicionar
  </a>
</div>

<div class="table-responsive">
  <table id="datatablesList" class="display table table-striped table-hover" cellspacing="0" width="100%">
    <thead>
      <tr>
        <th>Título</th>
        <th>Linhas em Branco</th>
        <th>Ação</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <th>Título</th>
        <th>Linhas em Branco</th>
        <th>Ação</th>
      </tr>
    </tfoot>
    <tbody>
      <?php
      if ($typesIntention) :
        foreach ($typesIntention as $typeIntention) :
      ?>
          <tr>
            <td id="title_<?= $typeIntention->id_type_intention ?>"><?= $typeIntention->title ?></td>
            <td id="empty_lines_<?= $typeIntention->id_type_intention ?>"><?= $typeIntention->empty_lines ?></td>
            <td>
              <div class="form-button-action">
                <a class="btn btn-link btn-primary btn-lg" href="<?= $router->route("typesintention.update", ["id_type_intention" => $typeIntention->id_type_intention]); ?>" data-toggle="tooltip" data-original-title="Editar">
                  <i class="fa fa-edit"></i>
                </a>
                <button class="btn btn-link btn-danger" data-toggle="tooltip" data-original-title="Deletar" onclick="deleteTypeIntention(<?= $typeIntention->id_type_intention ?>)">
                  <i class="fa fa-times"></i>
                </button>
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

<!-- Modal -->
<div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="modalConfirmDeleteTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><b>Confirma Exclusão</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Deseja excluir tipo de intenção: <b><span id="typeIntentionTitle">_____</span></b>?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <a id="buttonDelete" class="btn btn-primary" href="">Excluir</a>
      </div>
    </div>
  </div>
</div>

<?php $v->start("scripts"); ?>
<script>
  function deleteTypeIntention(id) {
    var title = $("#title_" + id).html();
    $("#typeIntentionTitle").html(title);
    $('#confirmDelete').modal();
    $('#buttonDelete').attr('href', '<?= $router->route("typesintention.delete", ["id_type_intention" => ""]) ?>' + id);
  }
</script>
<?php $v->end(); ?>