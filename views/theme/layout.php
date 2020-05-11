<!DOCTYPE html>
<html lang="br">
<?php
if (!array_key_exists('user', $_SESSION))
  $router->redirect("auth.logout");
?>

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title><?= $title ?></title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <link rel="icon" href="<?= asset("img/favicon.ico") ?>" type="image/x-icon" />

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
  <link rel="stylesheet" href="<?= asset("css/jquery.datepick.css"); ?>">

  <!-- CSS Just for demo purpose, don't include it in your project -->
  <!-- <link rel="stylesheet" href="../assets/css/demo.css"> -->
</head>

<body>
  <div class="wrapper">
    <div class="main-header">
      <!-- Logo Header -->
      <div class="logo-header" data-background-color="blue">

        <a href="index.html" class="logo">
          <img src="<?= asset("img/logo.png") ?>" alt="navbar brand" class="navbar-brand">
        </a>
        <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon">
            <i class="icon-menu"></i>
          </span>
        </button>
        <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
        <div class="nav-toggle">
          <button id="buttonMenu" class="btn btn-toggle toggle-sidebar">
            <i class="icon-menu"></i>
          </button>
        </div>
      </div>
      <!-- End Logo Header -->

      <!-- Navbar Header -->
      <nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">

        <div class="container-fluid">
          <div class="collapse" id="search-nav">
            <form class="navbar-left navbar-form nav-search mr-md-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <button type="submit" class="btn btn-search pr-1">
                    <i class="fa fa-search search-icon"></i>
                  </button>
                </div>
                <input type="text" placeholder="Procurar..." class="form-control" disabled>
              </div>
            </form>
          </div>
          <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
            <li class="nav-item toggle-nav-search hidden-caret">
              <a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false" aria-controls="search-nav">
                <i class="fa fa-search"></i>
              </a>
            </li>
            <!-- <li class="nav-item dropdown hidden-caret">
              <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-envelope"></i>
              </a>
              <ul class="dropdown-menu messages-notif-box animated fadeIn" aria-labelledby="messageDropdown">
                <li>
                  <div class="dropdown-title d-flex justify-content-between align-items-center">
                    Messages
                    <a href="#" class="small">Mark all as read</a>
                  </div>
                </li>
                <li>
                  <div class="message-notif-scroll scrollbar-outer">
                    <div class="notif-center">
                      <a href="#">
                        <div class="notif-img">
                          <img src="<?= asset("img/jm_denis.jpg") ?>" alt="Img Profile">
                        </div>
                        <div class="notif-content">
                          <span class="subject">Jimmy Denis</span>
                          <span class="block">
                            How are you ?
                          </span>
                          <span class="time">5 minutes ago</span>
                        </div>
                      </a>
                      <a href="#">
                        <div class="notif-img">
                          <img src="<?= asset("img/chadengle.jpg") ?>" alt="Img Profile">
                        </div>
                        <div class="notif-content">
                          <span class="subject">Chad</span>
                          <span class="block">
                            Ok, Thanks !
                          </span>
                          <span class="time">12 minutes ago</span>
                        </div>
                      </a>
                      <a href="#">
                        <div class="notif-img">
                          <img src="<?= asset("img/mlane.jpg") ?>" alt="Img Profile">
                        </div>
                        <div class="notif-content">
                          <span class="subject">Jhon Doe</span>
                          <span class="block">
                            Ready for the meeting today...
                          </span>
                          <span class="time">12 minutes ago</span>
                        </div>
                      </a>
                      <a href="#">
                        <div class="notif-img">
                          <img src="<?= asset("img/talha.jpg") ?>" alt="Img Profile">
                        </div>
                        <div class="notif-content">
                          <span class="subject">Talha</span>
                          <span class="block">
                            Hi, Apa Kabar ?
                          </span>
                          <span class="time">17 minutes ago</span>
                        </div>
                      </a>
                    </div>
                  </div>
                </li>
                <li>
                  <a class="see-all" href="javascript:void(0);">See all messages<i class="fa fa-angle-right"></i> </a>
                </li>
              </ul>
            </li> -->
            <!-- <li class="nav-item dropdown hidden-caret">
              <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-bell"></i>
                <span class="notification">4</span>
              </a>
              <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                <li>
                  <div class="dropdown-title">You have 4 new notification</div>
                </li>
                <li>
                  <div class="notif-scroll scrollbar-outer">
                    <div class="notif-center">
                      <a href="#">
                        <div class="notif-icon notif-primary"> <i class="fa fa-user-plus"></i> </div>
                        <div class="notif-content">
                          <span class="block">
                            New user registered
                          </span>
                          <span class="time">5 minutes ago</span>
                        </div>
                      </a>
                      <a href="#">
                        <div class="notif-icon notif-success"> <i class="fa fa-comment"></i> </div>
                        <div class="notif-content">
                          <span class="block">
                            Rahmad commented on Admin
                          </span>
                          <span class="time">12 minutes ago</span>
                        </div>
                      </a>
                      <a href="#">
                        <div class="notif-img">
                          <img src="<?= asset("img/profile2.jpg") ?>" alt="Img Profile">
                        </div>
                        <div class="notif-content">
                          <span class="block">
                            Reza send messages to you
                          </span>
                          <span class="time">12 minutes ago</span>
                        </div>
                      </a>
                      <a href="#">
                        <div class="notif-icon notif-danger"> <i class="fa fa-heart"></i> </div>
                        <div class="notif-content">
                          <span class="block">
                            Farrah liked Admin
                          </span>
                          <span class="time">17 minutes ago</span>
                        </div>
                      </a>
                    </div>
                  </div>
                </li>
                <li>
                  <a class="see-all" href="javascript:void(0);">See all notifications<i class="fa fa-angle-right"></i> </a>
                </li>
              </ul>
            </li> -->
            <!-- <li class="nav-item dropdown hidden-caret">
              <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                <i class="fas fa-layer-group"></i>
              </a>
              <div class="dropdown-menu quick-actions quick-actions-info animated fadeIn">
                <div class="quick-actions-header">
                  <span class="title mb-1">Quick Actions</span>
                  <span class="subtitle op-8">Shortcuts</span>
                </div>
                <div class="quick-actions-scroll scrollbar-outer">
                  <div class="quick-actions-items">
                    <div class="row m-0">
                      <a class="col-6 col-md-4 p-0" href="#">
                        <div class="quick-actions-item">
                          <i class="flaticon-file-1"></i>
                          <span class="text">Generated Report</span>
                        </div>
                      </a>
                      <a class="col-6 col-md-4 p-0" href="#">
                        <div class="quick-actions-item">
                          <i class="flaticon-database"></i>
                          <span class="text">Create New Database</span>
                        </div>
                      </a>
                      <a class="col-6 col-md-4 p-0" href="#">
                        <div class="quick-actions-item">
                          <i class="flaticon-pen"></i>
                          <span class="text">Create New Post</span>
                        </div>
                      </a>
                      <a class="col-6 col-md-4 p-0" href="#">
                        <div class="quick-actions-item">
                          <i class="flaticon-interface-1"></i>
                          <span class="text">Create New Task</span>
                        </div>
                      </a>
                      <a class="col-6 col-md-4 p-0" href="#">
                        <div class="quick-actions-item">
                          <i class="flaticon-list"></i>
                          <span class="text">Completed Tasks</span>
                        </div>
                      </a>
                      <a class="col-6 col-md-4 p-0" href="#">
                        <div class="quick-actions-item">
                          <i class="flaticon-file"></i>
                          <span class="text">Create New Invoice</span>
                        </div>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </li> -->
            <li class="nav-item dropdown hidden-caret">
              <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                <div class="avatar-sm">
                  <img src="<?= asset("img/profile3.jpg") ?>" alt="..." class="avatar-img rounded-circle">
                </div>
              </a>
              <ul class="dropdown-menu dropdown-user animated fadeIn">
                <div class="dropdown-user-scroll scrollbar-outer">
                  <li>
                    <div class="user-box">
                      <div class="avatar-lg">
                        <img src="<?= asset("img/profile3.jpg") ?>" alt="image profile" class="avatar-img rounded">
                      </div>
                      <div class="u-text">
                        <h4><?= $_SESSION['user']['name'] ?></h4>
                        <?=
                          ($_SESSION['user']['level'] == 1) ? 'Padre' : 'Secretária';
                        ?>
                        <!-- <p class="text-muted">hello@example.com</p><a href="profile.html" class="btn btn-xs btn-secondary btn-sm">View Profile</a> -->
                      </div>
                    </div>
                  </li>
                  <li>
                    <!-- <div class="dropdown-divider"></div> -->
                    <!-- <a class="dropdown-item" href="#">Meu Perfil</a> -->
                    <!-- <a class="dropdown-item" href="#">My Balance</a> -->
                    <!-- <a class="dropdown-item" href="#">Inbox</a> -->
                    <!-- <div class="dropdown-divider"></div> -->
                    <!-- <a class="dropdown-item" href="#">Account Setting</a> -->
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?= $router->route("auth.logout"); ?>">Logout</a>
                  </li>
                </div>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
      <!-- End Navbar -->
    </div>

    <!-- Sidebar -->
    <div class="sidebar sidebar-style-2">
      <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
          <div class="user">
            <!-- <div class="avatar-sm float-left mr-2">
              <img src="<?= asset("img/profile.jpg") ?>" alt="..." class="avatar-img rounded-circle">
            </div> -->
            <div class="info">
              <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                <span>
                  <?= $_SESSION['user']['name'] ?>
                  <span class="user-level">
                    <?=
                      ($_SESSION['user']['level'] == 1) ? 'Padre' : 'Secretária';
                    ?>
                  </span>
                  <!-- <span class="caret"></span> -->
                </span>
              </a>
              <!-- <div class="clearfix"></div> -->

              <!-- <div class="collapse in" id="collapseExample">
                <ul class="nav">
                  <li>
                    <a href="#profile">
                      <span class="link-collapse">My Profile</span>
                    </a>
                  </li>
                  <li>
                    <a href="#edit">
                      <span class="link-collapse">Edit Profile</span>
                    </a>
                  </li>
                  <li>
                    <a href="#settings">
                      <span class="link-collapse">Settings</span>
                    </a>
                  </li>
                </ul>
              </div> -->
            </div>
          </div>
          <!-- Side menu -->
          <ul class="nav nav-primary">
            <?php
            if ($_SESSION['user']['level'] == 1) :
            ?>
              <li class="nav-item">
                <a href="<?= $router->route("typesintention.index"); ?>">
                  <i class="fas fa-location-arrow"></i>
                  <p>Tipos de Intenções</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= $router->route("users.index"); ?>">
                  <i class="fas fa-user-edit"></i>
                  <p>Usuários</p>
                </a>
              </li>
            <?php
            endif;

            if ($_SESSION['user']['level'] == 1 || $_SESSION['user']['level'] == 2) :
            ?>
              <li class="nav-item">
                <a data-toggle="collapse" href="#submenu">
                  <i class="fas fa-bars"></i>
                  <p>Missas</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="submenu">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="<?= $router->route("masses.index"); ?>">
                        <i class="fas fa-hands"></i>
                        <p>Pedidos de Missas</p>
                      </a>
                    </li>
                    <li>
                      <a href="<?= $router->route("masses.report"); ?>">
                        <i class="fas fa-paste"></i>
                        <p>Relatório de Missas</p>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a href="<?= $router->route("typesmass.index"); ?>">
                  <i class="fas fa-school"></i>
                  <p>Tipos de Missas</p>
                </a>
              </li>
            <?php
            endif;
            if ($_SESSION['user']['level'] == 1) :
            ?>
              <li class="nav-item">
                <a href="<?= $router->route("cash.index"); ?>">
                  <i class="fas fa-dollar-sign"></i>
                  <p>Caixa</p>
                </a>
              </li>
            <?php
            endif;
            ?>
            <li class="nav-item">
              <a href="<?= $router->route("auth.logout"); ?>">
                <i class="fas fa-sign-out-alt"></i>
                <p>Sair</p>
              </a>
            </li>

          </ul>
        </div>
      </div>
    </div>
    <!-- End Sidebar -->

    <div class="main-panel">
      <div class="content">
        <div class="page-inner">
          <div class="page-header">
            <h4 class="page-title"><?= $pageTitle ?></h4>
            <!-- <ul class="breadcrumbs">
              <li class="nav-home">
                <a href="#">
                  <i class="flaticon-home"></i>
                </a>
              </li>
              <li class="separator">
                <i class="flaticon-right-arrow"></i>
              </li>
              <li class="nav-item">
                <a href="#">Pages</a>
              </li>
              <li class="separator">
                <i class="flaticon-right-arrow"></i>
              </li>
              <li class="nav-item">
                <a href="#">Starter Page</a>
              </li>
            </ul> -->
          </div>
          <div class="page-category">
            <!-- Inner page content goes here -->
            <?= $v->section("content"); ?>
          </div>
        </div>
      </div>
      <footer class="footer">
        <div class="container-fluid">
          <nav class="pull-left">
            <ul class="nav">
              <!-- <li class="nav-item">
                <a class="nav-link" href="https://www.themekita.com">
                  ThemeKita
                </a>
              </li> -->
              <li class="nav-item">
                <a class="nav-link" href="https://github.com/carlosvalter/fin-missa/releases" target="_blank" data-toggle="tooltip" data-placement="top" title="Verifique novas atualizações">
                  <v1 class="0 1">v1.2.0</v1>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="https://pt.wikipedia.org/wiki/Licen%C3%A7a_MIT" target="_blank">
                  Licença MIT
                </a>
              </li>
            </ul>
          </nav>
          <div class="copyright ml-auto">
            2020, feito com <i class="fa fa-heart heart text-danger"></i> por <a target="_blank" href="https://www.5bits.com.br">5 Bits</a>
          </div>
        </div>
      </footer>
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
  <!-- <script src="<?= asset("js/plugin/chart.js/chart.min.js") ?>"></script> -->

  <!-- jQuery Sparkline -->
  <script src="<?= asset("js/plugin/jquery.sparkline/jquery.sparkline.min.js") ?>"></script>

  <!-- Chart Circle -->
  <!-- <script src="<?= asset("js/plugin/chart-circle/circles.min.js") ?>"></script> -->

  <!-- Datatables -->
  <script src="<?= asset("js/plugin/datatables/datatables.min.js") ?>"></script>

  <!-- Bootstrap Notify -->
  <script src="<?= asset("js/plugin/bootstrap-notify/bootstrap-notify.min.js") ?>"></script>

  <!-- jQuery Vector Maps -->
  <!-- <script src="<?= asset("js/plugin/jqvmap/jquery.vmap.min.js") ?>"></script> -->
  <!-- <script src="<?= asset("js/plugin/jqvmap/maps/jquery.vmap.world.js") ?>"></script> -->

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
        },
        "pageLength": 30,
        initComplete: function() {
          this.api().columns().every(function() {
            var column = this;
            var select = $('<select class="form-control"><option value=""></option></select>')
              .appendTo($(column.footer()).empty())
              .on('change', function() {
                var val = $.fn.dataTable.util.escapeRegex(
                  $(this).val()
                );

                column
                  .search(val ? '^' + val + '$' : '', true, false)
                  .draw();
              });

            column.data().unique().sort().each(function(d, j) {
              select.append('<option value="' + d + '">' + d + '</option>')
            });
          });
        }
      });
    });
  </script>
  <!-- Show notification -->
  <?= notify() ?>
</body>

</html>