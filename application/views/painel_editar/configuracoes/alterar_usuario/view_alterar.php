<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alterar Usuário - Configurações - SiGA</title>
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
<?php $this->load->view('common/view_menu_painel_editar', array('posicao' => 8)); ?>

<div class="content-wrapper">
  <section class="content">
    
<?php
    // Inserção realizada com sucesso.
    if (isset($sucesso)) {
        if ($sucesso === TRUE) {
            echo '<div class="container">
                    <div id="alertaSucesso" class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span
                                        class="sr-only">Close</span></button>
                                <div class="text-center">
                                    Usuário alterado com <b>sucesso!</b>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
        }
    }

    // Caso houve um erro no momento da inserção.
    if (isset($erro)) {
        if ($erro === TRUE && $erro_mensagem != "") {
            echo '<div class="container">
                    <div id="alertaErro" class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span
                                        class="sr-only">Close</span></button>
                                <div class="text-center">
                                   ' . $erro_mensagem . '
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
        }
    }
?>



    <div class="row">
      <div class="col-md-2"></div>
        <div class="col-md-8">

            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <p class="header-painel">Alterar Usuário - Alterar Dados</p>
                </div>
                <div class="panel-body">
                    <form id="formAlterarUsuario"
                          action="<?php echo base_url($url); ?>"
                          method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="formNomeCompleto" class="control-label"><span
                                            style="color: #ac2925">*</span>Nome Completo:</label>
                                    <input id="formNomeCompleto" name="formNomeCompleto" type="text"
                                           class="form-control"
                                           placeholder="Insira o nome completo do novo usuário..."
                                        <?php
                                            if (isset($usuario['nome']) && $usuario['nome']) {
                                                echo 'value="' . $usuario['nome'] . '"';
                                            }
                                        ?>
                                        />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="formUsuario" class="control-label"><span style="color: #ac2925">*</span>Usuário:</label>
                                    <input id="formUsuario" name="formUsuario" type="text" class="form-control"
                                           placeholder="Insira o Usuário..." autocomplete="off"
                                        <?php
                                            if (isset($usuario['nome_usuario']) && $usuario['nome_usuario']) {
                                                echo 'value="' . $usuario['nome_usuario'] . '"';
                                            }
                                        ?>
                                        />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div id="alterarSenha" hidden="hidden">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="formSenha" class="control-label"><span
                                                        style="color: #ac2925">*</span> Senha:</label>
                                                <input id="formSenha" name="formSenha" type="password"
                                                       class="form-control" placeholder="Insira a senha..."
                                                       autocomplete="off"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="formConfSenha" class="control-label"><span
                                                        style="color: #ac2925">*</span> Confirmação de senha:</label>
                                                <input id="formConfSenha" name="formConfSenha" type="password"
                                                       class="form-control" placeholder="Confirmação de senha..."
                                                       autocomplete="off"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="formNivel" class="control-label"><span style="color: #ac2925">*</span>Nível
                                        de Permissão:</label>
                                    <select id="formNivel" name="formNivel" class="form-control">
                                        <option value="0">Escolha o Nível</option>
                                        <?php
                                            if (isset($usuario['nivel']) && $usuario['nivel']) {
                                                for ($i = 1; $i <= 2; $i++) {
                                                    if ($usuario['nivel'] == $i) {
                                                        echo '<option value="' . $i . '" selected="selected">Nível ' . $i . '</option>';
                                                    } else {
                                                        echo '<option value="' . $i . '">Nível ' . $i . '</option>';
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-12">
                            <a id="avisoAlterarSenha">Clique aqui caso queira alterar a senha</a>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center">
                                <a class="btn btn-default"
                                   href="<?php echo base_url('/paineleditar/configuracoes/alterarusuario/lista'); ?>"><b>Voltar</b></a>
                                <button class="btn btn-success" id="botaoAlterarDados"><b>Alterar Dados</b></button>
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

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <div class="text-center"><h4 class="modal-title" id="myModalLabel">Confirmação de Alteração de
                        Usuário</h4></div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <h5>NOME COMPLETO:</h5>
                    </div>
                    <div class="col-md-8">
                        <h5 id="confFormNomeCompleto" class="bold">(Sem nome completo)</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <h5>LOGIN:</h5>
                    </div>
                    <div class="col-md-8">
                        <h5 id="confFormUsuario" class="bold">(Sem Usuario)</h5>
                    </div>
                </div>
                <div class="row" id="divConfFormSenha" hidden="hidden">
                    <div class="col-md-4">
                        <h5>SENHA:</h5>
                    </div>
                    <div class="col-md-8">
                        <h5 id="confFormSenha" class="bold">(Clique aqui para visualizar)</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <h5>NÍVEL DE USUÁRIO:</h5>
                    </div>
                    <div class="col-md-8">
                        <h5 id="confFormNivel" class="bold">(Sem nível de usuário)</h5>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <h5>Os dados acima estão corretos?</h5>
                <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                <button id="confFormEnviar" type="button" class="btn btn-success">Sim</button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('/js/jquery-2.1.1.min.js') ?>"></script>
<script src="<?php echo base_url('/js/bootstrap.min.js') ?>"></script>
<script src="<?php echo base_url('/js/pnotify.custom.min.js') ?>"></script>
<script src="<?php echo base_url('/js/comum/script.min.js') ?>"></script>
<script src="<?php echo base_url('/js/jquery.slimscroll.min.js') ?>"></script>
<script src="<?php echo base_url('/js/adminlte.js') ?>"></script>
<script type="application/javascript">
    <?php
       if(isset($sucesso)) {
           if($sucesso === 1) {
               echo '$("#alertaSucesso").delay(5000).fadeOut(1000);';
           }
       }
    ?>
</script>
<script src="<?php echo base_url('/js/painel_editar/configuracoes/alterar_usuario/alterar.min.js') ?>"></script>

</body>
</html>
