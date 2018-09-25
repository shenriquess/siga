<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alterar Destino - Configurações - SiGA</title>
    <link href="<?php echo base_url('/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('/css/bootstrap-theme.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('/css/font-awesome.min.css') ?>" rel="stylesheet">
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
                                    Destino alterado com <b>sucesso!</b>
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
        <?php $this->load->view('common/view_menu_painel_editar', array('posicao' => 4)); ?>
        <div class="col-md-7">
            Bem Vindo <b><?php echo $nome_usuario; ?></b>
            <a class="pull-right" href="<?php echo base_url('/painel/logout') ?>">Sair do Sistema</a>
            <hr>
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <p class="header-painel">Alterar Destino - Alterar Dados</p>
                </div>
                <div class="panel-body">
                    <form id="formAlterarDestino"
                          action="<?php echo base_url($url); ?>"
                          method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="formDestino" class="control-label"><span
                                            style="color: #ac2925">*</span>Destino:</label>
                                    <input id="formDestino" name="formDestino" type="text"
                                           class="form-control"
                                           placeholder="Insira o nome do destino..."
                                        <?php
                                            if (isset($destino['nome']) && $destino['nome']) {
                                                echo 'value="' . $destino['nome'] . '"';
                                            }
                                        ?>
                                        />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="formDescricao" class="control-label">Descrição (Opcional):</label>
                                    <input id="formDescricao" name="formDescricao" type="text" class="form-control"
                                           placeholder="Insira uma breve descrição..." autocomplete="off"
                                        <?php
                                            if (isset($destino['descricao']) && $destino['descricao']) {
                                                echo 'value="' . $destino['descricao'] . '"';
                                            }
                                        ?>
                                        />
                                </div>
                            </div>
                        </div>
                    </form>
                    <hr/>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center">
                                <a class="btn btn-default"
                                   href="<?php echo base_url('/paineleditar/configuracoes/alterardestino/lista'); ?>"><b>Voltar</b></a>
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
                        Destino</h4></div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <h5>DESTINO:</h5>
                    </div>
                    <div class="col-md-8">
                        <h5 id="confFormDestino" class="bold">(Sem Destino)</h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <h5>DESCRIÇÃO:</h5>
                    </div>
                    <div class="col-md-8">
                        <h5 id="confFormDescricao" class="bold">(Sem Descrição)</h5>
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
<script type="application/javascript">
    <?php
       if(isset($sucesso)) {
           if($sucesso === 1) {
               echo '$("#alertaSucesso").delay(5000).fadeOut(1000);';
           }
       }
    ?>
</script>
<script src="<?php echo base_url('/js/painel_editar/configuracoes/alterar_destino/alterar.min.js') ?>"></script>

</body>
</html>

