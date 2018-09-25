<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller que manipula o menu 'Alterar Usuário'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
class Controller_Alterar_Usuario extends CI_Controller
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
        $this->load->model('painel_editar/configuracoes/model_alterar_usuario', 'model_alterar_usuario');
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página para alterar o cadastro de um usuário.
     *
     * url - {root}/paineleditar/configuracoes/alterarusuario/alterar/*
     */
    public function alterar()
    {
        // Lendo o usuário.
        $id_usuario = $this->uri->segment(5);
        $usuario = $this->model_alterar_usuario->ler_usuario($id_usuario);

        // Verifica se há mudanças no nome de usuário.
        if (isset($usuario['nome_usuario']) && $this->input->post('formUsuario') == $usuario['nome_usuario']) {
            $this->form_validation->set_rules('formUsuario', 'USUARIO', 'xss_clean|trim|required');
        } else {
            $this->form_validation->set_rules('formUsuario', 'USUARIO', 'xss_clean|trim|required|is_unique[usuario.nome_usuario]');
        }
        $this->form_validation->set_rules('formNomeCompleto', 'NOME COMPLETO', 'required|xss_clean|');
        $this->form_validation->set_rules('formNivel', 'DESCRIÇÃO', 'xss_clean|required');

        // Inicializando variáveis.
        $dados['sucesso'] = FALSE;
        $dados['erro'] = FALSE;
        $dados['erro_mensagem'] = "";

        if ($this->form_validation->run()) {
            $form_nome_completo = $this->input->post('formNomeCompleto', TRUE);
            $form_usuario = $this->input->post('formUsuario', TRUE);
            $form_senha = $this->input->post('formSenha', TRUE);
            $form_nivel = $this->input->post('formNivel', TRUE);

            // Alteração sem senha.
            if ($form_senha == "") {
                $resultado = $this->model_alterar_usuario->atualizar_usuario($id_usuario, $form_nome_completo, $form_usuario, $form_nivel);
            } // Alteração com senha.
            else {
                $resultado = $this->model_alterar_usuario->atualizar_usuario_senha($id_usuario, $form_nome_completo, $form_usuario, $form_senha, $form_nivel);
            }
            $dados['usuario'] = $this->model_alterar_usuario->ler_usuario($id_usuario);

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
        $resultado = $this->model_alterar_usuario->ler_usuario($id_usuario);
        if ($resultado) {
            $dados['usuario'] = $resultado;
            $this->load->view('painel_editar/configuracoes/alterar_usuario/view_alterar.php', $dados);
        } else {
            $this->load->view('painel_editar/configuracoes/alterar_usuario/view_inexistente.php', $dados);
        }
    }


    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página de confirmação de exclusão.
     *
     * url - {root}/paineleditar/configuracoes/alterarusuario/confirmarexcluir/*
     */
    public function confirmarexcluir()
    {
        $id_usuario = $this->uri->segment(5);

        // Inicializando variáveis.
        $dados['erro'] = FALSE;
        $dados['erro_mensagem'] = "";

        $dados['nome_usuario'] = $this->nome_usuario;
        $resultado = $this->model_alterar_usuario->ler_usuario($id_usuario);
        if ($resultado) {
            $dados['usuario'] = $resultado;
            $this->load->view('painel_editar/configuracoes/alterar_usuario/view_confirmar_excluir.php', $dados);
        } else {
            $this->load->view('painel_editar/configuracoes/alterar_usuario/view_inexistente.php', $dados);
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página para excluir um usuário.
     *
     * url - {root}/paineleditar/configuracoes/alterarusuario/excluir/*
     */
    public function excluir()
    {
        $id_usuario = $this->uri->segment(5);

        // Inicializando variáveis.
        $dados['sucesso'] = FALSE;
        $dados['erro'] = FALSE;
        $dados['erro_mensagem'] = "";

        if ($this->model_alterar_usuario->checar_usuario($id_usuario)) {
            $resultado = $this->model_alterar_usuario->excluir_usuario($id_usuario);
            if ($resultado) {
                $dados['sucesso'] = TRUE;
            } else {
                $dados['erro'] = TRUE;
                $dados['erro_mensagem'] = "O usuário escolhido não pode ser deletado pois há dependências.";
            }
        } else {
            $dados['erro'] = TRUE;
            $dados['erro_mensagem'] = "O usuário escolhido não existe.";
        }

        $dados['nome_usuario'] = $this->nome_usuario;
        $this->load->view('painel_editar/configuracoes/alterar_usuario/view_excluir.php', $dados);
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página que lista todos os usuários cadastrados.
     *
     * url - {root}/paineleditar/configuracoes/alterarusuario/lista
     */
    public function lista()
    {
        $dados['usuarios'] = $this->model_alterar_usuario->ler_usuarios();

        $dados['nome_usuario'] = $this->nome_usuario;
        $this->load->view('painel_editar/configuracoes/alterar_usuario/view_lista.php', $dados);
    }
}

/* Fim do arquivo controller_alterar_usuario.php */
/* Localização: ./application/controllers/painel_editar/configuracoes/controller_alterar_usuario.php */
