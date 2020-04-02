<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

/**
 * Class User
 * @package Source\Models
 */
class User extends DataLayer
{
  /**
   * __construct
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct("users", ["name", "login", "passwd", "level"], "id_user");
  }

  public function save(): bool
  {
    if (
      !$this->validateLogin()
      || !$this->validatePassword()
      || !parent::save()
    ) {
      return false;
    }

    return true;
  }

  /**
   * validateEmail
   *
   * @return bool
   */
  public function validateLogin(): bool
  {
    $userByLogin = null;
    // Verifica se eh um create ou update
    if (!$this->id_user) {
      $userByLogin = $this->find("login = :login", "login={$this->login}")->count();
    } else {
      $userByLogin = $this->find("login = :login AND id_user != :id_user", "login={$this->login}&id_user={$this->id_user}")->count();
    }

    if($userByLogin) {
      notify("warning", "Usuário já existe!");
      return false;
    }

    return true;
  }

  /**
   * validatePassword
   *
   * @return bool
   */
  public function validatePassword(): bool
  {
    if(empty($this->passwd) || strlen($this->passwd) < 5){
      notify("warning", "Informe uma senha com pelo menos 5 caracteres");
      return false;
    }

    // Analise se ja eh uma criptografia, em caso de esta editando um usuario nao precisa esta alterando a senha
    if(password_get_info($this->passwd)["algo"]){
      return true;
    }

    // Criptografa a senha
    $this->passwd = password_hash($this->passwd, PASSWORD_DEFAULT);
    return true;
  }
}
