<?php

namespace Source\Controllers;

use Source\Models\User as EntityUser;

class Users extends Controller
{
  public function __construct($router)
  {
    if (!array_key_exists('user', $_SESSION) || $_SESSION['user']['level'] != 1)
      $router->redirect("auth.logout");
    parent::__construct($router);
  }

  public function index(): void
  {
    $users = (new EntityUser())->find()->fetch(true);

    echo $this->view->render("theme/users/index", [
      "title" => "Usuários | " . site("name"),
      "pageTitle" => "Usuários",
      "users" => $users
    ]);
  }

  public function new(array $data): void
  {

    if (!empty($data)) {
      // Remove codigos de scripts do form
      $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

      // Verifica se tem algum campo do form em branco
      if ($data["name"] == "" || $data["login"] == "" || $data["passwd"] == "" || $data["level"] == "") {
        echo $this->ajaxResponse("message", [
          "type" => "warning",
          "message" => "Preencha os campos obrigatórios para cadastra-se!"
        ]);
        return;
      }

      if (empty($data['id_user'])) {
        // New register
        $user = new EntityUser();
      } else {
        // Update register
        $user = (new EntityUser())->findById($data['id_user']);
      }

      $user->name = $data['name'];
      $user->login = $data['login'];
      $user->passwd = $data["passwd"];
      $user->level = $data['level'];

      if ($user->save()) {
        // Receive by ajax
        if (!empty($data['id_user'])) {
          // Update register
          notify("success", "Registro gravado com sucesso!");
          echo $this->ajaxResponse("redirect", [
            "url" => $this->router->route('users.index')
          ]);
        } else {
          // New register
          echo $this->ajaxResponse("message", [
            "type" => "success",
            "message" => "Registro gravado com sucesso!"
          ]);
          return;
        }
      } else {
        echo $this->ajaxResponse("message", [
          "type" => $_SESSION["notify"]["type"],
          "message" => $_SESSION["notify"]["message"]
        ]);
        unset($_SESSION["notify"]);
        return;
      }
    } else {
      echo $this->view->render("theme/users/new", [
        "title" => "Usuários | " . site("name"),
        "pageTitle" => "Cadastrar Usuários",
        "user" => (new EntityUser())
      ]);
    }
  }

  public function update(array $data): void
  {
    // Use function new() for salve form updating
    $user = (new EntityUser())->findById($data['id_user']);

    if ($user) {
      echo $this->view->render("theme/users/new", [
        "title" => "Usuários | " . site("name"),
        "pageTitle" => "Editar Usuários",
        "user" => $user
      ]);
    } else {
      notify("warning", "Registro não encontrado!");
      $this->router->redirect('users.index');
    }
  }

  public function delete(array $data): void
  {
    $user = (new EntityUser())->findById($data['id_user']);

    if ($user->destroy()) {
      notify("success", "Registro apagado com sucesso!");
    } else {
      notify("danger", "Erro na exclusão! \n" . $user->fail()->getMessage());
    }

    $this->router->redirect('users.index');
  }
}
