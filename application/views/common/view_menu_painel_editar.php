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

<div class="col-md-3 col-md-offset-1">
    <div class="text-center">
        <h4><b>Administrador</b></h4>
    </div>
    <ul class="nav nav-pills nav-stacked">
        <li class="<?php echo $ativarMenu[9] ?>"><a class="green" href="<?php echo base_url("/paineleditar/administrador/dadosadministrador/alterar") ?>">Dados Administrador</a></li>
    </ul>
    <hr>
    <div class="text-center">
        <h4><b>Entrada</b></h4>
    </div>
    <ul class="nav nav-pills nav-stacked">
        <li class="<?php echo $ativarMenu[1] ?>"><a class="green" href="<?php echo base_url("/paineleditar/entrada/alterarentrada/lista") ?>">Alterar Entrada</a></li>
    </ul>
    <hr>
    <div class="text-center">
        <h4><b>Saída</b></h4>
    </div>
    <ul class="nav nav-pills nav-stacked">
        <li class="<?php echo $ativarMenu[2] ?>"><a class="green" href="<?php echo base_url("/paineleditar/saida/alterarsaida/lista") ?>">Alterar Saída</a></li>
    </ul>
    <hr>
    <div class="text-center">
        <h4><b>Configurações</b></h4>
    </div>
    <ul class="nav nav-pills nav-stacked">
        <li class="<?php echo $ativarMenu[3] ?>"><a class="green" href="<?php echo base_url("/paineleditar/configuracoes/alterarcontrato/lista") ?>">Alterar Contrato</a></li>
        <li class="<?php echo $ativarMenu[4] ?>"><a class="green" href="<?php echo base_url("/paineleditar/configuracoes/alterardestino/lista") ?>">Alterar Destino</a></li>
        <li class="<?php echo $ativarMenu[5] ?>"><a class="green" href="<?php echo base_url("/paineleditar/configuracoes/alterarfornecedor/lista") ?>">Alterar Fornecedor</a></li>
        <li class="<?php echo $ativarMenu[6] ?>"><a class="green" href="<?php echo base_url("/paineleditar/configuracoes/alteraritem/lista") ?>">Alterar Item</a></li>
        <li class="<?php echo $ativarMenu[7] ?>"><a class="green" href="<?php echo base_url("/paineleditar/configuracoes/alterartipo/lista") ?>">Alterar Tipo</a></li>
        <li class="<?php echo $ativarMenu[8] ?>"><a class="green" href="<?php echo base_url("/paineleditar/configuracoes/alterarusuario/lista")  ?>">Alterar Usuário</a></li>
    </ul>
    <hr/>
    <ul class="nav nav-pills nav-stacked">
        <li><a class="btn btn-default btn-block" href="<?php echo base_url("/painel/home"); ?>"><b>Voltar para SiGA Inserção</b></a></li>
    </ul>
</div>


