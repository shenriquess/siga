/**
 * JavaScript do menu 'Inserir Saída'
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */

$(document).ready(function () {
    /**
     * Se estiver no modo edição armazena true, senão false.
     * @type {boolean}
     */
    var editando = false;
    /**
     * Armazena o valor do contrato selecionado.
     * @type {number}
     */
    var valorFormContrato = 0;
    /**
     * Itens do contrato escolhido.
     * @type {{}}
     */
    var itens_contrato = {};
    /**
     * Se a lista está vazia igual a true, senão false.
     * @type {boolean}
     */
    var listaVazia = true;
    /**
     * Tamanho da lista.
     * @type {number}
     */
    var listaTamanho = 0;
    /**
     * Posição do item que está sendo editado no momento.
     * @type {number}
     */
    var posicaoEditar = 0;

    // Caixa de seleção do contrato.
    $('#formContrato').focus(function () {
        valorFormContrato = $(this).val();
    }).change(function () {
        if (valorFormContrato != 0) {
            alertaMudancaContrato(valorFormContrato, $(this).val());
        } else {
            criaOpcaoItensContratos();
        }
    });

    // Caixa de seleção Item.
    $('#formItemContrato').change(criaUnidade);

    // Botão Adicionar.
    recarregaTudo()
    $('#botaoAdicionar').click(function () {
        if (!validaAdicionarItem()) {
            if (listaVazia == true) {
                $('#listaVazia').hide();
            }

            if (editando == false) {
                adicionarItem();
                listaTamanho++;
                notificacao_sucesso('Item <b>adicionado</b> com sucesso.');
                limparCamposItem();
            } else {
                editando = false;
                concluiEditarItem();
                $('#botaoAdicionar').attr('class', 'btn btn-default btn-block');
                $('#botaoAdicionar').html('Adicionar a Lista');
                notificacao_sucesso('Item <b>editado</b> com sucesso.');
                limparCamposItem();
            }
            recarregaTudo();
        }
    });

    // Botão Cadastrar Contrato.
    $('#botaoInserirEntrada').click(function () {
        if (!validaCampos() && !validaQuantidadeFaltante()) {
            preencherModal();
            $('#modalConfirmacao').modal('show');
        }
    });

    // Botão Confirmar Inserir Saida (No Modal).
    $('#confBotaoEnviar').click(function () {
        if (!validaQuantidadeFaltante()) {
            $('#barraProgresso').show();
            $('#modalTitulo').html('Realizando Cadastro');
            enviarCadastro();
        }
    });

    // Caixas de Seleção das Datas.
    $('#dataEntrada').datepicker(formatoData);

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Adiciona um novo item na lista de itens.
     */
    function adicionarItem() {
        var $formItemContrato = $('#formItemContrato option:selected');
        var $formQuantidade = $('#formQuantidade');
        var $formUnidade = $('#formUnidade');

        var stringHTML = ''
            + '<div class="listaItem">'
            + '<div class="row">'
            + '<var class="idItemContrato" style="display: none">' + $formItemContrato.val() + '</var>'
            + '<var class="valorQuantidade" style="display: none">' + $formQuantidade.val() + '</var>'
            + '<div class="col-md-4 item" style="margin-top: 5px">'
            + $formItemContrato.text()
            + '</div>'
            + '<div class="col-md-4 quantidade" style="margin-top: 5px">'
            + $formQuantidade.val() + ' ' + $formUnidade.html()
            + '</div>'
            + '<div class="col-md-4">'
            + '<div class="text-right">'
            + '<button class="btn btn-default botaoEditar"><i class="fa fa-edit"></i></button>'
            + '<button class="btn btn-danger botaoRemover"><i class="fa fa-trash"></i></button>'
            + '</div>'
            + '</div>'
            + '</div>'
            + '<hr/>'
            + '</div>';

        $('#listaItens').append(stringHTML);
    }

    //------------------------------------------------------------------------------------------------------------------

    function atualizaItensContrato() {
        var erro = false;
        var idContrato = $('#formContrato option:selected').val();

        $.ajax({
            url: urlBase + 'api/painel/entrada/inserirentrada/itenscontrato?idContrato=' + idContrato,
            type: 'get',
            async: false,
            success: function (dados, status) {
                if (dados.sucesso == true) {
                    itens_contrato = dados.resposta;
                }
            },
            error: function (xhr, desc, err) {
                erro = true;
            }
        });
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Exibe um alerta falando que todos os dados preenchidos da lista serão perdidos.
     */
    function alertaMudancaContrato(valorContratoAntigo, valorContratoNovo) {
        $('#modalAlerta').modal('show');
        $('#botaoAlertaSim').click(function () {
            $('#formContrato').val(valorContratoNovo);
            limparTudo();
            criaOpcaoItensContratos();
        });
        $('#botaoAlertaNao').click(function () {
            $('#formContrato').val(valorContratoAntigo);
            criaOpcaoItensContratos();
        });
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Cria a opção de itens de acordo com o tipo selecionado.
     *
     * @param idTipo ID do tipo.
     * @returns {string}
     */
    function criaOpcaoItensContratos() {
        atualizaItensContrato();

        var $formItemContrato = $('#formItemContrato');
        var string = '<option value="0">Item</option>';

        for (var i in itens_contrato) {
            if (itens_contrato.hasOwnProperty(i)) {
                string += '<option value="' + itens_contrato[i].id_item_contrato + '">' + itens_contrato[i].nome + '</option>';
            }
        }

        $formItemContrato.empty();
        $formItemContrato.html(string);
    }


    //------------------------------------------------------------------------------------------------------------------

    /**
     * Cria o label unidade, de acordo com o item selecionado.
     */
    function criaUnidade() {
        var idItemContrato = $('#formItemContrato option:selected').val();
        var encontrouItem = false;

        for (var i in itens_contrato) {
            if (itens_contrato.hasOwnProperty(i) && itens_contrato[i]['id_item_contrato'] == idItemContrato) {
                $('#formUnidade').html(unidades[itens_contrato[i]['unidade_padrao_id']]['nome']);
                encontrouItem = true;
                break;
            }
        }
        if (!encontrouItem) {
            $('#formUnidade').empty();
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Atualiza o campo após finalizar a edição de um item da lista.
     */
    function concluiEditarItem() {
        var $formItemContratoSelected = $('#formItemContrato option:selected');
        var $formQuantidade = $('#formQuantidade');
        var $formUnidade = $('#formUnidade');

        $($('.idItemContrato')[posicaoEditar]).html($formItemContratoSelected.val());
        $($('.valorQuantidade')[posicaoEditar]).html($formQuantidade.val());

        $($('.item')[posicaoEditar]).html($formItemContratoSelected.text());
        $($('.quantidade')[posicaoEditar]).html($formQuantidade.val() + ' ' + $formUnidade.html());
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Envia o cadastro para a API REST.
     */
    function enviarCadastro() {
        var idContrato = $("#formContrato option:selected").val();
        var numeroNota = $("#formNumeroNota").val();
        var dataEntrada = $("#formDataEntrada").val();

        var jsonListaItens = [];

        $('var[class="idItemContrato"]').each(function (pos, item) {
            if (!jsonListaItens.hasOwnProperty(pos)) {
                jsonListaItens[pos] = {
                    idContrato: idContrato,
                    numeroNota: numeroNota,
                    dataEntrada: dataEntrada
                };
            }
            jsonListaItens[pos][$(this).attr('class')] = $(this).html();
        });
        $('var[class="valorQuantidade"]').each(function (pos, item) {
            if (!jsonListaItens.hasOwnProperty(pos)) {
                jsonListaItens[pos] = {
                    idContrato: idContrato,
                    numeroNota: numeroNota,
                    dataEntrada: dataEntrada
                };
            }
            jsonListaItens[pos][$(this).attr('class')] = $(this).html();
        });

        $.ajax({
            url: urlBase + 'api/painel/entrada/inserirentrada/cadastrar',
            type: 'post',
            dataType: 'json',
            data: JSON.stringify(jsonListaItens),
            success: function (data, status) {
                if (data.sucesso == true) {
                    modalSucesso();
                }
                // TODO implementar erro.
            },
            error: function (xhr, desc, err) {
                modalErro();
            }
        });
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Limpa os campos, exceto contrato.
     */
    function limparCampos() {
        $('#formDataEntrada').val('');
        $('#formNumeroNota').val('');
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Limpa ou zera os campos do adicionar novo item.
     */
    function limparCamposItem() {
        $('#formItemContrato').val(0);
        $('#formQuantidade').val('');
        $('#formUnidade').empty();
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Limpa toda a lista de itens.
     */
    function limparLista() {
        $('#listaItens').empty();
        $('#listaVazia').show();
        listaTamanho = 0;
        listaVazia = true;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Limpa tudo. Campos, a lista e o os campos do adicionar item.11111111
     */
    function limparTudo() {
        limparCampos();
        limparCamposItem();
        limparLista();
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Mostra uma mensagem de sucesso no modal
     */
    function modalSucesso() {
        var stringHtml = ''
            + '<div class="row">'
            + '<div class="col-md-12">'
            + '<div class="text-center">'
            + '<h4>Entrada cadastrada com <b>sucesso</b>.</h4>'
            + '</div>'
            + '</div>'
            + '</div>'
            + '<div class="row">'
            + '<div class="col-md-2 col-md-offset-5">'
            + '<button id="botaoOk" class="btn btn-success btn-block">OK</button>'
            + '</div>'
            + '</div>';

        $('#modalRodape').empty();
        $('#modalTitulo').html('Entrada Cadastrada');
        $('#modalCorpo').html(stringHtml);
        $('#botaoOk').click(function () {
            resetaTudo();
            location.reload();
        });
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Modal de aviso de erro de conexão.
     */
    function modalErro() {
        $('#tituloModal').html('Confirmação de Cadastro de Saída')
        $('#barraProgresso').hide();
        $('#modalErro').modal('show');
    }


    //------------------------------------------------------------------------------------------------------------------

    /**
     * Preenche o modal com os valores preenchidos pelo usuário.
     */
    function preencherModal() {
        var string = '';
        var $classItem = $('.item');
        var $classQuantidade = $('.quantidade');

        $("#confFormContrato").text($("#formContrato option:selected").text());
        $("#confFormNumeroNota").text($("#formNumeroNota").val());
        $("#confFormDataEntrada").text($("#formDataEntrada").val());

        $('.listaItem').each(function (posicao, listaItem) {
            string += ''
            + '<div class="row">'
            + '<div class="col-md-6" style="padding-right: 0;">'
            + '<h5>' + $($classItem[posicao]).html() + '</h5>'
            + '</div>'
            + '<div class="col-md-6" style="padding-right: 0; padding-left: 4px;">'
            + '<h5>&nbsp;&nbsp;&nbsp;' + $($classQuantidade[posicao]).html() + '</h5>'
            + '</div>'
            + '</div>';
        });

        $('#confListaItens').html(string);
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Recarrega os botões de edição.
     */
    function recarregaEditarItem() {
        var $botaoEditar = $('.botaoEditar');

        $botaoEditar.off();
        $botaoEditar.each(function (posicao, botaoEditar) {
            $(botaoEditar).click(function () {
                var $idItemContrato = $($('.idItemContrato')[posicao]);
                var $valorQuantidade = $($('.valorQuantidade')[posicao]);

                posicaoEditar = posicao;
                editando = true;

                $('#formItemContrato').val($idItemContrato.html());
                $('#formQuantidade').val($valorQuantidade.html());
                criaUnidade();

                $('#botaoAdicionar').attr('class', 'btn btn-warning btn-block');
                $('#botaoAdicionar').html('Edição Concluída');
            });
        });
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Recarrega os botões de remoção.
     */
    function recarregaRemoverItem() {
        var $botaoRemover = $('.botaoRemover');

        $botaoRemover.off();
        $botaoRemover.each(function (posicao, botaoRemover) {
            $(botaoRemover).click(function () {
                $($('.listaItem')[posicao]).remove();
                listaTamanho--;
                recarregaTudo();
                if (listaTamanho == 0) {
                    $('#listaVazia').show();
                }
                notificacao_sucesso('Item <b>removido</b> com sucesso.');
            });
        });
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Recarrega tudo (botões de edição e botões de remoção).
     */
    function recarregaTudo() {
        recarregaEditarItem();
        recarregaRemoverItem();
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Limpa ou reseta todos os campos da página.
     */
    function resetaTudo() {
        limparCamposItem();
        limparLista();
        $('#formContrato').val(0);
        $('#formDataEntrada').val('');
        $('#formNumeroNota').val('');
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Valida os campos antes de adiciona-lós na lista de itens.
     * @returns {boolean} Retorna verdadeiro caso houve erros, caso contrário retorna falso.
     */
    function validaAdicionarItem() {
        var erro = false;

        var $formItemContratoSelected = $('#formItemContrato option:selected');
        var $formQuantidade = $('#formQuantidade');

        if ($formItemContratoSelected.val() <= 0) {
            erro = true;
            notificacao_alerta('Selecine um <b>Item</b.');
        }
        else if (!$.isNumeric($formQuantidade.val())) {
            erro = true;
            notificacao_alerta('Insira um número em <b>Quantidade</b>.');
        }
        else if ($formQuantidade.val().indexOf('.') > 0 || $formQuantidade.val().indexOf(',') > 0) {
            erro = true;
            notificacao_alerta('Insira apenas valores inteiros em <b>Quantidade</b>.');
        }
        else if (parseInt($formQuantidade.val()) <= 0) {
            erro = true;
            notificacao_alerta('Insira um valor maior que 0 (zero) em <b>Quantidade</b>.');
        }
        else {
            // Verificando se há não há itens repetidos.
            $('var[class="idItemContrato"]').each(function (position, idItem) {
                if ($(idItem).html() == $formItemContratoSelected.val() && editando == false) {
                    erro = true;
                    notificacao_alerta('<b>Itens iguais</b> estão sendo c adastrados. Junte suas quantidades.');
                }
            });

            for (var i in itens_contrato) {
                if (itens_contrato.hasOwnProperty(i) && itens_contrato[i]['id_item_contrato'] == $formItemContratoSelected.val()) {
                    if (parseInt($formQuantidade.val()) > itens_contrato[i]['quantidade_faltante']) {
                        erro = true;
                        notificacao_alerta('A <b>quantidade</b> inserida supera a quantidade contratada.');
                        notificacao_sucesso('Quantidade restante a ser entregue: <b>' + itens_contrato[i]['quantidade_faltante'] + ' ' + unidades[itens_contrato[i]['unidade_padrao_id']]['nome'] + '</b>');
                        break;
                    }
                }
            }
        }

        return erro;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Valida os outros campos do cadastrado.
     * @returns {boolean} Retorna verdadeiro caso ocorra algum erro, se não retorna falso.
     */
    function validaCampos() {
        var erro = false;

        var $formDataEntrada = $("#formDataEntrada");

        // Verifica se um contrato foi selecionado.
        if ($("#formContrato option:selected").val() <= 0) {
            erro = true;
            notificacao_alerta('Selecione um <b>Contrato</b>.');
        }
        // Verifica se um número de nota foi digitado.
        else if ($.trim($("#formNumeroNota").val()) == "") {
            erro = true;
            notificacao_alerta('Insira o <b>Número Nota</b>.');
        }
        // Verifica se a data de entrada foi selecionada.
        else if ($.trim($("#formDataEntrada").val()) == "") {
            erro = true;
            notificacao_alerta('Insira uma <b>Data Entrada</b>.');
        }
        // Verifica se a data selecionada não é maior que a data atual.
        else if (pegaData($("#formDataEntrada").val()) > new Date()) {
            erro = true;
            notificacao_alerta('A <b>Data Entrada</b> não pode ser maior que a data atual.');
        }
        // Verifica se há algum item na lista.
        else if (listaTamanho <= 0) {
            erro = true;
            notificacao_alerta('<b>Lista de Itens</b> está vazia.');
        } else {
            // Verifica se as datas inseridas estão dentro do período de vigência do contrato.
            $.ajax({
                async: false,
                url: urlBase + 'api/painel/entrada/inserirentrada/datavigencia?idContrato=' + $("#formContrato option:selected").val(),
                type: 'get',
                success: function (dados, status) {
                    if (dados.sucesso == true) {
                        var data_vigencia = dados.resposta;

                        if ((pegaData($formDataEntrada.val()) > pegaData(data_vigencia.data_fim)) || (pegaData($formDataEntrada.val()) < pegaData(data_vigencia.data_inicio))) {
                            erro = true;
                            notificacao_alerta('A <b>Data Entrada</b> deverá pertencer ao período de vigência do contrato. Período de vigência do contrato: de <b>' + data_vigencia.data_inicio + '</b> até <b>' + data_vigencia.data_fim + '</b>');
                        }
                    }
                    // TODO implementar erro.
                },
                error: function (xhr, desc, err) {
                    erro = true;
                    notificacao_alerta('Falha na conexão com a rede.');
                }
            });
        }

        return erro;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Valida ou verifica se a quantidade de um item inserido não está passando da quantidade total contratada.
     * Esta validação evita as inserções em paralelo.
     *
     * @returns {boolean}
     */
    function validaQuantidadeFaltante() {
        var erro = false;

        atualizaItensContrato();

        var $idItemContrato = $('var[class="idItemContrato"]');
        var $valorQuantidade = $('var[class="valorQuantidade"]');

        $idItemContrato.each(function (pos, item) {
            for (var i in itens_contrato) {
                if (itens_contrato.hasOwnProperty(i) && itens_contrato[i]['id_item_contrato'] == $(item).html()) {
                    if (parseInt($($valorQuantidade[pos]).html()) > parseInt(itens_contrato[i]['quantidade_faltante'])) {
                        erro = true;
                        notificacao_alerta('A <b>quantidade</b> inserida para o item <b>' + itens_contrato[i]['nome'] + '</b> supera a quantidade contratada.');
                        notificacao_sucesso('Quantidade restante a ser entregue: <b>' + itens_contrato[i]['quantidade_faltante'] + ' ' + unidades[itens_contrato[i]['unidade_padrao_id']]['nome'] + '</b>');
                        return false;
                    }
                }
            }
        });

        return erro;
    }

});

/* Fim do arquivo: inserir-entrada.js */
/* Localização: ./js/painel/saida/inserir-entrada.js */
