<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alterar Contrato - Configurações - SiGA</title>
    <link href="<?php echo base_url('/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('/css/bootstrap-theme.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link href="<?php echo base_url('/css/font-awesome.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('/css/pnotify.custom.min.css') ?>" rel="stylesheet">
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

<?php $this->load->view('common/view_header.php'); ?>
<?php $this->load->view('common/view_menu_painel_editar', array('posicao' => 3)); ?>

  <div class="content-wrapper">
    <section class="content">
      <div class="row">
        <div class="col-md-2"></div>
          <div class="col-md-8">

            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <p class="header-painel">Alterar Contrato</p>
                </div>
                <div class="panel-body">
                    <?php
                    if ($sucesso == TRUE) {
                        echo '
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="alert alert-success">
                                        <div class="text-center">
                                            <h5>Contrato removido com <b>sucesso!</b></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    } else {
                        echo '
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="alert alert-danger">
                                        <div class="text-center">
                                            <h5>
                                            <b>Erro</b> ao remover contrato.<br/>
                                            ' . $erro_mensagem . '
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    }
                    ?>
                    <hr/>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center">
                                <a class="btn btn-default"
                                   href="<?php
                                   if (isset($contrato['id_contrato']) && $contrato['id_contrato']) {
                                       echo base_url('/paineleditar/configuracoes/alterarcontrato/alterar/contrato/' . $contrato['id_contrato']);
                                   } else {
                                       echo base_url('/paineleditar/configuracoes/alterarcontrato/lista');
                                   }
                                   ?>"><b>Voltar</b></a>
                            </div>
                        </div>
                    </div>
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

</body>
</html>
