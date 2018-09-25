/**
 * JavaScript do menu 'Alterar Entrada'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */


$(document).ready(function () {
    /**
     * Data de entrada atual (sem modificações).
     */
    var dataEntradaAtual;
    /**
     * Número da nota atual (sem modificações).
     */
    var numeroNotaAtual;
    /**
     * Quantidade de itens entregues (sem modificações).
     */
    var quantidadeAtual;

    main();
    //------------------------------------------------------------------------------------------------------------------

    /**
     * Ativa a caixa de seleção de data.
     */
    function ativaSelecionarDataEntrada() {
        var $dataEntrada = $('#dataEntrada');

        $dataEntrada.datepicker(formatoData);
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

    /**
     * Enviar ou submeter o formulário.
     */
    function enviarFormulario() {
        var $formAlterarEntrada = $('#formAlterarEntrada');
        var $myModal = $('#myModal');

        if (!validaCampos()) {
            $formAlterarEntrada.submit();
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

        ativaSelecionarDataEntrada();
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
        var $formDataEntrada = $('#formDataEntrada');
        var $formNumeroNota = $('#formNumeroNota');
        var $formQuantidade = $('#formQuantidade');

        dataEntradaAtual = $formDataEntrada.val();
        numeroNotaAtual = $formNumeroNota.val();
        quantidadeAtual = $formQuantidade.val();
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Preenche o modal com os dados que o usuário inseriu.
     */
    function preencherModal() {
        // Modal.
        var $confFormCodigoContrato = $('#confFormCodigoContrato');
        var $confFormDataEntrada = $('#confFormDataEntrada');
        var $confFormItem = $('#confFormItem');
        var $confFormNumeroNota = $('#confFormNumeroNota');
        var $confFormQuantidade = $('#confFormQuantidade');
        var $confFormTipo = $('#confFormTipo');
        var $confFormUnidade = $('#confFormUnidade');

        // Formulário.
        var $formCodigoContrato = $('#formCodigoContrato');
        var $formDataEntrada = $('#formDataEntrada');
        var $formItem = $('#formItem');
        var $formNumeroNota = $('#formNumeroNota');
        var $formQuantidade = $('#formQuantidade');
        var $formTipo = $('#formTipo');
        var $formUnidade = $('#formUnidade');

        // Preenchendo modal.
        $confFormCodigoContrato.text($formCodigoContrato.val());
        $confFormDataEntrada.text($formDataEntrada.val());
        $confFormNumeroNota.text($formNumeroNota.val());
        $confFormItem.text($formItem.val());
        $confFormQuantidade.text($formQuantidade.val());
        $confFormTipo.text($formTipo.val());
        $confFormUnidade.text($formUnidade.html());
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Valida os campos.
     *
     * @returns {boolean} Retorna falso caso não tenha corrido nenhum erro de validão,
     *                    e verdadeiro caso houve erros.
     */
    function validaCampos() {
        var $formCodigoContrato = $('#formCodigoContrato');
        var $formDataEntrada = $('#formDataEntrada');
        var $formItemSelected = $('#formItem option:selected');
        var $formNumeroNota = $('#formNumeroNota');
        var $formQuantidade = $('#formQuantidade');
        var $formTipoSelected = $('#formTipo option:selected');

        var erro = false;

        // Campo Data Entrada.
        if ($formDataEntrada.val() == "") {
            erro = true;
            notificacao_alerta('Selecione uma <b>Data de Entrada</b>.');
        }
        // Campo data entrada - não pode ser maior que a data atual.
        else if (pegaData($formDataEntrada.val()) > new Date()) {
            erro = true;
            notificacao_alerta('A <b>Data Entrada</b> não pode ser maior que a data atual.');
        }
        // Campo Número Nota.
        else if($.trim($formNumeroNota) == "") {
            erro = true;
            notificacao_alerta('Insira um <b>Número da Nota</b>');
        }
        // Campo Item.
        else if ($formItemSelected.val() == 0) {
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
        } else if(dataEntradaAtual == $formDataEntrada.val() &&
            numeroNotaAtual == $formNumeroNota.val() &&
            quantidadeAtual == $formQuantidade.val()) {
            erro = true;
            notificacao_alerta('Não há nenhuma atualização nos campos.');
        } else {
            // Verifica se as datas inseridas estão dentro do período de vigência do contrato.
            $.ajax({
                async: false,
                url: urlBase + 'api/paineleditar/entrada/alterarentrada/datavigencia?idContrato=' + idContrato,
                type: 'get',
                success: function (dados, status) {
                    if (dados.sucesso == true) {
                        var data_vigencia = dados.resposta;

                        if ((pegaData($formDataEntrada.val()) > pegaData(data_vigencia.data_fim)) || (pegaData($formDataEntrada.val()) < pegaData(data_vigencia.data_inicio))) {
                            erro = true;
                            notificacao_alerta('A <b>Data Entrada</b> deverá pertencer ao período de vigência do contrato. Período de vigência do contrato: de <b>' + data_vigencia.data_inicio + '</b> até <b>' + data_vigencia.data_fim + '</b>');
                        }
                    }
                    // TODO implementar erro.
                },
                error: function (xhr, desc, err) {
                    erro = true;
                    notificacao_alerta('Falha na conexão com a rede.');
                }
            });
        }

        return erro;
    }
});

/* Fim do arquivo: alterar.js */
/* Localização: ./js/painel_editar/entrada/alterar_entrada/alterar.js */