<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller que manipula o menu 'Alterar Tipo'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
class Controller_Alterar_Tipo extends CI_Controller
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
        $this->load->model('painel_editar/configuracoes/model_alterar_tipo', 'model_alterar_tipo');
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página para alterar o cadastro de um tipo.
     *
     * url - {root}/paineleditar/configuracoes/alterartipo/alterar/*
     */
    public function alterar()
    {
        // Lendo o usuário.
        $id_tipo = $this->uri->segment(5);

        $this->form_validation->set_rules('formTipo', 'TIPO', 'required|xss_clean|required');
        $this->form_validation->set_rules('formDescricao', 'DESCRIÇÃO', 'xss_clean');

        // Inicializando variáveis.
        $dados['sucesso'] = FALSE;
        $dados['erro'] = FALSE;
        $dados['erro_mensagem'] = "";

        if ($this->form_validation->run()) {
            $form_tipo = $this->input->post('formTipo', TRUE);
            $form_descricao = $this->input->post('formDescricao', TRUE);

            $resultado = $this->model_alterar_tipo->atualizar_tipo($id_tipo, $form_tipo, $form_descricao);
            if ($resultado) {
                $dados['sucesso'] = TRUE;
            } else {
                $dados['erro'] = TRUE;
                $dados['erro_mensagem'] = 'Houve um erro no momento da atualização dos dados do <b>Tipo</b> no banco de dados.<br/>'
                    . 'Por favor, tente novamente';
            }
        } else {
            $dados['erro'] = TRUE;
            $dados['erro_mensagem'] = validation_errors();
        }

        $dados['nome_usuario'] = $this->nome_usuario;
        $dados['url'] = $this->uri->uri_string();
        $resultado = $this->model_alterar_tipo->ler_tipo($id_tipo);
        if ($resultado) {
            $dados['tipo'] = $resultado;
            $this->load->view('painel_editar/configuracoes/alterar_tipo/view_alterar.php', $dados);
        } else {
            $this->load->view('painel_editar/configuracoes/alterar_tipo/view_inexistente.php', $dados);
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página de confirmação de exclusão.
     *
     * url - {root}/paineleditar/configuracoes/alterartipo/confirmarexcluir/*
     */
    public function confirmarexcluir()
    {
        $id_tipo = $this->uri->segment(5);

        $dados['nome_usuario'] = $this->nome_usuario;
        $resultado = $this->model_alterar_tipo->ler_tipo($id_tipo);
        if ($resultado) {
            $dados['tipo'] = $resultado;
            $this->load->view('painel_editar/configuracoes/alterar_tipo/view_confirmar_excluir.php', $dados);
        } else {
            $this->load->view('painel_editar/configuracoes/alterar_tipo/view_inexistente.php', $dados);
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página para excluir um tipo.
     *
     * url - {root}/paineleditar/configuracoes/alterartipo/excluir/*
     */
    public function excluir()
    {
        $id_tipo = $this->uri->segment(5);

        // Inicializando variáveis.
        $dados['sucesso'] = FALSE;
        $dados['erro'] = FALSE;
        $dados['erro_mensagem'] = "";

        if ($this->model_alterar_tipo->checar_tipo($id_tipo)) {
            $resultado = $this->model_alterar_tipo->excluir_tipo($id_tipo);
            if ($resultado) {
                $dados['sucesso'] = TRUE;
            } else {
                $dados['erro'] = TRUE;
                $dados['erro_mensagem'] = "O tipo escolhido não pode ser deletado pois há dependências.";
            }
        } else {
            $dados['erro'] = TRUE;
            $dados['erro_mensagem'] = "O tipo escolhido não existe.";
        }

        $dados['nome_usuario'] = $this->nome_usuario;
        $this->load->view('painel_editar/configuracoes/alterar_tipo/view_excluir.php', $dados);
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página que lista todos os tipos cadastrados.
     *
     * url - {root}/paineleditar/configuracoes/alterartipo/lista
     */
    public function lista()
    {
        $this->load->helper('text');

        $dados['tipos'] = $this->model_alterar_tipo->ler_tipos();
        $dados['nome_usuario'] = $this->nome_usuario;
        $this->load->view('painel_editar/configuracoes/alterar_tipo/view_lista.php', $dados);
    }
}

/* Fim do arquivo controller_alterar_tipo.php */
/* Localização: ./application/controllers/painel_editar/configuracoes/controller_alterar_tipo.php */
