<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Balanço de Contrato - Relatório - SiGA</title>
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
                    <p class="header-painel">Relatório de Balanço de Contrato - Contrato</p>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="" class="control-label">Código do Contrato:</label>
                                <h5 class="thumbnail">
                                    <?php
                                    if ($contrato['codigo']) {
                                        echo $contrato['codigo'];
                                    } else {
                                        echo 'Contrato não encontrado.';
                                    }
                                    ?>
                                </h5>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <label for="" class="control-label">Período de Vigência:</label>

                            <div class="row">
                                <div class="form-group">
                                    <div class="col-md-5">
                                        <h5 class="thumbnail">
                                            <?php
                                            if ($contrato['data_inicio']) {
                                                echo $contrato['data_inicio'];
                                            } else {
                                                echo 'Inválida';
                                            }
                                            ?>
                                        </h5>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="text-center"><h5 style="margin-top: 18px"><b>Até</b></h5></div>
                                    </div>
                                    <div class="col-md-5">
                                        <h5 class="thumbnail">
                                            <?php
                                            if ($contrato['data_fim']) {
                                                echo $contrato['data_fim'];
                                            } else {
                                                echo 'Inválida';
                                            }
                                            ?>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="" class="control-label">Nome do Fornecedor:</label>
                                <h5 class="thumbnail">
                                    <?php
                                    if ($contrato['nome']) {
                                        echo $contrato['nome'];
                                    } else {
                                        echo 'Contrato não encontrado.';
                                    }
                                    ?>
                                </h5>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="" class="control-label">Valor Total:</label>
                                <h5 class="thumbnail">
                                    <?php
                                    if (isset($valor_total_contrato)) {
                                        echo 'R$ ' . number_format($valor_total_contrato, 2, '.', '');
                                    } else {
                                        echo 'Contrato não encontrado.';
                                    }
                                    ?>
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <hr/>
                        </div>
                        <div class="col-md-2">
                            <h5><b>Itens Contratados</b></h5>
                        </div>
                        <div class="col-md-5">
                            <hr/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"><b>NOME DO ITEM</b></div>
                        <div class="col-md-3"><b>QUANTIDADE CONTRATADA</b></div>
                        <div class="col-md-3"><b>QUANTIDADE ENTREGUE</b></div>
                        <div class="col-md-2"><b>VALOR POR UNIDADE</b></div>
                    </div>
                    <hr style="margin: 0; border-width: 4px"/>
                    <?php
                    if (isset($itens_contrato) && $itens_contrato) {
                        foreach ($itens_contrato as $item_contrato) {
                            echo '<div class="row">';
                            echo '<div class="col-md-4">' . $item_contrato['nome'] . '</div>';
                            echo '<div class="col-md-3">' . $item_contrato['quantidade'];
                            if (isset($unidades)) {
                                echo ' ' . $unidades[$item_contrato['unidade_padrao_id']]['nome'];
                            }
                            echo '</div>';
                            echo '<div class="col-md-3">';
                            if ($item_contrato['quantidade_entregue']) {
                                echo $item_contrato['quantidade_entregue'];
                            } else {
                                echo '0';
                            }
                            if (isset($unidades)) {
                                echo ' ' . $unidades[$item_contrato['unidade_padrao_id']]['nome'];
                            }
                            echo '</div>';
                            echo '<div class="col-md-2"> R$ ' . number_format($item_contrato['valor'], 2, '.', '') . '</div>';
                            echo '</div>';
                            echo '<hr style="margin: 0"/>';
                        }
                    } else {
                        echo '<h5 class="text-center">Não há registros de itens para o contrato selecionado.</h5>';
                    }
                    ?>
                    <br/>

                    <div class="row">
                        <div class="col-md-10">
                            <hr/>
                        </div>
                        <div class="col-md-2">
                            <h5><b>Valor Total Entregue:</b></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-md-offset-10">
                            <div class="thumbnail">
                                <?php
                                if (isset($valor_total_entregue)) {
                                    echo 'R$ ' . number_format($valor_total_entregue, 2, '.', '');
                                } else {
                                    echo 'Contrato não encontrado.';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-md-offset-5">
                            <a href="<?php echo base_url('/painel/relatorio/balancocontratos/contrato/pdf?formCodigo=' . $formContrato); ?>"
                               target="_blank" class="btn btn-success btn-block">Gerar PDF</a>
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

</body>
</html>
