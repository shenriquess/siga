<?php

$title = '   PREFEITURA MUNICIPAL DE SÃO GONÇALO DO RIO ABAIXO';
$header_pdf = '   Almoxarifado - Secretaria de Educação';

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
$linhas_dados_saidas = NULL;
if (isset($dados_saidas) && $dados_saidas) {
    foreach ($dados_saidas as $dado_saida) {
        $linhas_dados_saidas .= '
        <table>
        <tr>
            <td style="width: 40%"><h4 style="font-weight: normal">' . $dado_saida['nome_tipo'] . '</h4></td>
            <td style="width: 40%"><h4 style="font-weight: normal">' . $dado_saida['nome_item'] . '</h4></td>
            <td style="width: 20%"><h4 style="font-weight: normal">' . $dado_saida['quantidade'] . ' ' . $unidades[$dado_saida['unidade_padrao_id']]['nome'] . '</h4></td>
        </tr>
        </table>
    ';
    }
} else {
    $linhas_dados_saidas = '<h4 style="font-weight: normal" align="center">Não há registros de saídas.</h4>';
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
            <h3 align="center">CONFIRMAÇÃO DE CADASTRO DE SAÍDA</h3>
            <table>
                <tr>
                    <td style="width: 8%"><h4 style="font-weight: normal"><b>Destino: </b></h4></td>
                    <td style="width: 42%"><h4 style="font-weight: normal">' . ((isset($destino)) ? $destino['nome'] : 'Erro ao gerar relatório') . '</h4></td>
                    <td style="width: 13%"><h4 style="font-weight: normal"><b>Data da Saída:</b></h4></td>
                    <td style="width: 37%"><h4 style="font-weight: normal">' . ((isset($destino)) ? $destino['data'] : 'Erro ao gerar relatório') . '</h4></td>
                </tr>
            </table>
            <br/>
            <hr/>
            <table>
                <tr>
                    <td style="width: 40%"><h4><b>TIPO</b></h4></td>
                    <td style="width: 40%"><h4><b>ITEM</b></h4></td>
                    <td style="width: 20%"><h4><b>QUANTIDADE</b></h4></td>
                </tr>
            </table>
            ' . $linhas_dados_saidas . '
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            </body>
            <table>
                <tr>
                    <td style="width: 10%"></td>
                    <td style="width: 35%"><h4 align="center">Responsável pela Emissão</h4></td>
                    <td style="width: 10%"></td>
                    <td style="width: 35%"><h4 align="center">Responsável pelo Recebimento</h4></td>
                    <td style="width: 10%"></td>
                </tr>
            </table>
            <br/>
            <br/>
            <br/>
            <br/>
            <br/>
            <table>
                <tr>
                    <td style="width: 10%"></td>
                    <td style="width: 35%"><hr/></td>
                    <td style="width: 10%"></td>
                    <td style="width: 35%"><hr/></td>
                    <td style="width: 10%"></td>
                </tr>
            </table>
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
        </html>';
}

ob_end_clean();

$obj_pdf->writeHTML($conteudo, true, false, true, false, '');
header('Content-type: application/pdf');
header('Content-Disposition: attachment; filename="cadastro-saida.pdf"');
$obj_pdf->Output('cadastro-saida.pdf', 'I');