<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controler responsável por manipular a tela do login.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
class Controller_Login extends CI_Controller
{
    /**
     * Página inicial do login
     *
     * url - {root}/login
     */
    public function index()
    {
        // Validando formulário de login.
        $this->form_validation->set_rules('formLoginUsuario', 'USUARIO', 'required');
        $this->form_validation->set_rules('formLoginSenha', 'SENHA', 'required');

        // Verificando formulário.
        if ($this->form_validation->run()) {
            $formUsuario = $this->input->post('formLoginUsuario', TRUE);
            $formSenha = $this->input->post('formLoginSenha', TRUE);

            // Pegando usuário no banco de dados.
            $this->load->model('model_login', 'model_login');
            $resultado = $this->model_login->ler_usuario($formUsuario, md5($formSenha));

            // Verificando credenciais do usuário.
            if($resultado) {
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
                $url = base_url('/painel/home');
                redirect($url);
            }
            else {
                $dados['erros'] = 1;
                $this->load->view('login/view_index.php', $dados);
            }
        } // Caso houve alguns erros no formulário de login.
        else {
            $this->load->view('login/view_index.php');
        }
    }
}

/* Fim do arquivo controller_login.php */
/* Localização: ./application/controllers/painel/controller_login.php */
