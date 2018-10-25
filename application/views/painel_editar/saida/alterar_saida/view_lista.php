<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alterar Saída - Saída - SiGA</title>
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

<div class="container">
    <div class="row">
        <?php $this->load->view('common/view_menu_painel_editar', array('posicao' => 2)); ?>
        <div class="col-md-7">
            Bem Vindo <b><?php echo $nome_usuario; ?></b>
            <a class="pull-right" href="<?php echo base_url('/painel/logout') ?>">Sair do Sistema</a>
            <hr>
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <p class="header-painel">Alterar Saída - Saídas Cadastradas</p>
                </div>
                <div class="panel-body">
                  <div class="row">
                      <form id="formSaidaItens"
                            action="<?php echo base_url('painel/relatorio/saidaitens/pesquisa'); ?>" method="post"
                            target="_blank">
                          <div class="col-md-12">
                              <div class="row">
                                  <div class="col-md-12">
                                      <select name="formDestino" id="formDestino" class="form-control">
                                          <option value="0">Todos os Destinos</option>
                                          <?php
                                          if (isset($destinos) && $destinos) {
                                              foreach ($destinos as $destino) {
                                                  if ($destino['id_destino'] != $formDestino) {
                                                      echo '<option value="' . $destino['id_destino'] . '">' . $destino['nome'] . '</option>';
                                                  } else {
                                                      echo '<option value="' . $destino['id_destino'] . '" selected="selected">' . $destino['nome'] . '</option>';
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
                                              foreach ($tipos as $tipo) {
                                                  if ($formTipo == $tipo['id_tipo']) {
                                                      echo '<option value="' . $tipo['id_tipo'] . '" selected="selected">' . $tipo['nome'] . '</option>';
                                                  } else {
                                                      echo '<option value="' . $tipo['id_tipo'] . '">' . $tipo['nome'] . '</option>';
                                                  }
                                              }
                                          }
                                          ?>
                                      </select>
                                  </div>
                                  <div class="col-md-6">
                                      <select name="formItem" id="formItem" class="form-control">
                                          <option value="0">Todos os Itens</option>
                                          <?php
                                          if (isset($itens)) {
                                              if ($formItem == 0 && $formTipo != 0) {
                                                  foreach ($itens as $item) {
                                                      if ($formTipo == $item['id_tipo']) {
                                                          echo '<option value="' . $item['id_item'] . '">' . $item['nome'] . '</option>';
                                                      }
                                                  }
                                              } else if ($formItem != 0 && $formTipo != 0) {
                                                  foreach ($itens as $item) {
                                                      if ($formTipo == $item['id_tipo']) {
                                                          if ($formItem == $item['id_item'] && $formTipo == $item['id_tipo']) {
                                                              echo '<option value="' . $item['id_item'] . '" selected="selected">' . $item['nome'] . '</option>';
                                                          } else {
                                                              echo '<option value="' . $item['id_item'] . '">' . $item['nome'] . '</option>';
                                                          }
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

                              <br/>
                          </div>
                      </form>
                  </div>

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
                                    <div class="col-md-3"><h5><b>ITEM</b></h5></div>
                                    <div class="col-md-3"><h5><b>QUANTIDADE</b></h5></div>
                                    <div class="col-md-3"><h5><b>DATA SAÍDA</b></h5></div>
                                    <div class="col-md-3"><h5><b>EDITAR|EXCLUIR</b></h5></div>
                                </div>
                                <div class="row thumbnail">
                                    <div class="col-md-12 div-scrollbar-2x">
                                        <br/>
                                        <?php
                                        if (isset($saidas) && $saidas) {
                                            foreach ($saidas as $saida) {
                                                $url_editar = base_url('/paineleditar/saida/alterarsaida/alterar/' . $saida['id_saida']);
                                                $url_excluir = base_url('/paineleditar/saida/alterarsaida/confirmarexcluir/' . $saida['id_saida']);

                                                echo '<div class="row">';
                                                echo '<div class="col-md-3">';
                                                echo '<h5>' . $saida['nome_item'] . '</h5>';
                                                echo '</div>';
                                                echo '<div class="col-md-3">';
                                                echo '<h5>&nbsp;' . $saida['quantidade_saida'] . '</h5>';
                                                echo '</div>';
                                                echo '<div class="col-md-3">';
                                                echo '<h5>&nbsp;' . $saida['data_saida'] . '</h5>';
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
                                            echo '<div class="text-center"><h5>No momento não há cadastro de saídas.</h5></div>';
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
</div>

<?php $this->load->view('common/view_footer.php') ?>

<script src="<?php echo base_url('/js/jquery-2.1.1.min.js') ?>"></script>
<script src="<?php echo base_url('/js/bootstrap.min.js') ?>"></script>
<script src="<?php echo base_url('/js/bootstrap-datepicker.min.js') ?>"></script>
<script src="<?php echo base_url('/js/locales/bootstrap-datepicker.pt-BR.min.js') ?>"></script>
<script src="<?php echo base_url('/js/pnotify.custom.min.js') ?>"></script>
<script src="<?php echo base_url('/js/comum/script.min.js') ?>"></script>
<script type="application/javascript">
    <?php
        // URL das páginas.
        echo 'baseUrlLista = "'.base_url('/paineleditar/saida/alterarsaida/lista').'";';


        // Passando dados para JS.
        if(isset($tipos)) {
            echo 'var tipos = '.json_encode($tipos).';';
        }
        if(isset($itens)) {
            echo 'var itens = '.json_encode($itens).';';
        }
     ?>
</script>

<script src="<?php echo base_url('/js/painel_editar/saida/alterar_saida/saida-itens.min.js') ?>"></script>


</body>
</html>
