<?php $v->layout("theme/layout"); ?>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <div class="card-title">
          Usuários
        </div>
      </div>
      <form id="form" class="form" action="<?= $router->route("users.new"); ?>" method="post" autocomplete="off">
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="inputName">Nome</label>
                <input type="hidden" name="id_user" value="<?= $user->id_user ?>">
                <input type="text" class="form-control" id="inputName" name="name" placeholder="Nome do usuário" value="<?= $user->name ?>">
              </div>
              <div class="form-group">
                <label for="inputLogin">Login</label>
                <input type="text" class="form-control" id="inputLogin" name="login" value="<?= $user->login ?>">
              </div>
              <div class="form-group">
                <label for="inputPasswd">Senha</label>
                <input type="password" class="form-control" id="inputPasswd" name="passwd" value="<?= $user->passwd ?>">
              </div>
              <div class="form-check">
                <label>Nível</label><br>
                <label class="form-radio-label">
                  <input class="form-radio-input" type="radio" name="level" value="1" <?= ($user->level === "1") ? "checked" : "" ?>>
                  <span class="form-radio-sign">Padre</span>
                </label>
                <label class="form-radio-label ml-3">
                  <input class="form-radio-input" type="radio" name="level" value="2" <?= ($user->level === "2") ? "checked" : "" ?>>
                  <span class="form-radio-sign">Secretária</span>
                </label>
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