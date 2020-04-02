<?php

/**
 * SITE CONFIG
 */
define("SITE", [
  "name" => "Sistema Financeiro | Missa",
  "desc" => "Controle financeiro de pedidos de intensão da santa missa, doações e apadrinhamento de seminaristas.",
  "domain" => "fin-missa.santuariosetelagoas.com.br",
  "locale" => "pt_BR",
  "root" => "http://localhost/fin-missa"
  // "root" => "http://192.168.25.10/fin-missa"
]);

/**
 * SITE MINIFY
 */
// So faco o minify em minha maquina
if($_SERVER["SERVER_NAME"] == "localhost"){
  require __DIR__."/Minify.php";
}

/**
 * DATABASE CONECTION
 */
define("DATA_LAYER_CONFIG", [
  "driver" => "mysql",
  "host" => "127.0.0.1",
  "port" => "3306",
  "dbname" => "fin_missa",
  "username" => "root",
  "passwd" => "tiger",
  "options" => [
      PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
      PDO::ATTR_CASE => PDO::CASE_NATURAL
  ]
]);

