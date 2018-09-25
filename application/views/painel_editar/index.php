<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $this->lang->line('s1'); ?></title>
    <link href="<?php echo base_url('/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('/css/bootstrap-theme.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('/css/font-awesome.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('/css/style.min.css') ?>" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="<?php echo base_url('/js/html5shiv.min.js') ?>"></script>
    <script src="<?php echo base_url('/js/respond.min.js') ?>"></script>
    <![endif]-->
</head>
<body>

<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?php echo base_url('/painel/home') ?>"><b>SiGA</b></a>
        </div>
    </div>
</nav>


<div class="container">
    <div class="row">
        <?php $this->load->view('common/menu_paineledit', array('posicao' => -1)); ?>
        <div class="col-md-7">
            Bem Vindo <strong>Admin</strong>
            <a class="pull-right" href="<?php echo base_url('/painel/logout') ?>">Sair do Sistema</a>
            <hr>
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
</div>
<hr>

<script src="<?php echo base_url('/js/jquery-2.1.1.min.js') ?>"></script>
<script src="<?php echo base_url('/js/bootstrap.min.js') ?>"></script>
<script type="application/javascript">
    $(document).ready(function () {
        $('#botaoImprimir').click(function () {
            window.print();
        })
    });
</script>

</body>
</html>
