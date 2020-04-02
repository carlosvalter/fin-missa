<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class TypeIntention extends DataLayer
{
  public function __construct()
  {
    parent::__construct("typesIntention", ["title"], "id_type_intention");
  }

  /**
   * masses find mass foreigh key
   *
   * @return Mass
   */
  public function masses(): Mass
  {
    return (new Mass)->find("id_type_intention = :id", "id={$this->id_type_intention}")->fetch(true);
  }

  public function save(): bool
  {
    if (empty($this->title) | !parent::save()) {
      return false;
    } else {
      return true;
    }
  }
}
