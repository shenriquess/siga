/**
 * JavaScript do menu 'Alterar Contrato'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */

$(document).ready(function () {
    /**
     * Código atual do contrato. (Sem modificações).
     */
    var codigoAtual;
    /**
     * Data de Início do contrato sem modificaç].
     */
    var dataInicioAtual;
    /**
     * Data de fim do contrato sem modificações.
     */
    var dataFimAtual;
    /**
     * Fornecedor do contrato sem modificações.
     */
    var fornecedorAtual;

    main();
    //------------------------------------------------------------------------------------------------------------------

    /**
     * Ativa a caixas de seleção das datas.
     */
    function ativaSelecionarDatas() {
        var $dataInicio = $('#dataInicio');
        var $dataFim = $('#dataFim');

        $dataInicio.datepicker(formatoData);
        $dataFim.datepicker(formatoData);
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Enviar ou submeter o formulário.
     */
    function enviarFormulario() {
        var $formAlterarContrato = $('#formAlterarContrato');
        var $myModal = $('#myModal');

        if (!validaCampos()) {
            $formAlterarContrato.submit();
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
        var $confFormEnviar = $('#confFormEnviar');

        ativaSelecionarDatas();
        pegaCamposAtuais();
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
        })
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
     * Pegar os valores dos campos atuais (onde ainda não houve modificação).
     */
    function pegaCamposAtuais() {
        var $formCodigo = $('#formCodigo');
        var $formDataInicio = $('#formDataInicio');
        var $formDataFim = $('#formDataFim');
        var $formFornecedorSelected = $('#formFornecedor option:selected');

        codigoAtual = $formCodigo.val();
        dataInicioAtual = $formDataInicio.val();
        dataFimAtual = $formDataFim.val();
        fornecedorAtual = $formFornecedorSelected.val();
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Preenche o modal com os dados que o usuário inseriu.
     */
    function preencherModal() {
        // Formulário.
        var $formCodigo = $('#formCodigo');
        var $formDataInicio = $('#formDataInicio');
        var $formDataFim = $('#formDataFim');
        var $formFornecedorSelected = $('#formFornecedor option:selected');

        // Modal.
        var $confFormCodigo = $('#confFormCodigo');
        var $confFormFornecedor = $('#confFormFornecedor');
        var $confFormVigencia = $('#confFormVigencia');

        $confFormCodigo.text($formCodigo.val());
        $confFormFornecedor.text($formFornecedorSelected.text());
        $confFormVigencia.text($formDataInicio.val() + ' até ' + $formDataFim.val());
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Valida os campos.
     *
     * @returns {boolean} Retorna falso caso não tenha corrido nenhum erro de validão,
     *                    e verdadeiro caso houve erros.
     */
    function validaCampos() {
        var $formCodigo = $('#formCodigo');
        var $formDataInicio = $('#formDataInicio');
        var $formDataFim = $('#formDataFim');
        var $formFornecedorSelected = $('#formFornecedor option:selected');
        var erro = false;

        // Verifica se um fornecedor foi selecionado.
        if ($formFornecedorSelected.val() <= 0) {
            erro = true;
            notificacao_alerta('Selecione um <b>Fornecedor</b>.');
        }
        // Verifica se um codigo foi digitado.
        else if ($.trim($formCodigo.val()) == "") {
            erro = true;
            notificacao_alerta('Insira um <b>Código</b>.');
        }
        // Verifica se a data inicio foi selecionada.
        else if ($.trim($formDataInicio.val()) == "") {
            erro = true;
            notificacao_alerta('Insira uma <b>Data Saída</b>.');
        }
        // Verifica se a data fim foi selecionada.
        else if ($.trim($formDataFim.val()) == "") {
            erro = true;
            notificacao_alerta('Insira uma <b>Data Fim</b>.');
        }
        // Verifica se a data inicio e menos que a data fim.
        else if (pegaData($formDataInicio.val()) >= pegaData($formDataFim.val())) {
            erro = true;
            notificacao_alerta('A <b>Data Início</b> não pode ser maior ou igual que a <b>Data Fim</b>.');
        }
        // Validando se há atualizações nos campos.
        else if ($formCodigo.val() == codigoAtual &&
            $formDataInicio.val() == dataInicioAtual &&
            $formDataFim.val() == dataFimAtual &&
            $formFornecedorSelected.val() == fornecedorAtual) {
            erro = true;
            notificacao_alerta('Não há nenhuma atualização nos campos.');
        }


        return erro;
    }
});

/* Fim do arquivo: alterar.js */
/* Localização: ./js/painel_editar/configuracoes/alterar_contrato/alterar-contrato.js */