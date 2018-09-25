<?php

$title = '   PREFEITURA MUNICIPAL DE SÃO GONÇALO DO RIO ABAIXO';
$header_pdf = '   Almoxarifado da Secretaria de Educação / Guia de Entrada de Itens';

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
$linhas_entradas = NULL;
if (isset($entradas) && $entradas) {
    foreach ($entradas as $entrada) {
        $linhas_entradas .= '
        <table>
        <tr>
            <td style="width: 35%"><h4 style="font-weight: normal">' . $entrada['codigo_contrato'] . '</h4></td>
            <td style="width: 20%"><h4 style="font-weight: normal">' . $entrada['nome_item'] . '</h4></td>
            <td style="width: 15%"><h4 style="font-weight: normal">' . $entrada['quantidade_entrada'] . ' ' . $unidade_padrao[$entrada['unidade_padrao_id']]['nome'] . '</h4></td>
            <td style="width: 15%"><h4 style="font-weight: normal">' . $entrada['numero_nota'] . '</h4></td>
            <td style="width: 15%"><h4 style="font-weight: normal">' . $entrada['data_entrada'] . '</h4></td>
        </tr>
        </table>
    ';
    }
} else {
    $linhas_entradas = '<h4 style="font-weight: normal" align="center">Não há registros de entradas de itens para a pesquisa selecionada.</h4>';
}


ob_start();

// Caso houve algum problema na geração do relatório.
if (isset($erro)) {
    if ($erro === 1 && $erro_mensagem != "") {
        $conteudo = '<br/><h3 align="center">Parâmetros incorretos.<br/> Por favor, tente gerar o relatório novamente.</h3>';
    }
} else {
    $conteudo = '
        <!DOCTYPE html>
            <body>
            <h3 align="center">RELATÓRIO DE ENTRADA DE ITENS</h3>
            <table>
                <tr>
                    <td style="width: 22%"><h4 style="font-weight: normal"><b>Fornecedor Selecionado:</b></h4></td>
                    <td style="width: 28%"><h4 style="font-weight: normal">' . (($formFornecedor == 0) ? 'Todos os Fornecedores' : $nome_fornecedor) . '</h4></td>
                    <td style="width: 8%"><h4 style="font-weight: normal"><b>Período:</b></h4></td>
                    <td style="width: 42%"><h4 style="font-weight: normal">' . $formDataInicio . ' até ' . $formDataFim . '</h4></td>
                </tr>
                <tr>
                    <td style="width: 16%"><h4 style="font-weight: normal"><b>Tipo Selecionado:</b></h4></td>
                    <td style="width: 34%"><h4 style="font-weight: normal">' . (($formTipo == 0) ? 'Todos os Tipos' : $nome_tipo) . '</h4></td>
                    <td style="width: 16%"><h4 style="font-weight: normal"><b>Item Selecionado:</b></h4></td>
                    <td style="width: 34%"><h4 style="font-weight: normal">' . (($formItem == 0) ? 'Todos os Itens' : $nome_item) . '</h4></td>
                </tr>
            </table>
            <br/>
            <hr/>
            <table>
                <tr>
                    <td style="width: 35%"><h4><b>CONTRATO</b></h4></td>
                    <td style="width: 20%"><h4><b>ITEM</b></h4></td>
                    <td style="width: 15%"><h4><b>QUANTIDADE</b></h4></td>
                    <td style="width: 15%"><h4><b>NÚMERO NOTA</b></h4></td>
                    <td style="width: 15%"><h4><b>DATA ENTRADA</b></h4></td>
                </tr>
            </table>
            ' . $linhas_entradas . '
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
header('Content-Disposition: attachment; filename="entrada-itens.pdf"');
$obj_pdf->Output('entrada-itens.pdf', 'I');