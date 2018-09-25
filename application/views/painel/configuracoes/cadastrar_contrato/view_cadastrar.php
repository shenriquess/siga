<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastrar Contrato - Configurações - SiGA</title>
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
    if ($sucesso === 1) {
        echo '<div class="container-fluid">
                    <div id="alertaSucesso" class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span
                                        class="sr-only">Close</span></button>
                                <div class="text-center">
                                    Contrato cadastrado com <strong>sucesso!</strong>
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
        <?php $this->load->view('common/view_menu_painel', array('posicao' => 7)); ?>
        <div class="col-md-7">
            Bem Vindo <b><?php echo $nome_usuario; ?></b>
            <a class="pull-right" href="<?php echo base_url('/painel/logout') ?>">Sair do Sistema</a>
            <hr>
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <p class="header-painel">Cadastrar Contrato</p>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8">
                            <label for="formFornecedor" class="control-label"><span style="color: #ac2925">*</span>Fornecedor:</label>
                            <select name="formFornecedor" id="formFornecedor" class="form-control">
                                <option value="0">Selecione um fornecedor</option>
                                <?php
                                if (isset($fornecedores)) {
                                    foreach ($fornecedores as $fornecedor) {
                                        echo '<option value="' . $fornecedor['id_fornecedor'] . '">' . $fornecedor['nome'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="control-label" for="formCodigo"><span
                                    style="color: #ac2925">*</span>Código:</label>
                            <input id="formCodigo" name="formCodigo" type="text" class="form-control"
                                   placeholder="Insira o código..."/>
                        </div>
                    </div>
                    <br/>

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
                                                   class="form-control" placeholder="Data Fim" readonly>
                                                <span id="spanDataFim" class="input-group-addon"><i
                                                        class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="alertaCodigoCadastrado" hidden="hidden">
                            <div class="col-md-4">
                                <div class="alert alert-warning" role="alert">
                                    <b>Atenção:</b><br/>
                                    Contrato Cadastrado.
                                </div>
                            </div>
                        </div>
                    </div>
                    <br/>

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
                        <div class="col-md-3" style="padding-right: 0;">
                            <select id="formTipo" class="form-control">
                                <option value="0">Tipo</option>
                                <?php
                                if (isset($tipos) && $tipos) {
                                    foreach ($tipos as $tipo) {
                                        echo '<option value="' . $tipo['id_tipo'] . '">' . $tipo['nome'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3" style="padding-right: 0; padding-left: 4px;">
                            <select class="form-control" id="formItem">
                                <option value="0">Item</option>
                            </select>
                        </div>
                        <div class="col-md-6" style="padding-left: 4px;">
                            <div class="col-md-3" style="padding-right: 0; padding-left: 4px;">
                                <input type="text" class="form-control" id="formQuantidade" placeholder="Qnt."/>
                            </div>
                            <div class="col-md-9" style="padding-right: 0;">
                                <div class="row">
                                    <div class="col-md-5" style="padding-left: 4px;">
                                        <h5>
                                            <div id="formUnidade"></div>
                                        </h5>
                                    </div>
                                    <div class="col-md-7" style="padding-left: 0px;">
                                        <div class="input-group">
                                            <span id="spanDataFim" class="input-group-addon">R$</span>
                                            <input type="text" id="formPreco" class="form-control" placeholder="Valor"/>
                                        </div>

                                    </div>
                                </div>
                            </div>
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
                            <div class="text-center"><h5><b>Lista dos itens a serem cadastrados</b></h5></div>
                        </div>
                        <div class="col-md-3">
                            <hr/>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-3">
                            <h5><b>TIPO</b></h5>
                        </div>
                        <div class="col-md-3">
                            <h5><b>ITEM</b></h5>
                        </div>
                        <div class="col-md-2">
                            <h5><b>QUANTIDADE</b></h5>
                        </div>
                        <div class="col-md-2">
                            <h5><b>VALOR UN.</b></h5>
                        </div>
                        <div class="col-md-2">
                            <h5><b>ED.|EXCL.</b></h5>
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

                    <div id="listaCadastradaColunas" hidden="hidden">
                        <div class="row">
                            <div class="col-md-3">
                                <hr/>
                            </div>
                            <div class="col-md-6">
                                <div class="text-center"><h5><b>Lista dos itens já cadastrados</b></h5></div>
                            </div>
                            <div class="col-md-3">
                                <hr/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h5><b>TIPO</b></h5>
                            </div>
                            <div class="col-md-3">
                                <h5><b>ITEM</b></h5>
                            </div>
                            <div class="col-md-3">
                                <h5><b>QUANTIDADE</b></h5>
                            </div>
                            <div class="col-md-2">
                                <h5><b>VALOR UN.</b></h5>
                            </div>
                        </div>
                        <br/>
                    </div>

                    <div id="listaCadastrada">
                    </div>

                    <div class="row">
                        <div class="col-md-10">
                            <hr/>
                        </div>
                        <div class="col-md-2">
                            <h5><b>Valor Total</b></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-md-offset-9">
                            <div class="text-right">
                                <div class="thumbnail"><h5><b id="valorTotal">R$ 0.00</b></h5></div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <a class="btn btn-success btn-block" id="botaoCadastrarContrato"><b>Cadastrar
                                    Contrato</b></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('common/view_footer.php') ?>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <div class="text-center"><h4 class="modal-title" id="modalTitulo">Confirmação de Cadastro de
                        Contrato</h4></div>
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
                    <div class="col-md-4">
                        <h5>FORNECEDOR:</h5>
                    </div>
                    <div class="col-md-8">
                        <h5 id="confFormFornecedor" class="bold">(Sem fornecedor)</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <h5>CÓDIGO:</h5>
                    </div>
                    <div class="col-md-8">
                        <h5 id="confFormCodigo" class="bold">(Sem código)</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <h5>PERÍODO DE VIGÊNCIA:</h5>
                    </div>
                    <div class="col-md-8">
                        <h5 class="bold"><span id="confFormDataInicio">(Sem data início)</span> ATÉ <span
                                id="confFormDataFim">(Sem data fim)</span></h5>
                    </div>
                </div>
                <br/>

                <div class="row">
                    <div class="col-md-3">
                        <hr/>
                    </div>
                    <div class="col-md-6">
                        <div class="text-center"><h5><b>Itens a serem cadastrados</b></h5></div>
                    </div>
                    <div class="col-md-3">
                        <hr/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3" style="padding-right: 0;">
                        <h5><b>TIPO</b></h5>
                    </div>
                    <div class="col-md-3" style="padding-right: 0; padding-left: 4px;">
                        <h5><b>ITEM</b></h5>
                    </div>
                    <div class="col-md-3" style="padding-right: 0; padding-left: 4px;">
                        <h5><b>QUANTIDADE</b></h5>
                    </div>
                    <div class="col-md-3" style="padding-left: 4px;">
                        <h5><b>VALOR</b></h5>
                    </div>
                </div>
                <div id="confListaItem">
                </div>

                <br/>

                <div id="confListaCadastradaColunas" hidden="hidden">
                    <div class="row">
                        <div class="col-md-4">
                            <hr/>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center"><h5><b>Itens já cadastrados</b></h5></div>
                        </div>
                        <div class="col-md-4">
                            <hr/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3" style="padding-right: 0;">
                            <h5><b>TIPO</b></h5>
                        </div>
                        <div class="col-md-3" style="padding-right: 0; padding-left: 4px;">
                            <h5><b>ITEM</b></h5>
                        </div>
                        <div class="col-md-3" style="padding-right: 0; padding-left: 4px;">
                            <h5><b>QUANTIDADE</b></h5>
                        </div>
                        <div class="col-md-3" style="padding-left: 4px;">
                            <h5><b>VALOR</b></h5>
                        </div>
                    </div>
                </div>
                <div id="confListaCadastrada"></div>

                <div class="row">
                    <div class="col-md-9">
                        <hr/>
                    </div>
                    <div class="col-md-3">
                        <div class="pull-right">
                            <h5><b>Valor Total</b></h5>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-md-offset-8">
                        <div class="text-right">
                            <div class="thumbnail"><h5><b id="confValorTotal">(Sem valor total)</b></h5></div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer" id="modalRodape">
                <h5>Os dados acima estão corretos?</h5>
                <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                <button id="confBotaoEnviar" type="button" class="btn btn-success">Sim</button>
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
<script type="application/javascript">
    <?php
       if(isset($sucesso)) {
           if($sucesso === 1) {
               echo '$("#alertaSucesso").delay(5000).fadeOut(1000);';
           }
       }
    ?>

    var itens = {};
    var tipos = {};
    var unidades = {};
    var contratos = {};

    <?php
        echo 'var urlBase = "'.base_url().'";';

        // Passando para JS.
        if(isset($itens)) {
            echo 'itens = '.json_encode($itens).';';
        }
        if(isset($tipos)) {
           echo 'tipos = '.json_encode($tipos).';';
        }
        if(isset($unidades)) {
           echo 'unidades = '.json_encode($unidades).';';
        }
        if(isset($contratos)) {
            echo 'contratos = '.json_encode($contratos).';';
        }
    ?>
</script>
<script src="<?php echo base_url('/js/painel/configuracoes/cadastrar-contrato.js') ?>"></script>

</body>
</html>
