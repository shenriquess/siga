<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Biblioteca do REST_Controller
require_once(APPPATH . '/libraries/REST_Controller.php');

/**
 * Controller responsável por tratar as requisições REST do menu 'cadastrar contrato'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
class Controller_Cadastrar_Contrato extends REST_Controller
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

        // Carregando componentes.
        $this->load->helper('data');
        $this->load->library('api_comunicacao');
        $this->load->library('autenticacao');
        $this->load->model('api_painel/configuracoes/model_cadastrar_contrato', 'model_cadastrar_contrato');

        // Verificando credenciais.
        $this->autenticacao->autentica();
        if (!$this->autenticacao->verificar_permissao(array(0, 1, 2))) {
            redirect(base_url('/painel/home'));
        }

        // Lendo nome de usuário.
        $this->nome_usuario = $this->autenticacao->get_nome_usuario();

    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Adiciona mais itens a um contrato existente.
     *
     * url - {root}/api/painel/configuracoes/cadastrarcontrato/adicionar
     */
    public function adicionar_post()
    {
        // Capturando o corpo da mensagem.
        $itens_contrato = json_decode(file_get_contents('php://input'), TRUE);

        // Inicializando resposta.
        $resposta = array();

        // Inserindo dados.
        $this->db->trans_start();
        if ($itens_contrato && isset($itens_contrato[0])) {
            $verificar_json = $this->api_comunicacao->checarFormatacao(array('idFornecedor', 'codigo', 'dataInicio', 'dataFim', 'idTipo', 'idItem', 'valorQuantidade', 'valorPreco'), $itens_contrato[0]);
            // Sucesso: JSON bem formatado.
            if ($verificar_json == TRUE) {
                // Lendo id do contrato.
                $id_contrato = $this->model_cadastrar_contrato->ler_id_contrato($itens_contrato[0]['codigo']);
                foreach ($itens_contrato as $item_contrato) {
                    array_push($resposta, $this->model_cadastrar_contrato->inserir_item_contrato($id_contrato, $item_contrato['idItem'], $item_contrato['valorPreco'], $item_contrato['valorQuantidade']));
                }
            } // Erro: Os campos não há os campos obrigatórios no json.
            else {
                $this->api_comunicacao->setErro(TRUE);
                $this->api_comunicacao->setErroMensagem('Parâmetros inválidos');
            }
        } // Erro: Json mal formatado.
        else {
            $this->api_comunicacao->setErro(TRUE);
            $this->api_comunicacao->setErroMensagem('Parâmetros inválidos');
        }
        $this->db->trans_complete();

        // Sucesso
        if ($this->db->trans_complete() == TRUE) {
            // Sucesso
            if ($this->api_comunicacao->isErro() == FALSE) {
                $this->api_comunicacao->setSucesso(TRUE);
                $this->api_comunicacao->setSucessoMensagem('Contrato cadastrado com sucesso.');
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
     * Realiza o cadastro de um contrato com seus respetivos itens do contrato.
     *
     * url - {root}/api/painel/configuracoes/cadastrarcontrato/cadastrar
     */
    public function cadastrar_post()
    {
        // Capturando o corpo da mensagem.
        $itens_contrato = json_decode(file_get_contents('php://input'), TRUE);

        // Incializando variáveis.
        $cadastro_contrato = FALSE;
        $id_contrato = 0;
        $resposta = array();

        // Inserindo dados.
        $this->db->trans_start();
        if ($itens_contrato && isset($itens_contrato[0])) {
            $verificar_json = $this->api_comunicacao->checarFormatacao(array('idFornecedor', 'codigo', 'dataInicio', 'dataFim', 'idTipo', 'idItem', 'valorQuantidade', 'valorPreco'), $itens_contrato[0]);
            // Sucesso: JSON bem formatado.
            if ($verificar_json == TRUE) {
                foreach ($itens_contrato as $item_contrato) {
                    // Cadastrando o contrado
                    if ($cadastro_contrato == FALSE) {
                        if ($this->model_cadastrar_contrato->ler_id_contrato($item_contrato['codigo'])) {
                            $this->api_comunicacao->setErro(TRUE);
                            $this->api_comunicacao->setErroMensagem('O código do contrato já cadastrado.');
                            break;
                        }
                        $dataInicioMySQL = data_normal_para_MySQL($item_contrato['dataInicio']);
                        $dataFimMySQL = data_normal_para_MySQL($item_contrato['dataFim']);
                        $id_contrato = $this->model_cadastrar_contrato->inserir_contrato($item_contrato['idFornecedor'], $item_contrato['codigo'], $dataInicioMySQL, $dataFimMySQL);
                        $cadastro_contrato = TRUE;
                    }
                    // Cadastrado os itens do contrato.
                    array_push($resposta, $this->model_cadastrar_contrato->inserir_item_contrato($id_contrato, $item_contrato['idItem'], $item_contrato['valorPreco'], $item_contrato['valorQuantidade']));
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
                $this->api_comunicacao->setSucessoMensagem('Contrato cadastrado com sucesso.');
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
     * Lê os dados de um contrato.
     *
     * url - {root}/api/painel/configuracoes/cadastrarcontrato/lerdadoscontrato
     */
    public function lerdadoscontrato_get()
    {
        $formCodigo = $this->input->get('formCodigo', TRUE);

        $resultado = $this->model_cadastrar_contrato->ler_dados_contrato($formCodigo);

        // Encontrou um contrato com o código especificado.
        if ($resultado && $formCodigo) {
            $this->api_comunicacao->setSucesso(TRUE);
            $this->api_comunicacao->setSucessoMensagem("Contrato encontrado.");
            $this->api_comunicacao->setResposta($resultado);
            $this->response($this->api_comunicacao->criarArray(), 200);
        } // Não encontrou um contrato com o código especificado.
        else if ($resultado == FALSE && $formCodigo != NULL) {
            $this->api_comunicacao->setErro(TRUE);
            $this->api_comunicacao->setErroMensagem("Contrato não encontrado.");
            $this->response($this->api_comunicacao->criarArray(), 200);
        } // Erro
        else {
            $this->api_comunicacao->setErro(TRUE);
            $this->api_comunicacao->setErroMensagem('Parâmetros inválidos');
            $this->response($this->api_comunicacao->criarArray(), 400);
        }
    }
}

/* Fim do arquivo controller_cadastrar_contrato.php */
/* Localização: ./application/controllers/api_painel/configuracoes/controller_cadastrar_contrato.php */

