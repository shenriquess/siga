<!-- Fazer o sistema de Gerar Saída -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gerar Saída - Saída - SiGA</title>
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
<?php $this->load->view('common/view_menu_painel', array('posicao' => 1)); ?>

<?php
/*if (isset($dados_saidas)) {
    foreach ($dados_saidas as $dados) {
        echo $dados['id_saida'] . '<br/>';
        echo $dados['nome_tipo'] . '<br/>';
        echo $dados['nome_item'] . '<br/>';
        echo $dados['quantidade'] . '<br/>';
        echo $dados['unidade_padrao_id'] . '<br/>';
    }
}*/
?>




<div class="content-wrapper">
<section class="content">
  <div class="container">
      <div id="alertaSucesso" class="row">
          <div class="col-md-4 col-md-offset-4">
              <div class="alert alert-success alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span
                          class="sr-only">Close</span></button>
                  <div class="text-center">
                      Saída cadastrada com <b>sucesso!</b>
                  </div>
              </div>
          </div>
      </div>
  </div>


    <div class="row">
      <div class="col-md-2"></div>
        <div class="col-md-8">

            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <p class="header-painel">Inserir Saída - Saída Gerada</p>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h5>
                                <b>DESTINO:</b>
                                <?php
                                if ($destino) {
                                    echo $destino['nome'];
                                }
                                ?>
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h5>
                                <b>DATA:</b>
                                <?php
                                if ($destino) {
                                    echo $destino['data'];
                                }
                                ?>
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <hr/>
                        <div class="col-md-12">
                            <div class="well">
                                <div class="row thumbnail">
                                    <div class="col-md-4"><h5><b>TIPO</b></h5></div>
                                    <div class="col-md-5"><h5><b>ITEM</b></h5></div>
                                    <div class="col-md-3"><h5><b>QUANTIDADE</b></h5></div>
                                </div>
                                <div class="row thumbnail">
                                    <div class="col-md-12 div-scrollbar-2x">
                                        <?php
                                        if (isset($dados_saidas)) {
                                            foreach ($dados_saidas as $dado_saida) {
                                                echo '<div class="row">
                                                            <div class="col-md-4">
                                                                <h5>' . $dado_saida['nome_tipo'] . '</h5>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <h5>&nbsp;&nbsp;' . $dado_saida['nome_item'] . '</h5>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <h5>&nbsp;&nbsp;' . $dado_saida['quantidade'] . ' ' . $unidades[$dado_saida['unidade_padrao_id']]['nome'] . '</h5 >
                                                            </div >
                                                        </div > ';
                                            }
                                        } else {
                                            echo '<h5 class="text-center" >Dados inválidos.</h5 > ';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-md-offset-1">
                            <a href="<?php echo base_url('painel/saida/inserirsaida/cadastrar') ?>"
                               class="btn btn-block btn-default">Cadastrar Nova Saída</a>
                        </div>
                        <div class="col-md-5 col-md-offset-1">
                            <div class="pull-right">
                                <button id="botaoGerarPdf" class="btn btn-success">Gerar PDF</button>
                            </div>
                        </div>
                        <form id="formGerarSaidaPdf"
                              action="<?php echo base_url('/painel/saida/inserirsaida/gerarsaida/pdf'); ?>" target="_blank"
                              method="post">
                            <input type="hidden" id="formGerarSaida" name="formGerarSaida"/>
                        </form>
                    </div>
                    <br/>
                </div>
            </div>
        </div>
    </div>
    </section>
</div>

<?php $this->load->view('common/view_footer.php') ?>
</div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <div class="text-center"><h4 class="modal-title" id="myModalLabel">Emitir PDF</h4></div>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                            <h4>Deseja emitir o relatório do cadastro de saída em PDF?</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                <button id="confGerarPdf" type="button" class="btn btn-success">Sim</button>
            </div>
        </div>
    </div>
</div>


<script src="<?php echo base_url('/js/jquery-2.1.1.min.js') ?>"></script>
<script src="<?php echo base_url('/js/bootstrap.min.js') ?>"></script>
<script src="<?php echo base_url('/js/comum/script.min.js') ?>"></script>
<script src="<?php echo base_url('/js/jquery.slimscroll.min.js') ?>"></script>
<script src="<?php echo base_url('/js/adminlte.js') ?>"></script>
<script type="application/javascript">
    <?php
        echo 'var urlGerarPdf = "'.base_url('/painel/saida/inserirsaida/gerarsaida/pdf').'";';
        echo 'var dados_saida = '.$formGerarSaida.';';
    ?>
</script>
<script src="<?php echo base_url('/js/painel/saida/inserir-saida/gerar-saida.min.js') ?>"></script>


</body>
</html>
