/**
 * JavaScript do menu 'Alterar Fornecedor'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */


$(document).ready(function () {
    var descricaoAtual;
    var destinoAtual;

    main();
    //------------------------------------------------------------------------------------------------------------------

    /**
     * Enviar ou submeter o formulário.
     */
    function enviarFormulario() {
        var $formAlterarDestino = $('#formAlterarDestino');
        var $myModal = $('#myModal');

        if (!validaCampos()) {
            $formAlterarDestino.submit();
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
        var $formDestino = $('#formDestino');

        descricaoAtual = $formDescricao.val();
        destinoAtual = $formDestino.val();
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Preenche o modal com os dados que o usuário inseriu.
     */
    function preencherModal() {
        var $confFormDescricao = $('#confFormDescricao');
        var $confFormDestino = $('#confFormDestino');;
        var $formDescricao = $('#formDescricao');
        var $formDestino = $('#formDestino')

        if ($formDescricao.val() != "") {
            $confFormDescricao.text($formDescricao.val());
        } else {
            $confFormDescricao.text('(Sem Descrição)');
        }
        $confFormDestino.text($formDestino.val());
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
        var $formDestino = $('#formDestino');

        var erro = false;

        // Validando campo Destino.
        if ($.trim($formDestino.val()) == "") {
            erro = true;
            notificacao_alerta('Insira um <b>nome</b> para o <b>Destino</b>.');
        }
        // Validando campo Destino, tamanho máximo atingido.
        else if ($.trim($formDestino.val()).length > 255) {
            erro = true;
            notificacao_alerta('O <b>nome</b> para o <b>Destino</b> deve conter no <b>máximo 255 caracteres.</b>');
        }
        // Validando campo descrição.
        else if ($formDescricao.val() != "" && $.trim($formDescricao.val()) == "") {
            erro = true;
            notificacao_alerta('Insira uma <b>Descrição</b> válida.');
        }
        // Validando campo descrição, tamanho máximo atingido.
        else if ($formDescricao.val().length > 65535) {
            erro = true;
            notificacao_alerta('A <b>descrição</b> para o <b>Destino</b> deve conter no <b>máximo 65535 caracteres.</b>');
        }
        // Validando se há atualizações nos campos.
        else if ($formDestino.val() == destinoAtual && $formDescricao.val() == descricaoAtual) {
            erro = true;
            notificacao_alerta('Não há nenhuma atualização nos campos.');
        }


        return erro;
    }
});

/* Fim do arquivo: alterar.js */
/* Localização: ./js/painel_editar/configuracoes/alterar_destino/alterar.js */