/**
 * JavaScript do menu 'Alterar Saída'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */


$(document).ready(function () {
    var dataSaidaAtual;
    var destinoAtual;
    var itemAtual;
    var quantidadeAtual;

    main();
    //------------------------------------------------------------------------------------------------------------------

    /**
     * Ativa a caixa de seleção de data.
     */
    function ativaSelecionarDataSaida() {
        var $dataSaida = $('#dataSaida');

        $dataSaida.datepicker(formatoData);
    }

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

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Cria a opção de itens disponíveis para um tipo selecionado.
     */
    function criaOpcaoContratos(IDitem) {
        var $formContrato = $('#formContrato');

        var string = '<option value="0">Contrato</option>';

        $formContrato.empty();
        for (var i in itens) {
            if (itens.hasOwnProperty(i) && itens[i]['id_item'] == IDitem) {
                for (var j in contratos) {
                    if (contratos.hasOwnProperty(j) && contratos[j]['id_item'] == itens[i]['id_item']) {
                        string += '<option value="' + contratos[j]['id_contrato'] + '">' + contratos[j]['codigo'] + '</option>';
                    }
                }
            }
        }
        $formContrato.append(string);
    }

    //------------------------------------------------------------------------------------------------------------------


    /**
     * Enviar ou submeter o formulário.
     */
    function enviarFormulario() {
        var $formAlterarSaida = $('#formAlterarSaida');
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
        var $formContrato = $('#formContrato');
        var $formTipo = $('#formTipo');
        var $formContratoSelected = $('#formContrato option:selected');
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
            criaOpcaoContratos($(this).val());
        });

        $formContrato.onchange(function () {
            criaOpcaoContratos($formItem.val());
        });



        ativaSelecionarDataSaida();
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
        var $formDataSaida = $('#formDataSaida');
        var $formDestinoSelected = $('#formDestino option:selected');
        var $formItemSelected = $('#formItem option:selected');
        var $formContratoSelected = $('#formContrato option:selected');
        var $formQuantidade = $('#formQuantidade');

        dataSaidaAtual = $formDataSaida.val();
        destinoAtual = $formDestinoSelected.val();
        itemAtual = $formItemSelected.val();
        contratoAtual = $formContratoSelected.val();
        quantidadeAtual = $formQuantidade.val();
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Preenche o modal com os dados que o usuário inseriu.
     */
    function preencherModal() {
        // Modal.
        var $confFormDataSaida = $('#confFormDataSaida');
        var $confFormDestino = $('#confFormDestino');
        var $confFormItem = $('#confFormItem');
        var $confFormQuantidade = $('#confFormQuantidade');
        var $confFormContrato = $('#confFormContrato');
        var $confFormTipo = $('#confFormTipo');
        var $confLabelUnidade = $('#confLabelUnidade');

        // Formulário.
        var $formDataSaida = $('#formDataSaida');
        var $formDestinoSelected = $('#formDestino option:selected');
        var $formItemSelected = $('#formItem option:selected');
        var $formQuantidade = $('#formQuantidade');
        var $formContratoSelected = $('#formContrato option:selected');
        var $formTipoSelected = $('#formTipo option:selected');
        var $labelUnidade = $('#labelUnidade');

        // Preenchendo modal.
        $confFormDataSaida.text($formDataSaida.val());
        $confFormDestino.text($formDestinoSelected.text());
        $confFormItem.text($formItemSelected.text());
        $confFormQuantidade.text($formQuantidade.val());
        $confFormContrato.text($formContratoSelected.text());
        $confFormTipo.text($formTipoSelected.text());
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
        var $formDataSaida = $('#formDataSaida');
        var $formDestinoSelected = $('#formDestino option:selected');
        var $formItemSelected = $('#formItem option:selected');
        var $formQuantidade = $('#formQuantidade');
        var $formContratoSelected = $('#formContrato option:selected');
        var $formTipoSelected = $('#formTipo option:selected');

        var erro = false;

        // Campo data saída.
        if ($formDataSaida.val() == "") {
            erro = true;
            notificacao_alerta('Selecione uma <b>Data de Saída</b>.');
        }
        // Campo data saída - não pode ser maior que a data atual.
        else if (pegaData($formDataSaida.val()) > new Date()) {
            erro = true;
            notificacao_alerta('A <b>Data Saida</b> não pode ser maior que a data atual.');
        }
        // Campo Destino.
        else if ($formDestinoSelected.val() == 0) {
            erro = true;
            notificacao_alerta('Selecione um <b>Destino</b>.');
        }
        // Campo Item.
        else if ($formItemSelected.val() == 0) {
            erro = true;
            notificacao_alerta('Selecione um <b>Item</b>.');
        }

        // Campo Contrato.
        else if ($formContratoSelected.val() == 0) {
            erro = true;
            notificacao_alerta('Selecione um <b>Contrato</b>.');
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
        else if(dataSaidaAtual == $formDataSaida.val() &&
            destinoAtual == $formDestinoSelected.val() &&
            itemAtual == $formItemSelected.val() &&
            contratoAtual == $formContratoSelected.val() &&
            quantidadeAtual == $formQuantidade.val()) {
            erro = true;
            notificacao_alerta('Não há nenhuma atualização nos campos.');
        }

        return erro;
    }
});

/* Fim do arquivo: alterar.js */
/* Localização: ./js/painel_editar/saida/alterar_saida/alterar.js */
