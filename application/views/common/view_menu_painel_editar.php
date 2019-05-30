<?php

$ativarMenu = array(
    1 => '',
    2 => '',
    3 => '',
    4 => '',
    5 => '',
    6 => '',
    7 => '',
    8 => '',
    9 => '',
);

$ativarMenu[$posicao] = "active";

?>

<aside class="main-sidebar">
<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">

<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu" data-widget="tree">
<li class="header">ADMINISTRAÇÃO</li>
<li class="treeview <?php echo $ativarMenu[9] ?> ">
  <a href="#">
    <i class="fa fa-user"></i> <span>Administrador</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li class="<?php echo $ativarMenu[9] ?>"><a href="<?php echo base_url("/paineleditar/administrador/dadosadministrador/alterar") ?>"><i class="fa fa-circle-o"></i> Dados Administrador</a></li>
  </ul>
</li>
<li class="treeview <?php echo $ativarMenu[1] ?> ">
  <a href="#">
    <i class="fa fa-arrow-right"></i> <span>Entrada</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li class="<?php echo $ativarMenu[1] ?>"><a href="<?php echo base_url("/paineleditar/entrada/alterarentrada/lista") ?>"><i class="fa fa-circle-o"></i> Alterar Entrada</a></li>
  </ul>
</li>

<li class="treeview <?php echo $ativarMenu[2] ?> ">
  <a href="#">
    <i class="fa  fa-arrow-left"></i>
    <span>Saída</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li class="<?php echo $ativarMenu[2] ?>"><a  href="<?php echo base_url("/paineleditar/saida/alterarsaida/lista") ?>"><i class="fa fa-circle-o"></i> Alterar Saída</a></li>
  </ul>
</li>
<li class="treeview <?php echo $ativarMenu[3] ?> <?php echo $ativarMenu[4] ?> <?php echo $ativarMenu[5] ?> <?php echo $ativarMenu[6] ?> <?php echo $ativarMenu[7] ?> <?php echo $ativarMenu[8] ?> ">
  <a href="#">
    <i class="fa fa-cog"></i> <span>Configurações</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
  <ul class="treeview-menu">
    <li class="<?php echo $ativarMenu[3] ?>"><a href="<?php echo base_url("/paineleditar/configuracoes/alterarcontrato/lista") ?>"><i class="fa fa-circle-o"></i> Alterar Contrato</a></li>
    <li class="<?php echo $ativarMenu[4] ?>"><a href="<?php echo base_url("/paineleditar/configuracoes/alterardestino/lista") ?>"><i class="fa fa-circle-o"></i> Alterar Destino</a></li>
    <li class="<?php echo $ativarMenu[5] ?>"><a href="<?php echo base_url("/paineleditar/configuracoes/alterarfornecedor/lista") ?>"><i class="fa fa-circle-o"></i> Alterar Fornecedor</a></li>
    <li class="<?php echo $ativarMenu[6] ?>"><a href="<?php echo base_url("/paineleditar/configuracoes/alteraritem/lista") ?>"><i class="fa fa-circle-o"></i> Alterar Item</a></li>
    <li class="<?php echo $ativarMenu[7] ?>"><a href="<?php echo base_url("/paineleditar/configuracoes/alterartipo/lista") ?>"><i class="fa fa-circle-o"></i> Alterar Tipo</a></li>
    <li class="<?php echo $ativarMenu[8] ?>"><a href="<?php echo base_url("/paineleditar/configuracoes/alterarusuario/lista")  ?>"><i class="fa fa-circle-o"></i> Alterar Usuário</a></li>
  </ul>
</li>
<li>
  <a href="<?php echo base_url("/painel/home"); ?>">
  </i> <span class="btn btn-warning">Voltar para SiGA Inserção</span>
  </a>
</li>
</section>
<!-- /.sidebar -->
</aside>
