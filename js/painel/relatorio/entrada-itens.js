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

    limparCamposItem();
    // Caixa de seleção da Data Inicio.
    $('#dataInicio').datepicker(formatoData);

    // Caixa de seleção da Data Fim.
    $('#dataFim').datepicker(formatoData);

    // Caixa de seleção do Contrato.
    $('#formFornecedor').change(filtraContrato);

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
        if ($('#formFornecedor option:selected').val() != 0) {
          $('#formUnidade').empty();
          $('#formContrato').html('<option value="0">Todos os Contratos</option>');
          for (i in fornecedores_contratos) {
              if (fornecedores_contratos.hasOwnProperty(i) && fornecedores_contratos[i]['id_fornecedor'] == $('#formFornecedor option:selected').val())
                  //$('#formFornecedor').html('<option value="0">' + textoFormContrato[0] + '</option>');

                  $('#formContrato').append('<option selected="selected" value="' + fornecedores_contratos[i]['id_contrato'] + '">'  + fornecedores_contratos[i]['nome']  + ' - '  + fornecedores_contratos[i]['codigo'] + '</option>');
          }
        } else {
            $('#formContrato').html('<option value="0">Todos os Contratos</option>');
            for (i in fornecedores_contratos) {
                if (fornecedores_contratos.hasOwnProperty(i))
                    $('#formContrato').append('<option value="' + fornecedores_contratos[i]['id_contratro'] + '">' + fornecedores_contratos[i]['nome']  + ' - ' + fornecedores_contratos[i]['codigo'] + '</option>');
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

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Limpa ou zera os campos do adicionar novo item.
     */
    function limparCamposItem() {
        //$('#formTipo').val(0);
        $('#formFornecedor').val(0);
        $('#formContrato').val(0);
        $('#formTipo').val(0);
        $('#formItem').empty();
        $('#formItem').html('<option value="0">Todos os Itens</option>');
    }

    //------------------------------------------------------------------------------------------------------------------

});
