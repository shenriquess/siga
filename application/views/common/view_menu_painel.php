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
    13 => ''
);

$ativar_menu[$posicao] = "active";

$dados_acesso = $this->session->all_userdata();
$nivel = $dados_acesso['nivel'];

if($nivel == 0) {
    echo '  <div class="col-md-3 col-md-offset-1">
                <h4 class="text-center"><b>Entrada</b></h4>
                <ul class="nav nav-pills nav-stacked">
                    <li class="'.$ativar_menu[0].'"><a class="green" href="'.base_url("/painel/entrada/inserirentrada/cadastrar").'">Inserir Entrada</a></li>
                </ul>
                <hr>
                <h4 class="text-center"><b>Saída</b></h4>
                <ul class="nav nav-pills nav-stacked">
                    <li class="'.$ativar_menu[1].'"><a class="green" href="'.base_url("/painel/saida/inserirsaida/cadastrar").'">Inserir Saída</a></li>
                </ul>
                <hr>

                <h4 class="text-center"><b>Relatórios</b></h4>
                <ul class="nav nav-pills nav-stacked">
                    <li class="'.$ativar_menu[2].'"><a class="green" href="'.base_url("/painel/relatorio/balancocontratos/lista").'">Balanço de Contratos</a></li>
                    <li class="'.$ativar_menu[4].'"><a class="green" href="'.base_url("/painel/relatorio/entradaitens/lista").'">Entrada de Itens</a></li>
                    <li class="'.$ativar_menu[3].'"><a class="green" href="'.base_url("/painel/relatorio/estoquedisponivel/lista").'">Estoque Disponível</a></li>
                    <li class="'.$ativar_menu[6].'"><a class="green" href="'.base_url("/painel/relatorio/saidaitens/lista").'">Saída de Itens</a></li>
                </ul>
                <hr>
                <h4 class="text-center"><b>Configurações</b></h4>
                <ul class="nav nav-pills nav-stacked">
                    <li class="'.$ativar_menu[7].'"><a class="green" href="'.base_url("/painel/configuracoes/cadastrarcontrato/cadastrar").'">Cadastrar Contrato</a></li>
                    <li class="'.$ativar_menu[8].'"><a class="green" href="'.base_url("/painel/configuracoes/cadastrardestino/cadastrar").'">Cadastrar Destino</a></li>
                    <li class="'.$ativar_menu[9].'"><a class="green" href="'.base_url("/painel/configuracoes/cadastrarfornecedor/cadastrar").'">Cadastrar Fornecedor</a></li>
                    <li class="'.$ativar_menu[10].'"><a class="green" href="'.base_url("/painel/configuracoes/cadastraritem/cadastrar").'">Cadastrar Item</a></li>
                    <li class="'.$ativar_menu[11].'"><a class="green" href="'.base_url("/painel/configuracoes/cadastrartipo/cadastrar").'">Cadastrar Tipo</a></li>
                    <li class="'.$ativar_menu[12].'"><a class="green" href="'.base_url("/painel/configuracoes/cadastrarusuario/cadastrar") .'">Cadastrar Usuário</a></li>
                </ul>
                <hr>
                <h4 class="text-center"><b>Administração</b></h4>
                <div class="nav nav-pills nav-stacked">
                    <a class="btn btn-danger btn-block" href="'.base_url("/painel/administracao/login").'">Alterar Informações</a>
                </div>
            </div>';
}
else if($nivel == 1)
{
    echo '  <div class="col-md-3 col-md-offset-1">
                <h4 class="text-center"><b>Entrada</b></h4>
                <ul class="nav nav-pills nav-stacked">
                    <li class="'.$ativar_menu[0].'"><a class="green" href="'.base_url("/painel/entrada/inserirentrada/cadastrar").'">Inserir Entrada</a></li>
                </ul>
                <hr>
                <h4 class="text-center"><b>Saída</b></h4>
                <ul class="nav nav-pills nav-stacked">
                    <li class="'.$ativar_menu[1].'"><a class="green" href="'.base_url("/painel/saida/inserirsaida/cadastrar").'">Inserir Saída</a></li>
                </ul>
                <hr>

                <h4 class="text-center"><b>Relatórios</b></h4>
                <ul class="nav nav-pills nav-stacked">
                    <li class="'.$ativar_menu[2].'"><a class="green" href="'.base_url("/painel/relatorio/balancocontratos/lista").'">Balanço de Contratos</a></li>
                    <li class="'.$ativar_menu[4].'"><a class="green" href="'.base_url("/painel/relatorio/entradaitens/lista").'">Entrada de Itens</a></li>
                    <li class="'.$ativar_menu[3].'"><a class="green" href="'.base_url("/painel/relatorio/estoquedisponivel/lista").'">Estoque Disponível</a></li>
                    <li class="'.$ativar_menu[6].'"><a class="green" href="'.base_url("/painel/relatorio/saidaitens/lista").'">Saída de Itens</a></li>
                </ul>
                <hr>
                <h4 class="text-center"><b>Configurações</b></h4>
                <ul class="nav nav-pills nav-stacked">
                    <li class="'.$ativar_menu[7].'"><a class="green" href="'.base_url("/painel/configuracoes/cadastrarcontrato/cadastrar").'">Cadastrar Contrato</a></li>
                    <li class="'.$ativar_menu[8].'"><a class="green" href="'.base_url("/painel/configuracoes/cadastrardestino/cadastrar").'">Cadastrar Destino</a></li>
                    <li class="'.$ativar_menu[9].'"><a class="green" href="'.base_url("/painel/configuracoes/cadastrarfornecedor/cadastrar").'">Cadastrar Fornecedor</a></li>
                    <li class="'.$ativar_menu[10].'"><a class="green" href="'.base_url("/painel/configuracoes/cadastraritem/cadastrar").'">Cadastrar Item</a></li>
                    <li class="'.$ativar_menu[11].'"><a class="green" href="'.base_url("/painel/configuracoes/cadastrartipo/cadastrar").'">Cadastrar Tipo</a></li>
                </ul>
            </div>';
}
else if($nivel == 2)
{
    echo '  <div class="col-md-3 col-md-offset-1">
                <h4 class="text-center"><b>Entrada</b></h4>
                <ul class="nav nav-pills nav-stacked">
                    <li class="'.$ativar_menu[0].'"><a class="green" href="'.base_url("/painel/entrada/inserirentrada/cadastrar").'">Inserir Entrada</a></li>
                </ul>
                <hr>
                <h4 class="text-center"><b>Saída</b></h4>
                <ul class="nav nav-pills nav-stacked">
                    <li class="'.$ativar_menu[1].'"><a class="green" href="'.base_url("/painel/saida/inserirsaida/cadastrar").'">Inserir Saída</a></li>
                </ul>
            </div>';
}

?>


