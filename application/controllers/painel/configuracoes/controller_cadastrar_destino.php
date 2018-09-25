<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Controller responsável por manipular o menu 'cadastrar destino'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
class Controller_Cadastrar_Destino extends CI_Controller
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
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página do painel que realiza o cadastro de um destino.
     *
     * url - {root}/painel/configuracoes/cadastrardestino
     * @access public
     */
    public function cadastrar()
    {
        // Verificando permissão para o usuário.
        if (!$this->autenticacao->verificar_permissao(array(0, 1))) {
            redirect(base_url('/painel/home'));
        }

        $this->form_validation->set_rules('formDestino', 'DESTINO', 'xss_clean|required|is_unique[destino.nome]');
        $this->form_validation->set_rules('formDescricao', 'DESCRIÇÃO', 'xss_clean');

        $dados['sucesso'] = 0;
        $dados['erro'] = 0;

        // Validando os dados do formulário.
        if ($this->form_validation->run()) {
            $form_destino = $this->input->post('formDestino', TRUE);
            $form_descricao = $this->input->post('formDescricao', TRUE);

            $this->load->model('painel/configuracoes/model_cadastrar_destino', 'model_cadastrar_destino');

            // Verificando inserção no banco de dados.
            if ($this->model_cadastrar_destino->inserir_destino($form_destino, $form_descricao)) {
                $dados['sucesso'] = 1;
            } else {
                $dados['erro'] = 1;
                $dados['erro_mensagem'] = 'Houve um erro no momento da inserção do <b>Fornecedor</b> no banco de dados.<br/>' .
                    'Por favor, tente novamente';
            }
        } else {
            $dados['erro'] = 1;
            $dados['erro_mensagem'] = validation_errors();
        }

        // Pegando usuario.
        $dados['nome_usuario'] = $this->nome_usuario;
        $this->load->view('painel/configuracoes/cadastrar_destino/view_cadastrar.php', $dados);
    }
}

/* Fim do arquivo controller_cadastrar_destino.php */
/* Localização: ./application/controllers/painel/configuracoes/controller_cadastrar_destino.php */

