<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alterar Contrato - Configurações - SiGA</title>
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
                                    Contrato alterado com <b>sucesso!</b>
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
                    <p class="header-painel">Alterar Contrato - Alterar Dados</p>
                </div>
                <div class="panel-body">
                    <form id="formAlterarContrato"
                          action="<?php echo base_url($url); ?>"
                          method="post">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="formFornecedor" class="control-label"><span
                                            style="color: #ac2925">*</span>Fornecedor:</label>
                                    <select id="formFornecedor" name="formFornecedor" class="form-control">
                                        <option value="0">Fornecedor</option>
                                        <?php
                                        if (isset($contrato['id_fornecedor']) && isset($fornecedores)) {
                                            foreach ($fornecedores as $fornecedor) {
                                                if ($fornecedor['id_fornecedor'] == $contrato['id_fornecedor']) {
                                                    echo '<option value="' . $fornecedor['id_fornecedor'] . '" selected="selected">' . $fornecedor['nome'] . '</option>';
                                                } else {
                                                    echo '<option value="' . $fornecedor['id_fornecedor'] . '">' . $fornecedor['nome'] . '</option>';
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="formCodigo" class="control-label"><span
                                            style="color: #ac2925">*</span>Código:</label>
                                    <input id="formCodigo" name="formCodigo" type="text" class="form-control"
                                           placeholder="Insira uma breve descrição..." autocomplete="off"
                                        <?php
                                        if (isset($contrato['codigo'])) {
                                            echo 'value="' . $contrato['codigo'] . '"';
                                        }
                                        ?>
                                        />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="control-label"><span style="color: #ac2925">*</span>Período de
                                        Vigência</label>

                                    <div class="row">
                                        <div class="col-md-5">
                                            <div id="dataInicio" class="input-group date">
                                                <input id="formDataInicio" name="formDataInicio" type="text"
                                                       class="form-control" placeholder="Data Início"
                                                    <?php
                                                    if (isset($contrato['data_inicio']) && $contrato['data_inicio']) {
                                                        echo 'value="' . $contrato['data_inicio'] . '"';
                                                    }
                                                    ?>
                                                       readonly>
                                                <span id="spanDataInicio" class="input-group-addon"><i
                                                        class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="text-center"><h5><b>até</b></h5></div>
                                        </div>
                                        <div class="col-md-5">
                                            <div id="dataFim" class="input-group date">
                                                <input id="formDataFim" name="formDataFim" type="text"
                                                       class="form-control" placeholder="Data Fim"
                                                    <?php
                                                    if (isset($contrato['data_fim']) && $contrato['data_fim']) {
                                                        echo 'value="' . $contrato['data_fim'] . '"';
                                                    }
                                                    ?>
                                                       readonly>
                                                <span id="spanDataFim" class="input-group-addon"><i
                                                        class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-4">
                            <hr/>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <h5><b>Itens do Contrato</b></h5>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <hr/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-2"><h5><b>TIPO</b></h5></div>
                            <div class="col-md-3"><h5><b>ITEM</b></h5></div>
                            <div class="col-md-3"><h5><b>QUANTIDADE</b></h5></div>
                            <div class="col-md-2"><h5><b>VALOR</b></h5></div>
                            <div class="col-md-2">
                                <div class="text-center"><h5><b>ED.|EX.</b></h5></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            if (isset($itens_contrato) && $itens_contrato) {
                                foreach ($itens_contrato as $item_contrato) {
                                    $url_editar = base_url('/paineleditar/configuracoes/alterarcontrato/alterar/itemcontrato/' . $item_contrato['id_item_contrato']);
                                    $url_excluir = base_url('/paineleditar/configuracoes/alterarcontrato/confirmarexcluir/itemcontrato/' . $item_contrato['id_item_contrato']);

                                    echo '<div class="row">';
                                    echo '<div class="col-md-2">';
                                    echo '<h5>' . $item_contrato['nome_tipo'] . '</h5>';
                                    echo '</div>';
                                    echo '<div class="col-md-3">';
                                    echo '<h5>&nbsp;' . $item_contrato['nome_item'] . '</h5>';
                                    echo '</div>';
                                    echo '<div class="col-md-3">';
                                    echo '<h5>&nbsp;' . $item_contrato['quantidade'] . ' ' . $unidades[$item_contrato['unidade_padrao_id']]['nome'] . '</h5>';
                                    echo '</div>';
                                    echo '<div class="col-md-2">';
                                    echo '<h5>&nbsp;R$ ' . number_format($item_contrato['valor'], 2, '.', '') . '</h5>';
                                    echo '</div>';
                                    echo '<div class="col-md-2">';
                                    echo '<div class="pull-center">';
                                    echo '<a class="btn btn-default" href="' . $url_editar . '"><i class="fa fa-edit"></i></a>';
                                    echo '<a class="btn btn-danger" href="' . $url_excluir . '"><i class="fa fa-trash excluir"></i></a>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '</div>';
                                    echo '<hr/>';
                                }
                            } else {
                                echo '<div class="text-center"><h5>No momento não há cadastro de contratos.</h5></div>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center">
                                <a class="btn btn-default"
                                   href="<?php echo base_url('/paineleditar/configuracoes/alterarcontrato/lista'); ?>"><b>Voltar</b></a>
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
                        Contrato</h4></div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <h5>FORNECEDOR:</h5>
                    </div>
                    <div class="col-md-8">
                        <h5 id="confFormFornecedor" class="bold">(Sem Fornecedor)</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <h5>CÓDIGO:</h5>
                    </div>
                    <div class="col-md-8">
                        <h5 id="confFormCodigo" class="bold">(Sem Código)</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <h5>PERÍODO DE VIGÊNCIA:</h5>
                    </div>
                    <div class="col-md-8">
                        <h5 id="confFormVigencia" class="bold">(Sem Vigência)</h5>
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
    ?>
</script>
<script src="<?php echo base_url('/js/painel_editar/configuracoes/alterar_contrato/alterar-contrato.js') ?>"></script>

</body>
</html>

