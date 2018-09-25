<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller responsável por manipular o menu 'balanço de contratos'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
class Controller_Balanco_Contratos extends CI_Controller
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
     * Página inicial do relatório de balanço de contratos.
     *
     * url = {root}/painel/relatorio/balancocontratos/lista
     */
    public function lista()
    {
        $this->load->model('painel/relatorio/model_balanco_contratos', 'model_balanco_contratos');

        // Lendo o ano selecionado.
        if ($this->input->get('formAno', TRUE) != NULL && $this->input->get('formAno', TRUE) > 0) {
            $formAno = $this->input->get('formAno', TRUE);
        } else {
            $formAno = 0;
        }

        // Lendo os contratos.
        $contratos = $this->model_balanco_contratos->ler_fornecedor_contrato($formAno);
        if ($contratos) {
            $dados['contratos'] = $contratos;
        }

        // Lendo o ano final dos contratos.
        $dados['anos_contratos'] = $this->model_balanco_contratos->ler_anos_contratos();

        // Lendo o nome do usuario (username).
        $dados['nome_usuario'] = $this->nome_usuario;

        $dados['formAno'] = $formAno;
        $this->load->view('painel/relatorio/balanco_contratos/view_lista', $dados);
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página de um contrato do relatório de balanço de contratos.
     *
     * url = {root}/painel/relatorio/balancocontratos/contrato?formCodigo=*
     * url = {root}/painel/relatorio/balancocontratos/contrato/pdf?formCodigo=*
     */
    public function contrato()
    {
        if ($this->input->get('formCodigo', TRUE) != NULL) {
            $formCodigo = $this->input->get('formCodigo', TRUE);
        } else {
            $formCodigo = 0;
            $dados['erro'] = 1;
            $dados['erro_mensagem'] = 'Por favor selecione um contrato válido';
        }

        // Carregando o componentes.
        $this->load->library('unidades');
        $this->load->model('painel/relatorio/model_balanco_contratos', 'model_balanco_contratos');

        // Lendo os valores cadastrados
        $dados['contrato'] = $this->model_balanco_contratos->ler_contrato($formCodigo);
        $dados['itens_contrato'] = $this->model_balanco_contratos->ler_itens_contrato($formCodigo);
        $dados['unidades'] = $this->unidades->ler_unidades_padrao();
        $dados['valor_total_contrato'] = $this->model_balanco_contratos->ler_valor_total_contrato($formCodigo);
        $dados['valor_total_entregue'] = $this->model_balanco_contratos->ler_valor_total_entregue($formCodigo);

        if ($dados['contrato'] == NULL) {
            $dados['erro'] = 1;
            $dados['erro_mensagem'] = 'Contrato não encontrato.<br/>Código do Contrato: <b>' . $this->input->get('formCodigo', TRUE) . '</b>';
        }

        // Passando o get para a view.
        $dados['formContrato'] = $formCodigo;
        $dados['nome_usuario'] = $this->nome_usuario;

        // DETALHES
        if ($this->uri->segment(4) == 'contrato' && $this->uri->segment(5) != 'pdf') {
            $this->load->view('painel/relatorio/balanco_contratos/view_contrato', $dados);
        } // PDF
        else {
            $this->load->helper('pdf');
            $this->load->helper('date');
            $dados['data_hora'] = mdate('%d/%m/%Y %h:%i:%s', time());
            $this->load->view('painel/relatorio/balanco_contratos/view_contrato_pdf', $dados);
        }
    }
}

/* Fim do Arquivo: controller_balanco_contratos.php */
/* Localização: ./application/controllers/painel/relatorio/controller_balanco_contratos.php */
