<?php

namespace Source\Controllers;

use Source\Models\TypeMass as EntityTypeMass;

class TypesMass extends Controller
{
  public function __construct($router)
  {
    if (!array_key_exists('user', $_SESSION) || $_SESSION['user']['level'] > 2)
      $router->redirect("auth.logout");
    parent::__construct($router);
  }

  public function index(): void
  {
    $typesMass = (new EntityTypeMass())->find()->fetch(true);

    echo $this->view->render("theme/types-mass/index", [
      "title" => "Tipos de Missa | " . site("name"),
      "pageTitle" => "Tipos de Missas",
      "typesMass" => $typesMass
    ]);
  }

  public function new(array $data): void
  {

    if (!empty($data)) {
      // Remove codigos de scripts do form
      $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

      // Verifica se tem algum campo do form em branco
      if ($data["title"] == "" || $data["hour"] == "") {
        echo $this->ajaxResponse("message", [
          "type" => "warning",
          "message" => "Preencha todos os campos para cadastrar!"
        ]);
        return;
      }

      if (empty($data['id_type_mass'])) {
        // New register
        $typeMass = new EntityTypeMass();
      } else {
        // Update register
        $typeMass = (new EntityTypeMass())->findById($data['id_type_mass']);
      }

      // convert Brazilian currency to DB decimal
      $data['price'] = str_replace('.', '', $data['price']);
      $data['price'] = str_replace(',', '.', $data['price']);

      $typeMass->title = $data['title'];
      $typeMass->hour = $data['hour'];
      $typeMass->mass_special = $data['typeMass'];
      $typeMass->price = $data['price'];
      $typeMass->enable = (array_key_exists('enable', $data)) ? $data['enable'] : '0';
      $typeMass->date = ($data['date'] !== '') ? $data['date'] : NULL;

      if ($typeMass->save()) {
        // Receive by ajax
        if (!empty($data['id_type_mass'])) {
          // Update register
          notify("success", "Registro gravado com sucesso!");
          echo $this->ajaxResponse("redirect", [
            "url" => $this->router->route('typesmass.index')
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
        if (!empty($data['id_type_mass'])) {
          // Update register
          notify("danger", "Erro na gravação! \n" . $typeMass->fail()->getMessage());
          echo $this->ajaxResponse("redirect", [
            "url" => $this->router->route('typesmass.index')
          ]);
        } else {
          // New register
          echo $this->ajaxResponse("message", [
            "type" => "danger",
            "message" => "Erro na gravação! \n" . $typeMass->fail()->getMessage()
          ]);
          return;
        }
      }
    } else {
      echo $this->view->render("theme/types-mass/new", [
        "title" => "Tipos de Missa | " . site("name"),
        "pageTitle" => "Cadastrar Tipos de Missas",
        "typeMass" => (new EntityTypeMass()),
        "update" => false
      ]);
    }
  }

  public function update(array $data): void
  {
    // Use function new() for salve form updating
    $typeMass = (new EntityTypeMass())->findById($data['id_type_mass']);

    if ($typeMass) {
      echo $this->view->render("theme/types-mass/new", [
        "title" => "Tipos de Missas | " . site("name"),
        "pageTitle" => "Editar Tipos de Missas",
        "typeMass" => $typeMass,
        "update" => true
      ]);
    } else {
      notify("warning", "Registro não encontrado!");
      $this->router->redirect('typesmass.index');
    }
  }

  public function delete(array $data): void
  {
    $typeMass = (new EntityTypeMass())->findById($data['id_type_mass']);

    if ($typeMass->destroy()) {
      notify("success", "Registro apagado com sucesso!");
    } else {
      notify("danger", "Erro na exclusão! \n" . $typeMass->fail()->getMessage());
    }

    $this->router->redirect('typesmass.index');
  }
}
