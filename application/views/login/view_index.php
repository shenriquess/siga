<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - SiGA</title>
    <link href="<?php echo base_url('/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('/css/bootstrap-theme.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('/css/font-awesome.min.css') ?>" rel="stylesheet">
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


<?php
if (isset($erros)) {
    if ($erros == 1) {
        echo '<div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="col-md-4 col-md-offset-4">
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span
                                        class="sr-only">Close</span></button>
                                <div class="text-center">
                                    <strong>Usuário</strong> ou <strong>senha</strong> incorretos.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
    }
}
?>

<div class="content">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="col-md-4 col-md-offset-4">
                <div class="thumbnail">
                    <div class="text-center">
                        <h5 style="padding-bottom: 0px;"><b>SiGA</b></h5>
                        <h5>Secretaria de Educação</h5>
                    </div>
                    <div class="text-center">
                        <img src="<?php echo base_url('/images/brasaosaogoncalo.jpg'); ?>" alt="Brasão São Gonçalo"
                             width="160"/>
                    </div>
                    <br/>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="col-md-4 col-md-offset-4">
                <div class="col-md-12 well">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 align="center"><b>Login</b></h4>
                            <h5 align="center">Autenticação Necessária</h5>
                        </div>
                        <div class="panel-body">
                            <form action="<?php echo base_url('/login'); ?>" method="post">
                                <div class="form-group">
                                    <label for="formUsuario" class="control-label">Usuário:</label>

                                    <div class="input-group">
                                        <input type="text" class="form-control" id="formLoginUsuario"
                                               name="formLoginUsuario" required="required" placeholder="usuário"/>
                                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="formSenha" class="control-label">Senha:</label>

                                    <div class="input-group">
                                        <input type="password" class="form-control" id="formLoginSenha"
                                               name="formLoginSenha" required="required" placeholder="senha"/>
                                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6 col-md-offset-3">
                                            <input class="btn btn-success btn-block" type="submit" value="Entrar"
                                                   name="formEntrar"/>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('/js/jquery-2.1.1.min.js') ?>"></script>
<script src="<?php echo base_url('/js/bootstrap.min.js') ?>"></script>

</body>
</html>