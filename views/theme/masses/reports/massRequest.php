<!DOCTYPE html>
<html lang="br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pedidos de Missa</title>
  <style>
    .relatorio {
      margin: 0;
      padding: 0;
      line-height: 1.4em;
      font-size: 10.5pt;
      font-family: verdana, arial, helvetica, sans-serif;
      color: #000000;
      /*orphans: 3; Numero minimo de linha no inicio da pag*/
      /*border: solid 1px red;*/
    }

    /* Seta margin da pagina */
    @page {
      size: A4;
      margin: 1cm 1cm 1.5cm 1cm;
      word-wrap: break-word;
    }

    .quebra_pagina {
      page-break-after: always;
    }

    /* Gerar cabeçalho */
    /* #header {
      font-family: verdana, arial, helvetica, sans-serif;
      font-size: 10pt;
      height: 170px;
      width: 100%;
      position: fixed;
      top: -100px;
      left: 0;
      right: 0;
      margin: auto;
      border: solid 1px red;
    } */

    #header {
      border-bottom: solid 2px black;
    }

    #header img {
      width: 100px;
    }

    #header #logo {
      float: left;
    }

    #header #textHeader {
      text-align: center;
      font-family: verdana, arial, helvetica, sans-serif;
      font-size: 12pt;
    }

    .address {
      font-size: 10pt;
      margin-top: 10px;
      margin-bottom: 10px;
    }

    #footer {
      font-family: verdana, arial, helvetica, sans-serif;
      font-size: 10pt;
      text-align: right;
      font-style: italic;
      height: 50px;
      width: 100%;
      position: fixed;
      bottom: -60px;
      left: 0;
      right: 0;
      margin: auto;
    }

    /* Contagem de paginas */
    #footer .page:after {
      content: counter(page);
    }

    table {
      border-collapse: collapse;
      position: relative;
      width: 100%;
      table-layout: fixed;
    }

    tr th,
    tr td {
      border: solid 1px #CCC;
    }

    thead,
    tfoot tr th,
    tbody tr th {
      background-color: #EEE;
    }

    tfoot tr th {
      text-align: left;
    }

    td.col1,
    td.col2 {
      width: 50%;
      padding-left: 5px;
    }

    td.empty {
      width: 50%;
      height: 15pt;
    }

    .date {
      border: 0px;
      background-color: #ffffff;
      font-size: 12pt;
    }

    img.relatorio {
      max-width: 100%;
    }

    h2 {
      text-align: center;
    }
  </style>
</head>

<body>
  <?php
  include(dirname(__DIR__,2)."/report-header.php");
  include(dirname(__DIR__,2)."/report-footer.php");
  ?>

<?php
$dayWeekArray = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];
$dayWeekNumber = date('w', strtotime($date));
?>
  <div class="relatorio">
    <h2>Celebração Eucarística</h2>
    <h3><?= $typeMass->title ?></h3>

    <table class="date">
      <thead>
        <tr>
          <th class="date" style="text-align: left">Data: <?= $data['date'] ?></th>
          <th class="date"><?= $dayWeekArray[$dayWeekNumber] ?></th>
          <th class="date" style="text-align: right"><?= substr($typeMass->hour, 0, 5) ?> hs</th>
        </tr>
      </thead>
    </table>
    <br>
    <?php
    foreach ($massesArray as $titleTypeIntention => $masses) : ?>
      <table class="relatorio">
        <thead>
          <tr>
            <th colspan="2"><?= $titleTypeIntention ?></th>
          </tr>
        </thead>
        <?php
        foreach ($masses['data'] as $key => $mass) :
          if (!($key % 2)) : ?>
            <tr>
              <td class="col1"><?= $mass->faithful ?></td>
            <?php
            $openTr = true; // Flag used to check if the tag <tr> has opened
          else : ?>
              <td class="col2"><?= $mass->faithful ?></td>
            </tr>
        <?php
            $openTr = false; // Flag used to check if the tag <tr> has closed
          endif;
        endforeach;
        echo ($openTr) ? '<td></td></tr>' : ''; // Close tag <tr> if it was left open in even columns
        // imprime linhas em branco
        for ($line=1; $line <= $masses['empty_lines']; $line++) : ?> 
          <tr>
              <td class="empty"> </td>
              <td class="empty"> </td>
          </tr>
          <?php
        endfor; ?>
      </table>
      <br><br>
    <?php
    endforeach; ?>
  </div>

</body>

</html>