<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Biblioteca do REST_Controller
require_once(APPPATH . '/libraries/REST_Controller.php');


/**
 * Controller responsável por tratar as requisições REST do menu 'inserir saída'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
class Controller_Inserir_Saida extends REST_Controller
{
    /**
     * Nome de usuário(username) do usuário.
     *
     * @var string
     */
    private $id_usuario;

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Construtor padrão.
     *
     * Verifica se o usuário está logado no sistema.
     */
    public function __construct()
    {
        parent::__construct();

        // Carregando módulos.
        $this->load->helper('data');
        $this->load->library('autenticacao');
        $this->load->library('api_comunicacao');
        $this->load->model('api_painel/saida/model_inserir_saida', 'model_inserir_saida');

        // Autenticando.
        $this->autenticacao->autentica();
        $this->id_usuario = $this->autenticacao->get_id_usuario();
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Requisição REST para inserir uma saída no sistema.
     *
     * url - {root}/api/painel/saida/inserirsaida/cadastrar
     */
    public function cadastrar_post()
    {
        // Capturando o corpo da mensagem.
        $saidas = json_decode(file_get_contents('php://input'));

        // Inserindo dados.
        $this->db->trans_start();

        if ($saidas && isset($saidas[0])) {
            // Verificando campos do json.
            if ($this->api_comunicacao->checarFormatacao(array('dataSaida', 'idDestino', 'idItem', 'idContrato', 'idTipo', 'valorQuantidade'), $saidas[0])) {
                $resposta = array();
                // Inserindo os dados no banco de dados.
                foreach ($saidas as $saida) {
                    $dataMySQL = data_normal_para_MySQL($saida->dataSaida);
                    array_push($resposta, $this->model_inserir_saida->inserir_saida($saida->idDestino, $saida->idItem, $saida->idContrato, $this->autenticacao->get_id_usuario(), $dataMySQL, $saida->valorQuantidade));
                }
                $this->api_comunicacao->setSucesso(TRUE);
                $this->api_comunicacao->setSucessoMensagem('Inserções realizadas com sucesso.');
                $this->api_comunicacao->setResposta($resposta);
            } // Erro: Parâmetros Incorretos.
            else {
                $this->api_comunicacao->setErro(TRUE);
                $this->api_comunicacao->setErroMensagem('Parâmetros Incorretos.');
            }
        } // Erro: JSON Mal Formatado.
        else {
            $this->api_comunicacao->setErro(TRUE);
            $this->api_comunicacao->setErroMensagem('JSON Mal Formatado.');
        }
        $this->db->trans_complete();

        // Sucesso.
        if ($this->db->trans_status()) {
            if ($this->api_comunicacao->isSucesso()) {
                $this->response($this->api_comunicacao->criarArray(), 200);
            } // Erro
            else {
                $this->response($this->api_comunicacao->criarArray(), 200);
            }
        } // Erro: Problema na inserção no banco de dados.
        else {
            $this->api_comunicacao->setErro(TRUE);
            $this->api_comunicacao->setErroMensagem('Erro na inserção da saída no banco de dados.');
            $this->response($this->api_comunicacao->criarArray(), 400);
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Requisição REST para retornar os itens cadastrados.
     *
     * url - {root}/api/painel/saida/inserirsaida/itens
     */
    public function itens_get()
    {
        $quantidade_itens = $this->model_inserir_saida->ler_itens();

        if ($quantidade_itens) {
            $this->api_comunicacao->setSucesso(TRUE);
            $this->api_comunicacao->setSucessoMensagem('Itens cadastrados.');
            $this->api_comunicacao->setResposta($quantidade_itens);
            $this->response($this->api_comunicacao->criarArray(), 200);
        } else {
            $this->api_comunicacao->setErro(TRUE);
            $this->api_comunicacao->setErroMensagem('Não há itens cadastrados.');
            $this->response($this->api_comunicacao->criarArray(), 400);
        }
    }
}

/* Fim do Arquivo: controller_inserir_saida.php */
/* Localização: ./application/controllers/api_painel/saida/controller_inserir_saida.php */
