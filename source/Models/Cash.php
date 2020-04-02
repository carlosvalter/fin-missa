<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class Cash extends DataLayer
{
  public function __construct()
  {
    parent::__construct("cash", ["name", "amount"], "id_cash");
  }

  /**
   * masses find mass foreigh key
   *
   * @return Mass
   */
  public function masses(): Mass
  {
    return (new Mass)->find("id_cash = :id", "id={$this->id_cash}")->fetch(true);
  }

  public function save(): bool
  {
    if (empty($this->name) | empty($this->amount) | !parent::save()) {
      return false;
    } else {
      return true;
    }
  }
}
