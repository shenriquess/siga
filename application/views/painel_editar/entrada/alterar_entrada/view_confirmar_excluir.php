<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alterar Entrada - Entrada - SiGA</title>
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
<?php $this->load->view('common/view_menu_painel_editar', array('posicao' => 1)); ?>

<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <div class="col-md-2"></div>
        <div class="col-md-8">

            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <p class="header-painel">Alterar Entrada - Excluir Entrada</p>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h5>Data Entrada:</h5>
                        </div>
                        <div class="col-md-8">
                            <h5><b><?php echo $entrada['data_entrada']; ?></b></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <h5>Código Contrato:</h5>
                        </div>
                        <div class="col-md-8">
                            <h5><b><?php echo $entrada['codigo']; ?></b></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <h5>Número Nota:</h5>
                        </div>
                        <div class="col-md-8">
                            <h5><b><?php echo $entrada['numero_nota']; ?></b></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <h5>Tipo:</h5>
                        </div>
                        <div class="col-md-8">
                            <h5><b><?php echo $entrada['nome_tipo']; ?></b></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <h5>Item:</h5>
                        </div>
                        <div class="col-md-8">
                            <h5><b><?php echo $entrada['nome_item'] ?></b></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <h5>Quantidade:</h5>
                        </div>
                        <div class="col-md-8">
                            <h5>
                                <b><?php echo $entrada['quantidade'] . ' ' . $unidades[$entrada['unidade_padrao_id']]['nome'] ?></b>
                            </h5>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center">
                                <h5><b>Tem certeza que deseja excluir a entrada acima?</b></h5>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center">
                                <a class="btn btn-default"
                                   href="<?php echo base_url('/paineleditar/entrada/alterarentrada/lista'); ?>"><b>Não</b></a>
                                <a href="<?php echo base_url('/paineleditar/entrada/alterarentrada/excluir/' . $entrada['id_entrada']); ?>"
                                   class="btn btn-danger"><b>Sim</b></a>
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
