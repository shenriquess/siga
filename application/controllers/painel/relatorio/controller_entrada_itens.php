<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller responsável por manipular o menu 'entrada de itens'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
class Controller_Entrada_itens extends CI_Controller
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
     * Página de pesquisa do relatório de entrada de intes.
     *
     * url - {root}/painel/relatorio/entradaitens/lista
     * url - {root}/painel/relatorio/entradaitens/lista/expandir
     * url - {root}/painel/relatorio/entradaitens/lista/expandir/pdf
     */
    public function lista()
    {
        // Carregando componentes.
        $this->load->helper('date');
        $this->load->helper('data');
        $this->load->helper('pdf');
        $this->load->library('unidades');
        $this->load->model('painel/relatorio/model_entrada_itens', 'model_entrada_itens');

        // Lendo os posts.
        $formContrato = $this->input->post('formContrato', TRUE);
        $formDataInicio = $this->input->post('formDataInicio', TRUE);
        $formDataFim = $this->input->post('formDataFim', TRUE);
        $formFornecedor = $this->input->post('formFornecedor', TRUE);
        $formItem = $this->input->post('formItem', TRUE);
        $formTipo = $this->input->post('formTipo', TRUE);

        // Transformando a data escolhida para formato do MySQL
        $data_inicio_mysql = data_normal_para_MySQL($formDataInicio);
        $data_fim_mysql = data_normal_para_MySQL($formDataFim);

        // Validando formato da data.
        if (validar_data($formDataInicio, 'd/m/Y') && validar_data($formDataFim, 'd/m/Y')) {
            // Busca pela data.
            if ($formContrato == 0 && $formTipo == 0 && $formItem == 0 ) {
                $dados['entradas'] = $this->model_entrada_itens->ler_entradas_data($data_inicio_mysql, $data_fim_mysql);
            } // Busca pela data e contrato.
            else if ($formContrato > 0 && $formTipo == 0 && $formItem == 0) {
                $dados['entradas'] = $this->model_entrada_itens->ler_entradas_data_contrato($data_inicio_mysql, $data_fim_mysql, $formContrato);
            } // Busca pela data, contrato e tipo.
            else if ($formContrato > 0 && $formTipo > 0 && $formItem == 0) {
                $dados['entradas'] = $this->model_entrada_itens->ler_entradas_data_contrato_tipo($data_inicio_mysql, $data_fim_mysql, $formContrato, $formTipo);
            } // Busca pela data, contrato, tipo e item.
            else if ($formContrato > 0 && $formTipo > 0 && $formItem > 0) {
                $dados['entradas'] = $this->model_entrada_itens->ler_entradas_data_contrato_tipo_item($data_inicio_mysql, $data_fim_mysql, $formContrato, $formTipo, $formItem);
            } // Busca pela data e fornecedor.
            else if ($formContrato == 0 && $formFornecedor > 0 && $formTipo == 0 && $formItem == 0) {
                $dados['entradas'] = $this->model_entrada_itens->ler_entradas_data_fornecedor($data_inicio_mysql, $data_fim_mysql, $formFornecedor);
            } // Busca pela data, fornecedor e tipo.
            else if ($formContrato == 0 && $formFornecedor > 0 && $formTipo > 0 && $formItem == 0) {
                $dados['entradas'] = $this->model_entrada_itens->ler_entradas_data_fornecedor_tipo($data_inicio_mysql, $data_fim_mysql, $formFornecedor, $formTipo);
            } // Busca pela data, fornecedor, tipo e item.
            else if ($formContrato == 0 && $formFornecedor > 0 && $formTipo > 0 && $formItem > 0) {
                $dados['entradas'] = $this->model_entrada_itens->ler_entradas_data_fornecedor_tipo_item($data_inicio_mysql, $data_fim_mysql, $formFornecedor, $formTipo, $formItem);
            } // Busca pela data e tipo.
            else if ($formContrato == 0 && $formFornecedor == 0 && $formTipo > 0 && $formItem == 0) {
                $dados['entradas'] = $this->model_entrada_itens->ler_entradas_data_tipo($data_inicio_mysql, $data_fim_mysql, $formTipo);
            } // Busca pela data, tipo e item.
            else if ($formContrato == 0 && $formFornecedor == 0 && $formTipo > 0 && $formItem > 0) {
                $dados['entradas'] = $this->model_entrada_itens->ler_entradas_data_tipo_item($data_inicio_mysql, $data_fim_mysql, $formTipo, $formItem);
            }

        } else {
            $dados['erro'] = 1;
            $dados['erro_mensagem'] = 'O formato das <b>datas</b> inseridas é invalida.';
        }

        // Lendo os dados cadastrados no banco de dados.
        $dados['fornecedores_contratos'] = $this->model_entrada_itens->ler_fornecedores_contratos();
        $dados['fornecedores'] = $this->model_entrada_itens->ler_fornecedores();
        $dados['itens'] = $this->model_entrada_itens->ler_itens();
        $dados['nome_fornecedor'] = $this->model_entrada_itens->ler_nome_fornecedor($formFornecedor);
        $dados['nome_item'] = $this->model_entrada_itens->ler_nome_item($formItem);
        $dados['nome_tipo'] = $this->model_entrada_itens->ler_nome_tipo($formTipo);
        $dados['nome_fornecedor_contrato'] = $this->model_entrada_itens->ler_nome_fornecedor_contrato($formContrato);
        $dados['unidade_padrao'] = $this->unidades->ler_unidades_padrao();
        $dados['tipos'] = $this->model_entrada_itens->ler_tipos();

        // Enviando dados para a view.
        $dados['formContrato'] = $formContrato;
        $dados['formItem'] = $formItem;
        $dados['formDataInicio'] = $formDataInicio;
        $dados['formDataFim'] = $formDataFim;
        $dados['formFornecedor'] = $formFornecedor;
        $dados['formTipo'] = $formTipo;
        $dados['nome_usuario'] = $this->nome_usuario;

        // EXPANDIR
        if ($this->uri->segment(5) == 'expandir' && $this->uri->segment(6) != 'pdf') {
            $this->load->view('painel/relatorio/entrada_itens/view_expandir.php', $dados);
        } // PDF
        else if ($this->uri->segment(5) == 'expandir' && $this->uri->segment(6) == 'pdf') {
            $dados['data_hora'] = mdate('%d/%m/%Y %h:%i:%s', time());
            $this->load->view('painel/relatorio/entrada_itens/view_expandir_pdf.php', $dados);
        } // INDEX
        else {
            if ($formDataInicio == NULL && $formDataFim == NULL) {
                $dados['entradas'] = $this->model_entrada_itens->ler_entradas_data(Date('Y-m-d', strtotime("-7 days")), Date('Y-m-d'));
                $dados['formDataFim'] = data_MySQL_para_normal(Date('Y-m-d'));
                $dados['formDataInicio'] = data_MySQL_para_normal(Date('Y-m-d', strtotime("-7 days")));
            }
            $this->load->view('painel/relatorio/entrada_itens/view_lista.php', $dados);
        }

    }
}

/* Fim do Arquivo: controller_entrada_itens.php */
/* Localização: ./application/controllers/painel/relatorio/controller_entrada_itens.php */
