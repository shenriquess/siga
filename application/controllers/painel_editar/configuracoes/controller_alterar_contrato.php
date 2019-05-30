<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller que manipula o menu 'Alterar Contrato'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
class Controller_Alterar_Contrato extends CI_Controller
{
    /**
     * Nome de usuário(username) do usuário.
     *
     * @var string
     */
    private $nome_usuario;

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Construtor padrão.
     *
     * Verifica se o usuário (Admin está logado no sistema).
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->library('autenticacao');
        $this->autenticacao->autentica();

        // Verificando permissão para o usuário.
        if (!$this->autenticacao->verificar_permissao(array(0))) {
            redirect(base_url('/painel/home'));
        }
        $this->nome_usuario = $this->autenticacao->get_nome_usuario();

        // Carregando módulos.
        $this->load->helper('data');
        $this->load->library('unidades');
        $this->load->model('painel_editar/configuracoes/model_alterar_contrato', 'model_alterar_contrato');
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Redireciona para a função correta. Alterar_contrato ou alterar_item_contrato.
     *
     * url - {root}/paineleditar/configuracoes/alterardestino/alterar/contrato
     * url - {root}/paineleditar/configuracoes/alterardestino/alterar/itemcontrato
     */
    public function alterar()
    {
        if ($this->uri->segment(5) == 'contrato') {
            $this->alterar_contrato();
        } else if ($this->uri->segment(5) == 'itemcontrato') {
            $this->alterar_item_contrato();
        } else {
            $this->alterar_contrato();
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página que altera os dados de um contrato.
     *
     * url - {root}/paineleditar/configuracoes/alterardestino/alterar/contrato
     */
    private function alterar_contrato()
    {
        // Lendo o usuário.
        $id_contrato = $this->uri->segment(6);

        $this->form_validation->set_rules('formCodigo', 'CÓDIGO', 'xss_clean|required');
        $this->form_validation->set_rules('formDataInicio', 'DATA INÍCIO', 'xss_clean|required');
        $this->form_validation->set_rules('formDataFim', 'DATA FIM', 'xss_clean|required');
        $this->form_validation->set_rules('formFornecedor', 'FORNECEDOR', 'xss_clean|required');

        // Inicializando variáveis.
        $dados['sucesso'] = FALSE;
        $dados['erro'] = FALSE;
        $dados['erro_mensagem'] = "";

        if ($this->form_validation->run()) {
            $form_codigo = $this->input->post('formCodigo', TRUE);
            $form_data_inicio = $this->input->post('formDataInicio', TRUE);
            $form_data_fim = $this->input->post('formDataFim', TRUE);
            $form_fornecedor = $this->input->post('formFornecedor', TRUE);

            $data_inicio_mysql = data_normal_para_MySQL($form_data_inicio);
            $data_fim_mysql = data_normal_para_MySQL($form_data_fim);

            $resultado = $this->model_alterar_contrato->atualizar_contrato($id_contrato, $form_codigo, $data_inicio_mysql, $data_fim_mysql, $form_fornecedor);
            if ($resultado) {
                $dados['sucesso'] = TRUE;
            } else {
                $dados['erro'] = TRUE;
                $dados['erro_mensagem'] = 'Houve um erro no momento da atualização dos dados do <b>Contrato</b> no banco de dados.<br/>'
                    . 'Por favor, tente novamente';
            }
        } else {
            $dados['erro'] = TRUE;
            $dados['erro_mensagem'] = validation_errors();
        }

        $dados['nome_usuario'] = $this->nome_usuario;
        $dados['url'] = $this->uri->uri_string();
        $resultado = $this->model_alterar_contrato->ler_contrato($id_contrato);
        if ($resultado) {
            $dados['contrato'] = $resultado;
            $dados['fornecedores'] = $this->model_alterar_contrato->ler_fornecedores();
            $dados['itens_contrato'] = $this->model_alterar_contrato->ler_itens_contrato($id_contrato);
            $dados['unidades'] = $this->unidades->ler_unidades_padrao();
            $this->load->view('painel_editar/configuracoes/alterar_contrato/view_alterar_contrato.php', $dados);
        } else {
            $this->load->view('painel_editar/configuracoes/alterar_contrato/view_inexistente_contrato.php', $dados);
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página que altera os dados de um item do contrato.
     *
     * url - {root}/paineleditar/configuracoes/alterardestino/alterar/itemcontrato
     */
    private function alterar_item_contrato()
    {
        // Lendo o usuário.
        $id_item_contrato = $this->uri->segment(6);

        $this->form_validation->set_rules('formItem', 'ITEM', 'xss_clean|required');
        $this->form_validation->set_rules('formQuantidade', 'QUANTIDADE', 'xss_clean|required');
        $this->form_validation->set_rules('formValor', 'VALOR', 'xss_clean|required');

        // Inicializando variáveis.
        $dados['sucesso'] = FALSE;
        $dados['erro'] = FALSE;
        $dados['erro_mensagem'] = "";

        if ($this->form_validation->run()) {
            $form_item = $this->input->post('formItem', TRUE);
            $form_quantidade = $this->input->post('formQuantidade', TRUE);
            $form_valor = $this->input->post('formValor', TRUE);

            $quantidade_entrada = $this->model_alterar_contrato->ler_quantidade_entrada_item($id_item_contrato);
            if ($form_quantidade >= $quantidade_entrada) {
                $resultado = $this->model_alterar_contrato->atualizar_item_contrato($id_item_contrato, $form_item, $form_quantidade, $form_valor);
                if ($resultado) {
                    $dados['sucesso'] = TRUE;
                } else {
                    $dados['erro'] = TRUE;
                    $dados['erro_mensagem'] = 'Houve um erro no momento da atualização dos dados do <b>Item do Contrato</b> no banco de dados.<br/>'
                        . 'Por favor, tente novamente';
                }
            } else {
                $item_contrato = $this->model_alterar_contrato->ler_item_contrato($id_item_contrato);
                $dados['erro'] = TRUE;
                $dados['erro_mensagem'] = 'Há <b>' . $quantidade_entrada . ' ' . $this->unidades->ler_unidade_padrao($item_contrato['unidade_padrao_id'])['nome'] . '</b> de <b>'.$item_contrato['nome_item'].'</b> cadastradas na entrada.'
                    . '<br/>Por favor, insira uma quantidade maior ou igual que a quantidade de itens cadastrados na entrada.';
            }
        } else {
            $dados['erro'] = TRUE;
            $dados['erro_mensagem'] = validation_errors();
        }

        $dados['nome_usuario'] = $this->nome_usuario;
        $dados['url'] = $this->uri->uri_string();
        $resultado = $this->model_alterar_contrato->ler_item_contrato($id_item_contrato);
        if ($resultado) {
            $dados['item_contrato'] = $resultado;
            $dados['itens'] = $this->model_alterar_contrato->ler_itens();
            $dados['tipos'] = $this->model_alterar_contrato->ler_tipos();
            $dados['unidades'] = $this->unidades->ler_unidades_padrao();
            $this->load->view('painel_editar/configuracoes/alterar_contrato/view_alterar_item_contrato.php', $dados);
        } else {
            $this->load->view('painel_editar/configuracoes/alterar_contrato/view_inexistente_item_contrato.php', $dados);
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página de confirmação de exclusão.
     *
     * url - {root}/paineleditar/configuracoes/alterarcontrato/confirmarexcluir/contrato/*
     * url - {root}/paineleditar/configuracoes/alterarcontrato/confirmarexcluir/itemcontrato/*
     */
    public function confirmarexcluir()
    {
        if ($this->uri->segment(5) == 'contrato') {
            $this->confirmarexcluir_contrato();
        } else if ($this->uri->segment(5) == 'itemcontrato') {
            $this->confirmarexcluir_item_contrato();
        } else {
            $this->confirmarexcluir_contrato();
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    private function confirmarexcluir_contrato()
    {
        $id_contrato = $this->uri->segment(6);

        $dados['nome_usuario'] = $this->nome_usuario;
        $resultado = $this->model_alterar_contrato->ler_contrato($id_contrato);
        if ($resultado) {
            $dados['contrato'] = $resultado;
            $this->load->view('painel_editar/configuracoes/alterar_contrato/view_confirmar_excluir_contrato.php', $dados);
        } else {
            $this->load->view('painel_editar/configuracoes/alterar_contrato/view_inexistente_contrato.php', $dados);
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    private function confirmarexcluir_item_contrato()
    {
        $id_item_contrato = $this->uri->segment(6);

        $dados['nome_usuario'] = $this->nome_usuario;
        $resultado = $this->model_alterar_contrato->ler_item_contrato($id_item_contrato);
        if ($resultado) {
            $dados['item_contrato'] = $resultado;
            $dados['unidades'] = $this->unidades->ler_unidades_padrao();
            $this->load->view('painel_editar/configuracoes/alterar_contrato/view_confirmar_excluir_item_contrato.php', $dados);
        } else {
            $this->load->view('painel_editar/configuracoes/alterar_contrato/view_inexistente_item_contrato.php', $dados);
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Redireciona  para a página de excluir um contrato ou excluir um item do contrato.
     *
     * url - {root}/paineleditar/configuracoes/alterarcontrato/excluir/contrato/*
     * url - {root}/paineleditar/configuracoes/alterarcontrato/excluir/itemcontrato/*
     */
    public function excluir()
    {
        if ($this->uri->segment(5) == 'contrato') {
            $this->excluir_contrato();
        } else if ($this->uri->segment(5) == 'itemcontrato') {
            $this->excluir_item_contrato();
        } else {
            $this->excluir_contrato();
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página para excluir um contato.
     *
     * url - {root}/paineleditar/configuracoes/alterarcontrato/excluir/contrato/*
     */
    private function excluir_contrato()
    {

        $id_contrato = $this->uri->segment(6);


        // Inicializando variáveis.
        $dados['sucesso'] = FALSE;
        $dados['erro'] = FALSE;
        $dados['erro_mensagem'] = "";


        if ($this->model_alterar_contrato->checar_contrato($id_contrato)) {
            $dados['item_contrato'] = $this->model_alterar_contrato->ler_contrato($id_contrato);
            $resultado = $this->model_alterar_contrato->excluir_contrato($id_contrato);
            if ($resultado) {
                $dados['sucesso'] = TRUE;

            } else {
                $dados['erro'] = TRUE;
                $dados['erro_mensagem'] = "O contrato escolhido não pode ser deletado pois há dependências.";
            }
        } else {
            $dados['erro'] = TRUE;
            $dados['erro_mensagem'] = "O contrato escolhido não existe.";
        }
        $dados['nome_usuario'] = $this->nome_usuario;
        $this->load->view('painel_editar/configuracoes/alterar_contrato/view_excluir_contrato.php', $dados);
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página para excluir um item do contrato.
     *
     * url - {root}/paineleditar/configuracoes/alterarcontrato/excluir/itemcontrato/*
     */
    private function excluir_item_contrato()
    {
        $id_item_contrato = $this->uri->segment(6);

        // Inicializando variáveis.
        $dados['sucesso'] = FALSE;
        $dados['erro'] = FALSE;
        $dados['erro_mensagem'] = "";

        if ($this->model_alterar_contrato->checar_item_contrato($id_item_contrato)) {
            $dados['item_contrato'] = $this->model_alterar_contrato->ler_item_contrato($id_item_contrato);
            $resultado = $this->model_alterar_contrato->excluir_item_contrato($id_item_contrato);
            if ($resultado) {
                $dados['sucesso'] = TRUE;
            } else {
                $dados['erro'] = TRUE;
                $dados['erro_mensagem'] = "O item do contrato escolhido não pode ser deletado pois há dependências.";
            }
        } else {
            $dados['erro'] = TRUE;
            $dados['erro_mensagem'] = "O item do contrato escolhido não existe.";
        }
        $dados['nome_usuario'] = $this->nome_usuario;
        $this->load->view('painel_editar/configuracoes/alterar_contrato/view_excluir_item_contrato.php', $dados);
    }


    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página que lista todos os contratos cadastrados.
     *
     * url - {root}/paineleditar/configuracoes/alterarcontrato/lista
     */
    public function lista()
    {
        $this->load->helper('text');

        $dados['contratos'] = $this->model_alterar_contrato->ler_contratos();
        $dados['nome_usuario'] = $this->nome_usuario;
        $this->load->view('painel_editar/configuracoes/alterar_contrato/view_lista.php', $dados);
    }
}

/* Fim do arquivo controller_alterar_contrato.php */
/* Localização: ./application/controllers/painel_editar/configuracoes/controller_alterar_contrato.php */
