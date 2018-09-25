<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller responsável por manipular as telas do relatório.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
class Controller_Saida_Itens extends CI_Controller
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
     * Página de pesquisa do relatório de saída de itens.
     *
     * url - {root}/painel/relatorio/saidaitens/lista
     * url - {root}/painel/relatorio/saidaitens/lista/expandir
     * url - {root}/painel/relatorio/saidaitens/lista/expandir/pdf
     */
    public function lista()
    {
        // Verificando permissão para o usuário.
        if (!$this->autenticacao->verificar_permissao(array(0, 1))) {
            redirect(base_url('/painel/home'));
        }

        // Carregando componentes.
        $this->load->helper('data');
        $this->load->helper('date');
        $this->load->helper('pdf');
        $this->load->library('unidades');
        $this->load->model('painel/relatorio/model_saida_itens', 'model_saida_itens');

        // Lendo os posts.
        $formDestino = $this->input->post('formDestino', TRUE);
        $formDataInicio = $this->input->post('formDataInicio', TRUE);
        $formDataFim = $this->input->post('formDataFim', TRUE);
        $formItem = $this->input->post('formItem', TRUE);
        $formSomaQuantidade = $this->input->post('formSomaQuantidade', TRUE);
        $formTipo = $this->input->post('formTipo', TRUE);

        // Transformando data para formato do MySQL
        $data_inicio_mysql = data_normal_para_MySQL($formDataInicio);
        $data_fim_mysql = data_normal_para_MySQL($formDataFim);

        // Validando formato da data.
        if (validar_data($formDataInicio, 'd/m/Y') && validar_data($formDataFim, 'd/m/Y')) {
            // Busca pelo data
            if ($formDestino == 0 && $formTipo == 0 && $formItem == 0) {
                $dados['saidas'] = $this->model_saida_itens->ler_saidas_data($data_inicio_mysql, $data_fim_mysql, $formSomaQuantidade);
            } // Busca pela data e destino.
            else if ($formDestino != 0 && $formTipo == 0 && $formItem == 0) {
                $dados['saidas'] = $this->model_saida_itens->ler_saidas_data_destino($data_inicio_mysql, $data_fim_mysql, $formDestino, $formSomaQuantidade);
            } // Busca pela data, destino, tipo.
            else if ($formDestino != 0 && $formTipo != 0 && $formItem == 0) {
                $dados['saidas'] = $this->model_saida_itens->ler_saidas_data_destino_tipo($data_inicio_mysql, $data_fim_mysql, $formDestino, $formTipo, $formSomaQuantidade);
            } // Busca pela data, destino, tipo e item.
            else if ($formDestino != 0 && $formTipo != 0 && $formItem != 0) {
                $dados['saidas'] = $this->model_saida_itens->ler_saidas_data_destino_tipo_item($data_inicio_mysql, $data_fim_mysql, $formDestino, $formTipo, $formItem, $formSomaQuantidade);
            } // Busca pelo tipo.
            else if ($formDestino == 0 && $formTipo != 0 && $formItem == 0) {
                $dados['saidas'] = $this->model_saida_itens->ler_saidas_data_tipo($data_inicio_mysql, $data_fim_mysql, $formTipo, $formSomaQuantidade);
            } // Busca pelo tipo e item.
            else if ($formDestino == 0 && $formTipo != 0 && $formItem != 0) {
                $dados['saidas'] = $this->model_saida_itens->ler_saidas_data_tipo_item($data_inicio_mysql, $data_fim_mysql, $formTipo, $formItem, $formSomaQuantidade);
            }
        } else {
            $dados['erro'] = 1;
            $dados['erro_mensagem'] = 'O formato das <b>datas</b> inseridas é invalida.';
        }

        // Lendo dados do banco de dados.
        $dados['destinos'] = $this->model_saida_itens->ler_destinos();
        $dados['itens'] = $this->model_saida_itens->ler_itens();
        $dados['nome_destino'] = $this->model_saida_itens->ler_nome_destino($formDestino);
        $dados['nome_item'] = $this->model_saida_itens->ler_nome_item($formItem);
        $dados['nome_tipo'] = $this->model_saida_itens->ler_nome_tipo($formTipo);
        $dados['tipos'] = $this->model_saida_itens->ler_tipos();
        $dados['unidade_padrao'] = $this->unidades->ler_unidades_padrao();

        // Enviando dados para a view.
        $dados['formDataInicio'] = $formDataInicio;
        $dados['formDataFim'] = $formDataFim;
        $dados['formDestino'] = $formDestino;
        $dados['formItem'] = $formItem;
        $dados['formSomaQuantidade'] = $formSomaQuantidade;
        $dados['formTipo'] = $formTipo;
        $dados['nome_usuario'] = $this->nome_usuario;

        // EXPANDIR
        if ($this->uri->segment(5) == 'expandir' && $this->uri->segment(6) != 'pdf') {
            $this->load->view('painel/relatorio/saida_itens/view_expandir.php', $dados);
        } // PDF
        else if ($this->uri->segment(5) == 'expandir' && $this->uri->segment(6) == 'pdf') {
            $dados['data_hora'] = mdate('%d/%m/%Y %h:%i:%s', time());
            $this->load->view('painel/relatorio/saida_itens/view_expandir_pdf.php', $dados);
        } // INDEX
        else {
            if ($formDataInicio == NULL && $formDataFim == NULL) {
                $dados['saidas'] = $this->model_saida_itens->ler_saidas_data(Date('Y-m-d', strtotime("-7 days")), Date('Y-m-d'), false);
                $dados['formDataFim'] = data_MySQL_para_normal(Date('Y-m-d'));
                $dados['formDataInicio'] = data_MySQL_para_normal(Date('Y-m-d', strtotime("-7 days")));
            }
            $this->load->view('painel/relatorio/saida_itens/view_lista.php', $dados);
        }
    }
}

/* Fim do Arquivo: controller_saida_itens.php */
/* Localização: ./application/controllers/painel/relatorio/controller_saida_itens.php */
