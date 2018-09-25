<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alterar Usuário - Configurações - SiGA</title>
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

<?php $this->load->view('common/view_header.php'); ?>

<div class="container">
    <div class="row">
        <?php $this->load->view('common/view_menu_painel_editar', array('posicao' => 8)); ?>
        <div class="col-md-7">
            Bem Vindo <b><?php echo $nome_usuario; ?></b>
            <a class="pull-right" href="<?php echo base_url('/painel/logout') ?>">Sair do Sistema</a>
            <hr>
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <p class="header-painel">Alterar Usuário - Usuários Cadastrados</p>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="well">
                                <div class="row thumbnail">
                                    <div class="col-md-5"><h5><b>NOME</b></h5></div>
                                    <div class="col-md-4"><h5><b>NOME DE USUÁRIO</b></h5></div>
                                    <div class="col-md-3">
                                        <h5><b>EDITAR|EXCLUIR</b></h5>
                                    </div>
                                </div>
                                <div class="row thumbnail">
                                    <div class="col-md-12 div-scrollbar-2x">
                                        <br/>
                                        <?php
                                        if (isset($usuarios) && $usuarios) {
                                            foreach ($usuarios as $usuario) {
                                                $url_editar = base_url('/paineleditar/configuracoes/alterarusuario/alterar/' . $usuario['id_usuario']);
                                                $url_excluir = base_url('/paineleditar/configuracoes/alterarusuario/confirmarexcluir/' . $usuario['id_usuario']);

                                                echo '<div class="row">';
                                                echo '<div class="col-md-5">';
                                                echo '<h5>' . $usuario['nome'] . '</h5>';
                                                echo '</div>';
                                                echo '<div class="col-md-4">';
                                                echo '<h5>&nbsp;' . $usuario['nome_usuario'] . '</h5>';
                                                echo '</div>';
                                                echo '<div class="col-md-3">';
                                                echo '<div class="pull-right">';
                                                echo '<a class="btn btn-default" href="' . $url_editar . '"><i class="fa fa-edit"></i></a>';
                                                echo '<a class="btn btn-danger" href="' . $url_excluir . '"><i class="fa fa-trash excluir"></i></a>';
                                                echo '</div>';
                                                echo '</div>';
                                                echo '</div>';
                                                echo '<hr/>';
                                            }
                                        } else {
                                            echo '<div class="text-center"><h5>No momento não há cadastro de usuários.</h5></div>';
                                        }
                                        ?>
                                    </div>
                                </div>
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
