<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Balanço de Contrato - Relatório - SiGA</title>
    <link href="<?php echo base_url('/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('/css/bootstrap-theme.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link href="<?php echo base_url('/css/font-awesome.min.css') ?>" rel="stylesheet">
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
<?php $this->load->view('common/view_menu_painel', array('posicao' => 2)); ?>

<div class="content-wrapper">
  <section class="content">
    <div class="row">

      <div class="col-md-2"></div>
        <div class="col-md-8">

            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <p class="header-painel">Relatório de Balanço de Contrato </p>
                </div>
                <div class="panel-body">
                    <form action="<?php echo base_url('/painel/relatorio/balancocontratos/lista') ?>" method="get">
                        <div class="row">
                            <div class="col-md-7">
                                <label for="formAno">Selecione o ano final de vigência do
                                    contrato:</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <select name="formAno" id="formAno" class="form-control">
                                    <option value="0">Todos</option>
                                    <?php
                                    if (isset($anos_contratos)) {
                                        foreach ($anos_contratos as $ano) {
                                            echo '<option value="' . $ano['anos_contratos'] . '">' . $ano['anos_contratos'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <br/>

                        <div class="row">
                            <div class="col-md-4">
                                <hr/>
                            </div>
                            <div class="col-md-4">
                                <button id="botaoFiltrar" class="btn btn-block btn-success">Pesquisar</button>
                            </div>
                            <div class="col-md-4">
                                <hr/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-center">
                                    <h5><b>Ano final de vigência escolhido:</b><br/>
                                        <?php
                                        if (isset($formAno)) {
                                            if ($formAno <= 0) {
                                                echo 'Todos';
                                            } else {
                                                echo $formAno;
                                            }
                                        }
                                        ?>
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <hr/>
                            <div class="col-md-12">
                                <div class="well">
                                    <div class="row thumbnail">
                                        <div class="col-md-7"><h5><b>FORNECEDOR</b></h5></div>
                                        <div class="col-md-5"><h5><b>CÓDIGO DO CONTRATO</b></h5></div>
                                    </div>
                                    <div class="row thumbnail">
                                        <div class="col-md-12 div-scrollbar-2x">
                                            <?php
                                            if (isset($contratos)) {
                                                foreach ($contratos as $contrato) {
                                                    $url_contrato = '/painel/relatorio/balancocontratos/contrato?formCodigo=' . $contrato['codigo'];

                                                    echo '<div class="row">
                                                            <div class="col-md-7">
                                                                <h5>' . $contrato['fornecedor'] . '</h5>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <h5>&nbsp;&nbsp;' . $contrato['codigo'] . '</h5>
                                                            </div>
                                                            <div class="col-md-2 text-center">
                                                                <h5><a href="' . base_url($url_contrato) . '" target="_blank">Detalhes</a></h5>
                                                            </div>
                                                        </div>';
                                                }
                                            } else {
                                                echo '<h5 class="text-center">Não há contratos cadastradas para o periodo final de vigência escolhido.</h5>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </section>
</div>
<?php $this->load->view('common/view_footer.php') ?>

</div>


<script src="<?php echo base_url('/js/jquery-2.1.1.min.js') ?>"></script>
<script src="<?php echo base_url('/js/bootstrap.min.js') ?>"></script>
<script src="<?php echo base_url('/js/jquery.slimscroll.min.js') ?>"></script>
<script src="<?php echo base_url('/js/adminlte.js') ?>"></script>


</body>
</html>
