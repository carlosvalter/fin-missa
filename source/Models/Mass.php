<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class Mass extends DataLayer
{

  public function __construct()
  {
    parent::__construct("masses", ["id_type_mass", "id_type_intention", "id_cash", "faithful", "date"], "id_mass");
  }

  public function add(TypeMass $typeMass, TypeIntention $typeIntention, Cash $cash): Mass
  {
    $this->id_type_mass = $typeMass->id_type_mass;
    $this->id_type_intention = $typeIntention->id_type_intention;
    $this->id_cash = $cash->id_cash;

    return $this;
  }

  public function getTypeIntention(): TypeIntention
  {
    return (new TypeIntention)->find("id_type_intention = :id", "id={$this->id_type_intention}")->fetch(false);
  }

  public function getTypeMass(): TypeMass
  {
    return (new TypeMass)->find("id_type_mass = :id", "id={$this->id_type_mass}")->fetch(false);
  }

  public function getCash(): Cash
  {
    return (new Cash)->find("id_cash = :id", "id={$this->id_cash}")->fetch(false);
  }

  public function save(): bool
  {
    if (empty($this->id_type_mass) | empty($this->id_type_intention) | empty($this->id_cash) | empty($this->faithful) | empty($this->date) | !parent::save()) {
      return false;
    } else {
      return true;
    }
  }
}
