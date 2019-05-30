<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastrar Destino - Configurações - SiGA</title>
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
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

<?php $this->load->view('common/view_header.php'); ?>
<?php $this->load->view('common/view_menu_painel', array('posicao' => 8)); ?>

<div class="content-wrapper">
  <section class="content">

<?php
// Inserção realizada com sucesso.
if (isset($sucesso)) {
    if ($sucesso === 1) {
        echo '<div class="container">
                    <div id="alertaSucesso" class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span
                                        class="sr-only">Close</span></button>
                                <div class="text-center">
                                    Destinatário cadastrado com <strong>sucesso!</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
    }
}

// Caso houve um erro no momento da inserção.
if (isset($erro)) {
    if ($erro === 1 && $erro_mensagem != "") {
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
                    <p class="header-painel">Cadastrar Destino</p>
                </div>
                <div class="panel-body">
                    <form id="formCadastrarDestino" action="<?php echo base_url('/painel/configuracoes/cadastrardestino/cadastrar'); ?>" method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group has-feedback">
                                    <label for="formDestino" class="control-label"><span style="color: #ac2925">*</span>Destino:</label>
                                    <input type="text" id="formDestino" name="formDestino" placeholder="Insira o nome do destino..." class="form-control"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="formDescricao" class="control-label">Descrição (Opcional)</label>
                                    <input type="text" id="formDescricao" name="formDescricao" placeholder="Insira uma breve descrição..."
                                           class="form-control"/>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-md-4 col-md-offset-4">
                                <a class="btn btn-success btn-block" id="botaoCadastrarDestino"><strong>Cadastrar Destino</strong></a>
                            </div>
                        </div>
                    </form>
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
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <div class="text-center"><h4 class="modal-title" id="myModalLabel">Confirmação de Cadastro de Destino</h4></div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-2">
                        <h5>DESTINO:</h5>
                    </div>
                    <div class="col-md-10">
                        <h5 id="confFormDestino" class="bold">(Sem destino)</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <h5>DESCRIÇÃO:</h5>
                    </div>
                    <div class="col-md-10">
                        <h5 id="confFormDescricao" class="bold">(Sem descrição)</h5>
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
<script src="<?php echo base_url('/js/painel/configuracoes/cadastrar-destino.min.js') ?>"></script>


</body>
</html>
