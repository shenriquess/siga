<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller que manipula o menu 'Alterar Entrada'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
class Controller_Alterar_Entrada extends CI_Controller
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
     * Verifica se o usuário(Admin está logado no sistema).
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->library('autenticacao');
        $this->autenticacao->autentica();

        // Verificando permissão para o usuário.
        if (!$this->autenticacao->verificar_permissao(array(0))) {
            redirect(base_url('/painel/home'));
        }
        $this->nome_usuario = $this->autenticacao->get_nome_usuario();

        // Carregando model.
        $this->load->helper('data');
        $this->load->library('unidades');
        $this->load->model('painel_editar/entrada/model_alterar_entrada', 'model_alterar_entrada');
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página para alterar o cadastro de uma entrada.
     *
     * url - {root}/paineleditar/entrada/alterarentrada/alterar/*
     */
    public function alterar()
    {
        $id_entrada = $this->uri->segment(5);

        $this->form_validation->set_rules('formDataEntrada', 'DATA ENTRADA', 'xss_clean|required');
        $this->form_validation->set_rules('formItem', 'ITEM', 'xss_clean|required');
        $this->form_validation->set_rules('formItemAntigo', 'ITEM ANTIGO', 'xss_clean|required');
        $this->form_validation->set_rules('formNumeroNota', 'NÚMERO NOTA', 'xss_clean|required');
        $this->form_validation->set_rules('formQuantidade', 'QUANTIDADE', 'xss_clean|required');

        // Inicializando variáveis.
        $dados['sucesso'] = FALSE;
        $dados['erro'] = FALSE;
        $dados['erro_mensagem'] = "";

        if ($this->form_validation->run()) {
            $form_data_entrada = $this->input->post('formDataEntrada', TRUE);
            $form_item = $this->input->post('formItem', TRUE);
            $form_item_antigo = $this->input->post('formItemAntigo', TRUE);
            $form_numero_nota = $this->input->post('formNumeroNota', TRUE);
            $form_quantidade = $this->input->post('formQuantidade', TRUE);

            $id_item_contrato = $this->model_alterar_entrada->ler_id_item_contrato($id_entrada);
            $quantidade_falta = $this->model_alterar_entrada->verifica_quantidade_contrato($id_item_contrato);
            $quantidade_entrada = $this->model_alterar_entrada->ler_quantidade_entrada($id_entrada);

            if (($quantidade_falta + $quantidade_entrada['quantidade'] - $form_quantidade) >= 0) {
                $data_entrada_MySQL = data_normal_para_MySQL($form_data_entrada);

                $resultado = $this->model_alterar_entrada->atualiza_entrada($id_entrada, $form_numero_nota, $form_quantidade, $data_entrada_MySQL);
                if ($resultado) {
                    $this->model_alterar_entrada->atualiza_quantidade_item($form_item_antigo);
                    $this->model_alterar_entrada->atualiza_quantidade_item($form_item);
                    $dados['sucesso'] = TRUE;
                } else {
                    $dados['erro'] = TRUE;
                    $dados['erro_mensagem'] = 'Houve um erro no momento da atualização dos dados da <b>Entrada</b> no banco de dados.<br/>'
                        . 'Por favor, tente novamente';
                }
            } else {
                $dados['erro'] = TRUE;
                $dados['erro_mensagem'] = 'A quantidade de item <b>' . $quantidade_entrada['nome'] . '</b> supera a quantidade contratada.<br/>'
                    . 'Quantidade restante: ' . $quantidade_falta . ' ' . $this->unidades->ler_unidade_padrao($quantidade_entrada['unidade_padrao_id'])['nome'] . '<br/>'
                    . 'Por favor, tente novamente';
            }
        } else {
            $dados['erro'] = TRUE;
            $dados['erro_mensagem'] = validation_errors();
        }

        $dados['nome_usuario'] = $this->nome_usuario;
        $dados['url'] = $this->uri->uri_string();
        $resultado = $this->model_alterar_entrada->ler_entrada($id_entrada);
        if ($resultado) {
            $dados['unidades'] = $this->unidades->ler_unidades_padrao();
            $dados['tipos'] = $this->model_alterar_entrada->ler_tipos();
            $dados['itens'] = $this->model_alterar_entrada->ler_itens();
            $dados['entrada'] = $resultado;
            $this->load->view('painel_editar/entrada/alterar_entrada/view_alterar.php', $dados);
        } else {
            $this->load->view('painel_editar/entrada/alterar_entrada/view_inexistente.php', $dados);
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página de confirmação de exclusão de uma entrada.
     *
     * url - {root}/paineleditar/entrada/confirmarexcluir/confirmarexcluir/*
     */
    public function confirmarexcluir()
    {
        $id_entrada = $this->uri->segment(5);

        $dados['nome_usuario'] = $this->nome_usuario;
        $resultado = $this->model_alterar_entrada->ler_entrada($id_entrada);
        if ($resultado) {
            $dados['entrada'] = $resultado;
            $dados['unidades'] = $this->unidades->ler_unidades_padrao();
            $this->load->view('painel_editar/entrada/alterar_entrada/view_confirmar_excluir.php', $dados);
        } else {
            $this->load->view('painel_editar/entrada/alterar_entrada/view_inexistente.php', $dados);
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página para excluir uma entrada.
     *
     * url - {root}/paineleditar/entrada/alterarentrada/excluir/*
     */
    public function excluir()
    {
        $id_entrada = $this->uri->segment(5);

        // Inicializando variáveis.
        $dados['sucesso'] = FALSE;
        $dados['erro'] = FALSE;
        $dados['erro_mensagem'] = "";

        if ($id_entrada) {
            $id_item = $this->model_alterar_entrada->ler_item_entrada($id_entrada);
            $resultado = $this->model_alterar_entrada->excluir_entrada($id_entrada);
            if ($resultado) {
                $this->model_alterar_entrada->atualiza_quantidade_item($id_item);
                $dados['sucesso'] = TRUE;
            } else {
                $dados['erro'] = TRUE;
                $dados['erro_mensagem'] = "A entrada escolhida não existe.";
            }
        } else {
            $dados['erro'] = TRUE;
            $dados['erro_mensagem'] = "A entrada escolhida não existe.";
        }

        $dados['nome_usuario'] = $this->nome_usuario;
        $this->load->view('painel_editar/entrada/alterar_entrada/view_excluir.php', $dados);
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página que lista todos as entradas cadastradas.
     *
     * url - {root}/paineleditar/entrada/alterarentrada/lista
     */
    public function lista()
    {
        $this->load->helper('text');

        $dados['entradas'] = $this->model_alterar_entrada->ler_entradas();
        $dados['unidades'] = $this->unidades->ler_unidades_padrao();
        $dados['nome_usuario'] = $this->nome_usuario;
        $this->load->view('painel_editar/entrada/alterar_entrada/view_lista.php', $dados);
    }
}

/* Fim do arquivo controller_alterar_entrada.php */
/* Localização: ./application/controllers/painel_editar/entrada/controller_alterar_entrada.php */
