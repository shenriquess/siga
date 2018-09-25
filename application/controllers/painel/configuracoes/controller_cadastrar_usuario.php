<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Controller responsável por manipular o menu 'cadastrar usuário'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
class Controller_Cadastrar_Usuario extends CI_Controller
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

        $this->nome_usuario = $this->autenticacao->get_nome_usuario();

        // Verificando permissão para o usuário.
        if (!$this->autenticacao->verificar_permissao(array(0))) {
            redirect(base_url('/painel/home'));
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página de configurações para cadastrar um usuario no sistema.
     *
     * url - {root}/painel/configuracoes/cadastrarusuario/cadastrar
     */
    public function cadastrar()
    {
        $this->form_validation->set_rules('formNomeCompleto', 'NOME COMPLETO', 'required|xss_clean|');
        $this->form_validation->set_rules('formUsuario', 'USUARIO', 'xss_clean|trim|required|is_unique[usuario.nome_usuario]');
        $this->form_validation->set_rules('formSenha', 'SENHA', 'xss_clean|trim|required|matches[formConfSenha]');
        $this->form_validation->set_rules('formConfSenha', 'CONFIRMAÇÃO DE SENHA', 'xss_clean|trim|required');
        $this->form_validation->set_rules('formNivel', 'DESCRIÇÃO', 'xss_clean|required');

        // Inicializando variáveis.
        $dados['sucesso'] = 0;
        $dados['erro'] = 0;

        // Validando os dados do formulário.
        if ($this->form_validation->run()) {
            $form_nome_completo = $this->input->post('formNomeCompleto', TRUE);
            $form_usuario = $this->input->post('formUsuario', TRUE);
            $form_senha = $this->input->post('formSenha', TRUE);
            $form_nivel = $this->input->post('formNivel', TRUE);

            $this->load->model('painel/configuracoes/model_cadastrar_usuario', 'model_cadastrar_usuario');

            // Verificando inserção no banco de dados.
            if ($this->model_cadastrar_usuario->inserir_usuario($form_nome_completo, $form_usuario, $form_senha, $form_nivel)) {
                $dados['sucesso'] = 1;
            } else {
                $dados['erro'] = 1;
                $dados['erro_mensagem'] = 'Houve um erro no momento da inserção do <b>Usuário</b> no banco de dados.<br/>'
                    . 'Por favor, tente novamente';
            }
        } else {
            $dados['erro'] = 1;
            $dados['erro_mensagem'] = validation_errors();
        }

        // Pegando nome do usuario (username).
        $dados['nome_usuario'] = $this->nome_usuario;
        $this->load->view('painel/configuracoes/cadastrar_usuario/view_cadastrar.php', $dados);
    }
}

/* Fim do arquivo controller_cadastrar_usuario.php */
/* Localização: ./application/controllers/painel/configuracoes/controller_cadastrar_usuario.php */

