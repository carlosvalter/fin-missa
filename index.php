<?php
// controle de cache
ob_start();
// Inicia sessao
session_start();

require __DIR__ . "/vendor/autoload.php";

use CoffeeCode\Router\Router;

// site() eh um Helper
$router = new Router(site());
// Indica o namespace padrao para os controladores
$router->namespace("Source\Controllers");

/**
 * Camada: AUTH
 */
$router->group(null);
$router->get("/", "Auth:index", "auth.index");
$router->post("/login", "Auth:login", "auth.login");
$router->get("/logout", "Auth:logout", "auth.logout");


/**
 * USERS
 */
$router->group("usuarios");
$router->get("/", "Users:index", "users.index");
$router->get("/cadastrar", "Users:new", "users.new");
$router->post("/cadastrar", "Users:new", "users.new");
$router->get("/deletar/{id_user}", "Users:delete", "users.delete");
$router->get("/editar/{id_user}", "Users:update", "users.update");

/**
 * TYPESMASS
 */
$router->group("tiposmissa");
$router->get("/", "TypesMass:index", "typesmass.index");
$router->get("/cadastrar", "TypesMass:new", "typesmass.new");
$router->post("/cadastrar", "TypesMass:new", "typesmass.new");
$router->get("/deletar/{id_type_mass}", "TypesMass:delete", "typesmass.delete");
$router->get("/editar/{id_type_mass}", "TypesMass:update", "typesmass.update");

/**
 * TYPESINTENTION
 */
$router->group("tiposintencoes");
$router->get("/", "TypesIntention:index", "typesintention.index");
$router->get("/cadastrar", "TypesIntention:new", "typesintention.new");
$router->post("/cadastrar", "TypesIntention:new", "typesintention.new");
$router->get("/deletar/{id_type_intention}", "TypesIntention:delete", "typesintention.delete");
$router->get("/editar/{id_type_intention}", "TypesIntention:update", "typesintention.update");

/**
 * MASSES
 */
$router->group("missas");
$router->get("/", "Masses:index", "masses.index");
$router->get("/cadastrar", "Masses:new", "masses.new");
$router->post("/cadastrar", "Masses:new", "masses.new");
$router->get("/deletar/{id_mass}", "Masses:delete", "masses.delete");
$router->post("/ajaxtiposmissa", "Masses:ajaxTypesMass", "masses.ajaxTypesMass");
$router->get("/relatorio", "Masses:report", "masses.report");
$router->post("/relatorio", "Masses:report", "masses.report");

/**
 * CASH
 */
$router->group("caixa");
$router->get("/", "Cash:index", "cash.index");
$router->get("/cadastrar", "Cash:new", "cash.new");
$router->post("/cadastrar", "Cash:new", "cash.new");
$router->get("/deletar/{id_cash}", "Cash:delete", "cash.delete");
$router->get("/editar/{id_cash}", "Cash:update", "cash.update");
$router->get("/retirar/{id_cash}", "Cash:withdraw", "cash.withdraw");
$router->post("/retirar", "Cash:withdrawNew", "cash.withdrawNew");
$router->get("/relatorio", "Cash:reportCashMovement", "cash.reportCashMovement");
$router->post("/relatorio", "Cash:reportCashMovement", "cash.reportCashMovement");


/**
 * Camada: WEB
 */
// $router->group(null);
// web.login eh um atalho para poder acessar em outros lugares da aplicacao
// $router->get("/", "Web:login", "web.login");
// $router->get("/cadastrar", "Web:register", "web.register");
// $router->get("/recuperar", "Web:forget", "web.forget");
// $router->get("/senha/{email}/{forget}", "Web:reset", "web.reset");

/**
 * Camada: ERRORS
 */
$router->group("ops");
$router->get("/{errcode}", "Web:error", "web.error");

/**
 * Camada: ROUTE PROCESS
 * Executa as rotas configuradas acima
 */

$router->dispatch();

/**
 * Camada: ERRORS PROCESS
 */
if($router->error()){
  $router->redirect("web.error", ["errcode" => $router->error()]);
}

ob_end_flush();
