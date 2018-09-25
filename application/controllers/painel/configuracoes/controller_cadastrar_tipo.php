<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Controller responsável por manipular o menu 'cadastrar tipo'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
class Controller_Cadastrar_Tipo extends CI_Controller
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
        if (!$this->autenticacao->verificar_permissao(array(0, 1))) {
            redirect(base_url('/painel/home'));
        }
    }

    /**
     * Página de configurações para realizar o cadastro de um tipo.
     *
     * url - {root}/painel/configuracoes/cadastrartipo
     */
    public function cadastrar()
    {
        // Regras de validação.
        $this->form_validation->set_rules('formTipo', 'TIPO', 'required|xss_clean|is_unique[tipo.nome]|max_length[255]');
        $this->form_validation->set_rules('formDescricao', 'DESCRICAO', 'xss_clean|max_length[1000]');

        // Inicilizando variáveis.
        $dados['sucesso'] = 0;
        $dados['erro'] = 0;

        // Validando os dados do formulário.
        if ($this->form_validation->run()) {
            $form_tipo = $this->input->post('formTipo', TRUE);
            $form_descricao = $this->input->post('formDescricao', TRUE);

            $this->load->model('painel/configuracoes/model_cadastrar_tipo', 'model_cadastrar_tipo');

            // Verificando inserção no banco de dados.
            if ($this->model_cadastrar_tipo->inserir_tipo($form_tipo, $form_descricao)) {
                $dados['sucesso'] = 1;
            } else {
                $dados['erro'] = 1;
                $dados['erro_mensagem'] = 'Houve um erro no momento da inserção do <b>Tipo</b> no banco de dados.<br/>'
                    . 'Por favor, tente novamente';
            }
        } else {
            $dados['erro'] = 1;
            $dados['erro_mensagem'] = validation_errors();
        }

        // Pegando nome do usuario (username).
        $dados['nome_usuario'] = $this->nome_usuario;
        $this->load->view('painel/configuracoes/cadastrar_tipo/view_cadastrar.php', $dados);
    }
}

/* Fim do arquivo controller_cadastrar_tipo.php */
/* Localização: ./application/controllers/painel/configuracoes/controller_cadastrar_tipo.php */

