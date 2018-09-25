<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Controller responsável por manipular o menu 'cadastrar contrato'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
class Controller_Cadastrar_Contrato extends CI_Controller
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
     * Página de configurações para cadastrar um contrato.
     *
     * url - {root}/painel/configuracoes/cadastrarcontrato
     * @access public
     */
    public function cadastrar()
    {
        // Inicializando variáveis de erro.
        $dados['sucesso'] = 0;
        $dados['erro'] = 0;
        $dados['erro_mensagem'] = "";

        // Carregando módulos.
        $this->load->library('unidades');
        $this->load->model('painel/configuracoes/model_cadastrar_contrato', 'model_cadastrar_contrato');

        // Lendo os itens cadastrados no banco de dados.
        $dados['itens'] = $this->model_cadastrar_contrato->ler_todos_itens();
        if ($dados['itens'] == FALSE) {
            $dados['erro'] = 1;
            $dados['erro_mensagem'] .= 'Por favor, cadastre um <b>Item</b> primeiro.<br/>';
        }

        // Lendo os fornecedores cadastrados no banco de dados.
        $dados['fornecedores'] = $this->model_cadastrar_contrato->ler_todos_fornecedores();
        if ($dados['fornecedores'] == FALSE) {
            $dados['erro'] = 1;
            $dados['erro_mensagem'] .= 'Por favor, cadastre um <b>Fornecedor</b> primeiro.<br/>';
        }

        // Lendo os tipos cadastrados no banco de dados.
        $dados['tipos'] = $this->model_cadastrar_contrato->ler_todos_tipos();
        if ($dados['tipos'] == FALSE) {
            $dados['erro'] = 1;
            $dados['erro_mensagem'] .= 'Por favor, cadastre um <b>Tipo</b> primeiro.<br/>';
        }

        // Lendo os dados já cadastrados.
        $dados['contratos'] = $this->model_cadastrar_contrato->ler_todos_contratos();
        $dados['unidades'] = $this->unidades->ler_unidades_padrao();

        // Pegando nome do usuario (username).
        $dados['nome_usuario'] = $this->nome_usuario;
        $this->load->view('painel/configuracoes/cadastrar_contrato/view_cadastrar.php', $dados);
    }
}

/* Fim do arquivo controller_cadastrar_contrato.php */
/* Localização: ./application/controllers/painel/controller_cadastrar_contrato.php */

