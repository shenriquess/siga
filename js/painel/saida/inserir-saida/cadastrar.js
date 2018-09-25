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

    // Botão Inserir Saida
    $('#botaoInserirSaida').click(function () {
        if (!validaCampos() && !validaQuantidadeTotal()) {
            preencherModal();
            $('#myModal').modal('show');
        }
    });

    // Botão Confirmar Inserir Saida (No Modal).
    $('#confBotaoEnviar').click(function () {
        if (!validaQuantidadeTotal()) {
            $('#barraProgresso').show();
            $('#tituloModal').html('Realizando Cadastro.');
            enviarCadastro();
        }
    });

    // Caixa de seleção Item.
    $('#formItem').change(criaUnidade);

    $('#formItem').change(function () {
        $('#formContrato').empty();
        $('#formContrato').html(criaOpcaoContratos($('#formItem option:selected').val()));
    });


    // Caixa de Seleção do Tipo.
    $('#formTipo').change(function () {
        $('#formItem').empty();
        $('#formContrato').empty();
        $('#formContrato').html('<option value="0">Contrato</option>');
        $('#formItem').html(criaOpcaoItens($('#formTipo option:selected').val()));
    });

    // Caixa de Seleção da Data.
    $('#dataSaida').datepicker({
        format: "dd/mm/yyyy",
        todayBtn: "linked",
        language: "pt-BR",
        autoclose: true,
        todayHighlight: true
    });

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Adiciona um novo item na lista de itens.
     */
    function adicionarItem() {
        var $formItem = $('#formItem option:selected');
        var $formContrato = $('#formContrato option:selected');
        var $formQuantidade = $('#formQuantidade');
        var $formTipo = $('#formTipo option:selected');
        var $formUnidade = $('#formUnidade');

        var stringHTML = ''
            + '<div class="listaItem">'
            + '<div class="row">'
            + '<var class="idTipo" style="display: none">' + $formTipo.val() + '</var>'
            + '<var class="idItem" style="display: none">' + $formItem.val() + '</var>'
            + '<var class="idContrato" style="display: none">' + $formContrato.val() + '</var>'
            + '<var class="valorQuantidade" style="display: none">' + $formQuantidade.val() + '</var>'
            + '<div class="col-md-2 tipo" style="margin-top: 5px">'
            + $formTipo.text()
            + '</div>'
            + '<div class="col-md-3 item" style="margin-top: 5px">'
            + $formItem.text()
            + '</div>'
            + '<div class="col-md-2 contrato" style="margin-top: 5px">'
            + $formContrato.text()
            + '</div>'
            + '<div class="col-md-2 quantidade" style="margin-top: 5px">'
            + $formQuantidade.val() + ' ' + $formUnidade.html()
            + '</div>'
            + '<div class="col-md-3">'
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

    /**
     * Cria a opção de itens de acordo com o tipo selecionado.
     *
     * @param idTipo ID do tipo.
     * @returns {string}
     */
    function criaOpcaoItens(idTipo) {
        var $formItem = $('#formItem');
        var string = '<option value="0">Item</option>';

        for (var i in itens) {
            if (itens.hasOwnProperty(i) != null && itens[i].id_tipo == idTipo) {
                string += '<option value="' + itens[i].id_item + '">' + itens[i].nome + '</option>';
            }
        }

        $formItem.empty();
        $formItem.html(string);
    }

    function criaOpcaoContratos(idItem) {
        var $formContrato = $('#formContrato');
        var string = '<option value="0">Contrato</option>';

        for (var i in contratos) {
            if (contratos.hasOwnProperty(i) != null && contratos[i].id_item == idItem) {
                string += '<option value="' + contratos[i].id_item_contrato + '">' + contratos[i].codigo + '</option>';
            }
        }

        $formContrato.empty();
        $formContrato.html(string);
    }


    //------------------------------------------------------------------------------------------------------------------

    /**
     * Cria o label unidade, de acordo com o item selecionado.
     */
    function criaUnidade() {
        var idItem = $('#formItem option:selected').val();
        var encontrouItem = false;

        for (i in itens) {
            if (itens.hasOwnProperty(i) && itens[i]['id_item'] == idItem) {
                $('#formUnidade').html(unidades[itens[i]['unidade_padrao_id']]['nome']);
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
        var $formTipoSelected = $('#formTipo option:selected');
        var $formItemSelected = $('#formItem option:selected');
        var $formContratoSelected = $('#formContrato option:selected');
        var $formQuantidade = $('#formQuantidade');
        var $formUnidade = $('#formUnidade');

        $($('.idTipo')[posicaoEditar]).html($formTipoSelected.val());
        $($('.idItem')[posicaoEditar]).html($formItemSelected.val());
        $($('.idContrato')[posicaoEditar]).html($formContratoSelected.val());
        $($('.valorQuantidade')[posicaoEditar]).html($formQuantidade.val());
        $($('.tipo')[posicaoEditar]).html($formTipoSelected.text());
        $($('.item')[posicaoEditar]).html($formItemSelected.text());
        $($('.contrato')[posicaoEditar]).html($formItemSelected.text());
        $($('.quantidade')[posicaoEditar]).html($formQuantidade.val() + ' ' + $formUnidade.html());
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Atualiza a lista de itens e seus respetivos campos, principalmente quantidade total.
     */
    function lerItensServidor() {
        $.ajax({
            url: urlBase + 'api/painel/saida/inserirsaida/itens',
            async: false,
            type: 'get',
            dataType: 'json',
            success: function (data, status) {
                if (data.sucesso == true) {
                    itens = data.resposta;
                }
                // TODO colocar erros em um else.
            },
            error: function (xhr, desc, err) {
                modalErro();
            }
        });
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Envia o cadastro para a API REST.
     */
    function enviarCadastro() {
        var idDestino = $('#formDestino').val();
        var dataSaida = $('#formDataSaida').val();
        var jsonListaItens = [];

        $('var[class="idTipo"]').each(function (pos, item) {
            if (!jsonListaItens.hasOwnProperty(pos)) {
                jsonListaItens[pos] = {idDestino: idDestino, dataSaida: dataSaida};
            }
            jsonListaItens[pos][$(this).attr('class')] = $(this).html();
        });
        $('var[class="idItem"]').each(function (pos, item) {
            if (!jsonListaItens.hasOwnProperty(pos)) {
                jsonListaItens[pos] = {idDestino: idDestino, dataSaida: dataSaida};
            }
            jsonListaItens[pos][$(this).attr('class')] = $(this).html();
        });
        $('var[class="idContrato"]').each(function (pos, item) {
            if (!jsonListaItens.hasOwnProperty(pos)) {
                jsonListaItens[pos] = {idDestino: idDestino, dataSaida: dataSaida};
            }
            jsonListaItens[pos][$(this).attr('class')] = $(this).html();
        });
        $('var[class="valorQuantidade"]').each(function (pos, item) {
            if (!jsonListaItens.hasOwnProperty(pos)) {
                jsonListaItens[pos] = {idDestino: idDestino, dataSaida: dataSaida};
            }
            jsonListaItens[pos][$(this).attr('class')] = $(this).html();
        });

        $.ajax({
            url: urlBase + 'api/painel/saida/inserirsaida/cadastrar',
            type: 'post',
            dataType: 'json',
            data: JSON.stringify(jsonListaItens),
            success: function (data, status) {
                if (data.sucesso == true) {
                    $('#formGerarSaida').val(JSON.stringify(data.resposta));
                    $('#gerarSaida').submit();
                }
                // TODO colocar erros em um else.
            },
            error: function (xhr, desc, err) {
                modalErro();
            }
        });
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Limpa ou zera os campos do adicionar novo item.
     */
    function limparCamposItem() {
        $('#formTipo').val(0);
        $('#formItem').val(0);
        $('#formContrato').val(0);
        $('#formQuantidade').val('');
        $('#formUnidade').empty();
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
        var $classTipo = $('.tipo');
        var $classItem = $('.item');
        var $classQuantidade = $('.quantidade');

        $("#confFormDestino").text($("#formDestino option:selected").text());
        $("#confFormDataSaida").text($("#formDataSaida").val());

        $('.listaItem').each(function (posicao, listaItem) {
            string += ''
            + '<div class="row">'
            + '<div class="col-md-4" style="padding-right: 0;">'
            + '<h5 id="confFormTipo">' + $($classTipo[posicao]).html() + '</h5>'
            + '</div>'
            + '<div class="col-md-4" style="padding-right: 0; padding-left: 4px;">'
            + '<h5 id="confFormItem">' + $($classItem[posicao]).html() + '</h5>'
            + '</div>'
            + '<div class="col-md-4" style="padding-right: 0; padding-left: 4px;">'
            + '<h5 id="confFormQuantidade">' + $($classQuantidade[posicao]).html() + '</h5>'
            + '</div>'
            + '</div>';
        });

        $('#confListaItem').html(string);
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
                var $idTipo = $($('.idTipo')[posicao]);
                var $idItem = $($('.idItem')[posicao]);
                var $idContrato = $($('.idContrato')[posicao]);
                var $valorQuantidade = $($('.valorQuantidade')[posicao]);

                posicaoEditar = posicao;
                editando = true;

                $('#formTipo').val($idTipo.html());
                criaOpcaoItens($idTipo.html());
                $('#formItem').val($idItem.html());
                criaOpcaoContratos($idItem.html());
                $('#formContrato').val($idContrato.html());
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
     * Valida os campos antes de adiciona-lós na lista de itens.
     * @returns {boolean} Retorna verdadeiro caso houve erros, caso contrário retorna falso.
     */
    function validaAdicionarItem() {
        var erro = false;

        var $formTipoSelected = $('#formTipo option:selected');
        var $formItemSelected = $('#formItem option:selected');
        var $formContratoSelected = $('#formContrato option:selected');
        var $formQuantidade = $('#formQuantidade');


        if ($formTipoSelected.val() <= 0) {
            erro = true;
            notificacao_alerta('Selecine um <b>Tipo</b>.');
        }
        else if ($formItemSelected.val() <= 0) {
            erro = true;
            notificacao_alerta('Selecine um <b>Item</b.');
        }
        else if ($formContratoSelected.val() <= 0) {
            erro = true;
            notificacao_alerta('Selecine um <b>Contrato</b.');
        }
        else if (!$.isNumeric($formQuantidade.val())) {
            erro = true;
            notificacao_alerta('Insira um número em <b>Quantidade</b>.');
        }
        else if ($formQuantidade.val().indexOf('.') > 0 || $formQuantidade.val().indexOf(',') > 0) {
            erro = true;
            notificacao_alerta('Insira apenas valores inteiros em <b>Quantidade</b>.');
        }
        else if ($formQuantidade.val() <= 0) {
            erro = true;
            notificacao_alerta('Insira um valor maior que 0 (zero) em <b>Quantidade</b>.');
        }
        else {
            // Verificando se há quantidade disponível.
            for (var i in itens) {
                if (itens.hasOwnProperty(i) && itens[i]['id_item'] == $formItemSelected.val()) {
                    if (parseInt(itens[i]['quantidade_total']) < parseInt($formQuantidade.val())) {
                        erro = true;
                        notificacao_alerta('Não há <b>Quantidade</b> disponível de <b>' + itens[i]['nome'] + '</b>.');
                        notificacao_sucesso('Quantidade de <b>' + itens[i]['nome'] + '</b> disponível: ' + itens[i]['quantidade_total'] + ' ' + unidades[itens[i]['unidade_padrao_id']]['nome']);
                        break;
                    }
                }
            }

            // Verificando se há não há itens repetidos.
            $('var[class="idItem"]').each(function (position, idItem) {
                if ($(idItem).html() == $formItemSelected.val() && editando == false) {
                    erro = true;
                    notificacao_alerta('<b>Itens iguais</b> estão sendo cadastrados. Junte suas quantidades.');
                }
            });
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

        // Verifica se um fornecedor foi selecionado.
        if ($("#formDestino option:selected").val() <= 0) {
            erro = true;
            notificacao_alerta('Selecione um <b>Destino</b>.');
        }
        // Verifica se a data inicio foi selecionada.
        else if ($.trim($("#formDataSaida").val()) == "") {
            erro = true;
            notificacao_alerta('Insira uma <b>Data Saída</b>.');
        }
        // Verifica se a data selecionada não é maior que a data atual.
        else if (pegaData($("#formDataSaida").val()) > new Date()) {
            erro = true;
            notificacao_alerta('A <b>Data Saída</b> não pode ser maior que a data atual.');
        }
        // Verifisa se há algum item na lista.
        else if (listaTamanho <= 0) {
            erro = true;
            notificacao_alerta('<b>Lista de Itens</b> está vazia.');
        }

        return erro;
    }

    //------------------------------------------------------------------------------------------------------------------

    function validaQuantidadeTotal() {
        var erro = false;

        var $idItem = $('var[class="idItem"]');
        var $valorQuantidade = $('var[class="valorQuantidade"]');

        lerItensServidor();
        $idItem.each(function (pos, item) {
            for (var i in itens) {
                if (itens.hasOwnProperty(i) && itens[i]['id_item'] == $(item).html()) {
                    if (parseInt($($valorQuantidade[pos]).html()) > parseInt(itens[i]['quantidade_total'])) {
                        erro = true;
                        notificacao_alerta('Não há <b>Quantidade</b> disponível de <b>' + itens[i]['nome'] + '</b>.');
                        notificacao_sucesso('Quantidade de <b>' + itens[i]['nome'] + '</b> disponível: ' + itens[i]['quantidade_total'] + ' ' + unidades[itens[i]['unidade_padrao_id']]['nome']);
                        return false;
                    }
                }
            }
        });

        return erro;
    }
});

/* Fim do arquivo: inserir-saida.js */
/* Localização: ./js/painel/saida/inserir-saida.js */
