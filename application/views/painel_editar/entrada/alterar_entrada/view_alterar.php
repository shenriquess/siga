<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alterar Entrada - Entrada - SiGA</title>
    <link href="<?php echo base_url('/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('/css/bootstrap-theme.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('/css/font-awesome.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('/css/datepicker3.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('/css/pnotify.custom.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('/css/style.min.css') ?>" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="<?php echo base_url('/js/html5shiv.min.js') ?>"></script>
    <script src="<?php echo base_url('/js/respond.min.js') ?>"></script>
    <![endif]-->
</head>
<body>

<?php $this->load->view('common/view_header.php'); ?>

<?php
// Inserção realizada com sucesso.
if (isset($sucesso)) {
    if ($sucesso === TRUE) {
        echo '<div class="container-fluid">
                    <div id="alertaSucesso" class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span
                                        class="sr-only">Close</span></button>
                                <div class="text-center">
                                    Entrada alterada com <b>sucesso!</b>
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
        echo '<div class="container-fluid">
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


<div class="container">
    <div class="row">
        <?php $this->load->view('common/view_menu_painel_editar', array('posicao' => 1)); ?>
        <div class="col-md-7">
            Bem Vindo <b><?php echo $nome_usuario; ?></b>
            <a class="pull-right" href="<?php echo base_url('/painel/logout') ?>">Sair do Sistema</a>
            <hr>
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <p class="header-painel">Alterar Entrada - Alterar Dados</p>
                </div>
                <div class="panel-body">
                    <form id="formAlterarEntrada"
                          action="<?php echo base_url($url); ?>"
                          method="post">
                        <input type="hidden" name="formItemAntigo"
                            <?php
                            if (isset($entrada['id_item']) && $entrada['id_item']) {
                                echo 'value="' . $entrada['id_item'] . '"';
                            }
                            ?>
                            />

                        <div class="row">
                            <div class="col-md-6">
                                <div class="text-left">
                                    <label class="control-label"><span style="color: #ac2925">*</span>Data
                                        Entrada</label>
                                </div>
                                <div id="dataEntrada" class="input-group date">
                                    <input id="formDataEntrada" name="formDataEntrada" type="text" class="form-control"
                                           placeholder="Data Entrada"
                                        <?php
                                        if (isset($entrada['data_entrada']) && $entrada['data_entrada']) {
                                            echo 'value="' . $entrada['data_entrada'] . '"';
                                        }
                                        ?>
                                           readonly/>
                                    <span id="data" class="input-group-addon"><i
                                            class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <br/>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="formCodigoContrato" class="control-label">Código do Contrato:</label>
                                    <input type="text" id="formCodigoContrato" name="formCodigoContrato"
                                           class="form-control"
                                        <?php
                                        if (isset($entrada['codigo'])) {
                                            echo 'value="' . $entrada['codigo'] . '" ';
                                        }
                                        ?>
                                           readonly/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="formNumeroNota" class="control-label"><span
                                            style="color: #ac2925">*</span>Número da
                                        Nota:</label>
                                    <input id="formNumeroNota" name="formNumeroNota" type="text" class="form-control"
                                        <?php
                                        if (isset($entrada['numero_nota'])) {
                                            echo 'value="' . $entrada['numero_nota'] . '" ';
                                        }
                                        ?>/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="formTipo" class="control-label"><span style="color: #ac2925">*</span>Tipo:</label>
                                    <input type="text" id="formTipo" name="formTipo"
                                           class="form-control"
                                        <?php
                                        if (isset($entrada['nome_tipo'])) {
                                            echo 'value="' . $entrada['nome_tipo'] . '" ';
                                        }
                                        ?>
                                           readonly/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="formItem" class="control-label"><span style="color: #ac2925">*</span>Item:</label>
                                    <input type="text" id="formItem" name="formItem"
                                           class="form-control"
                                        <?php
                                        if (isset($entrada['nome_item'])) {
                                            echo 'value="' . $entrada['nome_item'] . '" ';
                                        }
                                        ?>
                                           readonly/>
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
                                        if (isset($entrada['quantidade']) && $entrada['quantidade']) {
                                            echo 'value="' . $entrada['quantidade'] . '"';
                                        }
                                        ?>
                                        />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div style="padding-top: 25px">
                                    <h5 id="formUnidade"><?php
                                        if (isset($entrada['unidade_padrao_id']) && $entrada['unidade_padrao_id'] && isset($unidades)) {
                                            echo $unidades[$entrada['unidade_padrao_id']]['nome'];
                                        }
                                        ?></h5>
                                </div>
                            </div>
                        </div>
                    </form>
                    <hr/>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center">
                                <a class="btn btn-default"
                                   href="<?php echo base_url('/paineleditar/entrada/alterarentrada/lista'); ?>"><b>Voltar</b></a>
                                <button class="btn btn-success" id="botaoAlterarDados"><b>Alterar Dados</b></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('common/view_footer.php') ?>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <div class="text-center"><h4 class="modal-title" id="myModalLabel">Confirmação de Alteração de
                        Entrada</h4></div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <h5>DATA ENTRADA:</h5>
                    </div>
                    <div class="col-md-8">
                        <h5 id="confFormDataEntrada" class="bold">(Sem Data Entrada)</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <h5>CÓDIGO DO CONTRATO:</h5>
                    </div>
                    <div class="col-md-8">
                        <h5 id="confFormCodigoContrato" class="bold">(Sem Código do Contrato)</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <h5>NÚMERO NOTA:</h5>
                    </div>
                    <div class="col-md-8">
                        <h5 id="confFormNumeroNota" class="bold">(Sem Número Nota)</h5>
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
                        <h5 id="confFormUnidade" class="bold">(Sem Unidade)</h5>
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

       if(isset($itens)) {
           echo 'var itens =  '.json_encode($itens).';';
       }

       if(isset($unidades)) {
           echo 'var unidades = '.json_encode($unidades).';';
       }

       if(isset($entrada['id_contrato']) && $entrada['id_contrato']) {
           echo 'var idContrato = '.$entrada['id_contrato'].';';
       }

       echo 'var urlBase = "'.base_url().'";';
    ?>
</script>
<script src="<?php echo base_url('/js/painel_editar/entrada/alterar_entrada/alterar.js') ?>"></script>

</body>
</html>

