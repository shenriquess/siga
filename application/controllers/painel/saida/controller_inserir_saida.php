<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller responsável por manipular o menu 'inserir saída'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
class Controller_Inserir_Saida extends CI_Controller
{
    /**
     * @var $nome_usuario Nome de usuário(username) do usuário.
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
        if (!$this->autenticacao->verificar_permissao(array(0, 1, 2))) {
            redirect(base_url('/painel/home'));
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página de inserção das saídas do sistema.
     *
     * url - {root}/painel/saida/inserirsaida/cadastrar
     */
    public function cadastrar()
    {
        // Carregando módulos.
        $this->load->helper('data');
        $this->load->library('unidades');
        $this->load->model('painel/saida/model_inserir_saida', 'model_inserir_saida');

        // Inicializando variáveis de erro.
        $dados['sucesso'] = 0;
        $dados['erro'] = 0;
        $dados['erro_mensagem'] = "";

        // Lendo as quantidades totais de itens disponíveis no banco de dados.
        $dados['unidades'] = $this->unidades->ler_unidades_padrao();

        // Lendo os itens cadastrados no banco de dados.
        $dados['itens'] = $this->model_inserir_saida->ler_itens();
        if (!$dados['itens']) {
            $dados['erro'] = 1;
            $dados['erro_mensagem'] .= 'Por favor, cadastre um <b>Item</b> primeiro.<br/>';
        }

        $dados['contratos'] = $this->model_inserir_saida->ler_item_contratos();
        if (!$dados['contratos']) {
            $dados['erro'] = 1;
            $dados['erro_mensagem'] .= 'Por favor, cadastre um <b>Contrato</b> para o produto primeiro.<br/>';
        }

        // Lendo os destinos cadastrados no banco de dados.
        $dados['destinos'] = $this->model_inserir_saida->ler_todos_destinos();
        if (!$dados['destinos']) {
            $dados['erro'] = 1;
            $dados['erro_mensagem'] .= 'Por favor, cadastre um <b>Destino</b> primeiro.<br/>';
        }

        // Lendo os tipos cadastrados no banco de dados.
        $dados['tipos'] = $this->model_inserir_saida->ler_tipos();
        if (!$dados['tipos']) {
            $dados['erro'] = 1;
            $dados['erro_mensagem'] .= 'Por favor, cadastre um <b>Tipo</b> primeiro.<br/>';
        }

        // Pegando nome do usuario (username).
        $dados['nome_usuario'] = $this->nome_usuario;
        $this->load->view('painel/saida/inserir_saida/view_cadastrar.php', $dados);
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página de gerar a saída.
     *
     * url - {root}/painel/saida/inserirsaida/gerarsaida
     */
    public function gerarsaida()
    {
        // Carregando componentes.
        $this->load->helper('data');
        $this->load->helper('date');
        $this->load->helper('pdf');
        $this->load->library('unidades');
        $this->load->model('painel/saida/model_inserir_saida', 'model_inserir_saida');

        // Lendo requisição.
        $saidas = json_decode($this->input->post('formGerarSaida'));
        $dados['formGerarSaida'] = $this->input->post('formGerarSaida');

        if ($saidas) {
            $dados['dados_saidas'] = array();
            $destino_data_lido = FALSE;
            foreach ($saidas as $id) {
                // Lendo as saidas que foram cadastradas.
                array_push($dados['dados_saidas'], $this->model_inserir_saida->ler_dado_saida($id));
                if (!$destino_data_lido) {
                    $dados['unidades'] = $this->unidades->ler_unidades_padrao();
                    $dados['destino'] = $this->model_inserir_saida->ler_destino($dados['dados_saidas'][0]['id_destino']);
                    $dados['destino']['data'] = data_MySQL_para_normal($dados['dados_saidas'][0]['data']);
                }
            }
        } else {
            redirect(base_url('/painel/home'));
        }

        $dados['nome_usuario'] = $this->nome_usuario;
        if ($this->uri->segment(4) == 'gerarsaida' && $this->uri->segment(5) == 'pdf') {
            $dados['data_hora'] = mdate('%d/%m/%Y %h:%i:%s', time());
            $this->load->view('painel/saida/inserir_saida/view_gerar_saida_pdf.php', $dados);
        } else {
            $this->load->view('painel/saida/inserir_saida/view_gerar_saida.php', $dados);
        }
    }
}

/* Fim do Arquivo: controller_inserir_saida.php */
/* Localização: ./application/controllers/painel/saida/controller_inserir_saida.php */
