<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home - SiGA</title>
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
        <?php $this->load->view('common/view_menu_painel', array('posicao' => -1)); ?>
        <div class="col-md-7">
            Bem Vindo <b><?php echo $nome_usuario; ?></b>
            <a class="pull-right" href="<?php echo base_url('/painel/logout') ?>">Sair do Sistema</a>
            <hr>
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <p class="header-painel">SiGA - Homepage </p>
                </div>
                <div class="panel-body">
                    <br/>
                    <hr/>
                    <div class="thumbnail">
                        <br>
                        <br>
                        <br>
                        <div class="text-center"><h4>Bem Vindo ao <b>SiGA</b> - Sistema de Gerenciamento de Almoxarifado</h4></div>
                        <div class="text-center"><h4>Secretaria de Educação</h4></div>
                        <br>
                        <br>
                        <div class="text-center">
                            <img src="<?php echo base_url('/images/brasaosaogoncalo.jpg'); ?>" alt="Brasão São Gonçalo"
                                 width="300"/>
                        </div>
                        <br>
                        <br>
                        <br>
                    </div>
                    <hr/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('common/view_footer.php') ?>

<script src="<?php echo base_url('/js/jquery-2.1.1.min.js') ?>"></script>
<script src="<?php echo base_url('/js/bootstrap.min.js') ?>"></script>

</body>
</html>