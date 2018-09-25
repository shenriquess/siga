<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alterar Fornecedor - Configurações - SiGA</title>
    <link href="<?php echo base_url('/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('/css/bootstrap-theme.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('/css/font-awesome.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('/css/pnotify.custom.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('/css/style.min.css') ?>" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="<?php echo base_url('/js/html5shiv.min.js') ?>"></script>
    <script src="<?php echo base_url('/js/respond.min.js') ?>"></script>
    <![endif]-->
</head>
<body>

<?php $this->load->view('common/view_header.php'); ?>

<div class="container">
    <div class="row">
        <?php $this->load->view('common/view_menu_painel_editar', array('posicao' => 5)); ?>
        <div class="col-md-7">
            Bem Vindo <b><?php echo $nome_usuario; ?></b>
            <a class="pull-right" href="<?php echo base_url('/painel/logout') ?>">Sair do Sistema</a>
            <hr>
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <p class="header-painel">Alterar Fornecedor - Fornecedor Excluído</p>
                </div>
                <div class="panel-body">
                    <?php
                    if ($sucesso == TRUE) {
                        echo '
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="alert alert-success">
                                        <div class="text-center">
                                            <h5>Fornecedor removido com <b>sucesso!</b></h5>
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
                                            <b>Erro</b> ao remover o fornecedor.<br/>
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
                                   href="<?php echo base_url('/paineleditar/configuracoes/alterarfornecedor/lista'); ?>"><b>Voltar</b></a>
                            </div>
                        </div>
                    </div>
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

