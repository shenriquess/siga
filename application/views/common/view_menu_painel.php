<?php

$ativar_menu = array(
    0 => '',
    1 => '',
    2 => '',
    3 => '',
    4 => '',
    5 => '',
    6 => '',
    7 => '',
    8 => '',
    9 => '',
    10 => '',
    11 => '',
    12 => '',
    13 => '',
    14 => ''
);

$ativar_menu[$posicao] = "active";

$dados_acesso = $this->session->all_userdata();
$nivel = $dados_acesso['nivel'];

if($nivel == 0) {
    echo '
            <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MENU PRINCIPAL</li>
            <li class="treeview ' .$ativar_menu[0].' ">
              <a href="#">
                <i class="fa fa-arrow-right"></i> <span>Entrada</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="'.$ativar_menu[0].'"><a href="'.base_url("/painel/entrada/inserirentrada/cadastrar").'"><i class="fas fa-genderless"></i> &nbsp;&nbsp;Inserir Entrada</a></li>
              </ul>
            </li>
            <li class="treeview '.$ativar_menu[1].' ">
              <a href="#">
                <i class="fa  fa-arrow-left"></i>
                <span>Saída</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="'.$ativar_menu[1].'"><a href="'.base_url("/painel/saida/inserirsaida/cadastrar").'"><i class="fas fa-genderless"></i> &nbsp;&nbsp;Inserir Saída</a></li>
              </ul>
            </li>
            <li class="treeview '.$ativar_menu[2].' '.$ativar_menu[4].' '.$ativar_menu[3].' '.$ativar_menu[6].'">
              <a href="#">
                <i class="fa fa-laptop"></i>
                <span>Relatórios</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="'.$ativar_menu[2].'"><a href="'.base_url("/painel/relatorio/balancocontratos/lista").'"><i class="fas fa-genderless"></i> &nbsp;&nbsp;Balanço de Contratos</a></li>
                <li class="'.$ativar_menu[4].'"><a href="'.base_url("/painel/relatorio/entradaitens/lista").'"><i class="fas fa-genderless"></i> &nbsp;&nbsp;Entrada de Itens</a></li>
                <li class="'.$ativar_menu[3].'"><a href="'.base_url("/painel/relatorio/estoquedisponivel/lista").'"><i class="fas fa-genderless"></i> &nbsp;&nbsp;Estoque Disponível</a></li>
                <li class="'.$ativar_menu[6].'"><a href="'.base_url("/painel/relatorio/saidaitens/lista").'"><i class="fas fa-genderless"></i> &nbsp;&nbsp;Saída de Itens</a></li>
              </ul>
            </li>
            <li class="treeview '.$ativar_menu[7].' '.$ativar_menu[8].' '.$ativar_menu[9].' '.$ativar_menu[10].' '.$ativar_menu[11].' '.$ativar_menu[12].'">
              <a href="#">
                <i class="fa fa-cog"></i> <span>Configurações</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="'.$ativar_menu[7].'"><a href="'.base_url("/painel/configuracoes/cadastrarcontrato/cadastrar").'"><i class="fas fa-genderless"></i> &nbsp;&nbsp;Cadastrar Contrato</a></li>
                <li class="'.$ativar_menu[8].'"><a href="'.base_url("/painel/configuracoes/cadastrardestino/cadastrar").'"><i class="fas fa-genderless"></i> &nbsp;&nbsp;Cadastrar Destino</a></li>
                <li class="'.$ativar_menu[9].'"><a href="'.base_url("/painel/configuracoes/cadastrarfornecedor/cadastrar").'"><i class="fas fa-genderless"></i> &nbsp;&nbsp;Cadastrar Fornecedor</a></li>
                <li class="'.$ativar_menu[10].'"><a href="'.base_url("/painel/configuracoes/cadastraritem/cadastrar").'"><i class="fas fa-genderless"></i> &nbsp;&nbsp;Cadastrar Item</a></li>
                <li class="'.$ativar_menu[11].'"><a  href="'.base_url("/painel/configuracoes/cadastrartipo/cadastrar").'"><i class="fas fa-genderless"></i> &nbsp;&nbsp;Cadastrar Tipo</a></li>
                <li class="'.$ativar_menu[12].'"><a href="'.base_url("/painel/configuracoes/cadastrarusuario/cadastrar") .'"><i class="fas fa-genderless"></i> &nbsp;&nbsp;Cadastrar Usuário</a></li>
              </ul>
            </li>
            <li class="treeview '.$ativar_menu[14].'">
              <a href="#">
                <i class="fa fa-key"></i> <span>Administração</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li class="'.$ativar_menu[14].'"><a href="'.base_url("/painel/administracao/login").'"><i class="fas fa-genderless"></i> &nbsp;&nbsp;Alterar Informações</a></li>
              </ul>
            </li>
            </section>
            <!-- /.sidebar -->
            </aside>';
}
else if($nivel == 1)
{
  echo '
          <aside class="main-sidebar">
          <!-- sidebar: style can be found in sidebar.less -->
          <section class="sidebar">

          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu" data-widget="tree">
          <li class="header">MENU PRINCIPAL</li>
          <li class="treeview ' .$ativar_menu[0].' ">
            <a href="#">
              <i class="fa fa-arrow-right"></i> <span>Entrada</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="'.$ativar_menu[0].'"><a href="'.base_url("/painel/entrada/inserirentrada/cadastrar").'"><i class="fa fa-circle-o"></i> &nbsp;&nbsp;Inserir Entrada</a></li>
            </ul>
          </li>
          <li class="treeview '.$ativar_menu[1].' ">
            <a href="#">
              <i class="fa  fa-arrow-left"></i>
              <span>Saída</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="'.$ativar_menu[1].'"><a href="'.base_url("/painel/saida/inserirsaida/cadastrar").'"><i class="fa fa-circle-o"></i> &nbsp;&nbsp;Inserir Saída</a></li>
            </ul>
          </li>
          <li class="treeview '.$ativar_menu[2].' '.$ativar_menu[4].' '.$ativar_menu[3].' '.$ativar_menu[6].'">
            <a href="#">
              <i class="fa fa-laptop"></i>
              <span>Relatórios</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="'.$ativar_menu[2].'"><a href="'.base_url("/painel/relatorio/balancocontratos/lista").'"><i class="fa fa-circle-o"></i> &nbsp;&nbsp;Balanço de Contratos</a></li>
              <li class="'.$ativar_menu[4].'"><a href="'.base_url("/painel/relatorio/entradaitens/lista").'"><i class="fa fa-circle-o"></i> &nbsp;&nbsp;Entrada de Itens</a></li>
              <li class="'.$ativar_menu[3].'"><a href="'.base_url("/painel/relatorio/estoquedisponivel/lista").'"><i class="fa fa-circle-o"></i> &nbsp;&nbsp;Estoque Disponível</a></li>
              <li class="'.$ativar_menu[6].'"><a href="'.base_url("/painel/relatorio/saidaitens/lista").'"><i class="fa fa-circle-o"></i> &nbsp;&nbsp;Saída de Itens</a></li>
            </ul>
          </li>
          <li class="treeview '.$ativar_menu[7].' '.$ativar_menu[8].' '.$ativar_menu[9].' '.$ativar_menu[10].' '.$ativar_menu[11].'">
            <a href="#">
              <i class="fa fa-cog"></i> <span>Configurações</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="'.$ativar_menu[7].'"><a href="'.base_url("/painel/configuracoes/cadastrarcontrato/cadastrar").'"><i class="fa fa-circle-o"></i> &nbsp;&nbsp;Cadastrar Contrato</a></li>
              <li class="'.$ativar_menu[8].'"><a href="'.base_url("/painel/configuracoes/cadastrardestino/cadastrar").'"><i class="fa fa-circle-o"></i> &nbsp;&nbsp;Cadastrar Destino</a></li>
              <li class="'.$ativar_menu[9].'"><a href="'.base_url("/painel/configuracoes/cadastrarfornecedor/cadastrar").'"><i class="fa fa-circle-o"></i> &nbsp;&nbsp;Cadastrar Fornecedor</a></li>
              <li class="'.$ativar_menu[10].'"><a href="'.base_url("/painel/configuracoes/cadastraritem/cadastrar").'"><i class="fa fa-circle-o"></i> &nbsp;&nbsp;Cadastrar Item</a></li>
              <li class="'.$ativar_menu[11].'"><a  href="'.base_url("/painel/configuracoes/cadastrartipo/cadastrar").'"><i class="fa fa-circle-o"></i> &nbsp;&nbsp;Cadastrar Tipo</a></li>
            </ul>
          </li>

          </section>
          <!-- /.sidebar -->
          </aside>';
}
else if($nivel == 2)
{
  echo '
          <aside class="main-sidebar">
          <!-- sidebar: style can be found in sidebar.less -->
          <section class="sidebar">

          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu" data-widget="tree">
          <li class="header">MENU PRINCIPAL</li>
          <li class="treeview ' .$ativar_menu[0].' ">
            <a href="#">
              <i class="fa fa-arrow-right"></i> <span>Entrada</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="'.$ativar_menu[0].'"><a href="'.base_url("/painel/entrada/inserirentrada/cadastrar").'"><i class="fa fa-circle-o"></i> &nbsp;&nbsp;Inserir Entrada</a></li>
            </ul>
          </li>
          <li class="treeview '.$ativar_menu[1].' ">
            <a href="#">
              <i class="fa  fa-arrow-left"></i>
              <span>Saída</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="'.$ativar_menu[1].'"><a href="'.base_url("/painel/saida/inserirsaida/cadastrar").'"><i class="fa fa-circle-o"></i> &nbsp;&nbsp;Inserir Saída</a></li>
            </ul>
          </li>

          </section>
          <!-- /.sidebar -->
          </aside>';
}

?>
