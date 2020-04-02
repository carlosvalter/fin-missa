<?php $v->layout("theme/layout"); ?>

<!-- Button -->
<div class="d-flex">
  <a class="btn btn-primary btn-round ml-auto mb-3" href="<?= $router->route("masses.new"); ?>">
    <i class="fa fa-plus"></i>
    Adicionar
  </a>
</div>

<div class="table-responsive">
  <table id="datatablesList" class="display table table-striped table-hover" cellspacing="0" width="100%">
    <thead>
      <tr>
        <th>Data</th>
        <th>Intenção</th>
        <th>Fiel</th>
        <th>Ação</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <th>Data</th>
        <th>Intenção</th>
        <th>Fiel</th>
        <th>Ação</th>
      </tr>
    </tfoot>
    <tbody>
      <?php
      if ($masses) :
        foreach ($masses as $key => $mass) :
      ?>
          <tr>
            <td id="date_<?= $mass->id_mass ?>" data-order="<?= $key ?>" style="white-space: nowrap;">
              <?php
              $data_formatada = DateTime::createFromFormat('Y-m-d', $mass->date);
              echo $data_formatada->format('d/m/Y');
              echo " - " . substr($mass->getTypeMass()->hour, 0, 5);
              ?>
            </td>
            <td>
              <?php
              $contentPopover = $mass->getTypeMass()->title . ' - ' . substr($mass->getTypeMass()->hour, 0, 5);
              $price = number_format(floatval($mass->getTypeMass()->price), 2, ',', '.');
              $contentPopover .= ($price) ? " - R$ {$price}" : '';
              ?>
              <button class="badge badge-info" data-toggle="popover" data-container="body" data-placement="top" data-content="<?= $contentPopover ?>" data-original-title="Missa">
                Info
              </button>
              <?= $mass->getTypeIntention()->title ?>
            </td>
            <td id="faithful_<?= $mass->id_mass ?>"><?= $mass->faithful ?></td>
            <td>
              <div class="form-button-action">
                <button class="btn btn-link btn-danger" data-toggle="tooltip" data-original-title="Deletar" onclick="deleteMass(<?= $mass->id_mass ?>)">
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
<div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="modalConfirmDeleteFaithful" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><b>Confirma Exclusão</b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Deseja excluir o pedido de: <b><span id="massFaithful">_____</span></b>?
        <p></p>
        <div class="alert alert-danger" role="alert">
          Esse valor será retirado do caixa!
        </div>
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
  function deleteMass(id) {
    var faithful = $("#faithful_" + id).html();
    var date = $("#date_" + id).html();

    $("#massFaithful").html(faithful + ' em ' + date);
    $('#confirmDelete').modal();
    $('#buttonDelete').attr('href', '<?= $router->route("masses.delete", ["id_mass" => ""]) ?>' + id);
  }

  $(document).ready(function() {
    $('#buttonMenu').trigger('click');
  });
</script>
<?php $v->end(); ?>