/**
 * JavaScript do menu 'Alterar Usuário'
 *
 * url - {root}/paineleditar/administrador/dadosadministrador/alterar
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */

$(document).ready(function () {
    /**
     * Armazena se o administrador deseja alterar a senha também.
     *
     * @type {boolean}
     */
    var alterarSenha = false;
    /**
     * Nome atual completo do administrador.
     *
     * @type {string}
     */
    var nomeCompletoAtual;

    main();

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Função Principal.
     */
    function main() {
        var $avisoAlterarSenha = $('#avisoAlterarSenha');
        var $botaoAlterarDados = $('#botaoAlterarDados');
        var $confFormEnviar = $('#confFormEnviar');
        var $confFormSenha = $('#confFormSenha');
        var $formAlterarUsuario = $('#formAlterarUsuario');

        pegaCamposAtuais();
        $avisoAlterarSenha.click(mostrarAlterarSenha);
        $botaoAlterarDados.click(function () {
            if (!validaCampos()) {
                mostrarModal();
            }
        });
        $confFormEnviar.click(function () {
            $formAlterarUsuario.submit()
        });
        $confFormSenha.click(mostrarSenha);
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Preenche e mostra o modal.
     */
    function mostrarModal() {
        // Dados Do Formulário.
        var $formNivel = $('#formNivel option:selected');
        var $formNomeCompleto = $('#formNomeCompleto');
        var $formUsuario = $('#formUsuario');

        // Campos Do Modal.
        var $confFormNivel = $('#confFormNivel');
        var $confFormUsuario = $('#confFormUsuario');
        var $confFormNomeCompleto = $('#confFormNomeCompleto');

        // Modal.
        var $myModal = $('#myModal');

        $myModal.modal('show');
        $confFormNivel.html($formNivel.text());
        $confFormNomeCompleto.html($formNomeCompleto.val());
        $confFormUsuario.html($formUsuario.val());
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Mostra a senha no modal.
     */
    function mostrarSenha() {
        var $confFormSenha = $('#confFormSenha');
        var $formSenha = $('#formSenha');

        $confFormSenha.html($formSenha.val());
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Mostrar campos para alterar a senha.
     */
    function mostrarAlterarSenha() {
        var $alterarSenha = $('#alterarSenha');
        var $avisoAlterarSenha = $('#avisoAlterarSenha');
        var $divConfFormSenha = $('#divConfFormSenha');
        var $formSenha = $('#formSenha');
        var $formConfSenha = $('#formConfSenha');

        $alterarSenha.show();
        $avisoAlterarSenha.hide();
        $divConfFormSenha.show();
        $formSenha.val('');
        $formConfSenha.val('');

        alterarSenha = true;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Pegar os valores dos campos atuais (onde ainda não houve modificação).
     */
    function pegaCamposAtuais() {
        var $formNomeCompleto = $('#formNomeCompleto');
        nomeCompletoAtual = $formNomeCompleto.val();
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Valida o preenchimento dos campos.
     */
    function validaCampos() {
        // Campos do formulário.
        var $formNomeCompleto = $('#formNomeCompleto');
        var $formSenha = $('#formSenha');
        var $formConfSenha = $('#formConfSenha');

        // Variável de erro.
        var erro = false;

        // Nome completo: espaços vazios.
        if ($.trim($formNomeCompleto.val()) == "") {
            erro = true;
            notificacao_erro('Por favor, preencha o campo <b>Nome Completo</b>.');
        }
        // Nome completo: tamanho máximo 255.
        else if ($formNomeCompleto.val().length >= 255) {
            erro = true;
            notificacao_alerta('Tamanho do <b>Nome Completo</b> excedido. Insira um <b>Nome Completo</b> menor que 255 caracteres.');
        }
        // Nome Completo, Usuário, Nível: Verifica se houve atualização em alguns desses campos.
        else if ($formNomeCompleto.val() === nomeCompletoAtual && alterarSenha == false) {
            erro = true;
            notificacao_alerta('Não há nenhuma atualização nos campos.');
        }


        // Caso o usuário deseja mudar a senha.
        if (alterarSenha == true && erro == false) {
            // Senha: campo vazio.
            if ($.trim($formSenha.val()) == "") {
                erro = true;
                notificacao_alerta('Por favor, preencha o campo <b>Senha</b>');
            }
            // Senha: campo com espaços vazios.
            else if ($formSenha.val().indexOf(" ") !== -1) {
                erro = true;
                notificacao_alerta('O campo <b>Senha</b> não pode conter espaços vazios.');
            }
            // Senha: menor que 6 caracteres.
            else if ($formSenha.val().length < 6) {
                erro = true;
                notificacao_alerta('A <b>Senha</b> deve conter no mínimo 6 caracteres.');
            }
            // Senha e Confirmação Senha: campos diferentes.
            else if ($formSenha.val() != $formConfSenha.val()) {
                erro = true;
                notificacao_alerta('O valor da <b>Senha</b> e da <b>Conformação Senha</b> devem ser iguais.');
            }
        }

        return erro;
    }
});

/* Fim do arquivo: alterar.js */
/* Localização: ./js/painel_editar/administrador/dados_administrador/alterar.js */



