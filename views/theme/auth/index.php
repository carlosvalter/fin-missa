<!DOCTYPE html>
<html lang="br">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title><?= $title ?></title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <link rel="icon" href="<?= asset("img/icon.ico") ?>" type="image/x-icon" />

  <!-- Fonts and icons -->
  <script src="<?= asset("js/plugin/webfont/webfont.min.js") ?>"></script>
  <script>
    WebFont.load({
      google: {
        "families": ["Lato:300,400,700,900"]
      },
      custom: {
        "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
        urls: ['<?= asset("css/fonts.min.css") ?>']
      },
      active: function() {
        sessionStorage.fonts = true;
      }
    });
  </script>

  <!-- CSS Files -->
  <link rel="stylesheet" href="<?= asset("css/bootstrap.min.css") ?>">
  <link rel="stylesheet" href="<?= asset("css/atlantis.min.css"); ?>">

  <!-- CSS Just for demo purpose, don't include it in your project -->
  <!-- <link rel="stylesheet" href="../assets/css/demo.css"> -->
</head>

<body>
  <div class="wrapper">
    <div class="main-header">
      <!-- Logo Header -->
      <div class="logo-header" data-background-color="blue">

        <a href="index.html" class="logo">
          <img src="<?= asset("img/logo.svg") ?>" alt="navbar brand" class="navbar-brand">
        </a>
        <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon">
            <i class="icon-menu"></i>
          </span>
        </button>
        <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
        <div class="nav-toggle">
          <button class="btn btn-toggle toggle-sidebar">
            <i class="icon-menu"></i>
          </button>
        </div>
      </div>
      <!-- End Logo Header -->

      <!-- Navbar Header -->
      <nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">
      </nav>
      <!-- End Navbar -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="modalLoginTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><b>Login do usuário</b></h5>
          </div>
          <form id="form" class="form" action="<?= $router->route("auth.login"); ?>" method="post" autocomplete="off">
            <div class="modal-body">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="inputLogin">Login</label>
                      <input type="text" class="form-control" id="inputLogin" name="login" placeholder="Entre com o login">
                    </div>
                    <div class="form-group">
                      <label for="inputPasswd">Senha</label>
                      <input type="password" class="form-control" id="inputPasswd" name="passwd">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Logar</button>
            </div>
          </form>
        </div>
      </div>
    </div>


  </div>
  <!--   Core JS Files   -->
  <script src="<?= asset("js/core/jquery.3.2.1.min.js") ?>"></script>
  <script src="<?= asset("js/core/popper.min.js") ?>"></script>
  <script src="<?= asset("js/core/bootstrap.min.js") ?>"></script>

  <!-- jQuery UI -->
  <script src="<?= asset("js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js") ?>"></script>
  <script src="<?= asset("js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js") ?>"></script>

  <!-- jQuery Scrollbar -->
  <script src="<?= asset("js/plugin/jquery-scrollbar/jquery.scrollbar.min.js") ?>"></script>


  <!-- Chart JS -->
  <script src="<?= asset("js/plugin/chart.js/chart.min.js") ?>"></script>

  <!-- jQuery Sparkline -->
  <script src="<?= asset("js/plugin/jquery.sparkline/jquery.sparkline.min.js") ?>"></script>

  <!-- Chart Circle -->
  <script src="<?= asset("js/plugin/chart-circle/circles.min.js") ?>"></script>

  <!-- Datatables -->
  <script src="<?= asset("js/plugin/datatables/datatables.min.js") ?>"></script>

  <!-- Bootstrap Notify -->
  <script src="<?= asset("js/plugin/bootstrap-notify/bootstrap-notify.min.js") ?>"></script>

  <!-- jQuery Vector Maps -->
  <script src="<?= asset("js/plugin/jqvmap/jquery.vmap.min.js") ?>"></script>
  <script src="<?= asset("js/plugin/jqvmap/maps/jquery.vmap.world.js") ?>"></script>

  <!-- Sweet Alert -->
  <script src="<?= asset("js/plugin/sweetalert/sweetalert.min.js") ?>"></script>

  <!-- Atlantis JS -->
  <script src="<?= asset("js/atlantis.min.js") ?>"></script>

  <!-- Scripts created in views -->
  <?= $v->section("scripts"); ?>

  <script type="text/javascript">
    $(document).ready(function() {
      $('#datatablesList').dataTable({
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Portuguese-Brasil.json",
        }
      });
      $('#modalLogin').on('shown.bs.modal', function() {
        $("#inputLogin").focus();
      })
      $('#modalLogin').modal();
    });
  </script>
  <!-- Show notification -->
  <?= notify() ?>
</body>

</html>