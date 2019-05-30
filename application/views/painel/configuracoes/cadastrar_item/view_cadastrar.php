<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastrar Item - Configurações - SiGA</title>
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
<?php $this->load->view('common/view_menu_painel', array('posicao' => 10)); ?>

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
                                    Item cadastrado com <strong>sucesso!</strong>
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
                    <p class="header-painel">Cadastrar Item</p>
                </div>
                <div class="panel-body">
                    <form id="formCadastrarItem" action="<?php echo base_url('painel/configuracoes/cadastraritem/cadastrar'); ?>" method="post">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="formItem" class="control-label"><span style="color: #ac2925">*</span>Item:</label>
                                    <input id="formItem" name="formItem" type="text" placeholder="Insira o nome do item..." class="form-control"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="formUnidadePadrao" class="control-label"><span style="color: #ac2925">*</span>Unidade Padrão:</label>
                                    <select name="formUnidadePadrao" id="formUnidadePadrao" class="form-control">
                                        <?php
                                            if(isset($unidades_padrao)) {
                                                foreach ($unidades_padrao as $unidade_padrao) {
                                                    echo '<option value="' . $unidade_padrao['unidade_id'] . '">' . $unidade_padrao['nome'] . '</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <label for="formDescricao" class="control-label">Descrição: (Opcional)</label>
                                <input id="formDescricao" name="formDescricao" type="text" class="form-control" placeholder="Insira uma descrição..."/>
                            </div>
                            <div class="col-md-4">
                                <label for="formTipo" class="control-label"><span style="color: #ac2925">*</span>Tipo:</label>
                                <select name="formTipo" id="formTipo" class="form-control">
                                    <option value="0">Escolha o Tipo</option>
                                    <?php
                                        if(isset($tipos)) {
                                            foreach ($tipos as $valor => $nome) {
                                                echo '<option value="' . $valor . '">' . $nome . '</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-md-4 col-md-offset-4">
                                <a class="btn btn-success btn-block" id="botaoCadastrarItem"><b>Cadastrar Item</b></a>
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
                <div class="text-center"><h4 class="modal-title" id="myModalLabel">Confirmação de Cadastro de Item</h4></div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <h5>TIPO:</h5>
                    </div>
                    <div class="col-md-8">
                        <h5 id="confFormTipo" class="bold">(Sem tipo)</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <h5>ITEM:</h5>
                    </div>
                    <div class="col-md-8">
                        <h5 id="confFormItem" class="bold">(Sem item)</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <h5>UNIDADE PADRÃO:</h5>
                    </div>
                    <div class="col-md-8">
                        <h5 id="confFormUnidadePadrao" class="bold">(Sem unidade padrão)</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <h5>DESCRIÇÃO:</h5>
                    </div>
                    <div class="col-md-8">
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
<script src="<?php echo base_url('/js/painel/configuracoes/cadastrar-item.min.js') ?>"></script>


</body>
</html>
