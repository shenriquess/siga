/**
 * Script com algumas funções padrões.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */

/**
 * Formato das datas utilizado no campo de seleção de datas.
 *
 * @type {{format: string, todayBtn: string, language: string, autoclose: boolean, todayHighlight: boolean}}
 */
var formatoData = {
    format: "dd/mm/yyyy",
    todayBtn: "linked",
    language: "pt-BR",
    autoclose: true,
    todayHighlight: true
};

/**
 * Notificação do tipo notificacao_alerta.
 *
 * @param string Frase a ser mostrada na tela.
 */
function notificacao_alerta(string) {
    var alerta = new PNotify({
        text: string,
        type: 'warning',
        icon: false,
        mouse_reset: false
    });
    alerta.get().click(function () {
        alerta.remove();
    })
}

/**
 * Notificação do tipo erro.
 *
 * @param string Frase a ser mostrada na tela.
 */
function notificacao_erro(string) {
    var alerta = new PNotify({
        text: string,
        type: 'erro',
        icon: false,
        mouse_reset: false
    });
    alerta.get().click(function () {
        alerta.remove();
    })
}

/**
 * Notificação do tipo sucesso.
 *
 * @param string Frase a ser mostrada na tela.
 */
function notificacao_sucesso(string) {
    var alerta = new PNotify({
        text: string,
        type: 'success',
        icon: false,
        mouse_reset: false
    });
    alerta.get().click(function () {
        alerta.remove();
    })
}

/**
 * Transforma uma data em formato pt-BR dd/mm/aaaa
 *
 * @param data Data a ser convertida
 * @returns {Date} Retorna a string da data formatada em pt-BR dd/mm/aaaa
 */
function pegaData(data) {
    var partes = data.split("/");
    return new Date(partes[2], partes[1] - 1, partes[0]);
}

function contarLetra(string, caracter) {
    return string.split(caracter).length - 1;
}