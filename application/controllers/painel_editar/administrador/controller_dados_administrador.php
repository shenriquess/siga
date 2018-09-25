<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller que manipula o menu 'Dados Administrador'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
class Controller_Dados_Administrador extends CI_Controller
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
     * Verifica se o usuário está logado no sistema.
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
        $this->load->model('painel_editar/administrador/model_dados_administrador', 'model_dados_administrador');
    }

    //------------------------------------------------------------------------------------------------------------------

    public function alterar()
    {
        $this->form_validation->set_rules('formNomeCompleto', 'NOME COMPLETO', 'required|xss_clean|');

        // Inicializando variáveis.
        $dados['sucesso'] = FALSE;
        $dados['erro'] = FALSE;
        $dados['erro_mensagem'] = "";

        if ($this->form_validation->run()) {
            $form_nome_completo = $this->input->post('formNomeCompleto', TRUE);
            $form_senha = $this->input->post('formSenha', TRUE);

            // Alteração sem senha.
            if ($form_senha == "") {
                $resultado = $this->model_dados_administrador->atualizar_administrador(1, $form_nome_completo);
            } // Alteração com senha.
            else {
                $resultado = $this->model_dados_administrador->atualizar_administrador_senha(1, $form_nome_completo, $form_senha);
            }

            // Erro na alteração.
            if ($resultado) {
                $dados['sucesso'] = $resultado;
            } else {
                $dados['erro'] = TRUE;
                $dados['erro_mensagem'] = 'Houve um erro no momento da atualização dos dados do <b>Usuário</b> no banco de dados.<br/>'
                    . 'Por favor, tente novamente';
            }
        } else {
            $dados['erro'] = TRUE;
            $dados['erro_mensagem'] = validation_errors();
        }

        $dados['nome_usuario'] = $this->nome_usuario;
        $dados['url'] = $this->uri->uri_string();
        $dados['administrador'] = $this->model_dados_administrador->ler_usuario(1);
        $this->load->view('painel_editar/administrador/dados_administrador/view_alterar.php', $dados);
    }
}

/* Fim do arquivo controller_dados_administrador.php */
/* Localização: ./application/controllers/painel_editar/administrador/controller_dados_administrador.php */
