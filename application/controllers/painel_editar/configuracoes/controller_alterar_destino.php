<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller que manipula o menu 'Alterar Destino'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
class Controller_Alterar_Destino extends CI_Controller
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
        $this->load->model('painel_editar/configuracoes/model_alterar_destino', 'model_alterar_destino');
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página para alterar o cadastro de um destino.
     *
     * url - {root}/paineleditar/configuracoes/alterardestino/alterar/*
     */
    public function alterar()
    {
        // Lendo o usuário.
        $id_destino = $this->uri->segment(5);

        $this->form_validation->set_rules('formDescricao', 'DESCRIÇÃO', 'xss_clean');
        $this->form_validation->set_rules('formDestino', 'DESTINO', 'xss_clean|required');

        // Inicializando variáveis.
        $dados['sucesso'] = FALSE;
        $dados['erro'] = FALSE;
        $dados['erro_mensagem'] = "";

        if ($this->form_validation->run()) {
            $form_descricao = $this->input->post('formDescricao', TRUE);
            $form_destino = $this->input->post('formDestino', TRUE);

            $resultado = $this->model_alterar_destino->atualizar_destino($id_destino, $form_destino, $form_descricao);
            if ($resultado) {
                $dados['sucesso'] = TRUE;
            } else {
                $dados['erro'] = TRUE;
                $dados['erro_mensagem'] = 'Houve um erro no momento da atualização dos dados do <b>Destino</b> no banco de dados.<br/>'
                    . 'Por favor, tente novamente';
            }
        } else {
            $dados['erro'] = TRUE;
            $dados['erro_mensagem'] = validation_errors();
        }

        $dados['nome_usuario'] = $this->nome_usuario;
        $dados['url'] = $this->uri->uri_string();
        $resultado = $this->model_alterar_destino->ler_destino($id_destino);
        if($resultado) {
            $dados['destino'] = $resultado;
            $this->load->view('painel_editar/configuracoes/alterar_destino/view_alterar.php', $dados);
        } else {
            $this->load->view('painel_editar/configuracoes/alterar_destino/view_inexistente.php', $dados);
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página de confirmação de exclusão.
     *
     * url - {root}/paineleditar/configuracoes/alterardestino/confirmarexcluir/*
     */
    public function confirmarexcluir()
    {
        $id_destino = $this->uri->segment(5);

        $dados['nome_usuario'] = $this->nome_usuario;
        $resultado = $this->model_alterar_destino->ler_destino($id_destino);
        if($resultado) {
            $dados['destino'] = $resultado;
            $this->load->view('painel_editar/configuracoes/alterar_destino/view_confirmar_excluir.php', $dados);
        } else {
            $this->load->view('painel_editar/configuracoes/alterar_destino/view_inexistente.php', $dados);
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página para excluir um destino.
     *
     * url - {root}/paineleditar/configuracoes/alterardestino/excluir/*
     */
    public function excluir()
    {
        $id_destino = $this->uri->segment(5);

        // Inicializando variáveis.
        $dados['sucesso'] = FALSE;
        $dados['erro'] = FALSE;
        $dados['erro_mensagem'] = "";

        if ($this->model_alterar_destino->checar_destino($id_destino)) {
            $resultado = $this->model_alterar_destino->excluir_destino($id_destino);
            if ($resultado) {
                $dados['sucesso'] = TRUE;
            } else {
                $dados['erro'] = TRUE;
                $dados['erro_mensagem'] = "O destino escolhido não pode ser deletado pois há dependências.";
            }
        } else {
            $dados['erro'] = TRUE;
            $dados['erro_mensagem'] = "O destino escolhido não existe.";
        }

        $dados['nome_usuario'] = $this->nome_usuario;
        $this->load->view('painel_editar/configuracoes/alterar_destino/view_excluir.php', $dados);
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página que lista todos os destinos cadastrados.
     *
     * url - {root}/paineleditar/configuracoes/alterardestino/lista
     */
    public function lista()
    {
        $this->load->helper('text');

        $dados['destinos'] = $this->model_alterar_destino->ler_destinos();
        $dados['nome_usuario'] = $this->nome_usuario;
        $this->load->view('painel_editar/configuracoes/alterar_destino/view_lista.php', $dados);
    }
}

/* Fim do arquivo controller_alterar_destino.php */
/* Localização: ./application/controllers/painel_editar/configuracoes/controller_alterar_destino.php */
