<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Biblioteca do REST_Controller
require_once(APPPATH . '/libraries/REST_Controller.php');


/**
 * Controller responsável por tratar as requisições REST do menu 'inserir entrada'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
class Controller_Inserir_Entrada extends REST_Controller
{
    /**
     * Nome de usuário(username) do usuário.
     *
     * @var string
     */
    private $id_usuario;

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
        $this->load->model('api_painel/entrada/model_inserir_entrada', 'model_inserir_entrada');

        // Verificando credenciais.
        $this->autenticacao->autentica();
        if (!$this->autenticacao->verificar_permissao(array(0, 1, 2))) {
            redirect(base_url('/painel/home'));
        }
        $this->id_usuario = $this->autenticacao->get_id_usuario();
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página de para inserção das entradas do sistema.
     *
     * url - {root}/api/painel/entrada/inserirentrada/cadastrar
     */
    public function cadastrar_post()
    {
        // Capturando o corpo da mensagem.
        $entradas = json_decode(file_get_contents('php://input'));

        $resposta = array();

        // Inserindo dados.
        $this->db->trans_start();
        if ($entradas && isset($entradas[0])) {
            if ($this->api_comunicacao->checarFormatacao(array('idItemContrato', 'idContrato', 'numeroNota', 'dataEntrada', 'valorQuantidade'), $entradas[0])) {
                foreach ($entradas as $entrada) {
                    $data_entrada_MySQL = data_normal_para_MySQL($entrada->dataEntrada);
                    $valor_item_contrato = $this->model_inserir_entrada->ler_valor_item_contrato($entrada->idItemContrato);
                    array_push($resposta,
                        $this->model_inserir_entrada->inserir_entrada(
                            $entrada->idItemContrato,
                            $this->id_usuario,
                            $entrada->numeroNota,
                            $entrada->valorQuantidade,
                            $data_entrada_MySQL,
                            $valor_item_contrato
                        ));
                }
            } // Erro: Os campos não há os campos obrigatórios no json.
            else {
                $this->api_comunicacao->setErro(TRUE);
                $this->api_comunicacao->setErroMensagem('Parâmetros inválidos');
            }
        } // Erro: Json mal formatado.
        else {
            $this->api_comunicacao->setErro(TRUE);
            $this->api_comunicacao->setErroMensagem('JSON Mal Formatado');
        }
        $this->db->trans_complete();


        // Sucesso
        if ($this->db->trans_complete() == TRUE) {
            // Sucesso
            if ($this->api_comunicacao->isErro() == FALSE) {
                $this->api_comunicacao->setSucesso(TRUE);
                $this->api_comunicacao->setSucessoMensagem('Entrada cadastrada com sucesso.');
                $this->api_comunicacao->setResposta($resposta);
                $this->response($this->api_comunicacao->criarArray(), 200);
            } // Erro: Exibir erros.
            else {
                $this->response($this->api_comunicacao->criarArray(), 200);
            }
        } // Erro: Problema na inserção do banco de dados.
        else {
            $this->api_comunicacao->setErro(TRUE);
            $this->api_comunicacao->setErroMensagem('Erro na inserção do banco de dados.');
            $this->response($this->api_comunicacao->criarArray(), 400);
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Retorna a data de vigência de um contrato.
     *
     * url - {root}/api/painel/entrada/datavigencia?idContrato=*
     */
    public function datavigencia_get()
    {
        $id_contrato = $this->input->get('idContrato', TRUE);
        $resultado = $this->model_inserir_entrada->ler_vigencia_contrato($id_contrato);

        if ($resultado) {
            $this->api_comunicacao->setSucesso(TRUE);
            $this->api_comunicacao->setSucessoMensagem('Data de vigência do contrato selecionado');
            $this->api_comunicacao->setResposta($resultado);
            $this->response($this->api_comunicacao->criarArray(), 200);
        } else {
            $this->api_comunicacao->setErro(TRUE);
            $this->api_comunicacao->setErroMensagem('Não há registros de data de vigência para o contrato selecionado.');
            $this->response($this->api_comunicacao->criarArray(), 400);
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Retorna todos os itens de um contrato.
     *
     * @url {root}/api/painel/entrada/inserirentrada/itenscontrato?idContrato=*
     */
    public function itenscontrato_get()
    {
        $id_contrato = $this->input->get('idContrato', TRUE);
        $resultado = $this->model_inserir_entrada->ler_itens_contrato($id_contrato);

        if ($resultado) {
            $this->api_comunicacao->setSucesso(TRUE);
            $this->api_comunicacao->setSucessoMensagem('Itens do contrato selecionado');
            $this->api_comunicacao->setResposta($resultado);
            $this->response($this->api_comunicacao->criarArray(), 200);
        } else {
            $this->api_comunicacao->setErro(TRUE);
            $this->api_comunicacao->setErroMensagem('Não há registros de itens para este contrato.');
            $this->response($this->api_comunicacao->criarArray(), 400);
        }
    }
}

/* Fim do Arquivo: controller_entrada.php */
/* Localização: ./application/controllers/api_painel/controller_entrada.php */


