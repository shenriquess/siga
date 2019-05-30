<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $this->lang->line('s1'); ?></title>
    <link href="<?php echo base_url('/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('/css/bootstrap-theme.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link href="<?php echo base_url('/css/font-awesome.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('/css/style.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('/css/AdminLTE.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('/css/_all-skins.css') ?>">
    <!--[if lt IE 9]>
    <script src="<?php echo base_url('/js/html5shiv.min.js') ?>"></script>
    <script src="<?php echo base_url('/js/respond.min.js') ?>"></script>
    <![endif]-->
</head>
<body class="hold-transition skin-yellow-light sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <a href="<?php echo base_url('/painel/home') ?>" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>S</b>iG</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>SiGA</b></span>
    </a>
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
        <div class="navbar-custom-menu">
            <!--div class="navbar-header">
                <a class="navbar-brand" href="<?php echo base_url('/painel/home') ?>"><b>SiGA</b></a>
            </div-->
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                        <!-- Left Side Of Navbar -->
                        <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav">
                          <li class="dropdown user user-menu">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                <i class="fa fa-user"></i>&nbsp;&nbsp;admin <span class="caret"></span>
                              </a>

                              <ul class="dropdown-menu">

                                  <li>
                                      <a href="<?php echo base_url('/painel/logout') ?>">
                                          <i class="fas fa-sign-out-alt"></i> Sair
                                      </a>
                                  </li>

                              </ul>
                          </li>
                        </ul>
                  </div>
            </div>
    </nav>
  </header>

  <?php $this->load->view('common/menu_paineledit', array('posicao' => -1)); ?>

  <div class="content-wrapper">
    <section class="content">
      <div class="row">
        <div class="col-md-2"></div>
          <div class="col-md-8">


            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <p class="header-painel">SiGA - Modo Edição</p>
                </div>
                <div class="panel-body">
                    <h3>Aguardando...</h3>
                </div>
            </div>
        </div>
    </div>
  </section>
</div>
  <?php $this->load->view('common/view_footer.php') ?>
</div>

<script src="<?php echo base_url('/js/jquery-2.1.1.min.js') ?>"></script>
<script src="<?php echo base_url('/js/bootstrap.min.js') ?>"></script>
<script src="<?php echo base_url('/js/jquery.slimscroll.min.js') ?>"></script>
<script src="<?php echo base_url('/js/adminlte.js') ?>"></script>
<script type="application/javascript">
    $(document).ready(function () {
        $('#botaoImprimir').click(function () {
            window.print();
        })
    });
</script>

</body>
</html>
