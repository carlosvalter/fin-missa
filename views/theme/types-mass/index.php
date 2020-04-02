<?php $v->layout("theme/layout"); ?>

<!-- Button -->
<div class="d-flex">
  <a class="btn btn-primary btn-round ml-auto mb-3" href="<?= $router->route("typesmass.new"); ?>">
    <i class="fa fa-plus"></i>
    Adicionar
  </a>
</div>

<div class="table-responsive">
  <table id="datatablesList" class="display table table-striped table-hover" cellspacing="0" width="100%">
    <thead>
      <tr>
        <th>Título</th>
        <th>Horas</th>
        <th>Date</th>
        <th>Preço</th>
        <th>Ação</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <th>Título</th>
        <th>Horas</th>
        <th>Data</th>
        <th>Preço</th>
        <th>Ação</th>
      </tr>
    </tfoot>
    <tbody>
      <?php
      if ($typesMass) :
        foreach ($typesMass as $typeMass) :
      ?>
          <tr <?= (!$typeMass->enable) ? 'style="text-decoration: line-through"' : '' ?>>
            <td id="title_<?= $typeMass->id_type_mass ?>"><?= $typeMass->title ?></td>
            <td id="hour_<?= $typeMass->id_type_mass ?>"><?= substr($typeMass->hour, 0, 5) ?></td>
            <td>
              <?php
              if ($typeMass->date) {
                $data_formatada = DateTime::createFromFormat('Y-m-d', $typeMass->date);
                echo $data_formatada->format('d/m/Y');
              } else {
                echo '---';
              }
              ?>
            </td>
            <td>
              <?= 'R$ ' . number_format($typeMass->price, 2, ',', '.'); ?>
            </td>
            <td>
              <div class="form-button-action">
                <a class="btn btn-link btn-primary btn-lg" href="<?= $router->route("typesmass.update", ["id_type_mass" => $typeMass->id_type_mass]); ?>" data-toggle="tooltip" data-original-title="Editar">
                  <i class="fa fa-edit"></i>
                </a>
                <button class="btn btn-link btn-danger" data-toggle="tooltip" data-original-title="Deletar" onclick="deleteTypeMass(<?= $typeMass->id_type_mass ?>)">
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
        Deseja excluir tipo de missa: <b><span id="typeMassTitle">_____</span></b>?
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
  function deleteTypeMass(id) {
    var title = $("#title_" + id).html();
    var hour = $("#hour_" + id).html();
    $("#typeMassTitle").html(title + " " + hour);
    $('#confirmDelete').modal();
    $('#buttonDelete').attr('href', '<?= $router->route("typesmass.delete", ["id_type_mass" => ""]) ?>' + id);
  }
</script>
<?php $v->end(); ?>