/**
 * JavaScript do menu 'Cadastrar Contrato'
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
     * Tamanho da lista de itens já cadatrados no sistema.
     * @type {number}
     */
    var listaCadastradaTamanho = 0;
    /**
     * Se a lista de itens já cadastrado está vazia.
     * @type {boolean}
     */
    var listaCadastradaVazia = true;
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
    recarregaTudo();
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
    $('#botaoCadastrarContrato').click(function () {
        if (!validaCampos()) {
            preencherModal();
            if (listaCadastradaVazia == false) {
                preencherModalCadastrado();
            }
            $('#myModal').modal('show');
        }
    });

    // Botão Confirmar Inserir Saida (No Modal).
    $('#confBotaoEnviar').click(function () {
        $('#barraProgresso').show();
        $('#modalTitulo').html('Realizando Cadastro');
        enviarCadastro();
    });

    // Input do codigo do contrato.
    $('#formCodigo').focusout(verificaCodigoContrato);

    // Caixa de seleção Item.
    $('#formItem').change(criaUnidade);

    // Caixa de Seleção do Tipo.
    $('#formTipo').change(function () {
        $('#formItem').empty();
        $('#formItem').html(criaOpcaoItens($('#formTipo option:selected').val()));
    });

    // Ativar a escolha de data e fornecedor.
    ativarEscolherData();
    ativarEscolherFornecedor();

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Adiciona um novo item na lista de itens.
     */
    function adicionarItem() {
        var $formItem = $('#formItem option:selected');
        var $formQuantidade = $('#formQuantidade');
        var $formTipo = $('#formTipo option:selected');
        var $formUnidade = $('#formUnidade');
        var $formPreco = $('#formPreco');

        var stringHTML = ''
            + '<div class="listaItem">'
            + '<div class="row">'
            + '<var class="idTipo" style="display: none">' + $formTipo.val() + '</var>'
            + '<var class="idItem" style="display: none">' + $formItem.val() + '</var>'
            + '<var class="valorQuantidade" style="display: none">' + $formQuantidade.val() + '</var>'
            + '<var class="valorPreco" style="display: none">' + $formPreco.val() + '</var>'
            + '<div class="col-md-3 tipo" style="margin-top: 5px">'
            + $formTipo.text()
            + '</div>'
            + '<div class="col-md-3 item" style="margin-top: 5px">'
            + $formItem.text()
            + '</div>'
            + '<div class="col-md-2 quantidade" style="margin-top: 5px">'
            + $formQuantidade.val() + ' ' + $formUnidade.html()
            + '</div>'
            + '<div class="col-md-2 preco" style="margin-top: 5px">'
            + 'R$ ' + parseFloat($formPreco.val()).toFixed(2)
            + '</div>'
            + '<div class="col-md-2">'
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
     * Ativa os campos de escolha do periodo de vigência
     * (data inicio e data fim).
     */
    function ativarEscolherData() {
        $('#dataInicio').datepicker({
            format: "dd/mm/yyyy",
            todayBtn: "linked",
            language: "pt-BR",
            autoclose: true,
            todayHighlight: true
        });
        $('#dataFim').datepicker({
            format: "dd/mm/yyyy",
            todayBtn: "linked",
            language: "pt-BR",
            autoclose: true,
            todayHighlight: true
        });
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Ativa o campo de escolha do fornecedor.
     */
    function ativarEscolherFornecedor() {
        $('#formFornecedor').off();
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


    //------------------------------------------------------------------------------------------------------------------

    /**
     * Cria o label unidade, de acordo com o item selecionado.
     */
    function criaUnidade() {
        var idItem = $('#formItem option:selected').val();
        var encontrouItem = false;

        for (var i in itens) {
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
     * Desativa os campos de escolha do periodo de vigência
     * (data inicio e data fim).
     */
    function desativarEscolherData() {
        $('#dataInicio').datepicker('remove');
        $('#dataFim').datepicker('remove');
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * 'Desativa' o campo de escolha do fornecedor.
     */
    function desativarEscolherFornecedor() {
        var valorAntigo;

        $('#formFornecedor').focus(function () {
            valorAntigo = $(this).val();
        }).change(function () {
            $(this).val(valorAntigo);
        });
    }


    //------------------------------------------------------------------------------------------------------------------

    /**
     * Atualiza o campo após finalizar a edição de um item da lista.
     */
    function concluiEditarItem() {
        var $formTipoSelected = $('#formTipo option:selected');
        var $formItemSelected = $('#formItem option:selected');
        var $formQuantidade = $('#formQuantidade');
        var $formUnidade = $('#formUnidade');
        var $formPreco = $('#formPreco');

        $($('.idTipo')[posicaoEditar]).html($formTipoSelected.val());
        $($('.idItem')[posicaoEditar]).html($formItemSelected.val());
        $($('.valorQuantidade')[posicaoEditar]).html($formQuantidade.val());
        $($('.valorPreco')[posicaoEditar]).html($formPreco.val());

        $($('.tipo')[posicaoEditar]).html($formTipoSelected.text());
        $($('.item')[posicaoEditar]).html($formItemSelected.text());
        $($('.quantidade')[posicaoEditar]).html($formQuantidade.val() + ' ' + $formUnidade.html());
        $($('.preco')[posicaoEditar]).html('R$ ' + $formPreco.val());
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Envia o cadastro para a API REST.
     */
    function enviarCadastro() {
        var idFornecedor = $("#formFornecedor option:selected").val();
        var codigo = $("#formCodigo").val();
        var dataInicio = $("#formDataInicio").val();
        var dataFim = $("#formDataFim").val();

        var jsonListaItens = [];

        $('var[class="idTipo"]').each(function (pos, item) {
            if (!jsonListaItens.hasOwnProperty(pos)) {
                jsonListaItens[pos] = {
                    idFornecedor: idFornecedor,
                    codigo: codigo,
                    dataInicio: dataInicio,
                    dataFim: dataFim
                };
            }
            jsonListaItens[pos][$(this).attr('class')] = $(this).html();
        });
        $('var[class="idItem"]').each(function (pos, item) {
            if (!jsonListaItens.hasOwnProperty(pos)) {
                jsonListaItens[pos] = {
                    idFornecedor: idFornecedor,
                    codigo: codigo,
                    dataInicio: dataInicio,
                    dataFim: dataFim
                };
            }
            jsonListaItens[pos][$(this).attr('class')] = $(this).html();
        });
        $('var[class="valorQuantidade"]').each(function (pos, item) {
            if (!jsonListaItens.hasOwnProperty(pos)) {
                jsonListaItens[pos] = {
                    idFornecedor: idFornecedor,
                    codigo: codigo,
                    dataInicio: dataInicio,
                    dataFim: dataFim
                };
            }
            jsonListaItens[pos][$(this).attr('class')] = $(this).html();
        });
        $('var[class="valorPreco"]').each(function (pos, item) {
            if (!jsonListaItens.hasOwnProperty(pos)) {
                jsonListaItens[pos] = {
                    idFornecedor: idFornecedor,
                    codigo: codigo,
                    dataInicio: dataInicio,
                    dataFim: dataFim
                };
            }
            jsonListaItens[pos][$(this).attr('class')] = $(this).html();
        });

        // Contrato novo.
        if (listaCadastradaVazia == true) {
            $.ajax({
                url: urlBase + 'api/painel/configuracoes/cadastrarcontrato/cadastrar',
                type: 'post',
                dataType: 'json',
                data: JSON.stringify(jsonListaItens),
                success: function (data, status) {
                    modalSucesso();
                },
                error: function (xhr, desc, err) {
                    modalErro();
                }
            });
        }
        // Contrato já cadastrado (adicionando itens).
        else {
            $.ajax({
                url: urlBase + 'api/painel/configuracoes/cadastrarcontrato/adicionar',
                type: 'post',
                dataType: 'json',
                data: JSON.stringify(jsonListaItens),
                success: function (data, status) {
                    modalSucesso();
                },
                error: function (xhr, desc, err) {
                    modalErro();
                }
            });
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Limpa ou zera os campos relacionados ao cadastro do contrato.
     */
    function limparCamposContrato() {
        $('#formFornecedor').val(0);
        $('#formCodigo').val('');
        $('#formDataInicio').val('');
        $('#formDataFim').val('');
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Limpa ou zera os campos do adicionar novo item.
     */
    function limparCamposItem() {
        $('#formTipo').val(0);
        $('#formItem').val(0);
        $('#formQuantidade').val('');
        $('#formUnidade').empty();
        $('#formPreco').val('');
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
     * Limpa a lista de itens já cadastrados.
     */
    function limparListaCadastrada() {
        $('#listaCadastrada').empty();
        $('#listaCadastradaColunas').hide();
        $('#alertaCodigoCadastrado').hide();
        listaCadastradaTamanho = 0;
        listaCadastradaVazia = true;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Limpa ou reseta todos os campos da página.
     */
    function limparTudo() {
        limparCamposContrato()
        limparCamposItem();
        limparLista();
        limparListaCadastrada();
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Modal de aviso de mudança do código do contrato
     */
    function modalAvisoCodigo() {
        $('#modalAvisoCodigo').modal('show');
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Modal de aviso de erro de conexão.
     */
    function modalErro() {
        $('#tituloModal').html('Confirmação de Cadastro de Contrato')
        $('#barraProgresso').hide();
        $('#modalErro').modal('show');
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
            + '<h4>Contrato cadastrado com <b>sucesso</b>.</h4>'
            + '</div>'
            + '</div>'
            + '</div>'
            + '<div class="row">'
            + '<div class="col-md-2 col-md-offset-5">'
            + '<button id="botaoOk" class="btn btn-success btn-block">OK</button>'
            + '</div>'
            + '</div>';

        $('#modalRodape').empty();
        $('#modalTitulo').html('Contrato Cadastrado');
        $('#modalCorpo').html(stringHtml);
        $('#botaoOk').click(function () {
            location.reload();
            limparTudo();
        });
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Preenche a lista antiga de dados, caso o código do contrato já exista.
     *
     * @param dados Dados recebidos.
     */
    function preencherListaCadastrada(dados) {
        var $listaCadastrada = $('#listaCadastrada');
        var $listaCadastradaColunas = $('#listaCadastradaColunas');
        var $alertaCodigoCadastrado = $('#alertaCodigoCadastrado');

        $listaCadastradaColunas.show();
        $alertaCodigoCadastrado.show();
        listaCadastradaVazia = false;

        var primeirosDados = false;
        for (var i in dados) {
            if (dados.hasOwnProperty(i)) {
                // Na primeira vez, seleciona os campos (fornecedor, data inicio e data fim) do
                // contrato cadastro.
                if (!primeirosDados) {
                    selecionarCamposCadastrados(dados[i].id_fornecedor, dados[i].data_inicio, dados[i].data_fim);
                    primeirosDados = true;
                }

                var stringHTML = ''
                    + '<div class="listaItemCadastrada">'
                    + '<div class="row">'
                    + '<var class="idTipoCadastrado" style="display: none">' + dados[i].id_tipo + '</var>'
                    + '<var class="idItemCadastrado" style="display: none">' + dados[i].id_item + '</var>'
                    + '<var class="valorQuantidadeCadastrado" style="display: none">' + dados[i].quantidade + '</var>'
                    + '<var class="valorPrecoCadastrado" style="display: none">' + dados[i].valor + '</var>'
                    + '<div class="col-md-4 tipoCadastrado" style="margin-top: 5px">'
                    + dados[i].nome_tipo
                    + '</div>'
                    + '<div class="col-md-3 itemCadastrado" style="margin-top: 5px">'
                    + dados[i].nome_item
                    + '</div>'
                    + '<div class="col-md-3 quantidadeCadastrado" style="margin-top: 5px">'
                    + dados[i].quantidade + ' ' + unidades[dados[i].unidade_padrao_id]['nome']
                    + '</div>'
                    + '<div class="col-md-2 precoCadastrado" style="margin-top: 5px">'
                    + 'R$ ' + parseFloat(dados[i].valor).toFixed(2)
                    + '</div>'
                    + '</div>'
                    + '<hr/>'
                    + '</div>';

                listaCadastradaTamanho++;
                $listaCadastrada.append(stringHTML);
            }
        }

        recarregaValorTotal();
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
        var $classPreco = $('.preco');

        $("#confFormFornecedor").text($("#formFornecedor option:selected").text());
        $("#confFormCodigo").text($("#formCodigo").val());
        $("#confFormDataInicio").text($("#formDataInicio").val());
        $("#confFormDataFim").text($("#formDataFim").val());
        $("#confValorTotal").text($("#valorTotal").text());

        $('.listaItem').each(function (posicao, listaItem) {
            string += ''
            + '<div class="row">'
            + '<div class="col-md-3" style="padding-right: 0;">'
            + '<h5>' + $($classTipo[posicao]).html() + '</h5>'
            + '</div>'
            + '<div class="col-md-3" style="padding-right: 0; padding-left: 4px;">'
            + '<h5>' + $($classItem[posicao]).html() + '</h5>'
            + '</div>'
            + '<div class="col-md-3" style="padding-right: 0; padding-left: 4px;">'
            + '<h5>' + $($classQuantidade[posicao]).html() + '</h5>'
            + '</div>'
            + '<div class="col-md-3" style="padding-right: 0; padding-left: 4px;">'
            + '<h5>' + $($classPreco[posicao]).html() + '</h5>'
            + '</div>'
            + '</div>';
        });

        $('#confListaItem').html(string);
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Preenche o modal com os dados já cadastrados.
     */
    function preencherModalCadastrado() {
        var string = '';
        var $classTipoCadastrado = $('.tipoCadastrado');
        var $classItemCadastrado = $('.itemCadastrado');
        var $classQuantidadeCadastrado = $('.quantidadeCadastrado');
        var $classPrecoCadastrado = $('.precoCadastrado');

        var $listaItemCadastrada = $('.listaItemCadastrada');
        var $confListaCadastrada = $('#confListaCadastrada');
        var $confListaCadastradaColunas = $('#confListaCadastradaColunas');

        $confListaCadastradaColunas.show();

        $listaItemCadastrada.each(function (posicao, listaItemCadastrado) {
            string += ''
            + '<div class="row">'
            + '<div class="col-md-3" style="padding-right: 0;">'
            + '<h5>' + $($classTipoCadastrado[posicao]).html() + '</h5>'
            + '</div>'
            + '<div class="col-md-3" style="padding-right: 0; padding-left: 4px;">'
            + '<h5>' + $($classItemCadastrado[posicao]).html() + '</h5>'
            + '</div>'
            + '<div class="col-md-3" style="padding-right: 0; padding-left: 4px;">'
            + '<h5>' + $($classQuantidadeCadastrado[posicao]).html() + '</h5>'
            + '</div>'
            + '<div class="col-md-3" style="padding-right: 0; padding-left: 4px;">'
            + '<h5>' + $($classPrecoCadastrado[posicao]).html() + '</h5>'
            + '</div>'
            + '</div>';
        });

        $confListaCadastrada.html(string);
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
                var $valorQuantidade = $($('.valorQuantidade')[posicao]);
                var $valorPreco = $($('.valorPreco')[posicao]);

                posicaoEditar = posicao;
                editando = true;

                $('#formTipo').val($idTipo.html());
                criaOpcaoItens($idTipo.html());
                $('#formItem').val($idItem.html());
                $('#formQuantidade').val($valorQuantidade.html());
                criaUnidade();
                $('#formPreco').val($valorPreco.html());

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
     * Recarrega ou recalcula o valor total do contrato.
     */
    function recarregaValorTotal() {
        var total = 0;

        // Lista de itens a cadastrar.
        var $valorPreco = $('var[class="valorPreco"]');
        var $valorQuantidade = $('var[class="valorQuantidade"]');
        $('.listaItem').each(function (posicao, listaItem) {
            total += (parseFloat($($valorPreco[posicao]).html()) * parseInt($($valorQuantidade[posicao]).html()));
        });

        // Lista de itens já cadastrado.
        var $valorPrecoCadastrado = $('var[class="valorPrecoCadastrado"]');
        var $valorQuantidadeCadastrado = $('var[class="valorQuantidadeCadastrado"]');
        $('.listaItemCadastrada').each(function (posicao, listaItemCadastrado) {
            total += (parseFloat($($valorPrecoCadastrado[posicao]).html()) * parseInt($($valorQuantidadeCadastrado[posicao]).html()));
        });

        $('#valorTotal').html('R$ ' + parseFloat(total).toFixed(2));
    }


    //------------------------------------------------------------------------------------------------------------------

    /**
     * Recarrega tudo (botões de edição, botões de remoção e valor total do contrato).
     */
    function recarregaTudo() {
        recarregaEditarItem();
        recarregaRemoverItem();
        recarregaValorTotal();
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Seleciona nos campos os dados já cadastrados
     *
     * @param id_fornecedor Id do fornecedor.
     * @param data_inicio Data de inicio do contrato.
     * @param data_fim Data de fim do contrato.
     */
    function selecionarCamposCadastrados(id_fornecedor, data_inicio, data_fim) {
        $('#formFornecedor').val(id_fornecedor)
        $('#formDataInicio').val(data_inicio);
        $('#formDataFim').val(data_fim);
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
        var $formQuantidade = $('#formQuantidade');
        var $formPreco = $('#formPreco');

        // Trocar vírgula por ponto no valor ou preço do item.
        if (contarLetra($formPreco.val(), ',') == 1) {
            var valor = $formPreco.val();
            $formPreco.val(valor.replace(/,/g, '.'));
        }
        $formPreco.val(parseFloat($formPreco.val()).toFixed(2));

        if ($formTipoSelected.val() <= 0) {
            erro = true;
            notificacao_alerta('Selecine um <b>Tipo</b>.');
        }
        else if ($formItemSelected.val() <= 0) {
            erro = true;
            notificacao_alerta('Selecine um <b>Item</b.');
        }
        else if ($formQuantidade.val().indexOf('.') > 0 || $formQuantidade.val().indexOf(',') > 0) {
            erro = true;
            notificacao_alerta('Insira apenas valores inteiros em <b>Quantidade</b>.');
        }
        else if (!$.isNumeric($formQuantidade.val())) {
            erro = true;
            notificacao_alerta('Insira um número em <b>Quantidade</b>.');
        }
        else if ($formQuantidade.val() <= 0) {
            erro = true;
            notificacao_alerta('Insira um valor maior que 0 (zero) em <b>Quantidade</b>.');
        }
        else if (!$.isNumeric($formPreco.val())) {
            erro = true;
            notificacao_alerta('Insira um número em <b>Valor</b>.');
        }
        else if ($formPreco.val() <= 0) {
            erro = true;
            notificacao_alerta('Insira um valor maior que 0 (zero) em <b>Valor</b>.');
        }
        else {
            // Verificando se há não há itens repetidos.
            $('var[class="idItem"]').each(function (position, idItem) {
                if ($(idItem).html() == $formItemSelected.val() && editando == false) {
                    erro = true;
                    notificacao_alerta('<b>Itens iguais</b> estão sendo cadastrados. Junte suas quantidades.');
                }
            });

            if (listaCadastradaVazia == false) {
                $('var[class="idItemCadastrado"]').each(function (position, idItemCadastrado) {
                    if ($(idItemCadastrado).html() == $formItemSelected.val() && editando == false) {
                        erro = true;
                        notificacao_alerta('Este <b>Item</b> já foi cadastrado para esse contrato.</b>');
                    }
                });
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

        // Verifica se um fornecedor foi selecionado.
        if ($("#formFornecedor option:selected").val() <= 0) {
            erro = true;
            notificacao_alerta('Selecione um <b>Fornecedor</b>.');
        }
        // Verifica se um codigo foi digitado.
        else if ($.trim($("#formCodigo").val()) == "") {
            erro = true;
            notificacao_alerta('Insira um <b>Código</b>.');
        }
        // Verifica se a data inicio foi selecionada.
        else if ($.trim($("#formDataInicio").val()) == "") {
            erro = true;
            notificacao_alerta('Insira uma <b>Data Saída</b>.');
        }
        // Verifica se a data inicio foi selecionada.
        else if ($.trim($("#formDataFim").val()) == "") {
            erro = true;
            notificacao_alerta('Insira uma <b>Data Fim</b>.');
        }
        // Verifica se a data inicio e menos que a data fim.
        else if (pegaData($("#formDataInicio").val()) >= pegaData($("#formDataFim").val())) {
            erro = true;
            notificacao_alerta('A <b>Data Início</b> não pode ser maior ou igual que a <b>Data Fim</b>.');
        }
        // Verifica se há algum item na lista.
        else if (listaTamanho <= 0) {
            erro = true;
            notificacao_alerta('<b>Lista de Itens</b> está vazia.');
        }
        // Verifica se há algum contrato cadastrado com o código.
        else {
            if (listaCadastradaVazia == true) {
                var $formCodigo = $('#formCodigo');
                for (var i in contratos) {
                    if (contratos.hasOwnProperty(i) && $formCodigo.val() == contratos[i]['codigo']) {
                        erro = true;
                        notificacao_alerta('Já existe um <b>contrato</b> com o mesmo código inserido.');
                        break;
                    }
                }
            }
        }

        return erro;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Verifica se um código do contrato já existe.
     *
     * @param codigoContrato Codigo do Contrato.
     */
    function verificaCodigoContrato() {
        var $formCodigo = $('#formCodigo');

        if ($.trim($formCodigo.val()) != '') {
            $.ajax({
                url: urlBase + 'api/painel/configuracoes/cadastrarcontrato/lerdadoscontrato',
                type: 'get',
                dataType: 'json',
                data: 'formCodigo=' + $formCodigo.val(),
                success: function (data, status) {
                    // Encontrou um contrato
                    if (data.sucesso == true) {
                        limparListaCadastrada();
                        desativarEscolherData();
                        desativarEscolherFornecedor();
                        preencherListaCadastrada(data.resposta);
                        recarregaValorTotal();
                    } else {
                        limparListaCadastrada();
                        ativarEscolherData();
                        ativarEscolherFornecedor();
                        recarregaValorTotal();
                    }
                },
                error: function (xhr, desc, err) {
                    // TODO Fazer deteção de erro.
                }
            });
        }
    }
});

/* Fim do arquivo: inserir-saida.js */
/* Localização: ./js/painel/saida/inserir-saida.js */
