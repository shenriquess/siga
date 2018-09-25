/**
 * JavaScript do menu 'Entrada de Itens'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */

$(document).ready(function () {
    // Ao carregar a página já filtrar o item por tipo.
    filtraItemPorTipo();

    // Caixa de seleção da Data Inicio.
    $('#dataInicio').datepicker(formatoData);

    // Caixa de seleção da Data Fim.
    $('#dataFim').datepicker(formatoData);

    // Caixa de seleção do Contrato.
    $('#formContrato').change(filtraContrato);

    // Caixa de seleção do Tipo.
    $('#formTipo').change(filtraItemPorTipo);

    // Formulário.
    var $formEntradaItens = $('#formEntradaItens');

    // Botão 'Gerar Pdf' na URL Expandir.
    $('#botaoExpandirGerarPdf').click(function () {
        if (!validaCampos()) {
            $formEntradaItens.attr('target', '_blank');
            $formEntradaItens.attr('action', baseUrlPdf);
            $formEntradaItens.submit();
        }
    });

    // Botão 'Pesquisar' na URL Expandir.
    $('#botaoExpandirPesquisar').click(function () {
        if (!validaCampos()) {
            $formEntradaItens.attr('target', '_self');
            $formEntradaItens.attr('action', baseUrlExpandir);
            $formEntradaItens.submit();
        }
    });

    // Botão 'Expandir' na URL Lista.
    $('#botaoListaExpandir').click(function () {
        if (!validaCampos()) {
            $formEntradaItens.attr('target', '_blank');
            $formEntradaItens.attr('action', baseUrlExpandir);
            $formEntradaItens.submit();
        }
    });

    // Botão 'Pesquisar' na URL Lista.
    $('#botaoListaPesquisar').click(function () {
        if (!validaCampos()) {
            $formEntradaItens.attr('target', '_self');
            $formEntradaItens.attr('action', baseUrlLista);
            $formEntradaItens.submit();
        }
    });

    //--------------------------------------------------------------------------------------------------------------

    /**
     * Quando selecionado um contrato, já seleciona automaticamente o nome do fornecedor.
     */
    function filtraContrato() {
        if ($('#formContrato option:selected').val() != 0) {
            var textoFormContrato = $('#formContrato option:selected').text();
            textoFormContrato = textoFormContrato.split('-')
            $('#formFornecedor').html('<option value="0">' + textoFormContrato[0] + '</option>');
        } else {
            $('#formFornecedor').html('<option value="0">Todos os Fornecedores</option>');
            for (i in fornecedores) {
                if (fornecedores.hasOwnProperty(i))
                    $('#formFornecedor').append('<option value="' + fornecedores[i]['id_fornecedor'] + '">' + fornecedores[i]['nome'] + '</option>');
            }
        }
    }

    //--------------------------------------------------------------------------------------------------------------

    /**
     * Filtra os Itens de acordo com o Tipo selecionado.
     */
    function filtraItemPorTipo() {
        $('#formItem').html('<option value="0">Todos os Itens</option>');
        for (i in itens) {
            if (itens.hasOwnProperty(i) && itens[i]['id_tipo'] == $('#formTipo option:selected').val()) {
                $('#formItem').append('<option value="' + itens[i]['id_item'] + '">' + itens[i]['nome'] + '</option>');
            }
        }
    }

    //--------------------------------------------------------------------------------------------------------------

    /**
     * Valida todos os campos do formulário.
     *
     * @returns {boolean} Retorna falso caso não tenha corrido nenhum erro de validação,
     *                    e verdadeiro caso houve erros.
     */
    function validaCampos() {
        var erro = false;

        // Validando data inicio - preenchimento.
        if ($('#formDataInicio').val() == "") {
            erro = true;
            notificacao_erro('<h5>Escolha uma <b>Data de Início.</b></h5>');
        }
        // Validando data fim - preenchimento.
        else if ($('#formDataFim').val() == "") {
            erro = true;
            notificacao_erro('<h5>Escolha uma <b>Data de Fim.</b></h5>');
        }
        // Validando se data de inicio e menor que data de fim.
        else if (pegaData($("#formDataInicio").val()) > pegaData($("#formDataFim").val())) {
            erro = true;
            notificacao_erro('A <b>Data Início</b> não pode ser maior que a <b>Data Fim</b>.');
        }
        // Validando se a data de fim não é maior que a data atual.
        else if (pegaData($("#formDataFim").val()) > new Date()) {
            erro = true;
            notificacao_alerta('A <b>Data Fim</b> não pode ser maior que a data atual.');
        }

        return erro;
    }
});