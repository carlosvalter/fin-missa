<?php

namespace Source\Controllers;

class Web extends Controller
{
  public function __construct($router)
  {
    parent::__construct($router);

    // Verifica se o usuario esta logado
    // if (!empty($_SESSION["user"])) {
    //   $this->router->redirect("app.home");
    // }
  }

  public function login(): void
  {

    // Irá preencher a <head> da pagina (_theme.php), com paramentro para o Google SEO
    $head = $this->seo->optimize(
      "Faça login para continuar " . site("name"),
      site("desc"),
      $this->router->route("web.login"),
      routeImage("Login")
    )->render();

    // template: views/theme
    echo $this->view->render("theme/login", [
      "head" => $head
    ]);
  }

  public function register(): void
  {
    $head = $this->seo->optimize(
      "Crie sua conta no " . site("name"),
      site("desc"),
      $this->router->route("web.register"),
      routeImage("register")
    )->render();

    // Cria uma classe stand sem nada
    $form_user = new \stdClass();
    $form_user->first_name = null;
    $form_user->last_name = null;
    $form_user->email = null;

    // template: views/theme
    echo $this->view->render("theme/register", [
      "head" => $head,
      "user" => $form_user
    ]);
  }

  public function forget(): void
  {
    $head = $this->seo->optimize(
      "Recupere sua senha | " . site("name"),
      site("desc"),
      $this->router->route("web.forget"),
      routeImage("forget")
    )->render();

    // template: views/theme
    echo $this->view->render("theme/forget", [
      "head" => $head,
    ]);
  }

  public function reset($data): void
  {
    $head = $this->seo->optimize(
      "Crie sua nova senha | " . site("name"),
      site("desc"),
      $this->router->route("web.reset"),
      routeImage("Reset")
    )->render();

    // template: views/theme
    echo $this->view->render("theme/reset", [
      "head" => $head,
    ]);
  }

  public function error($data): void
  {
    $error = filter_var($data["errcode"], FILTER_VALIDATE_INT);

    // $head = $this->seo->optimize(
    //   "Oooops {$error} | " . site("name"),
    //   site("desc"),
    //   $this->router->route("web.error", ["errcode" => $error]),
    //   routeImage($error)
    // )->render();

    $title = "Oooops {$error} | " . site("name");

    // template: views/theme
    echo $this->view->render("theme/error", [
      "title" => $title,
      "pageTitle" => "Erro {$error}",
      "error" => $error
    ]);
  }
}
