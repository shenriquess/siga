/**
 * JavaScript do menu 'Alterar Item'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
$(document).ready(function () {
    var descricaoAtual;
    var itemAtual;
    var tipoAtual;
    var unidadeAtual;

    main();
    //------------------------------------------------------------------------------------------------------------------

    /**
     * Enviar ou submeter o formulário.
     */
    function enviarFormulario() {
        var $formAlterarTipo = $('#formAlterarTipo');
        var $myModal = $('#myModal');

        if (!validaCampos()) {
            $formAlterarTipo.submit();
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
        var $formDescricao = $('#formDescricao');
        var $formItem = $('#formItem');
        var $formTipo = $('#formTipo');
        var $formUnidade = $('#formUnidade');

        descricaoAtual = $formDescricao.val();
        itemAtual = $formItem.val();
        tipoAtual = $formTipo.val();
        unidadeAtual = $formUnidade.val();
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Preenche o modal com os dados que o usuário inseriu.
     */
    function preencherModal() {
        var $confFormDescricao = $('#confFormDescricao');
        var $confFormItem = $('#confFormItem');
        var $confFormTipo = $('#confFormTipo');
        var $confFormUnidade = $('#confFormUnidade');

        var $formDescricao = $('#formDescricao');
        var $formItem = $('#formItem');
        var $formTipo = $('#formTipo option:selected');
        var $formUnidade = $('#formUnidade option:selected');


        if ($formDescricao.val() != "") {
            $confFormDescricao.text($formDescricao.val());
        } else {
            $confFormDescricao.text('(Sem Descrição)');
        }
        $confFormItem.text($formItem.val());
        $confFormTipo.text($formTipo.text());
        $confFormUnidade.text($formUnidade.text());
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Valida os campos.
     *
     * @returns {boolean} Retorna falso caso não tenha corrido nenhum erro de validão,
     *                    e verdadeiro caso houve erros.
     */
    function validaCampos() {
        var $formDescricao = $('#formDescricao');
        var $formItem = $('#formItem')
        var $formTipo = $('#formTipo option:selected');
        var $formUnidade = $('#formUnidade option:selected');

        var erro = false;

        // Validando campo item.
        if ($.trim($formItem.val()) == "") {
            erro = true;
            notificacao_alerta('Insira um nome para o <b>Item</b>.');
        }
        else if ($formItem.val().length >= 255) {
            erro = true;
            notificacao_alerta('O <b>nome</b> para o <b>Item</b> deve conter no <b>máximo 255 caracteres.</b>');
        }
        // Validando campo unidade padrão.
        else if ($formUnidade.val() == 0) {
            erro = true;
            notificacao_alerta('Selecione uma <b>Unidade Padrão</b>.');
        }
        // Validando campo tipo.
        else if ($formTipo.val() == 0) {
            erro = true;
            notificacao_alerta('Selecione um <b>Tipo</b>.');
        }
        // Validando campo descrição.
        else if ($formDescricao.val() != "" && $.trim($formDescricao.val()) == "") {
            erro = true;
            notificacao_alerta('Insira uma <b>Descrição</b> válida.');
        } // Validando tamanho máximo de 65535.
        else if ($formDescricao.val().length >= 65535) {
            erro = true;
            notificacao_alerta('A <b>descrição</b> para o <b>item</b> deve conter no <b>máximo 65535 caracteres.</b>');
        } else if ($formDescricao.val() === descricaoAtual && $formItem.val() === itemAtual && $formTipo.val() === tipoAtual && $formUnidade.val() === unidadeAtual) {
            erro = true;
            notificacao_alerta('Não há nenhuma atualização nos campos.');
        }

        return erro;
    }
});

/* Fim do arquivo: alterar.js */
/* Localização: ./js/painel_editar/configuracoes/alterar_item/alterar.js */