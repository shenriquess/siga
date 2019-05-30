<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alterar Saída - Saída - SiGA</title>
    <link href="<?php echo base_url('/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('/css/bootstrap-theme.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link href="<?php echo base_url('/css/font-awesome.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('/css/datepicker3.min.css') ?>" rel="stylesheet">
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
<?php $this->load->view('common/view_menu_painel_editar', array('posicao' => 2)); ?>

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
                                    Saída alterada com <b>sucesso!</b>
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
                    <p class="header-painel">Alterar Saída - Alterar Dados</p>
                </div>
                <div class="panel-body">
                    <form id="formAlterarSaida"
                          action="<?php echo base_url($url); ?>"
                          method="post">
                        <input type="hidden" name="formItemAntigo"
                            <?php
                            if (isset($saida['id_item']) && $saida['id_item']) {
                                echo 'value="' . $saida['id_item'] . '"';
                            }
                            ?>
                            />

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="formDestino" class="control-label"><span
                                            style="color: #ac2925">*</span>Destino:</label>
                                    <select name="formDestino" id="formDestino" class="form-control">
                                        <option value="0">Selecione o Destino</option>
                                        <?php
                                        if (isset($destinos) && $destinos) {
                                            foreach ($destinos as $destino) {
                                                if ($destino['id_destino'] == $saida['id_destino']) {
                                                    echo '<option value="' . $destino['id_destino'] . '" selected="selected">' . $destino['nome'] . "</option>";
                                                } else {
                                                    echo '<option value="' . $destino['id_destino'] . '">' . $destino['nome'] . "</option>";
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-left">
                                    <label class="control-label"><span style="color: #ac2925">*</span>Data
                                        Saída</label>
                                </div>
                                <div id="dataSaida" class="input-group date">
                                    <input id="formDataSaida" name="formDataSaida" type="text" class="form-control"
                                           placeholder="Data Saída"
                                        <?php
                                        if (isset($saida['data_saida']) && $saida['data_saida']) {
                                            echo 'value="' . $saida['data_saida'] . '"';
                                        }
                                        ?>
                                           readonly/>
                                    <span id="data" class="input-group-addon"><i
                                            class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="formTipo" class="control-label"><span style="color: #ac2925">*</span>Tipo:</label>
                                    <select name="formTipo" id="formTipo" class="form-control">
                                        <option value="0">Tipo</option>
                                        <?php
                                        if (isset($tipos) && $tipos) {
                                            foreach ($tipos as $tipo) {
                                                if ($tipo['id_tipo'] == $saida['id_tipo']) {
                                                    echo '<option value="' . $tipo['id_tipo'] . '" selected="selected">' . $tipo['nome'] . "</option>";
                                                } else {
                                                    echo '<option value="' . $tipo['id_tipo'] . '">' . $tipo['nome'] . "</option>";
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="formItem" class="control-label"><span style="color: #ac2925">*</span>Item:</label>
                                    <select name="formItem" id="formItem" class="form-control">
                                        <option value="0">Item</option>
                                        <?php
                                        if (isset($itens) && $itens) {
                                            foreach ($itens as $item) {
                                                if ($item['id_item'] == $saida['id_item']) {
                                                    echo '<option value="' . $item['id_item'] . '" selected="selected">' . $item['nome'] . "</option>";
                                                } else if ($item['id_tipo'] == $saida['id_tipo']) {
                                                    echo '<option value="' . $item['id_item'] . '">' . $item['nome'] . "</option>";
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="formContrato" class="control-label"><span style="color: #ac2925">*</span>Contrato:</label>
                                    <select name="formContrato" id="formContrato" class="form-control">
                                        <option value="0">Contrato</option>
                                        <?php
                                        if (isset($contratos) && $contratos) {
                                          foreach ($contratos as $contrato) {
                                              if ($contrato['id_item'] == $saida['id_item']) {
                                                if($contrato['id_item_contrato'] == $saida['id_item_contrato']) {
                                                  echo '<option value="' . $contrato['id_item_contrato'] . '" selected="selected">' . $contrato['codigo'] . "</option>";
                                                }else{
                                                  echo '<option value="' . $contrato['id_item_contrato'] . '">' . $contrato['codigo'] . "</option>";
                                                }
                                              }
                                          }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="formQuantidade" class="control-label"><span
                                            style="color: #ac2925">*</span>Quantidade:</label>
                                    <input id="formQuantidade" name="formQuantidade" type="text"
                                           class="form-control"
                                           placeholder="Quantidade..."
                                        <?php
                                        if (isset($saida['quantidade']) && $saida['quantidade']) {
                                            echo 'value="' . $saida['quantidade'] . '"';
                                        }
                                        ?>
                                        />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div style="padding-top: 25px">
                                    <h5 id="labelUnidade"></h5>
                                </div>
                            </div>
                        </div>
                    </form>
                    <hr/>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center">
                                <a class="btn btn-default"
                                   href="<?php echo base_url('/paineleditar/saida/alterarsaida/lista'); ?>"><b>Voltar</b></a>
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
                        Saída</h4></div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <h5>DESTINO:</h5>
                    </div>
                    <div class="col-md-8">
                        <h5 id="confFormDestino" class="bold">(Sem nome Destino)</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <h5>DATA SAÍDA:</h5>
                    </div>
                    <div class="col-md-8">
                        <h5 id="confFormDataSaida" class="bold">(Sem Data)</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <h5>TIPO:</h5>
                    </div>
                    <div class="col-md-8">
                        <h5 id="confFormTipo" class="bold">(Sem Tipo)</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <h5>ITEM:</h5>
                    </div>
                    <div class="col-md-8">
                        <h5 id="confFormItem" class="bold">(Sem Item)</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <h5>QUANTIDADE:</h5>
                    </div>
                    <div class="col-md-8">
                        <h5 id="confFormQuantidade" class="bold">(Sem Quantidade_</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <h5>UNIDADE:</h5>
                    </div>
                    <div class="col-md-8">
                        <h5 id="confLabelUnidade" class="bold">(Sem Unidade)</h5>
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
<script src="<?php echo base_url('/js/bootstrap-datepicker.min.js') ?>"></script>
<script src="<?php echo base_url('/js/locales/bootstrap-datepicker.pt-BR.min.js') ?>"></script>
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

       if(isset($tipos)) {
           echo 'var tipos = '.json_encode($tipos).';';
       }

       if(isset($tsaidas)) {
           echo 'var tsaidas = '.json_encode($tsaidas).';';
       }

       if(isset($itens)) {
           echo 'var itens =  '.json_encode($itens).';';
       }

       if(isset($contratos)) {
           echo 'var contratos =  '.json_encode($contratos).';';
       }

       if(isset($unidades)) {
           echo 'var unidades = '.json_encode($unidades).';';
       }
    ?>
</script>
<script src="<?php echo base_url('/js/painel_editar/saida/alterar_saida/alterar.min.js') ?>"></script>

</body>
</html>
