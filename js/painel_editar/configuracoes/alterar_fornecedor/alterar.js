/**
 * JavaScript do menu 'Alterar Fornecedor'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */


$(document).ready(function () {
    var descricaoAtual;
    var fornecedorAtual;

    main();
    //------------------------------------------------------------------------------------------------------------------

    /**
     * Enviar ou submeter o formulário.
     */
    function enviarFormulario() {
        var $formAlterarFornedor = $('#formAlterarFornecedor');
        var $myModal = $('#myModal');

        if (!validaCampos()) {
            $formAlterarFornedor.submit();
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
        var $formFornecedor = $('#formFornecedor');

        descricaoAtual = $formDescricao.val();
        fornecedorAtual = $formFornecedor.val();
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Preenche o modal com os dados que o usuário inseriu.
     */
    function preencherModal() {
        var $confFormDescricao = $('#confFormDescricao');
        var $confFormFornecedor = $('#confFormFornecedor');;
        var $formDescricao = $('#formDescricao');
        var $formFornecedor = $('#formFornecedor')

        if ($formDescricao.val() != "") {
            $confFormDescricao.text($formDescricao.val());
        } else {
            $confFormDescricao.text('(Sem Descrição)');
        }
        $confFormFornecedor.text($formFornecedor.val());
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Valida os campos.
     *
     * @returns {boolean} Retorna falso caso não tenha corrido nenhum erro de validão,
     *                    e verdadeiro caso houve erros.
     */
    function validaCampos() {
        var $formFornecedor = $('#formFornecedor');
        var $formDescricao = $('#formDescricao');

        var erro = false;

        // Validando campo fornecedor.
        if ($.trim($formFornecedor.val()) == "") {
            erro = true;
            notificacao_alerta('Insira um <b>nome</b> para o <b>Fornecedor</b>.');
        }
        // Validando campo fornecedor, tamanho máximo atingido.
        else if ($.trim($formFornecedor.val()).length > 255) {
            erro = true;
            notificacao_alerta('O <b>nome</b> para o <b>Fornecedor</b> deve conter no <b>máximo 255 caracteres.</b>');
        }
        // Validando campo descrição.
        else if ($formDescricao.val() != "" && $.trim($formDescricao.val()) == "") {
            erro = true;
            notificacao_alerta('Insira uma <b>Descrição</b> válida.');
        }
        // Validando campo descrição, tamanho máximo atingido.
        else if ($formDescricao.val().length > 65535) {
            erro = true;
            notificacao_alerta('A <b>descrição</b> para o <b>fornecedor</b> deve conter no <b>máximo 65535 caracteres.</b>');
        }
        // Validando se há atualizações nos campos.
        else if ($formFornecedor.val() == fornecedorAtual && $formDescricao.val() == descricaoAtual) {
            erro = true;
            notificacao_alerta('Não há nenhuma atualização nos campos.');
        }


        return erro;
    }
});

/* Fim do arquivo: alterar.js */
/* Localização: ./js/painel_editar/configuracoes/alterar_fornecedor/alterar.js */