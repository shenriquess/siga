<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alterar Item - Configurações - SiGA</title>
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
<body class="hold-transition skin-yellow-light sidebar-mini">
<div class="wrapper">

<?php $this->load->view('common/view_header.php'); ?>
<?php $this->load->view('common/view_menu_painel_editar', array('posicao' => 6)); ?>


<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <div class="col-md-2"></div>
        <div class="col-md-8">

            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <p class="header-painel">Alterar Item - Itens Cadastrados</p>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="well">
                                <div class="row thumbnail">
                                    <div class="col-md-5"><h5><b>NOME</b></h5></div>
                                    <div class="col-md-4"><h5><b>DESCRIÇÃO</b></h5></div>
                                    <div class="col-md-3">
                                        <h5><b>EDITAR|EXCLUIR</b></h5>
                                    </div>
                                </div>
                                <div class="row thumbnail">
                                    <div class="col-md-12 div-scrollbar-2x">
                                        <br/>
                                        <?php
                                        if (isset($itens) && $itens) {
                                            foreach ($itens as $item) {
                                                $url_editar = base_url('/paineleditar/configuracoes/alteraritem/alterar/' . $item['id_item']);
                                                $url_excluir = base_url('/paineleditar/configuracoes/alteraritem/confirmarexcluir/' . $item['id_item']);

                                                if ($item['descricao'] == "") {
                                                    $descricao = "(Sem Descrição)";
                                                } else {
                                                    $descricao = character_limiter($item['descricao'], 15);
                                                }

                                                echo '<div class="row">';
                                                echo '<div class="col-md-5">';
                                                echo '<h5>' . $item['nome'] . '</h5>';
                                                echo '</div>';
                                                echo '<div class="col-md-4">';
                                                echo '<h5>&nbsp;' . $descricao . '</h5>';
                                                echo '</div>';
                                                echo '<div class="col-md-3">';
                                                echo '<div class="pull-right">';
                                                echo '<a class="btn btn-default" href="' . $url_editar . '"><i class="fa fa-edit"></i></a>';
                                                echo '<a class="btn btn-danger" href="' . $url_excluir . '"><i class="fa fa-trash excluir"></i></a>';
                                                echo '</div>';
                                                echo '</div>';
                                                echo '</div>';
                                                echo '<hr/>';
                                            }
                                        } else {
                                            echo '<div class="text-center"><h5>No momento não há cadastro de itens.</h5></div>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
