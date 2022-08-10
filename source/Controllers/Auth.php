<?php

namespace Source\Controllers;

use Source\Models\User as EntityUser;

class Auth extends Controller
{
  public function __construct($router)
  {
    parent::__construct($router);
  }

  public function index(): void
  {
    if (isset($_SESSION["user"])) {
      $user = (new EntityUser())->findById($_SESSION["user"]['id_user']);

      echo $this->view->render("theme/users/index", [
        "title" => "Usuário | " . site("name"),
        "pageTitle" => "Usuário Logado",
        "users" => $user
      ]);
    } else {
      echo $this->view->render("theme/auth/index", [
        "title" => "Login | " . site("name"),
        "pageTitle" => "Login"
      ]);
    }
  }

  public function login(array $data): void
  {
    $login = filter_var($data["login"], FILTER_DEFAULT);
    $passwd = filter_var($data["passwd"], FILTER_DEFAULT);

    if (!$login || !$passwd) {
      notify("warning", "Informe seu usuário e senha para logar");
      $this->router->redirect("auth.index");
      return;
    }

    $user = (new EntityUser())->find("login = :l", "l={$login}")->fetch();
   
    if (!$user || !password_verify($passwd, $user->passwd)) {
      notify("danger", "Usuário ou senha informados não conferem");
      $this->router->redirect("auth.index");
      return;
    }

    // Login OK
    $_SESSION["user"] = [
      'id_user' => $user->id_user,
      'name' => $user->name,
      'level' => $user->level,
    ];
    $this->router->redirect("masses.index");
  }

  public function logout()
  {
    unset($_SESSION["user"]);
    $this->router->redirect("auth.index");
  }
}
