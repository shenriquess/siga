/**
 * JavaScript do menu 'Cadastrar Tipo'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */


$(document).ready(function () {
    // Botão Cadastrar tipo.
    $("#botaoCadastrarTipo").click(function () {
        // Validando os campos.
        if (!validaCampos()) {
            $("#myModal").modal('show');

            preencherModal();

            // Enviando formulário.
            $("#confFormEnviar").click(function () {
                $("#formCadastrarTipo").submit();
            });
        }
    });

    //----------------------------------------------------------------------------------------------------------------------

    /**
     * Preenche o modal com os dados que o usuário digitou.
     */
    function preencherModal() {
        $("#confFormTipo").text($("#formTipo").val());
        if ($("#formDescricao").val() != "") {
            $("#confFormDescricao").text($("#formDescricao").val());
        }

    }

    //----------------------------------------------------------------------------------------------------------------------

    /**
     * Valida todos os campos do formulário.
     *
     * @returns {boolean} Retorna falso caso não tenha corrido nenhum erro de validão,
     *                    e verdadeiro caso houve erros.
     */
    function validaCampos() {
        var erro = false;

        // Validando campo tipo.
        if($.trim($("#formTipo").val()) == "") {
            erro = true;
            notificacao_alerta('Insira um <b>nome</b> para o <b>Tipo</b>.');
        }
        // Validando campo tipo, tamanho máximo atingido.
        else if($.trim($("#formTipo").val()).length > 255)
        {
            erro = true;
            notificacao_alerta('O <b>nome</b> para o <b>tipo</b> deve conter no <b>máximo 255 caracteres.</b>');
        }
        // Validando campo descrição.
        else if ($("#formDescricao").val() != "" && $.trim($("#formDescricao").val()) == ""){
            erro = true;
            notificacao_alerta('Insira uma <b>Descrição</b> válida.');
        }
        // Validando campo descrição, tamanho máximo atingido.
        else if($("#formDescricao").val().length > 65535) {
            erro = true;
            notificacao_alerta('A <b>descrição</b> para o <b>tipo</b> deve conter no <b>máximo 65535 caracteres.</b>');
        }

        return erro;
    }
});

/* Fim do arquivo: cadastrar-tipo.js */
/* Localização: ./js/painel/configuracoes/cadastrar-tipo.js */