<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alterar Item do Contrato - Configurações - SiGA</title>
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
                                    Item do Contrato alterado com <b>sucesso!</b>
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
        <?php $this->load->view('common/view_menu_painel_editar', array('posicao' => 3)); ?>
        <div class="col-md-7">
            Bem Vindo <b><?php echo $nome_usuario; ?></b>
            <a class="pull-right" href="<?php echo base_url('/painel/logout') ?>">Sair do Sistema</a>
            <hr>
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <p class="header-painel">Alterar Item do Contrato - Alterar Dados</p>
                </div>
                <div class="panel-body">
                    <form id="formAlterarItemContrato"
                          action="<?php echo base_url($url); ?>"
                          method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="formTipo" class="control-label"><span style="color: #ac2925">*</span>Tipo:</label>
                                    <select name="formTipo" id="formTipo" class="form-control">
                                        <option value="0">Tipo</option>
                                        <?php
                                        if (isset($tipos) && $tipos) {
                                            foreach ($tipos as $tipo) {
                                                if ($tipo['id_tipo'] == $item_contrato['id_tipo']) {
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="formItem" class="control-label"><span style="color: #ac2925">*</span>Item:</label>
                                    <select name="formItem" id="formItem" class="form-control">
                                        <option value="0">Item</option>
                                        <?php
                                        if (isset($itens) && $itens) {
                                            foreach ($itens as $item) {
                                                if ($item['id_item'] == $item_contrato['id_item']) {
                                                    echo '<option value="' . $item['id_item'] . '" selected="selected">' . $item['nome'] . "</option>";
                                                } else if ($item['id_tipo'] == $item_contrato['id_tipo']) {
                                                    echo '<option value="' . $item['id_item'] . '">' . $item['nome'] . "</option>";
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
                                            style="color: #ac2925">*</span>Valor:</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1">R$</span>
                                        <input id="formValor" name="formValor" type="text"
                                               class="form-control"
                                               placeholder="Valor"
                                            <?php
                                            if (isset($item_contrato['valor']) && $item_contrato['valor']) {
                                                echo 'value="' . number_format($item_contrato['valor'], 2, '.', '') . '"';
                                            }
                                            ?>
                                            />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="formQuantidade" class="control-label"><span
                                            style="color: #ac2925">*</span>Quantidade:</label>
                                    <input id="formQuantidade" name="formQuantidade" type="text"
                                           class="form-control"
                                           placeholder="Quantidade..."
                                        <?php
                                        if (isset($item_contrato['quantidade']) && $item_contrato['quantidade']) {
                                            echo 'value="' . $item_contrato['quantidade'] . '"';
                                        }
                                        ?>
                                        />
                                </div>
                            </div>
                            <div class="col-md-3">
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
                                   href="<?php echo base_url('/paineleditar/configuracoes/alterarcontrato/alterar/contrato/' . $item_contrato['id_contrato']); ?>"><b>Voltar</b></a>
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
                        Item do Contrato</h4></div>
            </div>
            <div class="modal-body">
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
                <div class="row">
                    <div class="col-md-4">
                        <h5>VALOR:</h5>
                    </div>
                    <div class="col-md-8">
                        <h5 id="confFormValor" class="bold">(Sem Valor)</h5>
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
    ?>
</script>
<script
    src="<?php echo base_url('/js/painel_editar/configuracoes/alterar_contrato/alterar-item-contrato.js') ?>"></script>

</body>
</html>

