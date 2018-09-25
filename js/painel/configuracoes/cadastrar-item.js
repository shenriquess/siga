/**
 * JavaScript do menu 'Cadastrar Item'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */


/**
 * Valida todos os campos do formulário.
 *
 * @returns {boolean} Retorna falso caso não tenha corrido nenhum erro de validão,
 *                    e verdadeiro caso houve erros.
 */
function validaCampos() {
    var erro = false;

    // Validando campo item.
    if($.trim($("#formItem").val()) == "") {
        erro = true;
        notificacao_alerta('Insira um nome para o <b>Item</b>.');
    }
    // Validando campo unidade padrão.
    else if($("#formUnidadePadrao").val() == 0) {
        erro = true;
        notificacao_alerta('Selecione uma <b>Unidade Padrão</b>.');
    }
    // Validando campo tipo.
    else if($("#formTipo").val() == 0) {
        erro = true;
        notificacao_alerta('Selecione um <b>Tipo</b>.');
    }
    // Validando campo descrição.
    else if ($("#formDescricao").val() != "" && $.trim($("#formDescricao").val()) == ""){
        erro = true;
        notificacao_alerta('Insira uma <b>Descrição</b> válida.');
    }

    return erro;
}

//----------------------------------------------------------------------------------------------------------------------

$(document).ready(function () {
    $("#botaoCadastrarItem").click(function () {
        // Validando campos.
        if (!validaCampos()) {
            $("#myModal").modal('show');

            // Escrever os outros campos no Modal.
            $("#confFormTipo").text($("#formTipo option:selected").text());
            $("#confFormItem").text($("#formItem").val());
            $("#confFormUnidadePadrao").text($("#formUnidadePadrao option:selected").text());

            // Escrever descrição no Modal.
            if ($("#formDescricao").val() != "") {
                $("#confFormDescricao").text($("#formDescricao").val());
            }

            // Enviar formulário.
            $("#confFormEnviar").click(function () {
                $("#formCadastrarItem").submit();
            });
        }
    });
});

/* Fim do arquivo: cadastrar-item.js */
/* Localização: ./js/painel/configuracoes/cadastrar-item.js */