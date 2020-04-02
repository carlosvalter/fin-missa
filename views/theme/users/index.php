<?php $v->layout("theme/layout"); ?>

<!-- Button -->
<div class="d-flex">
  <a class="btn btn-primary btn-round ml-auto mb-3" href="<?= $router->route("users.new"); ?>">
    <i class="fa fa-plus"></i>
    Adicionar
  </a>
</div>

<div class="table-responsive">
  <table id="datatablesList" class="display table table-striped table-hover" cellspacing="0" width="100%">
    <thead>
      <tr>
        <th>Nome</th>
        <th>Login</th>
        <th>Nível</th>
        <th>Ação</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <th>Nome</th>
        <th>Login</th>
        <th>Nível</th>
        <th>Ação</th>
      </tr>
    </tfoot>
    <tbody>
      <?php
      if ($users) :
        foreach ($users as $user) :
      ?>
          <tr>
            <td id="name_<?= $user->id_user ?>"><?= $user->name ?></td>
            <td id="login_<?= $user->id_user ?>"><?= $user->login ?></td>
            <td>
              <?php
              switch ($user->level) {
                case '1':
                  echo "Padre";
                  break;
                case '2':
                  echo "Secretária";
                  break;
                default:
                  echo "INEXISTENTE";
                  break;
              }
              ?>
            </td>
            <td>
              <div class="form-button-action">
                <a class="btn btn-link btn-primary btn-lg" href="<?= $router->route("users.update", ["id_user" => $user->id_user]); ?>" data-toggle="tooltip" data-original-title="Editar">
                  <i class="fa fa-edit"></i>
                </a>
                <button class="btn btn-link btn-danger" data-toggle="tooltip" data-original-title="Deletar" onclick="deleteUser(<?= $user->id_user ?>)">
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
        Deseja excluir usuário: <b><span id="userName">_____</span></b>?
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
  function deleteUser(id) {
    var name = $("#name_" + id).html();
    $("#userName").html(name);
    $('#confirmDelete').modal();
    $('#buttonDelete').attr('href', '<?= $router->route("users.delete", ["id_user" => ""]) ?>' + id);
  }
</script>
<?php $v->end(); ?>