/**
 * JavaScript do menu 'Cadastrar Usuário'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */

/**
 * Principal
 */
$(document).ready(function () {

    // Botão Cadastrar Usuário.
    $("#botaoCadastrarUsuario").click(function () {
        // Validando os campos.
        if (!validaCampos()) {
            $("#myModal").modal('show');

            // Preenchendo o Modal.
            $("#confFormNomeCompleto").text($("#formNomeCompleto").val());
            $("#confFormUsuario").text($("#formUsuario").val());
            $("#confFormSenha").text("(Clique aqui para visualizar)");
            $("#confFormNivel").text($("#formNivel option:selected").text());

            $("#confFormSenha").click(function () {
                $("#confFormSenha").text($("#formSenha").val());
            });

            // Enviar formulário.
            $("#confFormEnviar").click(function () {
                $("#formCadastrarUsuario").submit();
            });
        }
    });

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Valida todos os campos do formulário.
     *
     * @returns {boolean} Retorna falso caso não tenha corrido nenhum erro de validão,
     *                    e verdadeiro caso houve erros.
     */
    function validaCampos() {
        var erro = false;

        // TODO fazer validão do nível.

        // Validando campo Nome Completo.
        if ($.trim($("#formNomeCompleto").val()) == "") {
            erro = true;
            notificacao_alerta('Insira o <b>Nome Completo</b> do novo usuário.');
        }
        // Validando se o campo 'Nome Completo' possui menos que 255 caracteres.
        else if($("#formNomeCompleto").val().length >= 255 ) {
            erro = true;
            notificacao_alerta('Tamanho do <b>Nome Completo</b> excedido. Insira um <b>Nome Completo</b> menor que 255 caracteres.');
        }
        // Validando campo usuário. (Verificando preenchimento).
        else if($.trim($("#formUsuario").val()) == "") {
            erro = true;
            notificacao_alerta('Insira o campo <b>Usuário</b> do novo usuário.');
        }
        // Validando campo usuário. (Verificando presença de espaços).
        else if ($("#formUsuario").val().indexOf(" ") !== -1) {
            erro = true;
            notificacao_alerta('O campo <b>Usuário</b> não pode conter espaços vazios.');
        }
        // Validando campo senha. (Verificando preenchimento).
        else if($.trim($("#formSenha").val()) == "") {
            erro = true;
            notificacao_alerta('Insira a <b>Senha</b> do novo usuário.');
        }
        // Validando campo senha. (Verificando presença de espaços).
        else if($("#formSenha").val().indexOf(" ") !== -1) {
            erro = true;
            notificacao_alerta('O campo <b>Senha</b> não pode conter espaços vazios.');
        }
        // Validando campo senha. (Verificação do tamanho).
        else if($("#formSenha").val().length < 6) {
            erro = true;
            notificacao_alerta('A <b>Senha</b> deve conter no mínimo 6 caracteres.');
        }
        // Validando campo senha e confirmação senha.
        else if($("#formSenha").val() != $("#formConfSenha").val()) {
            erro = true;
            notificacao_alerta('O valor da <b>Senha</b> e da <b>Confirmação Senha</b> devem ser iguais.');
        }

        return erro;
    }
});

/* Fim do arquivo: cadastrar-usuario.js */
/* Localização: ./js/painel/configuracoes/cadastrar-usuario.js */