<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alterar Saída - Saída - SiGA</title>
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
        <?php $this->load->view('common/view_menu_painel_editar', array('posicao' => 2)); ?>
        <div class="col-md-7">
            Bem Vindo <b><?php echo $nome_usuario; ?></b>
            <a class="pull-right" href="<?php echo base_url('/painel/logout') ?>">Sair do Sistema</a>
            <hr>
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <p class="header-painel">Alterar Saída - Excluir Saída</p>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h5>Destino:</h5>
                        </div>
                        <div class="col-md-8">
                            <h5><b><?php echo $saida['nome_destino']; ?></b></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <h5>Data Saída:</h5>
                        </div>
                        <div class="col-md-8">
                            <h5><b><?php echo $saida['data_saida']; ?></b></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <h5>Tipo:</h5>
                        </div>
                        <div class="col-md-8">
                            <h5><b><?php echo $saida['nome_tipo']; ?></b></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <h5>Item:</h5>
                        </div>
                        <div class="col-md-8">
                            <h5><b><?php echo $saida['nome_item'] ?></b></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <h5>Quantidade:</h5>
                        </div>
                        <div class="col-md-8">
                            <h5>
                                <b><?php echo $saida['quantidade'] . ' ' . $unidades[$saida['unidade_padrao_id']]['nome'] ?></b>
                            </h5>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center">
                                <h5><b>Tem certeza que deseja excluir a saída acima?</b></h5>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center">
                                <a class="btn btn-default"
                                   href="<?php echo base_url('/paineleditar/saida/alterarsaida/lista'); ?>"><b>Não</b></a>
                                <a href="<?php echo base_url('/paineleditar/saida/alterarsaida/excluir/' . $saida['id_saida']); ?>"
                                   class="btn btn-danger"><b>Sim</b></a>
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

