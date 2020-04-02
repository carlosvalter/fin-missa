<?php

/**
 * site
 *
 * @param  string|null $param
 * 
 * @return string
 */
function site(string $param = null): string
{
  if ($param && !empty(SITE[$param])) {
    return SITE[$param];
  }

  return SITE["root"];
}

/**
 * routeImage
 *
 * @param  string $imageUrl
 *
 * @return string
 */
function routeImage(string $imageUrl): string
{
  return SITE["root"] . "/views/assets/images/{$imageUrl}";
}

/**
 * asset
 *
 * @param  string $path
 * @param  bool $time
 *
 * @return string
 */
function asset(string $path, $time = true): string
{
  $file = SITE["root"] . "/views/assets/{$path}";
  $fileOnDir = dirname(__DIR__, 1) . "/views/assets/{$path}";
  if ($time && file_exists($fileOnDir)) {
    $file .= "?time=" . filemtime($fileOnDir);
  }
  return $file;
}

/**
 * notify
 * Manage notification message using SESSION
 *
 * @param  string|null $type
 * @param  string|null $message
 *
 * @return null|string
 */
function notify(string $type = null, string $message = null): ?string
{
  if ($type && $message) {
    $_SESSION["notify"] = [
      "type" => $type,
      "message" => $message
    ];
    return null;
  }

  if (!empty($_SESSION["notify"]) && $notify = $_SESSION["notify"]) {
    unset($_SESSION["notify"]);

    $title = [
      'info' => 'Informação',
      'warning' => 'Atenção',
      'danger' => 'Erro',
      'success' => 'Sucesso'
    ];

    $animateType = [
      'info' => 'animated fadeInDown',
      'warning' => 'animated bounce',
      'danger' => 'animated bounce',
      'success' => 'animated fadeInDown'
    ];

    $scriptNotify = "
    <script>
      $.notify({
          // options
          icon: 'flaticon-alarm-1',
          title: '{$title[$notify["type"]]}',
          message: '{$notify["message"]}'
      }, {
          // settings
          type: '{$notify["type"]}',
          placement: {
              from: 'top',
              align: 'center'
          },
          animate: {
              enter: '{$animateType[$notify["type"]]}',
              exit: 'animated fadeOutUp'
          },
      });
    </script>";
    return $scriptNotify;
  }

  return null;
}

/**
 * convertDate
 *
 * @param  string $date dd/mm/yyyy or yyyy-mm-dd
 *
 * @return string reversed date
 */
function convertDate(string $date): string
{
  if (strpos($date, '/')) {
    // convert dd/mm/yyyy -> yyyy-mm-dd
    $date = explode('/', $date);
    return $date[2] . '-' . $date[1] . '-' . $date[0];
  } else if (strpos($date, '-')) {
    // convert yyyy-mm-dd -> dd/mm/yyyy
    $date = explode('-', $date);
    return $date[2] . '/' . $date[1] . '/' . $date[0];
  } else {
    return 'Data não reconhecida';
  }
}

/**
 * convert Brazilian currency to currency DB decimal
 *
 * @param  string $value 1.000,00
 *
 * @return string reversed currency 1000.00
 */
function convertToCurrencyDB(string $value): string
{
  $value = str_replace('.', '', $value);
  $value = str_replace(',', '.', $value);

  return $value;
}
