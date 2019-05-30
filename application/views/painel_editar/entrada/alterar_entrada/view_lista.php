<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alterar Entrada - Entrada - SiGA</title>
    <link href="<?php echo base_url('/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('/css/bootstrap-theme.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link href="<?php echo base_url('/css/font-awesome.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('/css/datepicker3.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('/css/pnotify.custom.min.css') ?>" rel="stylesheet">
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
<?php $this->load->view('common/view_menu_painel_editar', array('posicao' => 1)); ?>

<div class="content-wrapper">
  <section class="content">
    <div class="row">
      <div class="col-md-2"></div>
        <div class="col-md-8">

            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <p class="header-painel">Alterar Entrada - Entrada Cadastradas</p>
                </div>
                <div class="panel-body">
                  <div class="row">
                      <form id="formEntradaItens"
                            action="<?php echo base_url('paineleditar/entrada/alterarentrada/lista'); ?>" method="post"
                            target="_blank">
                          <div class="col-md-12">
                              <div class="row">
                                  <div class="col-md-12">
                                      <select name="formContrato" id="formContrato" class="form-control">
                                          <option value="0">Todos os Contratos</option>
                                          <?php
                                          if (isset($fornecedores_contratos)) {
                                              if ($fornecedores_contratos == 0) {
                                                  foreach ($fornecedores_contratos as $fornecedor_contrato) {
                                                      echo '<option value="' . $fornecedor_contrato['id_contrato'] . '">' . $fornecedor_contrato['nome'] . ' - ' . $fornecedor_contrato['codigo'] . '</option>';
                                                  }
                                              } else {
                                                  foreach ($fornecedores_contratos as $fornecedor_contrato) {
                                                      if ($formContrato == $fornecedor_contrato['id_contrato']) {
                                                          echo '<option value="' . $fornecedor_contrato['id_contrato'] . '" selected="selected">' . $fornecedor_contrato['nome'] . ' - ' . $fornecedor_contrato['codigo'] . '</option>';
                                                      } else {
                                                          echo '<option value="' . $fornecedor_contrato['id_contrato'] . '">' . $fornecedor_contrato['nome'] . ' - ' . $fornecedor_contrato['codigo'] . '</option>';
                                                      }
                                                  }
                                              }
                                          }
                                          ?>
                                      </select>
                                  </div>
                              </div>
                              <br/>

                              <div class="row">
                                  <div class="col-md-12">
                                      <select name="formFornecedor" id="formFornecedor" class="form-control">
                                          <option value="0">Todos os Fornecedores</option>
                                          <?php
                                          if (isset($fornecedores)) {
                                              if (($formFornecedor == 0 && $formContrato == 0) || ($formContrato != 0)) {
                                                  foreach ($fornecedores as $fornecedor) {
                                                      echo '<option value="' . $fornecedor['id_fornecedor'] . '">' . $fornecedor['nome'] . '</option>';
                                                  }
                                              } else if ($formFornecedor != 0 && $formContrato == 0) {
                                                  foreach ($fornecedores as $fornecedor) {
                                                      if ($formFornecedor == $fornecedor['id_fornecedor']) {
                                                          echo '<option value="' . $fornecedor['id_fornecedor'] . '" selected="selected">' . $fornecedor['nome'] . '</option>';
                                                      } else {
                                                          echo '<option value="' . $fornecedor['id_fornecedor'] . '">' . $fornecedor['nome'] . '</option>';
                                                      }
                                                  }
                                              }
                                          }
                                          ?>
                                      </select>
                                  </div>
                              </div>
                              <br/>

                              <div class="row">
                                  <div class="col-md-6">
                                      <select name="formTipo" id="formTipo" class="form-control">
                                          <option value="0">Todos os Tipos</option>
                                          <?php
                                          if (isset($tipos)) {
                                              if ($formTipo == 0) {
                                                  foreach ($tipos as $tipo) {
                                                      echo '<option value="' . $tipo['id_tipo'] . '">' . $tipo['nome'] . '</option>';
                                                  }
                                              } else {
                                                  foreach ($tipos as $tipo) {
                                                      if ($formTipo == $tipo['id_tipo']) {
                                                          echo '<option value="' . $tipo['id_tipo'] . '" selected="selected">' . $tipo['nome'] . '</option>';
                                                      } else {
                                                          echo '<option value="' . $tipo['id_tipo'] . '">' . $tipo['nome'] . '</option>';
                                                      }
                                                  }
                                              }
                                          }
                                          ?>

                                      </select>
                                  </div>
                                  <div class="col-md-6">
                                      <select name="formItem" id="formItem" class="form-control">
                                          <option value="0">Todos os Itens</option>
                                      </select>
                                  </div>
                              </div>
                              <br/>

                              <div class="row">
                                  <div class="col-md-2 text-right">
                                      <label for="" class="control-label" style="margin-top: 5px;"><span
                                              style="color: #ac2925">*</span>Período:</label>
                                  </div>
                                  <div class="col-md-4">
                                      <div class="input-group date">
                                          <div id="dataInicio" class="input-group date">
                                              <input id="formDataInicio" name="formDataInicio" type="text"
                                                     class="form-control"
                                                     placeholder="Data Início" <?php echo((isset($formDataInicio)) ? 'value="' . $formDataInicio . '"' : ''); ?>
                                                     readonly>
                                          <span id="spanDataInicio" class="input-group-addon"><i
                                                  class="fa fa-calendar"></i></span>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="col-md-2 text-center" style="margin-top: 5px;">
                                      <p><strong>Até</strong></p>
                                  </div>
                                  <div class="col-md-4">
                                      <div id="dataFim" class="input-group date">
                                          <input id="formDataFim" name="formDataFim" type="text"
                                                 class="form-control" <?php echo((isset($formDataFim)) ? 'value="' . $formDataFim . '"' : ''); ?>
                                                 placeholder="Data Fim" readonly>
                                      <span id="spanDataFim" class="input-group-addon"><i
                                              class="fa fa-calendar"></i></span>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </form>
                  </div>
                  <br/>

                  <div class="row">
                      <div class="col-md-4">
                          <hr/>
                      </div>
                      <div class="col-md-4">
                          <button id="botaoListaPesquisar" class="btn btn-success btn-block">Pesquisar</button>
                      </div>

                      <div class="col-md-3">
                          <hr/>
                      </div>
                  </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="well">
                                <div class="row thumbnail">
                                    <div class="col-md-2"><h5><b>N. NOTA</b></h5></div>
                                    <div class="col-md-2"><h5><b>ITEM</b></h5></div>
                                    <div class="col-md-3"><h5><b>QNT</b></h5></div>
                                    <div class="col-md-2"><h5><b>DATA</b></h5></div>
                                    <div class="col-md-3"><h5><b>ED.|EX.</b></h5></div>
                                </div>
                                <div class="row thumbnail">
                                    <div class="col-md-12 div-scrollbar-2x">
                                        <br/>
                                        <?php
                                        if (isset($entradas) && $entradas) {
                                            foreach ($entradas as $entrada) {
                                                $url_editar = base_url('/paineleditar/entrada/alterarentrada/alterar/' . $entrada['id_entrada']);
                                                $url_excluir = base_url('/paineleditar/entrada/alterarentrada/confirmarexcluir/' . $entrada['id_entrada']);

                                                echo '<div class="row">';
                                                echo '<div class="col-md-2">';
                                                echo '<h5>' . $entrada['numero_nota'] . '</h5>';
                                                echo '</div>';
                                                echo '<div class="col-md-2">';
                                                echo '<h5>&nbsp;' . $entrada['nome_item'] . '</h5>';
                                                echo '</div>';
                                                echo '<div class="col-md-3">';
                                                echo '<h5>&nbsp;' . $entrada['quantidade_entrada'] . ' ' . $unidades[$entrada['unidade_padrao_id']]['nome'] . '</h5>';
                                                echo '</div>';
                                                echo '<div class="col-md-2">';
                                                echo '<h5>&nbsp;' . $entrada['data_entrada'] . '</h5>';
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
                                            echo '<div class="text-center"><h5>No momento não há cadastro de entradas.</h5></div>';
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
<script src="<?php echo base_url('/js/bootstrap-datepicker.js') ?>"></script>
<script src="<?php echo base_url('/js/locales/bootstrap-datepicker.pt-BR.min.js') ?>"></script>
<script src="<?php echo base_url('/js/pnotify.custom.min.js') ?>"></script>
<script src="<?php echo base_url('/js/comum/script.min.js') ?>"></script>
<script src="<?php echo base_url('/js/jquery.slimscroll.min.js') ?>"></script>
<script src="<?php echo base_url('/js/adminlte.js') ?>"></script>

<script type="application/javascript">
    <?php
        // URL das páginas.
        echo 'baseUrlLista = "'.base_url('paineleditar/entrada/alterarentrada/lista').'";';
        echo 'baseUrlExpandir = "'.base_url('paineleditar/entrada/alterarentrada/lista').'";';

        // Passando dados para JS.
        if(isset($tipos)) {
            echo 'var tipos = '.json_encode($tipos).';';
        }
        if(isset($itens)) {
            echo 'var itens = '.json_encode($itens).';';
        }
        if(isset($fornecedores)) {
            echo 'var fornecedores = '.json_encode($fornecedores).';';
        }
     ?>
</script>
<script src="<?php echo base_url('/js/painel_editar/entrada/alterar_entrada/entrada-itens.min.js') ?>"></script>


</body>
</html>
