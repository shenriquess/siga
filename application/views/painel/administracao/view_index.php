<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - SiGA Edit</title>
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
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

<?php $this->load->view('common/view_header.php'); ?>
<?php $this->load->view('common/view_menu_painel', array('posicao' => 14)); ?>

<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <div class="col-md-2"></div>
        <div class="col-md-8">

            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <p class="header-painel">Login - SiGA - Modo Edição</p>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span
                                        aria-hidden="true">&times;</span><span
                                        class="sr-only">Close</span></button>
                                <div class="text-center">
                                    <b>Atenção!</b> Tenha cuidado ao alterar as informações do banco de dados, pois
                                    poderá gerar inconsistências.
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    // Caso houve erro de autenticação.
                    if (isset($erro)) {
                        if ($erro === 1 && $erro_mensagem != "") {
                            echo '<div class="row">
                                    <div class="col-md-8 col-md-offset-2">
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert"><span
                                                    aria-hidden="true">&times;</span><span
                                                    class="sr-only">Close</span></button>
                                            <div class="text-center">
                                                ' . $erro_mensagem . '
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                        }
                    }
                    ?>
                </div>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="panel panel-default">
                            <div class="text-center"><h5><b>ACESSO RESTRITO</b></h5></div>
                            <div class="panel-footer">
                                <h5 align="center">Por favor, verifique suas credenciais.</h5>
                            </div>
                            <div class="panel-body">
                                <form action="<?php echo base_url('/painel/administracao/login'); ?>" method="post">
                                    <div class="form-group">
                                        <label for="formUsuario" class="control-label">Usuário:</label>

                                        <div class="input-group">
                                            <input type="text" class="form-control" id="formUsuario" name="formUsuario"
                                                   required="required" autocomplete="off" placeholder="usuário"/>
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="formSenha" class="control-label">Senha:</label>

                                        <div class="input-group">
                                            <input type="password" class="form-control" id="formSenha" name="formSenha"
                                                   required="required" autocomplete="off" placeholder="senha"/>
                                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6 col-md-offset-3">
                                                <input class="btn btn-success btn-block" type="submit" value="Acessar"
                                                       name="formEntrar"/>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <br>
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
