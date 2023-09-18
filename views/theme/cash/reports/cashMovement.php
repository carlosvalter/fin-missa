<!DOCTYPE html>
<html lang="br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Movimento de Caixa</title>
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

    .colDate,
    .colValue {
      width: 12%;
    }

    .colNameCash {
      width: 15%;
    }

    td.colDate,
    td.colNameCash {
      text-align: center;
    }

    th.colValue,
    td.colValue {
      text-align: right;
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
  include(dirname(__DIR__, 2) . "/report-header.php");
  include(dirname(__DIR__, 2) . "/report-footer.php");
  ?>

  <div class="relatorio">
    <h2>Movimento de Caixa</h2>
    <h3>Entradas no caixa do dia <?= $data['created_at'] ?></h3>

    <table class="relatorio">
      <thead>
        <tr>
          <th>Caixa</th>
          <th>Valor</th>
        </tr>
      </thead>
      <?php
      $totalAmount = 0.00;
      foreach ($massesArray as $nameCash => $masses) : ?>
        <tr>
          <td><?= $nameCash ?></td>
          <td class="colValue">
            <?php
            $amount = 0.00;
            foreach ($masses as $key => $mass) {
              $amount += $mass->amount_paid;
            }
            echo number_format($amount, 2, ',', '.');
            $totalAmount += $amount;
            ?>
          </td>
        </tr>
      <?php
      endforeach; ?>
      <tfoot>
        <tr>
          <th>Total</th>
          <th class="colValue"><?= number_format($totalAmount, 2, ',', '.'); ?></th>
        </tr>
      </tfoot>
    </table>
    <br><br>

    <?php
    if ($data['analytic']): ?>
      <h3>Movimentos do dia <?= $data['created_at'] ?></h3>
      <table class="relatorio">
        <thead>
          <tr>
            <th>Fiel</th>
            <th class="colDate">Data</th>
            <th>Valor</th>
            <th class="colNameCash">Caixa</th>
          </tr>
        </thead>
        <?php
        foreach ($massesArray as $nameCash => $masses) :
          foreach ($masses as $key => $mass) : ?>
            <tr>
              <td><?= $mass->faithful ?></td>
              <td class="colDate"><?= convertDate($mass->date) ?></td>
              <td class="colValue"><?= number_format($mass->amount_paid , 2, ',', '.') ?></td>
              <td class="colNameCash"><?= $nameCash ?></td>
            </tr>
          <?php
          endforeach;
        endforeach; ?>
        <tfoot>
          <tr>
            <th colspan="4">&nbsp;</th>
          </tr>
        </tfoot>
      </table>
      <br><br>
    <?php
    endif; ?>
  </div>

</body>

</html>