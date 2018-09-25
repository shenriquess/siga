<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// Biblioteca do REST_Controller
require_once(APPPATH . '/libraries/REST_Controller.php');


/**
 * Controller responsável por tratar as requisições REST do menu 'alterar entrada'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
class Controller_Alterar_Entrada extends REST_Controller
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
        $this->load->model('api_painel_editar/entrada/model_alterar_entrada', 'model_alterar_entrada');

        // Verificando credenciais.
        $this->autenticacao->autentica();
        if (!$this->autenticacao->verificar_permissao(array(0, 1, 2))) {
            redirect(base_url('/painel/home'));
        }
        $this->id_usuario = $this->autenticacao->get_id_usuario();
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Retorna a data de vigência de um contrato.
     *
     * url - {root}/api/paineleditar/entrada/alterarentrada/datavigencia?idContrato=*
     */
    public function datavigencia_get()
    {
        $id_contrato = $this->input->get('idContrato', TRUE);
        $resultado = $this->model_alterar_entrada->ler_vigencia_contrato($id_contrato);

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
}

/* Fim do Arquivo: controller_entrada.php */
/* Localização: ./application/controllers/api_painel_editar/controller_alterar_entrada.php */


