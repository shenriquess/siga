<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Controller responsável por manipular o menu 'cadastrar fornecedor'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
class Controller_Cadastrar_Fornecedor extends CI_Controller
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

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página do painel que realiza o cadastro de um fornecedor.
     *
     * url - {root}/painel/configuracoes/cadastrarfornecedor/cadastrar
     */
    public function cadastrar()
    {

        $this->form_validation->set_rules('formFornecedor', 'FORNECEDOR', 'xss_clean|required|is_unique[fornecedor.nome]');
        $this->form_validation->set_rules('formDescricao', 'DESCRIÇÃO', 'xss_clean');

        $dados['sucesso'] = 0;
        $dados['erro'] = 0;

        // Validando os dados do formulário.
        if ($this->form_validation->run()) {
            $form_fornecedor = $this->input->post('formFornecedor', TRUE);
            $form_descricao = $this->input->post('formDescricao', TRUE);

            $this->load->model('painel/configuracoes/model_cadastrar_fornecedor', 'model_cadastrar_fornecedor');

            // Verificando inserção no banco de dados.
            if ($this->model_cadastrar_fornecedor->inserir_fornecedor($form_fornecedor, $form_descricao)) {
                $dados['sucesso'] = 1;
            } else {
                $dados['erro'] = 1;
                $dados['erro_mensagem'] = 'Houve um erro no momento da inserção do <b>Fornecedor</b> no banco de dados.<br/>'
                    . 'Por favor, tente novamente';
            }
        } else {
            $dados['erro'] = 1;
            $dados['erro_mensagem'] = validation_errors();
        }

        // Pegando nome do usuario (username).
        $dados['nome_usuario'] = $this->nome_usuario;
        $this->load->view('painel/configuracoes/cadastrar_fornecedor/view_cadastrar.php', $dados);
    }
}

/* Fim do arquivo controller_cadastrar_fornecedor.php */
/* Localização: ./application/controllers/painel/configuracoes/controller_cadastrar_fornecedor.php */

