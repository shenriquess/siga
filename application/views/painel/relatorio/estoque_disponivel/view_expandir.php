<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Estoque Disponível - Relatório - SiGA</title>
    <link href="<?php echo base_url('/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('/css/bootstrap-theme.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('/css/font-awesome.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('/css/style.min.css') ?>" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="<?php echo base_url('/js/html5shiv.min.js') ?>"></script>
    <script src="<?php echo base_url('/js/respond.min.js') ?>"></script>
    <![endif]-->
</head>
<body>

<?php $this->load->view('common/view_header.php'); ?>

<?php
// Caso houve algum erro.
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
        <div class="col-md-12">
            Bem Vindo <b><?php echo $nome_usuario; ?></b>
            <hr>
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <p class="header-painel">Relatório de Estoque Disponível </p>
                </div>
                <div class="panel-body">
                    <form id="formEstoqueDisponivel"
                          action="<?php echo base_url('/painel/relatorio/estoquedisponivel') ?>" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="formTIpo">Selecione o Tipo:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <select name="formTipo" id="formTipo" class="form-control">
                                    <option value="0">Todos os Tipos</option>
                                    <?php
                                    foreach ($tipos as $tipo) {
                                        if ($tipo['id_tipo'] != $formTipo) {
                                            echo '<option value="' . $tipo['id_tipo'] . '">' . $tipo["nome"] . '</option>';
                                        } else {
                                            echo '<option value="' . $tipo['id_tipo'] . '" selected="selected">' . $tipo["nome"] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </form>
                    <br/>

                    <div class="row">
                        <div class="col-md-4">
                            <hr/>
                        </div>
                        <div class="col-md-4">
                            <div class="col-md-8 col-md-offset-2">
                                <button id="botaoExpandirPesquisar" class="btn btn-block btn-success">Pesquisar</button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <hr/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-center">
                                <?php
                                if ($formTipo != 0) {
                                    echo '<b>Tipo Selecionado:</b></br>';
                                    echo $tipo_selecionado['nome'];
                                } else {
                                    echo '<b>Tipo Selecionado:</b></br>Todos os Tipos';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="well">
                                <div class="row">
                                    <div class="col-md-12 thumbnail">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-5"><h5><b>ITEM</b></h5></div>
                                                <div class="col-md-5"><h5><b>TIPO</b></h5></div>
                                                <div class="col-md-2"><h5><b>QUANTIDADE</b></h5></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row thumbnail">
                                    <div class="col-md-12 div-scrollbar">
                                        <?php
                                        if (isset($estoques_disponiveis) && $estoques_disponiveis) {
                                            foreach ($estoques_disponiveis as $estoque_disponivel) {
                                                echo '<div class="row">';
                                                echo '<div class="col-md-5"><h5>' . $estoque_disponivel['nome_item'] . '</h5></div>';
                                                echo '<div class="col-md-5"><h5>&nbsp;' . $estoque_disponivel['nome_tipo'] . '</h5></div>';
                                                echo '<div class="col-md-2"><h5>&nbsp;&nbsp;' . $estoque_disponivel['quantidade_total'].' '.$unidades[$estoque_disponivel['unidade_padrao_id']]['nome']  . '</h5></div>';
                                                echo '</div>';
                                            }
                                        } else {
                                            echo '<h5 class="text-center">Não há itens em estoque.</h5>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-4">
                            <div class="col-md-8 col-md-offset-2">
                                <button id="botaoExpandirGerarPdf" class="btn btn-success btn-block">Gerar PDF</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php $this->load->view('common/view_footer.php') ?>

<script src="<?php echo base_url('/js/jquery-2.1.1.min.js') ?>"></script>
<script src="<?php echo base_url('/js/bootstrap.min.js') ?>"></script>
<script type="application/javascript">
    <?php
        // URL das páginas.
        echo 'baseUrlLista = "'.base_url('/painel/relatorio/estoquedisponivel/lista').'";';
        echo 'baseUrlExpandir = "'.base_url('/painel/relatorio/estoquedisponivel/lista/expandir').'";';
        echo 'baseUrlPdf = "'.base_url('/painel/relatorio/estoquedisponivel/lista/expandir/pdf').'";';
     ?>
</script>
<script src="<?php echo base_url('/js/painel/relatorio/estoque-disponivel.min.js') ?>"></script>

</body>
</html>
