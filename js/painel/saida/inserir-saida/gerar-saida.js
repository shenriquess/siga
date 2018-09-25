/**
 * JavaScript do menu 'Inserir Saída - Gerar Saída'
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */

$(document).ready(function () {
    $('#botaoGerarPdf').click(function () {
        $('#formGerarSaida').val(JSON.stringify(dados_saida));
        $('#formGerarSaidaPdf').submit();
    });

    $('#myModal').modal('show');
    $('#confGerarPdf').click(function () {
        $('#formGerarSaida').val(JSON.stringify(dados_saida));
        $('#formGerarSaidaPdf').submit();
        $('#myModal').modal('hide');
    });
});
