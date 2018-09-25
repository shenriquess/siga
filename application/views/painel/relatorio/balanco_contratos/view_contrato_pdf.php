<?php

$title = '   PREFEITURA MUNICIPAL DE SÃO GONÇALO DO RIO ABAIXO';
$header_pdf = '   Almoxarifado da Secretaria de Educação / Guia de Balanço de Contrato';

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
$linhas_itens_contrato = NULL;
if (isset($itens_contrato) && $itens_contrato) {
    foreach ($itens_contrato as $item_contrato) {
        $linhas_itens_contrato .= '
        <table>
        <tr>
            <td style="width: 28%"><h4 style="font-weight: normal">' . $item_contrato['nome'] . '</h4></td>
            <td style="width: 27%"><h4 style="font-weight: normal">' . $item_contrato['quantidade'] . ' ' . $unidades[$item_contrato['unidade_padrao_id']]['nome'] . '</h4></td>
            <td style="width: 25%"><h4 style="font-weight: normal">' . (($item_contrato['quantidade_entregue']) ? $item_contrato['quantidade_entregue'] . ' ' . $unidades[$item_contrato['unidade_padrao_id']]['nome'] : '0 ' . $unidades[$item_contrato['unidade_padrao_id']]['nome']) . '</h4></td>
            <td style="width: 20%"><h4 style="font-weight: normal"> R$ ' . number_format($item_contrato['valor'], 2, '.', '') . '</h4></td>
        </tr>
        </table>
    ';
    }
} else {
    $linhas_itens_contrato = '<h4 style="font-weight: normal" align="center">Não há registros cadastrados para o contrato selecionado.</h4>';
}


ob_start();

// Caso houve algum problema na geração do relatório.
if (isset($erro)) {
    if ($erro === 1 && $erro_mensagem != "") {
        $conteudo = '<br/><h3 align="center">Erro: O código do contrato selecionado não existe.</h3>';
    }
} else {
$conteudo = '
        <!DOCTYPE html>
            <body>
            <h3 align="center">RELATÓRIO DE BALANÇO DE CONTRATOS</h3>
            <table>
                <tr>
                    <td style="width: 18%"><h4 style="font-weight: normal"><b>Código do Contrato:</b></h4></td>
                    <td style="width: 32%"><h4 style="font-weight: normal">' . (($contrato['codigo']) ? $contrato['codigo'] : 'Contrato não encontrado') . '</h4></td>
                    <td style="width: 19%"><h4 style="font-weight: normal"><b>Nome do Fornecedor:</b></h4></td>
                    <td style="width: 31%"><h4 style="font-weight: normal">' . (($contrato['nome']) ? $contrato['nome'] : 'Contrato não encontrado') . '</h4></td>
                </tr>
                <tr>
                    <td style="width: 19%"><h4 style="font-weight: normal"><b>Período de Vigência:</b></h4></td>
                    <td style="width: 31%"><h4 style="font-weight: normal">' . (($contrato['data_inicio']) ? $contrato['data_inicio'] : 'Inválida') . ' até ' . (($contrato['data_fim']) ? $contrato['data_fim'] : 'Inválida') . '</h4></td>
                    <td style="width: 21%"><h4 style="font-weight: normal"><b>Valor Total do Contrato:</b></h4></td>
                    <td style="width: 29%"><h4 style="font-weight: normal">R$ ' . ((isset($valor_total_contrato)) ? number_format($valor_total_contrato, 2, '.', '') : 'Contrato não encontrado') . '</h4></td>
                </tr>
                <tr>
                    <td style="width: 19%"><h4 style="font-weight: normal"><b>Valor Total Entregue:</b></h4></td>
                    <td style="width: 31%"><h4 style="font-weight: normal">R$ ' . ((isset($valor_total_entregue)) ? number_format($valor_total_entregue, 2, '.', '') : 'Contrato não encontrado') . '</h4></td>
                </tr>
            </table>
            <br/>
            <hr/>
            <table>
                <tr>
                    <td style="width: 28%"><h4><b>NOME DO ITEM</b></h4></td>
                    <td style="width: 27%"><h4><b>QUANTIDADE CONTRATADA</b></h4></td>
                    <td style="width: 25%"><h4><b>QUANTIDADE ENTREGUE</b></h4></td>
                    <td style="width: 20%"><h4><b>VALOR POR UNIDADE</b></h4></td>
                </tr>
            </table>
            ' . $linhas_itens_contrato . '
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

echo $conteudo;

ob_end_clean();

$obj_pdf->writeHTML($conteudo, true, false, true, false, '');
header('Content-type: application/pdf');
header('Content-Disposition: attachment; filename="balanco-contrato.pdf"');
$obj_pdf->Output('balanco-contrato.pdf', 'I');