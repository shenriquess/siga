<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller que manipula o menu 'Alterar Fornecedor'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
class Controller_Alterar_Fornecedor extends CI_Controller
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
        $this->load->model('painel_editar/configuracoes/model_alterar_fornecedor', 'model_alterar_fornecedor');
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página para alterar o cadastro de um fornecedor.
     *
     * url - {root}/paineleditar/configuracoes/alterarfornecedor/alterar/*
     */
    public function alterar()
    {
        // Lendo o usuário.
        $id_fornecedor = $this->uri->segment(5);

        $this->form_validation->set_rules('formFornecedor', 'FORNECEDOR', 'required|xss_clean|required');
        $this->form_validation->set_rules('formDescricao', 'DESCRIÇÃO', 'xss_clean');

        // Inicializando variáveis.
        $dados['sucesso'] = FALSE;
        $dados['erro'] = FALSE;
        $dados['erro_mensagem'] = "";

        if ($this->form_validation->run()) {
            $form_fornecedor = $this->input->post('formFornecedor', TRUE);
            $form_descricao = $this->input->post('formDescricao', TRUE);

            $resultado = $this->model_alterar_fornecedor->atualizar_fornecedor($id_fornecedor, $form_fornecedor, $form_descricao);
            if ($resultado) {
                $dados['sucesso'] = TRUE;
            } else {
                $dados['erro'] = TRUE;
                $dados['erro_mensagem'] = 'Houve um erro no momento da atualização dos dados do <b>Fornecedor</b> no banco de dados.<br/>'
                    . 'Por favor, tente novamente';
            }
        } else {
            $dados['erro'] = TRUE;
            $dados['erro_mensagem'] = validation_errors();
        }

        $dados['nome_usuario'] = $this->nome_usuario;
        $dados['url'] = $this->uri->uri_string();
        $resultado = $this->model_alterar_fornecedor->ler_fornecedor($id_fornecedor);
        if($resultado) {
            $dados['fornecedor'] = $resultado;
            $this->load->view('painel_editar/configuracoes/alterar_fornecedor/view_alterar.php', $dados);
        } else {
            $this->load->view('painel_editar/configuracoes/alterar_fornecedor/view_inexistente.php', $dados);
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página de confirmação de exclusão.
     *
     * url - {root}/paineleditar/configuracoes/alterarfornecedor/confirmarexcluir/*
     */
    public function confirmarexcluir()
    {
        $id_fornecedor = $this->uri->segment(5);

        $dados['nome_usuario'] = $this->nome_usuario;
        $resultado = $this->model_alterar_fornecedor->ler_fornecedor($id_fornecedor);
        if($resultado) {
            $dados['fornecedor'] = $resultado;
            $this->load->view('painel_editar/configuracoes/alterar_fornecedor/view_confirmar_excluir.php', $dados);
        } else {
            $this->load->view('painel_editar/configuracoes/alterar_fornecedor/view_inexistente.php', $dados);
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página para excluir um fornecedor.
     *
     * url - {root}/paineleditar/configuracoes/alterarfornecedor/excluir/*
     */
    public function excluir()
    {
        $id_fornecedor = $this->uri->segment(5);

        // Inicializando variáveis.
        $dados['sucesso'] = FALSE;
        $dados['erro'] = FALSE;
        $dados['erro_mensagem'] = "";

        if ($this->model_alterar_fornecedor->checar_fornecedor($id_fornecedor)) {
            $resultado = $this->model_alterar_fornecedor->excluir_fornecedor($id_fornecedor);
            if ($resultado) {
                $dados['sucesso'] = TRUE;
            } else {
                $dados['erro'] = TRUE;
                $dados['erro_mensagem'] = "O fornecedor escolhido não pode ser deletado pois há dependências.";
            }
        } else {
            $dados['erro'] = TRUE;
            $dados['erro_mensagem'] = "O fornecedor escolhido não existe.";
        }

        $dados['nome_usuario'] = $this->nome_usuario;
        $this->load->view('painel_editar/configuracoes/alterar_fornecedor/view_excluir.php', $dados);
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página que lista todos os fornecedores cadastrados.
     *
     * url - {root}/paineleditar/configuracoes/alterarfornecedor/lista
     */
    public function lista()
    {
        $this->load->helper('text');

        $dados['fornecedores'] = $this->model_alterar_fornecedor->ler_fornecedores();
        $dados['nome_usuario'] = $this->nome_usuario;
        $this->load->view('painel_editar/configuracoes/alterar_fornecedor/view_lista.php', $dados);
    }
}

/* Fim do arquivo controller_alterar_fornecedor.php */
/* Localização: ./application/controllers/painel_editar/configuracoes/controller_alterar_fornecedor.php */
