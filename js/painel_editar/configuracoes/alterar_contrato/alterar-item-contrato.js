/**
 * JavaScript do menu 'Alterar Contrato' para alterar um item do contrato.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
$(document).ready(function () {
    // TODO comentar.
    var itemAtual;
    var quantidadeAtual;
    var valorAtual;

    main();

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Cria a opção de itens disponíveis para um tipo selecionado.
     */
    function criaOpcaoItens(IDtipo) {
        var $formItem = $('#formItem');

        var string = '<option value="0">Item</option>';

        $formItem.empty();
        for (var i in tipos) {
            if (tipos.hasOwnProperty(i) && tipos[i]['id_tipo'] == IDtipo) {
                for (var j in itens) {
                    if (itens.hasOwnProperty(j) && itens[j]['id_tipo'] == tipos[i]['id_tipo']) {
                        string += '<option value="' + itens[j]['id_item'] + '">' + itens[j]['nome'] + '</option>';
                    }
                }
            }
        }
        $formItem.append(string);
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Enviar ou submeter o formulário.
     */
    function enviarFormulario() {
        var $formAlterarSaida = $('#formAlterarItemContrato');
        var $myModal = $('#myModal');

        if (!validaCampos()) {
            $formAlterarSaida.submit();
        } else {
            $myModal.modal('hide');
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Função principal.
     */
    function main() {
        var $botaoAlterarDados = $('#botaoAlterarDados');
        var $formItem = $('#formItem');
        var $formItemSelected = $('#formItem option:selected');
        var $formTipo = $('#formTipo');
        var $confFormEnviar = $('#confFormEnviar');

        pegaCamposAtuais();

        mostraUnidade($formItemSelected.val());

        $botaoAlterarDados.click(function () {
            if (!validaCampos()) {
                mostrarModal();
                preencherModal();
                $confFormEnviar.click(function () {
                    enviarFormulario();
                });
            } else {
                $confFormEnviar.off();
            }
        });

        $formTipo.change(function () {
            criaOpcaoItens($(this).val());
        });

        $formItem.change(function () {
            mostraUnidade($(this).val());
        });
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Mostra o modal.
     */
    function mostrarModal() {
        var $myModal = $('#myModal');
        $myModal.modal('show');
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Mostra a unidade de acordo com  item selecinado.
     * @param IDitemSelecionado
     */
    function mostraUnidade(IDitemSelecionado) {
        var $labelUnidade = $('#labelUnidade');

        for (var i in itens) {
            if (itens.hasOwnProperty(i) && itens[i]['id_item'] == IDitemSelecionado) {
                for (var j in unidades) {
                    if (unidades.hasOwnProperty(j) && unidades[j]['unidade_id'] == itens[i]['unidade_padrao_id']) {
                        $labelUnidade.text(unidades[j]['nome']);
                        return;
                    }
                }
            }
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Pegar os valores dos campos atuais (onde ainda não houve modificação).
     */
    function pegaCamposAtuais() {
        var $formItemSelected = $('#formItem option:selected');
        var $formQuantidade = $('#formQuantidade');
        var $formValor = $('#formValor');

        itemAtual = $formItemSelected.val();
        quantidadeAtual = $formQuantidade.val();
        valorAtual = $formValor.val();
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Preenche o modal com os dados que o usuário inseriu.
     */
    function preencherModal() {
        // Modal.
        var $confFormItem = $('#confFormItem');
        var $confFormQuantidade = $('#confFormQuantidade');
        var $confFormTipo = $('#confFormTipo');
        var $confFormValor = $('#confFormValor');
        var $confLabelUnidade = $('#confLabelUnidade');

        // Formulário.
        var $formItemSelected = $('#formItem option:selected');
        var $formQuantidade = $('#formQuantidade');
        var $formTipoSelected = $('#formTipo option:selected');
        var $formValor = $('#formValor');
        var $labelUnidade = $('#labelUnidade');

        // Preenchendo modal.
        $confFormItem.text($formItemSelected.text());
        $confFormQuantidade.text($formQuantidade.val());
        $confFormTipo.text($formTipoSelected.text());
        $confFormValor.text('R$ ' + $formValor.val());
        $confLabelUnidade.text($labelUnidade.text());
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Valida os campos.
     *
     * @returns {boolean} Retorna falso caso não tenha corrido nenhum erro de validão,
     *                    e verdadeiro caso houve erros.
     */
    function validaCampos() {
        var $formItemSelected = $('#formItem option:selected');
        var $formQuantidade = $('#formQuantidade');
        var $formTipoSelected = $('#formTipo option:selected');
        var $formValor = $('#formValor');

        var erro = false;

        // Trocar vírgula por ponto.
        if (contarLetra($formValor.val(), ',') == 1) {
            var valor = $formValor.val();
            $formValor.val(valor.replace(/,/g, '.'));
        }

        // Campo Item.
        if ($formItemSelected.val() == 0) {
            erro = true;
            notificacao_alerta('Selecione um <b>Item</b>.');
        }
        // Campo Tipo.
        else if ($formTipoSelected.val() == 0) {
            erro = true;
            notificacao_alerta('Selecione um <b>Tipo</b>.');
        }
        // Campo Quantidade: apenas números.
        else if (isNaN($formQuantidade.val())) {
            erro = true;
            notificacao_alerta('Insira apenas números em <b>Quantidade</b>.');
        }
        // Campo Quantidade: maior que zero.
        else if (parseInt($formQuantidade.val()) == 0) {
            erro = true;
            notificacao_alerta('Insira um número maior que zero em <b>Quantidade</b>.');
        }
        else if(isNaN($formValor.val())) {
            erro = true;
            notificacao_alerta('Insira apenas números em <b>Quantidade</b>.');
        }
        else if(parseFloat($formValor.val()) == 0) {
            erro = true;
            notificacao_alerta('Insira um número maior que zero em <b>Valor</b>.');
        }
        // Verificando mudanças.
        else if (itemAtual == $formItemSelected.val() &&
            quantidadeAtual == $formQuantidade.val() &&
            valorAtual == $formValor.val()) {
            erro = true;
            notificacao_alerta('Não há nenhuma atualização nos campos.');
        }

        return erro;
    }
});

/* Fim do arquivo: alterar.js */
/* Localização: ./js/painel_editar/configuracoes/alterar_contrato/alterar-item-contrato.js */