/**
 * JavaScript do menu 'Entrada de Itens'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */

$(document).ready(function() {
    // Formulário.
    var $formEstoqueDisponivel = $('#formEstoqueDisponivel');

    // Botão 'Gerar PDF' na URL Expandir.
    $('#botaoExpandirGerarPdf').click(function() {
        $formEstoqueDisponivel.attr('action', baseUrlPdf);
        $formEstoqueDisponivel.attr('target', '_blank');
        $formEstoqueDisponivel.submit();
    });

    // Botão 'Pesquisar' na URL Expandir.
    $('#botaoExpandirPesquisar').click(function() {
        $formEstoqueDisponivel.attr('action', baseUrlExpandir);
        $formEstoqueDisponivel.attr('target', '_self');
        $formEstoqueDisponivel.submit();
    });

    // Botão 'Expandir' na URL Lista.
    $('#botaoListaExpandir').click(function() {
        $formEstoqueDisponivel.attr('action', baseUrlExpandir);
        $formEstoqueDisponivel.attr('target', '_blank');
        $formEstoqueDisponivel.submit();
    });

    // Botão 'Pesquisar' na URL Lista.
    $('#botaoListaPesquisar').click(function() {
        $formEstoqueDisponivel.attr('action', baseUrlLista);
        $formEstoqueDisponivel.attr('target', '_self');
        $formEstoqueDisponivel.submit();
    });
});