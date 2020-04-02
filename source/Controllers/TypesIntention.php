<?php

namespace Source\Controllers;

use Source\Models\TypeIntention as EntityTypeIntention;

class TypesIntention extends Controller
{
  public function __construct($router)
  {
    if (!array_key_exists('user', $_SESSION) || $_SESSION['user']['level'] != 1)
      $router->redirect("auth.logout");
    parent::__construct($router);
  }

  public function index(): void
  {
    $typesIntention = (new EntityTypeIntention())->find()->fetch(true);

    echo $this->view->render("theme/types-intention/index", [
      "title" => "Tipos de Intenções | " . site("name"),
      "pageTitle" => "Tipos de Intenções",
      "typesIntention" => $typesIntention
    ]);
  }

  public function new(array $data): void
  {

    if (!empty($data)) {
      // Remove codigos de scripts do form
      $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

      // Verifica se tem algum campo do form em branco
      if ($data["title"] == "") {
        echo $this->ajaxResponse("message", [
          "type" => "warning",
          "message" => "Preencha todos os campos para cadastra-se!"
        ]);
        return;
      }

      if (empty($data['id_type_intention'])) {
        // New register
        $typeIntention = new EntityTypeIntention();
      } else {
        // Update register
        $typeIntention = (new EntityTypeIntention())->findById($data['id_type_intention']);
      }

      $typeIntention->title = $data['title'];

      if ($typeIntention->save()) {
        // Receive by ajax
        if (!empty($data['id_type_intention'])) {
          // Update register
          notify("success", "Registro gravado com sucesso!");
          echo $this->ajaxResponse("redirect", [
            "url" => $this->router->route('typesintention.index')
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
        if (!empty($data['id_type_intention'])) {
          // Update register
          notify("danger", "Erro na gravação! \n" . $typeIntention->fail()->getMessage());
          echo $this->ajaxResponse("redirect", [
            "url" => $this->router->route('typesintention.index')
          ]);
        } else {
          // New register
          echo $this->ajaxResponse("message", [
            "type" => "danger",
            "message" => "Erro na gravação! \n" . $typeIntention->fail()->getMessage()
          ]);
          return;
        }
      }
    } else {
      echo $this->view->render("theme/types-intention/new", [
        "title" => "Tipos de Intenções | " . site("name"),
        "pageTitle" => "Cadastrar Tipos de Intenções",
        "typeIntention" => (new EntityTypeIntention())
      ]);
    }
  }

  public function update(array $data): void
  {
    // Use function new() for salve form updating
    $typeIntention = (new EntityTypeIntention())->findById($data['id_type_intention']);

    if ($typeIntention) {
      echo $this->view->render("theme/types-intention/new", [
        "title" => "Tipos de Intenções | " . site("name"),
        "pageTitle" => "Editar Tipos de Intenções",
        "typeIntention" => $typeIntention
      ]);
    } else {
      notify("warning", "Registro não encontrado!");
      $this->router->redirect('typesintention.index');
    }
  }

  public function delete(array $data): void
  {
    $typeIntention = (new EntityTypeIntention())->findById($data['id_type_intention']);

    if ($typeIntention->destroy()) {
      notify("success", "Registro apagado com sucesso!");
    } else {
      notify("danger", "Erro na exclusão! \n" . $typeIntention->fail()->getMessage());
    }

    $this->router->redirect('typesintention.index');
  }
}
