<?php

namespace Source\Controllers;

use DateTime;
use Dompdf\Dompdf;
use Source\Models\Cash as EntityCash;
use Source\Models\Mass as EntityMass;
use Source\Models\TypeIntention as EntityTypeIntention;
use Source\Models\TypeMass as EntityTypeMass;
use Source\Controllers\SSP;

class Masses extends Controller
{
  public function __construct($router)
  {
    if (!array_key_exists('user', $_SESSION) || $_SESSION['user']['level'] > 2)
      $router->redirect("auth.logout");
    parent::__construct($router);
  }

  public function index(): void
  {
    echo $this->view->render("theme/masses/index", [
      "title" => "Pedidos de Missa | " . site("name"),
      "pageTitle" => "Pedidos de Missa"
    ]);
  }
  public function new(array $data): void
  {

    if (!empty($data)) {
      // Remove codigos de scripts do form
      $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

      $formRequired = [
        (array_key_exists('id_type_mass', $data)) ? $data['id_type_mass'] : '',
        (array_key_exists('id_type_intention', $data)) ? $data['id_type_intention'] : '',
        (array_key_exists('id_cash', $data)) ? $data['id_cash'] : '',
        (array_key_exists('faithful', $data)) ? $data['faithful'] : '',
        (array_key_exists('price', $data)) ? $data['price'] : '',
        (array_key_exists('date', $data)) ? $data['date'] : ''
      ];

      // Verifica se tem algum campo do form em branco
      if (in_array("", $formRequired)) {
        echo $this->ajaxResponse("message", [
          "type" => "warning",
          "message" => "Preencha todos os campos para cadastrar!"
        ]);
        return;
      }

      $typeMass = (new EntityTypeMass())->findById($data['id_type_mass']);
      $typeIntention = (new EntityTypeIntention())->findById($data['id_type_intention']);
      $cash = (new EntityCash())->findById($data['id_cash']);

      if ($data['typeMass']) {
        // Mass special
        $amount = convertToCurrencyDB($data['amount']);

        $save = $this->saveMass($typeMass, $typeIntention, $cash, $data['faithful'], $amount, $data['date']);

        if ($save['ok']) {
          echo $this->ajaxResponse("message", [
            "type" => "success",
            "message" => "Registro gravado com sucesso!"
          ]);
        } else {
          echo $this->ajaxResponse("message", [
            "type" => "danger",
            "message" => "Erro na gravação!" . $save['message']
          ]);
          return;
        }
      } else {
        // Mass Common
        if ($data['typeDate'] === 'variadas') {
          $datesArray = explode(', ', $data['date']);

          $amount = convertToCurrencyDB($data['amount']) / count($datesArray);

          foreach ($datesArray as $date) {
            $save = $this->saveMass($typeMass, $typeIntention, $cash, $data['faithful'], $amount, $date);

            if (!$save['ok']) {
              echo $this->ajaxResponse("message", [
                "type" => "danger",
                "message" => "Erro na gravação!" . $save['message']
              ]);
              return;
            }
          }

          // Full register save success
          if ($save['ok']) {
            echo $this->ajaxResponse("message", [
              "type" => "success",
              "message" => "Registro gravado com sucesso!"
            ]);
          }
        } else if ($data['typeDate'] === 'continua') {
          $datesArray = explode(' - ', $data['date']);

          $dateBegin = DateTime::createFromFormat('d/m/Y', $datesArray[0]);
          $dateEnd = DateTime::createFromFormat('d/m/Y', $datesArray[1]);

          // Resgata diferença entre as datas
          $dateInterval = $dateBegin->diff($dateEnd);
          $days =  $dateInterval->days + 1; // + 1 add the first day

          $amount = convertToCurrencyDB($data['amount']) / $days;

          while ($dateBegin <= $dateEnd) {
            $date = $dateBegin->format('d/m/Y');

            $save = $this->saveMass($typeMass, $typeIntention, $cash, $data['faithful'], $amount, $date);

            if (!$save['ok']) {
              echo $this->ajaxResponse("message", [
                "type" => "danger",
                "message" => "Erro na gravação!" . $save['message']
              ]);
              return;
            }
            $dateBegin = $dateBegin->add(new \DateInterval('P1D')); // Soma um 1 dia da $data
          }
          // Full register save success
          if ($save['ok']) {
            echo $this->ajaxResponse("message", [
              "type" => "success",
              "message" => "Registro gravado com sucesso!"
            ]);
          }
        }
      }
      // Save total amount in cash
      $cash->amount += convertToCurrencyDB($data['amount']);
      if (!$cash->save()) {
        echo $this->ajaxResponse("message", [
          "type" => "danger",
          "message" => "Erro na gravação do caixa!" . $cash->fail()->getMessage()
        ]);
        return;
      }
    } else {
      $typesIntention = (new EntityTypeIntention())->find()->order("title ASC")->fetch(true);
      $cashier = (new EntityCash())->find()->order("name ASC")->fetch(true);

      echo $this->view->render("theme/masses/new", [
        "title" => "Pedidos de Missa | " . site("name"),
        "pageTitle" => "Cadastrar Pedidos de Missa",
        "mass" => (new EntityMass()),
        "typesIntention" => $typesIntention,
        "cashier" => $cashier
      ]);
    }
  }

