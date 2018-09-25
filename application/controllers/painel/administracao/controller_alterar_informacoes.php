<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller responsável por manipular o menu 'alterar informações'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
class Controller_Alterar_Informacoes extends CI_Controller
{
    /**
     * Nome de usuário(username) do usuário
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
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Exibe a tela de login do menu de administração.
     *
     * @url {root}/painel/adminstracacao/login
     */
    public function login()
    {
        // Validando formulário de login.
        $this->form_validation->set_rules('formUsuario', 'USUARIO', 'required');
        $this->form_validation->set_rules('formSenha', 'SENHA', 'required');

        // Lendo o nome do usuário (username).
        $dados['nome_usuario'] = $this->nome_usuario;

        // Verificando formulário.
        if ($this->form_validation->run()) {
            $formUsuario = $this->input->post('formUsuario', TRUE);
            $formSenha = $this->input->post('formSenha', TRUE);

            // Pegando usuário no banco de dados.
            $this->load->model('painel/administracao/model_alterar_informacoes', 'model_alterar_informacoes');
            $resultado = $this->model_alterar_informacoes->ler_usuario($formUsuario, md5($formSenha));

            // Verificando credenciais do usuário.
            if ($resultado) {
                if ($resultado['nivel'] == 0) {
                    $dados_acesso = array(
                        'id_usuario' => $resultado['id_usuario'],
                        'nome' => $resultado['nome'],
                        'nome_usuario' => $resultado['nome_usuario'],
                        'senha' => $resultado['senha'],
                        'nivel' => $resultado['nivel'],
                        'logado' => TRUE,
                        'modo_admin' => TRUE
                    );

                    $this->session->set_userdata($dados_acesso);
                    $url = base_url('/paineleditar/home');
                    redirect($url);
                } else {
                    $dados['erro'] = 1;
                    $dados['erro_mensagem'] = 'Você deve ter nível <b>Administrador</b> para editar as informações.';
                    $this->load->view('painel/administracao/view_index.php', $dados);
                }
            } else {
                $dados['erro'] = 1;
                $dados['erro_mensagem'] = '<b>Senha</b> ou <b>usuário</b> incorretos.';
                $this->load->view('painel/administracao/view_index.php', $dados);
            }
        } // Caso houve alguns erros no formulário de login.
        else {
            $this->load->view('painel/administracao/view_index.php', $dados);
        }
    }
}

/* Fim do arquivo controller_alterar_informacoes.php */
/* Localização: ./application/controllers/painel/administracao/controller_alterar_informacoes.php */

