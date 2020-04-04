<?php

namespace Source\Controllers;

use Source\Models\Cash as EntityCash;

class Cash extends Controller
{
  public function __construct($router)
  {
    if (!array_key_exists('user', $_SESSION) || $_SESSION['user']['level'] != 1)
      $router->redirect("auth.logout");
    parent::__construct($router);
  }

  public function index(): void
  {
    $cashFlow = (new EntityCash())->find()->fetch(true);

    echo $this->view->render("theme/cash/index", [
      "title" => "Caixa | " . site("name"),
      "pageTitle" => "Caixa",
      "cashFlow" => $cashFlow
    ]);
  }

  public function new(array $data): void
  {

    if (!empty($data)) {
      // Remove codigos de scripts do form
      $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

      // Verifica se tem algum campo do form em branco
      if ($data["name"] == "" || $data["amount"] == "") {
        echo $this->ajaxResponse("message", [
          "type" => "warning",
          "message" => "Preencha todos os campos para cadastra-se!"
        ]);
        return;
      }

      if (empty($data['id_cash'])) {
        // New register
        $cash = new EntityCash();
      } else {
        // Update register
        $cash = (new EntityCash())->findById($data['id_cash']);
      }

      $cash->name = $data['name'];
      $cash->amount = ($data['amount']) ? convertToCurrencyDB($data['amount']) : '0.00';

      if ($cash->save()) {
        // Receive by ajax
        if (!empty($data['id_cash'])) {
          // Update register
          notify("success", "Registro gravado com sucesso!");
          echo $this->ajaxResponse("redirect", [
            "url" => $this->router->route('cash.index')
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
        if (!empty($data['id_cash'])) {
          // Update register
          notify("danger", "Erro na gravação! \n" . $cash->fail()->getMessage());
          echo $this->ajaxResponse("redirect", [
            "url" => $this->router->route('cash.index')
          ]);
        } else {
          // New register
          echo $this->ajaxResponse("message", [
            "type" => "danger",
            "message" => "Erro na gravação! \n" . $cash->fail()->getMessage()
          ]);
          return;
        }
      }
    } else {
      echo $this->view->render("theme/cash/new", [
        "title" => "Caixa | " . site("name"),
        "pageTitle" => "Cadastrar Caixa",
        "cash" => (new EntityCash())
      ]);
    }
  }

  public function withdraw(array $data): void
  {
    $cash = (new EntityCash())->findById($data['id_cash']);

    if (array_key_exists('withdraw', $data)) {
      $cash->amount -= convertToCurrencyDB($data['withdraw']);

      if ($cash->save()) {
        // Receive by ajax
        notify("success", "Registro gravado com sucesso!");
        echo $this->ajaxResponse("redirect", [
          "url" => $this->router->route('cash.index')
        ]);
      }
    } else {
      if ($cash) {
        echo $this->view->render("theme/cash/withdraw", [
          "title" => "Retirar do Caixa | " . site("name"),
          "pageTitle" => "Retirar do Caixa",
          "cash" => $cash
        ]);
      } else {
        notify("warning", "Registro não encontrado!");
        $this->router->redirect('cash.index');
      }
    }
  }

  public function withdrawNew(array $data): void
  {
    $this->withdraw($data);
  }

  public function delete(array $data): void
  {
    $cash = (new EntityCash())->findById($data['id_cash']);

    if ($cash->destroy()) {
      notify("success", "Registro apagado com sucesso!");
    } else {
      notify("danger", "Erro na exclusão! \n" . $cash->fail()->getMessage());
    }

    $this->router->redirect('cash.index');
  }
}
