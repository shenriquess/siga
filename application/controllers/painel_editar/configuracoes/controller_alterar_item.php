<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller que manipula o menu 'Alterar Item'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
class Controller_Alterar_Item extends CI_Controller
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
     * Verifica se o usuário(Admin está logado no sistema.
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

        // Carregando model.
        $this->load->model('painel_editar/configuracoes/model_alterar_item', 'model_alterar_item');
        $this->load->library('unidades');
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página para alterar o cadastro de um item.
     *
     * url - {root}/paineleditar/configuracoes/alteraritem/alterar/*
     */
    public function alterar()
    {
        // Lendo o usuário.
        $id_item = $this->uri->segment(5);

        $this->form_validation->set_rules('formDescricao', 'DESCRIÇÃO', 'xss_clean');
        $this->form_validation->set_rules('formItem', 'ITEM', 'required|xss_clean|required');
        $this->form_validation->set_rules('formTipo', 'TIPO', 'required|xss_clean|required');
        $this->form_validation->set_rules('formUnidade', 'UNIDADE', 'required|xss_clean|required');

        // Inicializando variáveis.
        $dados['sucesso'] = FALSE;
        $dados['erro'] = FALSE;
        $dados['erro_mensagem'] = "";

        if ($this->form_validation->run()) {
            $form_descricao = $this->input->post('formDescricao', TRUE);
            $form_item = $this->input->post('formItem', TRUE);
            $form_tipo = $this->input->post('formTipo', TRUE);
            $form_unidade = $this->input->post('formUnidade', TRUE);

            $resultado = $this->model_alterar_item->atualizar_item($id_item, $form_tipo, $form_item, $form_descricao, $form_unidade);
            if ($resultado) {
                $dados['sucesso'] = TRUE;
            } else {
                $dados['erro'] = TRUE;
                $dados['erro_mensagem'] = 'Houve um erro no momento da atualização dos dados do <b>Item</b> no banco de dados.<br/>'
                    . 'Por favor, tente novamente';
            }
        } else {
            $dados['erro'] = TRUE;
            $dados['erro_mensagem'] = validation_errors();
        }

        $dados['nome_usuario'] = $this->nome_usuario;
        $dados['url'] = $this->uri->uri_string();
        $dados['unidades_padrao'] = $this->unidades->ler_unidades_padrao();
        $dados['tipos'] = $this->model_alterar_item->ler_tipos();
        $resultado = $this->model_alterar_item->ler_item($id_item);
        if ($resultado) {
            $dados['item'] = $resultado;
            $this->load->view('painel_editar/configuracoes/alterar_item/view_alterar.php', $dados);
        } else {
            $this->load->view('painel_editar/configuracoes/alterar_item/view_inexistente.php', $dados);
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página de confirmação de exclusão.
     *
     * url - {root}/paineleditar/configuracoes/alteraritem/confirmarexcluir/*
     */
    public function confirmarexcluir()
    {
        $id_item = $this->uri->segment(5);

        $dados['unidades_padrao'] = $this->unidades->ler_unidades_padrao();
        $dados['nome_usuario'] = $this->nome_usuario;
        $resultado = $this->model_alterar_item->ler_item($id_item);
        if ($resultado) {
            $dados['item'] = $resultado;
            $this->load->view('painel_editar/configuracoes/alterar_item/view_confirmar_excluir.php', $dados);
        } else {
            $this->load->view('painel_editar/configuracoes/alterar_item/view_inexistente.php', $dados);
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página para excluir um item.
     *
     * url - {root}/paineleditar/configuracoes/alteraritem/excluir/*
     */
    public function excluir()
    {
        $id_item = $this->uri->segment(5);

        // Inicializando variáveis.
        $dados['sucesso'] = FALSE;
        $dados['erro'] = FALSE;
        $dados['erro_mensagem'] = "";

        if ($this->model_alterar_item->checar_item($id_item)) {
            $resultado = $this->model_alterar_item->excluir_item($id_item);
            if ($resultado) {
                $dados['sucesso'] = TRUE;
            } else {
                $dados['erro'] = TRUE;
                $dados['erro_mensagem'] = "O item escolhido não pode ser deletado pois há dependências.";
            }
        } else {
            $dados['erro'] = TRUE;
            $dados['erro_mensagem'] = "O item escolhido não existe.";
        }

        $dados['nome_usuario'] = $this->nome_usuario;
        $this->load->view('painel_editar/configuracoes/alterar_item/view_excluir.php', $dados);
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página que lista todos os itens cadastrados.
     *
     * url - {root}/paineleditar/configuracoes/alteraritem/lista
     */
    public function lista()
    {
        $this->load->helper('text');

        $dados['itens'] = $this->model_alterar_item->ler_itens();
        $dados['nome_usuario'] = $this->nome_usuario;
        $this->load->view('painel_editar/configuracoes/alterar_item/view_lista.php', $dados);
    }
}

/* Fim do arquivo controller_alterar_item.php */
/* Localização: ./application/controllers/painel_editar/configuracoes/controller_alterar_item.php */
