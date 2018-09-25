<?php

$title = '   PREFEITURA MUNICIPAL DE SÃO GONÇALO DO RIO ABAIXO';
$header_pdf = '   Almoxarifado da Secretaria de Educação / Guia de Saída de Itens';

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
$linhas_saidas = NULL;
if (isset($saidas) && $saidas) {
    foreach ($saidas as $saida) {
        $linhas_saidas .= '
        <table>
        <tr>
            <td style="width: 30%"><h4 style="font-weight: normal">' . $saida['nome_destino'] . '</h4></td>
            <td style="width: 25%"><h4 style="font-weight: normal">' . $saida['nome_item'] . '</h4></td>
            <td style="width: 15%"><h4 style="font-weight: normal">' . $saida['quantidade_saida'] . ' ' . $unidade_padrao[$saida['unidade_padrao_id']]['nome'] . '</h4></td>
            <td style="width: 20%"><h4 style="font-weight: normal">' . $saida['data_saida'] . '</h4></td>
            <td style="width: 10%"><h4 style="font-weight: normal">R$ ' . number_format($saida['valor_item_contrato'] * $saida['quantidade_saida'], 2, ',', '.'). '</h4></td>

        </tr>
        </table>
    ';
      $soma = $soma + $saida['valor_item_contrato'] * $saida['quantidade_saida'];

    }
    $linhas_saidas .= '
    <table>
    <tr>
        <td style="width: 30%"><h4 style="font-weight: normal">&nbsp;</h4></td>
        <td style="width: 25%"><h4 style="font-weight: normal">&nbsp;</h4></td>
        <td style="width: 15%"><h4 style="font-weight: normal">&nbsp;</h4></td>
        <td style="width: 20%"><h4 style="font-weight: normal">&nbsp;</h4></td>
        <td style="width: 10%"><h4 style="font-weight: normal">&nbsp;</h4></td>

    </tr>
    <tr>
        <td style="width: 30%"><h4 style="font-weight: normal">&nbsp;</h4></td>
        <td style="width: 25%"><h4 style="font-weight: normal">&nbsp;</h4></td>
        <td style="width: 15%"><h4 style="font-weight: normal">&nbsp;</h4></td>
        <td style="width: 20%"><h4 style="font-weight: normal">&nbsp;<b>TOTAL:</b></h4></td>
        <td style="width: 10%"><h4 style="font-weight: normal">R$ ' . number_format($soma, 2, ',', '.'). '</h4></td>
    </tr>
    <tr>
        <td style="width: 30%"><h4 style="font-weight: normal">&nbsp;</h4></td>
        <td style="width: 25%"><h4 style="font-weight: normal">&nbsp;</h4></td>
        <td style="width: 15%"><h4 style="font-weight: normal">&nbsp;</h4></td>
        <td style="width: 20%"><h4 style="font-weight: normal">&nbsp;</h4></td>
        <td style="width: 10%"><h4 style="font-weight: normal">&nbsp;</h4></td>
    </tr>
    </table>
    ';
} else {
    $linhas_saidas = '<h4 style="font-weight: normal" align="center">Não há registros de saídas para a pesquisa selecionada.</h4>';
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
            <h3 align="center">RELATÓRIO DE SAÍDA DE ITENS</h3>
            <table>
                <tr>
                    <td style="width: 19%"><h4 style="font-weight: normal"><b>Destino Selecionado:</b></h4></td>
                    <td style="width: 31%"><h4 style="font-weight: normal">' . (($formDestino == 0) ? 'Todos os Destinos' : $nome_destino) . '</h4></td>
                    <td style="width: 8%"><h4 style="font-weight: normal"><b>Período:</b></h4></td>
                    <td style="width: 42%"><h4 style="font-weight: normal">' . $formDataInicio . ' até ' . $formDataFim . '</h4></td>
                </tr>
                <tr>
                    <td style="width: 16%"><h4 style="font-weight: normal"><b>Tipo Selecionado:</b></h4></td>
                    <td style="width: 34%"><h4 style="font-weight: normal">' . (($formTipo == 0) ? 'Todos os Tipo' : $nome_tipo) . '</h4></td>
                    <td style="width: 16%"><h4 style="font-weight: normal"><b>Item Selecionado:</b></h4></td>
                    <td style="width: 34%"><h4 style="font-weight: normal">' . (($formItem == 0) ? 'Todos os Itens' : $nome_item) . '</h4></td>
                </tr>
            </table>
            <br/>
            <hr/>
            <table>
                <tr>
                    <td style="width: 30%"><h4><b>DESTINO</b></h4></td>
                    <td style="width: 25%"><h4><b>ITEM</b></h4></td>
                    <td style="width: 15%"><h4><b>QUANTIDADE</b></h4></td>
                    <td style="width: 20%"><h4><b>DATA SAÍDA</b></h4></td>
                    <td style="width: 10%"><h4><b>VALOR</b></h4></td>

                </tr>
            </table>
            ' . $linhas_saidas . '
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
                    <td style="width: 89%"><h4 style="font-weight: normal">Rua Henriqueta Rubim, nº 1088, Niterói, São Gonçalo do Rio Abaixo</h4></td>
                </tr>
                <tr>
                    <td style="width: 11%"><h4 style="font-weight: normal">Telefone: </h4></td>
                    <td style="width: 89%"><h4 style="font-weight: normal">(031) 3820-1839 - Email: almoxarifado.sme@outlook.com</h4></td>
                </tr>
            </table>
            </body>
        </html>';
}

ob_end_clean();

$obj_pdf->writeHTML($conteudo, true, false, true, false, '');
header('Content-type: application/pdf');
header('Content-Disposition: attachment; filename="saida-itens.pdf"');
$obj_pdf->Output('saida-itens.pdf', 'I');
