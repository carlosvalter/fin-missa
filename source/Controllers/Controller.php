<?php
// Controller principal

namespace Source\Controllers;

use League\Plates\Engine;
use CoffeeCode\Router\Router;

// abstract, nao podera ser instanciada, somente herdada
/**
 * Class Controller
 * @package Source\Controllers
 */
abstract class Controller
{
  /** @var Engine */
  protected $view;

  /** @var Router */
  protected $router;

  /**
   * __construct
   *
   * @param  $router
   *
   * @return void
   */
  public function __construct($router)
  {
    $this->router = $router;
    // Indica o caminho da view/theme
    $this->view = Engine::create(dirname(__DIR__, 2) . "/views", "php");
    // Envia dados para views
    $this->view->addData(["router" => $this->router]);
  }

  /**
   * ajaxResponse
   *
   * Gerencia as mensagens nos formularios form.js
   * @param  string $param
   * @param  array $value
   *
   * @return string
   */
  public function ajaxResponse(string $param, array $value): string
  {
    return json_encode([$param => $value]);
  }
}
