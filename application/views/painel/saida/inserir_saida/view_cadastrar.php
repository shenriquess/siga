<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inserir Saída - Saída - SiGA</title>
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
                                    Saída cadastrada com <strong>sucesso!</strong>
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
        <?php $this->load->view('common/view_menu_painel', array('posicao' => 1)); ?>
        <div class="col-md-7">
            Bem Vindo <b><?php echo $nome_usuario; ?></b>
            <a class="pull-right" href="<?php echo base_url('/painel/logout'); ?>">Sair do Sistema</a>
            <hr>
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <p class="header-painel">Inserir Saída</p>
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="text-center">
                                <label for="formDestino" class="control-label"><span style="color: #ac2925">*</span>Escolha
                                    o Destino</label>
                            </div>
                            <select name="formDestino" id="formDestino" class="form-control">
                                <option value="0">Escolha o destino</option>
                                <?php
                                if (isset($destinos) && $destinos) {
                                    foreach ($destinos as $destino) {
                                        echo '<option value="' . $destino['id_destino'] . '">' . $destino['nome'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <br/>

                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <div class="text-center">
                                <label class="control-label"><span style="color: #ac2925">*</span>Data Saída</label>
                            </div>
                            <div id="dataSaida" class="input-group date">
                                <input id="formDataSaida" name="formDataSaida" type="text" class="form-control"
                                       placeholder="Data Saída" readonly>
                                    <span id="data" class="input-group-addon"><i
                                            class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <br>

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
                        <div class="col-md-2" style="padding-right: 0; padding-left: 4px;">
                            <select class="form-control" id="formItem">
                                <option value="0">Item</option>
                            </select>
                        </div>
                        <div class="col-md-2" style="padding-right: 0; padding-left: 4px;">
                            <select class="form-control" id="formContrato">
                                <option value="0">Contrato</option>
                            </select>
                        </div>
                        <div class="col-md-2" style="padding-right: 0; padding-left: 4px;">
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
                        <div class="col-md-2">
                            <h5><b>TIPO</b></h5>
                        </div>
                        <div class="col-md-3">
                            <h5><b>ITEM</b></h5>
                        </div>
                        <div class="col-md-2">
                            <h5><b>CONTRATO</b></h5>
                        </div>
                        <div class="col-md-2">
                            <h5><b>QUANTIDADE</b></h5>
                        </div>
                        <div class="col-md-3">
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

                    <br/>
                    <hr/>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <a class="btn btn-success btn-block" id="botaoInserirSaida"><b>Inserir Saída</b></a>
                        </div>
                    </div>
                    <form action="<?php echo base_url('/painel/saida/inserirsaida/gerarsaida') ?>" id="gerarSaida" method="post"
                          hidden="hidden">
                        <input type="hidden" id="formGerarSaida" name="formGerarSaida"/>
                    </form>
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
                <div class="text-center"><h4 class="modal-title" id="tituloModal">Confirmação de Cadastro de Saída</h4>
                </div>
            </div>
            <div class="modal-body">
                <div id="barraProgresso" style="display: none;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center">
                                <h4>
                                    Realizando cadastro da saída.<br/>
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
                        <h5>DESTINO:</h5>
                    </div>
                    <div class="col-md-8">
                        <h5 id="confFormDestino" class="bold">(Sem destino)</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <h5>DATA:</h5>
                    </div>
                    <div class="col-md-8">
                        <h5 id="confFormDataSaida" class="bold">(Sem data)</h5>
                    </div>
                </div>
                <br/>

                <div class="row">
                    <div class="col-md-5">
                        <hr/>
                    </div>
                    <div class="col-md-2">
                        <div class="text-center"><h5><b>Itens</b></h5></div>
                    </div>
                    <div class="col-md-5">
                        <hr/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4" style="padding-right: 0;">
                        <h5><b>TIPO</b></h5>
                    </div>
                    <div class="col-md-4" style="padding-right: 0; padding-left: 4px;">
                        <h5><b>ITEM</b></h5>
                    </div>
                    <div class="col-md-4" style="padding-right: 0; padding-left: 4px;">
                        <h5><b>QUANTIDADE</b></h5>
                    </div>
                </div>

                <div id="confListaItem">

                </div>

            </div>
            <div class="modal-footer">
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

        if(isset($itens)) {
            echo 'var itens = '.json_encode($itens).';';
        }
        if(isset($tipos)) {
           echo 'var tipos = '.json_encode($tipos).';';
        }
        if(isset($contratos)) {
           echo 'var contratos = '.json_encode($contratos).';';
        }
        if(isset($unidades)) {
           echo 'var unidades = '.json_encode($unidades).';';
        }

        // URL
        echo 'var urlBase = "'.base_url().'";';
    ?>
</script>
<script src="<?php echo base_url('/js/painel/saida/inserir-saida/cadastrar.min.js') ?>"></script>


</body>
</html>