  public function delete(array $data): void
  {
    $mass = (new EntityMass())->findById($data['id_mass']);
    $cash = $mass->getCash();

    $cash->amount -= $mass->amount_paid;

    if ($mass->destroy() && $cash->save()) {
      notify("success", "Registro apagado com sucesso!");
    } else {
      notify("danger", "Erro na exclusão!");
    }

    $this->router->redirect('masses.index');
  }

  public function report(array $data)
  {

    if (!empty($data)) {
      // Remove codigos de scripts do form
      $data = filter_var_array($data, FILTER_SANITIZE_STRIPPED);

      if (array_key_exists('id_type_mass', $data) && array_key_exists('date', $data)) {
        $formRequired = [
          $data['id_type_mass'],
          $data['date']
        ];

        // Verifica se tem algum campo do form em branco
        if (in_array("", $formRequired)) {
          echo "<script>alert('Preencha todos os campos para cadastrar!'); window.close()</script>";
        }
      } else {
        echo "<script>alert('Preencha todos os campos para cadastrar!'); window.close()</script>";
      }

      $typeMass = (new EntityTypeMass())->findById("{$data['id_type_mass']}");
      $date = convertDate($data['date']);

      $masses = (new EntityMass())
        ->find("id_type_mass = :id_type_mass AND date = :date", "id_type_mass={$typeMass->id_type_mass}&date={$date}")
        ->order("id_type_intention")
        ->fetch(true);

      if ($masses) {
        $typesIntention = (new EntityTypeIntention())->find()->fetch(true);

        //create a array of intention
        foreach ($typesIntention as $typeIntention) {
          $typesIntentionArray[$typeIntention->id_type_intention] = [
            'title' => $typeIntention->title, 
            'empty_lines' => $typeIntention->empty_lines
          ];
        }

        foreach ($typesIntentionArray as $id_type_intention => $titleTypeIntention) {
          $i = 0;
          foreach ($masses as $key => $mass) {
            if ($mass->id_type_intention == $id_type_intention) {
              $massesArray[$titleTypeIntention['title']]['empty_lines'] = $typesIntentionArray[$id_type_intention]['empty_lines'];
              $massesArray[$titleTypeIntention['title']]['data'][$i++] = $mass;
              unset($masses[$key]); // Diminui matriz para o proximo laço ser mais rapido
            }
          }
        }

        /*
        $typesIntentionArray =
        [
          'id' => [
            'title' => 'louvor',
            'empty_lines' => 10
          ],
        ]

        $massesArray =
        [
          'louvor' => [
            'empty_lines' => 5,
            'data' => [
              0 => entity mass,
              1 => entity mass,
            ]
          ]
        ]
        */

        $dompdf = new Dompdf(["enable_remote" => true]);
        ob_start(); // Abre uma sessao de cache, tudo q esta abaixo ira para uma variavel de cache, e não para a tela

        require dirname(__DIR__, 2) . "/views/theme/masses/reports/massRequest.php";

        $pdf = ob_get_clean(); // recebe o conteudo do cache do PHP

        // For see in html discoment the line below
        // echo $pdf; die;

        $dompdf->loadHtml($pdf); // Converte o conteudo html gerado para PDF

        $dompdf->setPaper("A4");

        $dompdf->render();

        $dompdf->stream("file.pdf", ['Attachment' => false]); // Abre o PDF
      } else {
        echo "<script>alert('Nenhuma pedido de missa encontrado!'); window.close()</script>";
      }
    } else {
      echo $this->view->render("theme/masses/indexReport", [
        "title" => "Relatório de Pedidos de Missa | " . site("name"),
        "pageTitle" => "Relatório de Pedidos de Missa",
      ]);
    }
  }

