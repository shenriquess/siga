/**
 * JavaScript do menu 'Cadastrar Fornecedor'.
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

    if($.trim($("#formFornecedor").val()) == "") {
        erro = true;
        notificacao_alerta('Insira o nome do <b>Fornecedor</b>.')
    }
    else if ($("#formDescricao").val() != "" && $.trim($("#formDescricao").val()) == ""){
        erro = true;
        notificacao_alerta('Insira uma <b>Descrição</b> válida.');
    }

    return erro;
}

//----------------------------------------------------------------------------------------------------------------------

/**
 * Principal.
 */
$(document).ready(function () {
    // Botão Cadastrar Fornecedor.
    $("#botaoCadastrarFornecedor").click(function () {
        // Validando os campos.
        if (!validaCampos()) {
            $("#myModal").modal('show');
            $("#confFormFornecedor").text($("#formFornecedor").val());

            // Caso exista alguma descrição.
            if ($.trim($("#formDescricao").val()) != "") {
                $("#confFormDescricao").text($("#formDescricao").val());
            }

            // Enviar formulário.
            $("#confFormEnviar").click(function () {
                $("#formCadastrarFornecedor").submit();
            });
        }
    });
});

/* Fim do arquivo: cadastrar-fornecedor.js */
/* Localização: ./js/painel/configuracoes/cadastrar-fornecedor.js */