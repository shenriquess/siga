<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller responsável por manipular o menu 'estoque disponível'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
class Controller_Estoque_Disponivel extends CI_Controller
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
     * Página do relatório de estoque disponível.
     *
     * url - {root}/painel/relatorio/estoquedisponível/lista
     * url - {root}/painel/relatorio/estoquedisponível/lista/expandir
     * url - {root}/painel/relatorio/estoquedisponível/lista/expandir/pdf
     */
    public function lista()
    {
        // Carregando módulos.
        $this->load->library('unidades');
        $this->load->model('painel/relatorio/model_estoque_disponivel', 'model_estoque_disponivel');

        // Lendo tipo selecionado.
        $formTipo = $this->input->post('formTipo', TRUE);
        if ($formTipo != NULL && $formTipo > 0) {
            $dados['formTipo'] = $formTipo;
            $dados['tipo_selecionado'] = $this->model_estoque_disponivel->ler_tipo($formTipo);
        } // Caso ele não selecione nenhum tipo.
        else {
            $dados['formTipo'] = 0;
            $dados['tipo_selecionado'] = NULL;
        }

        // Inicializando as variáveis.
        $dados['erro'] = 0;
        $dados['erro_mensagem'] = '';

        // Verificando se há itens cadastrado no sistema.
        $resultado = $this->model_estoque_disponivel->quantidade_itens();
        if ($resultado->quantidade_itens > 0) {
            $dados['estoques_disponiveis'] = $this->model_estoque_disponivel->itens_disponiveis($formTipo);
        } else {
            $dados['erro'] = 1;
            $dados['erro_mensagem'] .= 'Não há cadastro de <b>Itens</b>.';
        }

        // Lê os tipos e as unidades padrões.
        $dados['tipos'] = $this->model_estoque_disponivel->ler_tipos();
        $dados['unidades'] = $this->unidades->ler_unidades_padrao();

        // Carrega o nome do usuario (username).
        $dados['nome_usuario'] = $this->nome_usuario;

        // EXPANDIR
        if ($this->uri->segment(5) === "expandir" && $this->uri->segment(6) !== "pdf") {
            $this->load->view('painel/relatorio/estoque_disponivel/view_expandir', $dados);
        } // PDF
        else if ($this->uri->segment(5) === "expandir" && $this->uri->segment(6) === "pdf") {
            $this->load->helper('pdf');
            $this->load->helper('date');
            $dados['data_hora'] = mdate('%d/%m/%Y %h:%i:%s', time());
            $this->load->view('painel/relatorio/estoque_disponivel/view_expandir_pdf', $dados);
        } // INDEX
        else {
            $this->load->view('painel/relatorio/estoque_disponivel/view_lista', $dados);
        }
    }
}

/* Fim do Arquivo: controller_estoque_disponivel.php */
/* Localização: ./application/controllers/painel/relatorio/controller_estoque_disponivel.php */