  public function ajaxTypesMass(array $data): void
  {
    if ($data['massSpecial']) {
      $dateToday = date('Y-m-d');
      $typesMass = (new EntityTypeMass())->find("mass_special = 1 AND enable = 1 AND date >= :dateToday", "dateToday={$dateToday}")->order("date ASC")->fetch(true);
    } else {
      $typesMass = (new EntityTypeMass())->find("mass_special = 0 AND enable = 1")->order("hour ASC")->fetch(true);
    }

    if (!$typesMass)
      $callback['empty'] = true;

    $callback["typesMass"] = $this->view->render("theme/masses/fragments/radioTypesMass", ["typesMass" => $typesMass]);
    echo json_encode($callback);
  }

  private function saveMass(EntityTypeMass $typeMass, EntityTypeIntention $typeIntention, EntityCash $cash, $faithful, $amountPaid, $date): array
  {
    $mass = new EntityMass();
    $mass->add($typeMass, $typeIntention, $cash);

    $mass->faithful = $faithful;
    $mass->amount_paid = $amountPaid;
    $mass->date = convertDate($date);

    if ($mass->save()) {
      return ['ok' => true];
    } else {
      return [
        'ok' => false,
        'message' => $mass->fail()->getMessage()
      ];
    }
  }

  public function ajaxListMasses(): void
  {
    /*
     * DataTables example server-side processing script.
     *
     * Please note that this script is intentionally extremely simple to show how
     * server-side processing can be implemented, and probably shouldn't be used as
     * the basis for a large complex system. It is suitable for simple use cases as
     * for learning.
     *
     * See http://datatables.net/usage/server-side for full details on the server-
     * side processing requirements of DataTables.
     *
     * @license MIT - http://datatables.net/license_mit
     */
    
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Easy set variables
     */
    
    $dateNow = date('Y-m-d');

    // DB table to use
    // Modificado para usar join
    // https://www.gyrocode.com/articles/jquery-datatables-using-where-join-and-group-by-with-ssp-class-php/
    $table = <<<EOT
    (
    SELECT
      m.id_mass,
      m.id_type_intention,
      m.faithful,
      m.date,
      t.hour,
      i.title,
      CONCAT(t.title,' - ', TIME_FORMAT(t.hour, '%H:%i'), ' - R$ ',CAST(FORMAT(m.amount_paid, 2, 'de_DE') AS CHAR CHARACTER SET utf8)) AS info
    FROM masses m
    LEFT JOIN typesIntention i ON m.id_type_intention = i.id_type_intention
    LEFT JOIN typesMass t ON m.id_type_mass = t.id_type_mass
    WHERE m.date >= '{$dateNow}'
    ORDER BY m.date, m.id_type_intention
    ) temp
   EOT;

    // Table's primary key
    $primaryKey = 'id_mass';
    
    $columns = array(
      array( 'db' => 'id_mass', 'dt' => 0 ),
      array( 'db' => 'id_type_intention', 'dt' => 1 ),
      array(
        'db'        => 'date',
        'dt'        => 2,
        'formatter' => function( $d, $row ) {
          return date( 'd/m/Y', strtotime($d));
        }
      ),
      array(
        'db'        => 'hour',
        'dt'        => 3,
        'formatter' => function( $d, $row ) {
          return date( 'H:i', strtotime($d));
        }
      ),
      array( 'db' => 'info', 'dt' => 4 ),
      array( 'db' => 'title', 'dt' => 5 ),
      array( 'db' => 'faithful', 'dt' => 6 ),
      array( 'db' => 'id_mass', 'dt' => 7),
    );

    // SQL server connection information
    $sql_details = array(
      'user' => DATA_LAYER_CONFIG['username'],
      'pass' => DATA_LAYER_CONFIG['passwd'],
      'db'   => DATA_LAYER_CONFIG['dbname'],
      'host' => DATA_LAYER_CONFIG['host']
    );
    
    echo json_encode(
      SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns )
    );
  }
}
