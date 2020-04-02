<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class TypeMass extends DataLayer
{
  public function __construct()
  {
    parent::__construct("typesMass", ["title", "hour"], "id_type_mass");
  }

  /**
   * masses find mass foreigh key
   *
   * @return Mass
   */
  public function masses(): Mass
  {
    return (new Mass)->find("id_type_mass = :id", "id={$this->id_type_mass}")->fetch(true);
  }

  public function save(): bool
  {
    if (empty($this->title) | empty($this->hour) | !parent::save()) {
      return false;
    } else {
      return true;
    }
  }
}
