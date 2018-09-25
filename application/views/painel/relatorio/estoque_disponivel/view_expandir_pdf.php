<?php

$title = '   PREFEITURA MUNICIPAL DE SÃO GONÇALO DO RIO ABAIXO';
$header_pdf = '   Almoxarifado da Secretaria de Educação / Guia de Estoque Disponivel';

tcpdf();

$obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$obj_pdf->SetCreator(PDF_CREATOR);
$obj_pdf->SetTitle($title);
$obj_pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title, $header_pdf);
$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$obj_pdf->SetDefaultMonospacedFont('helvetica');
$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$obj_pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$obj_pdf->SetFont('helvetica', '', 9);
$obj_pdf->setFontSubsetting(false);
$obj_pdf->AddPage();

// Lendo entradas
$linhas_item_estoque = NULL;
if (isset($estoques_disponiveis) && $estoques_disponiveis) {
    foreach ($estoques_disponiveis as $estoque_disponivel) {
        $linhas_item_estoque .= '
        <table>
        <tr>
            <td style="width: 60%"><h4 style="font-weight: normal">' . $estoque_disponivel['nome_item'] . '</h4></td>
            <td style="width: 20%"><h4 style="font-weight: normal">' . $estoque_disponivel['quantidade_total'] . '</h4></td>
            <td style="width: 20%"><h4 style="font-weight: normal">' . $unidades[$estoque_disponivel['unidade_padrao_id']]['nome'] . '</h4></td>
        </tr>
        </table>
    ';
    }
} else {
    $linhas_item_estoque = '<h4 style="font-weight: normal" align="center">Não há itens em estoque.</h4>';
}


ob_start();

// Caso houve algum problema na geração do relatório.
if ($erro === 1 && $erro_mensagem != "") {
    $conteudo = '<br/><h3 align="center">Parâmetros incorretos.<br/> Por favor, tente gerar o relatório novamente.</h3>';
} else {
    $conteudo = '
        <!DOCTYPE html>
            <body>
            <h3 align="center">RELATÓRIO DE ESTOQUE DISPONÍVEL</h3>
            <table>
                <tr>
                    <td style="width: 16%"><h4 style="font-weight: normal"><b>Tipo Selecionado:</b></h4></td>
                    <td style="width: 34%"><h4 style="font-weight: normal">' . (($formTipo == 0) ? 'Todos os Tipos' : $tipo_selecionado['nome']) . '</h4></td>
                </tr>
            </table>
            <br/>
            <hr/>
            <table>
                <tr>
                    <td style="width: 60%"><h4><b>NOME DO ITEM</b></h4></td>
                    <td style="width: 20%"><h4><b>QUANTIDADE</b></h4></td>
                    <td style="width: 20%"><h4><b>UNIDADE</b></h4></td>
                </tr>
            </table>
            ' . $linhas_item_estoque . '
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <table>
                <tr>
                    <td style="width: 11%"><h4 style="font-weight: normal">Emitido em: </h4></td>
                    <td style="width: 39%"><h4 style="font-weight: normal">' . $data_hora . '</h4></td>
                </tr>
            </table>
            <br/>
            <br/>
            <br/>
            <br/>
            <table>
                <tr>
                    <td style="width: 11%"><h4 style="font-weight: normal">Endereço: </h4></td>
                    <td style="width: 89%"><h4 style="font-weight: normal">Rua Henriqueta Rubim, nº 1088, Niterói, São Goncaço do Rio Abaixo</h4></td>
                </tr>
                <tr>
                    <td style="width: 11%"><h4 style="font-weight: normal">Telefone: </h4></td>
                    <td style="width: 89%"><h4 style="font-weight: normal">(031) 3820-1839 - Email: almoxarifado.sme@outlool.com</h4></td>
                </tr>
            </table>
            </body>
        </html>';
}

ob_end_clean();

$obj_pdf->writeHTML($conteudo, true, false, true, false, '');
header('Content-type: application/pdf');
header('Content-Disposition: attachment; filename="estoque-disponivel.pdf"');
$obj_pdf->Output('estoque-disponivel.pdf', 'I');