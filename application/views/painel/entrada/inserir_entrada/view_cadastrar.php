<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inserir Entrada - Entrada - SiGA</title>
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
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<?php $this->load->view('common/view_header.php'); ?>
<?php $this->load->view('common/view_menu_painel', array('posicao' => 0)); ?>

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
                                    Entrada cadastrada com <strong>sucesso!</strong>
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
                    <p class="header-painel">Inserir Entrada</p>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="formContrato" class="control-label"><span
                                        style="color: #ac2925">*</span>Selecione o Contrato:</label>
                                <select id="formContrato" name="formContrato" class="form-control"
                                        required="required">
                                    <option value="0">Escolha o Contrato</option>
                                    <?php
                                    if (isset($contratos) && $contratos) {
                                        foreach ($contratos as $contrato) {
                                            echo '<option value="' . $contrato['id_contrato'] . '">' . $contrato['nome'] . ' - ' . $contrato['codigo'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="formNumeroNota" class="control-label"><span
                                        style="color: #ac2925">*</span>Número Nota:</label>
                                <input id="formNumeroNota" name="formNumeroNota" type="text" class="form-control"
                                       placeholder="Insira o número da nota. "
                                       required="required"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="formDataEntrada" class="control-label"><span style="color: #ac2925">*</span>Data
                                Entrada</label>

                            <div id="dataEntrada" class="input-group date">
                                <input id="formDataEntrada" name="formDataEntrada" type="text" class="form-control"
                                       placeholder="Data Entrada"
                                       readonly>
                                    <span id="data" class="input-group-addon"><i
                                            class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <hr/>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center"><h5><b>Adicionar novo item</b></h5></div>
                        </div>
                        <div class="col-md-4">
                            <hr/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6" style="padding-right: 0;">
                            <select class="form-control" id="formItemContrato">
                                <option value="0">Item</option>
                            </select>
                        </div>
                        <div class="col-md-3" style="padding-right: 0; padding-left: 4px;">
                            <input type="text" class="form-control" id="formQuantidade" placeholder="Quantidade"/>
                        </div>
                        <div class="col-md-3" style="padding-left: 4px;">
                            <h5><div id="formUnidade"></div></h5>
                        </div>
                    </div>
                    <br/>

                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <button id="botaoAdicionar" class="btn btn-default btn-block">Adicionar a Lista</button>
                        </div>
                    </div>
                    <br/>

                    <div class="row">
                        <div class="col-md-3">
                            <hr/>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center"><h5><b>Lista dos itens a serem retirados</b></h5></div>
                        </div>
                        <div class="col-md-3">
                            <hr/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <h5><b>ITEM</b></h5>
                        </div>
                        <div class="col-md-4">
                            <h5><b>QUANTIDADE</b></h5>
                        </div>
                        <div class="col-md-4 text-right">
                            <h5><b>EDITAR | EXCLUIR</b></h5>
                        </div>
                    </div>
                    <br/>

                    <div id="listaVazia">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-center">
                                    <div class="alert alert-warning" role="alert">
                                        <b>Lista Vazia</b>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="listaItens">
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <a id="botaoInserirEntrada" class="btn btn-success btn-block"><b>Inserir Entrada</b></a>
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


<!-- Modal -->
<div class="modal fade" id="modalConfirmacao" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <div class="text-center"><h4 class="modal-title" id="modalTitulo">Confirmação de Cadastro de
                        Entrada</h4></div>
            </div>
            <div class="modal-body" id="modalCorpo">
                <div id="barraProgresso" style="display: none;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center">
                                <h4>
                                    Realizando cadastro do contrato.<br/>
                                    Por favor, aguarde...
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped active" role="progressbar"
                                     aria-valuenow="45"
                                     aria-valuemin="0"
                                     aria-valuemax="100" style="width: 100%">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <h5>CONTRATO:</h5>
                    </div>
                    <div class="col-md-9">
                        <h5 id="confFormContrato" class="bold">(Sem contrato)</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <h5>NÚMERO NOTA:</h5>
                    </div>
                    <div class="col-md-9">
                        <h5 id="confFormNumeroNota" class="bold">(Sem número nota)</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <h5>DATA ENTRADA:</h5>
                    </div>
                    <div class="col-md-9">
                        <h5 id="confFormDataEntrada" class="bold">(Sem Data Entrada)</h5>
                    </div>
                </div>
                <br/>

                <div class="row">
                    <div class="col-md-4">
                        <hr/>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <h5><b>Itens entregues</b></h5>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <hr/>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h5><b>ITEM</b></h5>
                    </div>
                    <div class="col-md-6">
                        <h5><b>QUANTIDADE</b></h5>
                    </div>
                </div>

                <div id="confListaItens"></div>

                <div class="modal-footer" id="modalRodape">
                    <h5>Os dados acima estão corretos?</h5>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                    <button id="confBotaoEnviar" type="button" class="btn btn-success">Sim</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Alerta -->
<div class="modal fade" id="modalAlerta" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabelAlerta"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span
                        aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <div class="text-center"><h4 class="modal-title" id="myModalLabel">Atenção</h4></div>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <b>Ao alterar o contrato todos as informações dos itens já preenchidos serão perdidas.</b>
                </div>
            </div>
            <div class="modal-footer">
                <h5>Deseja continuar?</h5>
                <button id="botaoAlertaNao" type="button" class="btn btn-default" data-dismiss="modal" value="0">Não
                </button>
                <button id="botaoAlertaSim" type="button" class="btn btn-danger" data-dismiss="modal" value="1">Sim
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalErro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <div class="text-center"><h4 class="modal-title">Erro de Conexão</h4>
                </div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                            <h4>Erro de Conexão.<br>Por favor, tente novamente.</h4>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url('/js/jquery-2.1.1.min.js') ?>"></script>
<script src="<?php echo base_url('/js/bootstrap.min.js') ?>"></script>
<script src="<?php echo base_url('/js/bootstrap-datepicker.js') ?>"></script>
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

        // Passando os valores dos contratos para o JS.
        if(isset($contratos)) {
            echo 'var contratos = '.json_encode($contratos).';';
        }
        if(isset($unidades)) {
            echo 'var unidades = '.json_encode($unidades).';';
        }
        echo 'var urlBase = "'.base_url().'";'
    ?>
</script>
<script src="<?php echo base_url('/js/painel/entrada/inserir-entrada/cadastrar.min.js') ?>"></script>
</body>
</html>
