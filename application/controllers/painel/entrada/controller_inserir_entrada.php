<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller responsável por manipular o menu 'inserir entrada'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
class Controller_Inserir_Entrada extends CI_Controller
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
     * Página de para inserção das entradas do sistema.
     *
     * url - {root}/painel/entrada/inserirentrada/cadastrar
     */
    public function cadastrar()
    {
        // Atribuindo permissões.
        if (!$this->autenticacao->verificar_permissao(array(0, 1, 2))) {
            redirect(base_url('/painel/home'));
        }

        // Carregando módulos.
        $this->load->library('unidades', 'unidades');
        $this->load->model('painel/entrada/model_inserir_entrada', 'model_inserir_entrada');

        // Inicializando variáveis.
        $dados['erro'] = 0;
        $dados['sucesso'] = 0;
        $dados['erro_mensagem'] = '';

        // Pegando os itens dos contratos e o nome dos itens.
        $dados['itens_contratos'] = $this->model_inserir_entrada->ler_itens_contratos();
        $dados['contratos'] = $this->model_inserir_entrada->ler_contrato_fornecedor();
        $dados['unidades'] = $this->unidades->ler_unidades_padrao();

        if (!$dados['contratos']) {
            $dados['erro'] = 1;
            $dados['erro_mensagem'] = 'Por favor, cadastre um <b>Contrato</b> primeiro.';
        }

        // Pegando nome do usuario (username).
        $dados['nome_usuario'] = $this->nome_usuario;

        $this->load->view('painel/entrada/inserir_entrada/view_cadastrar.php', $dados);
    }
}

/* Fim do Arquivo: controller_inserir_entrada.php */
/* Localização: ./application/controllers/painel/entrada/controller_inserir_entrada.php */


