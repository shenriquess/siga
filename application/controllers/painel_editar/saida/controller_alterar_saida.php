<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller que manipula o menu 'Alterar Saída'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
class Controller_Alterar_Saida extends CI_Controller
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
        $this->load->model('painel_editar/saida/model_alterar_saida', 'model_alterar_saida');
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página para alterar o cadastro de uma saida.
     *
     * url - {root}/paineleditar/saida/alterarsaida/alterar/*
     */
    public function alterar()
    {
        $id_saida = $this->uri->segment(5);

        $this->form_validation->set_rules('formDataSaida', 'DATA SAÍDA', 'xss_clean|required');
        $this->form_validation->set_rules('formDestino', 'DESTINO', 'xss_clean|required');
        $this->form_validation->set_rules('formItem', 'ITEM', 'xss_clean|required');
        $this->form_validation->set_rules('formItemAntigo', 'ITEM ANTIGO', 'xss_clean|required');
        $this->form_validation->set_rules('formQuantidade', 'QUANTIDADE', 'xss_clean|required');

        // Inicializando variáveis.
        $dados['sucesso'] = FALSE;
        $dados['erro'] = FALSE;
        $dados['erro_mensagem'] = "";

        if ($this->form_validation->run()) {
            $form_item_antigo = $this->input->post('formItemAntigo', TRUE);
            $form_data_saida = $this->input->post('formDataSaida', TRUE);
            $form_destino = $this->input->post('formDestino', TRUE);
            $form_item = $this->input->post('formItem', TRUE);
            $form_contrato = $this->input->post('formContrato', TRUE);
            $form_quantidade = $this->input->post('formQuantidade', TRUE);

            if ($form_item != $form_item_antigo) {
                $quantidade_item = $this->model_alterar_saida->ler_quantidade_item($form_item);


                if (($quantidade_item['quantidade_total'] - $form_quantidade) >= 0) {
                    $data_saida_MySQL = data_normal_para_MySQL($form_data_saida);

                    $resultado = $this->model_alterar_saida->atualiza_saida($id_saida, $form_destino, $form_item, $form_contrato,$data_saida_MySQL, $form_quantidade);
                    if ($resultado) {
                        $this->model_alterar_saida->atualiza_quantidade_item($form_item_antigo);
                        $this->model_alterar_saida->atualiza_quantidade_item($form_item);
                        $dados['sucesso'] = TRUE;
                    } else {
                        $dados['erro'] = TRUE;
                        $dados['erro_mensagem'] = 'Houve um erro no momento da atualização dos dados da <b>Saída</b> no banco de dados.<br/>'
                            . 'Por favor, tente novamente';
                    }
                } else {
                    $dados['erro'] = TRUE;
                    $dados['erro_mensagem'] = 'Não há quantidade disponível do item <b>' . $quantidade_item['nome'] . '.</b>'
                        . '<br/>Quantidade disponível: ' . $quantidade_item['quantidade_total'] . ' ' . $this->unidades->ler_unidade_padrao($quantidade_item['unidade_padrao_id'])['nome'];
                }
            } else {
                $quantidade_item = $this->model_alterar_saida->ler_quantidade_item($form_item);
                $quantidade_saida = $this->model_alterar_saida->ler_quantidade_saida($id_saida);

                if (($quantidade_item['quantidade_total'] + $quantidade_saida - $form_quantidade) >= 0) {
                    $data_saida_MySQL = data_normal_para_MySQL($form_data_saida);

                    $resultado = $this->model_alterar_saida->atualiza_saida($id_saida, $form_destino, $form_item, $form_contrato, $data_saida_MySQL, $form_quantidade);
                    if ($resultado) {
                        $this->model_alterar_saida->atualiza_quantidade_item($form_item_antigo);
                        $this->model_alterar_saida->atualiza_quantidade_item($form_item);
                        $dados['sucesso'] = TRUE;
                    } else {
                        $dados['erro'] = TRUE;
                        $dados['erro_mensagem'] = 'Houve um erro no momento da atualização dos dados da <b>Saída</b> no banco de dados.<br/>'
                            . 'Por favor, tente novamente';
                    }
                } else {
                    $dados['erro'] = TRUE;
                    $dados['erro_mensagem'] = 'Não há quantidade disponível do item <b>' . $quantidade_item['nome'] . '.</b>'
                        . '<br/>Quantidade disponível: ' . $quantidade_item['quantidade_total'] . ' ' . $this->unidades->ler_unidade_padrao($quantidade_item['unidade_padrao_id'])['nome'];
                }
            }


        } else {
            $dados['erro'] = TRUE;
            $dados['erro_mensagem'] = validation_errors();
        }

        $dados['nome_usuario'] = $this->nome_usuario;
        $dados['url'] = $this->uri->uri_string();
        $resultado = $this->model_alterar_saida->ler_saida($id_saida);
        if ($resultado) {
            $dados['destinos'] = $this->model_alterar_saida->ler_destinos();
            $dados['itens'] = $this->model_alterar_saida->ler_itens();
            $dados['contratos'] = $this->model_alterar_saida->ler_contratos();
            $dados['tipos'] = $this->model_alterar_saida->ler_tipos();
            $dados['unidades'] = $this->unidades->ler_unidades_padrao();
            $dados['saida'] = $resultado;
            $this->load->view('painel_editar/saida/alterar_saida/view_alterar.php', $dados);
        } else {
            $this->load->view('painel_editar/saida/alterar_saida/view_inexistente.php', $dados);
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página de confirmação de exclusão de uma saída.
     *
     * url - {root}/paineleditar/saida/confirmarexcluir/confirmarexcluir/*
     */
    public function confirmarexcluir()
    {
        $id_saida = $this->uri->segment(5);

        $dados['nome_usuario'] = $this->nome_usuario;
        $resultado = $this->model_alterar_saida->ler_saida($id_saida);
        if ($resultado) {
            $dados['saida'] = $resultado;
            $dados['unidades'] = $this->unidades->ler_unidades_padrao();
            $this->load->view('painel_editar/saida/alterar_saida/view_confirmar_excluir.php', $dados);
        } else {
            $this->load->view('painel_editar/saida/alterar_saida/view_inexistente.php', $dados);
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página para excluir uma saída.
     *
     * url - {root}/paineleditar/saida/alterarsaida/excluir/*
     */
    public function excluir()
    {
        $id_saida = $this->uri->segment(5);

        // Inicializando variáveis.
        $dados['sucesso'] = FALSE;
        $dados['erro'] = FALSE;
        $dados['erro_mensagem'] = "";

        if ($id_saida) {
            $id_item = $this->model_alterar_saida->ler_id_item_saida($id_saida);
            $resultado = $this->model_alterar_saida->excluir_saida($id_saida);
            if ($resultado) {
                $this->model_alterar_saida->atualiza_quantidade_item($id_item);
                $dados['sucesso'] = TRUE;
            } else {
                $dados['erro'] = TRUE;
                $dados['erro_mensagem'] = "A saída escolhida não existe.";
            }
        } else {
            $dados['erro'] = TRUE;
            $dados['erro_mensagem'] = "A saída escolhida não existe.";
        }

        $dados['nome_usuario'] = $this->nome_usuario;
        $this->load->view('painel_editar/saida/alterar_saida/view_excluir.php', $dados);
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página que lista todos as saídas cadastradas.
     *
     * url - {root}/paineleditar/saida/alterarsaida/lista
     */
    public function lista()
    {
        $this->load->helper('text');

        $dados['saidas'] = $this->model_alterar_saida->ler_saidas();
        $dados['nome_usuario'] = $this->nome_usuario;
        $this->load->view('painel_editar/saida/alterar_saida/view_lista.php', $dados);
    }
}

/* Fim do arquivo controller_alterar_saida.php */
/* Localização: ./application/controllers/painel_editar/configuracoes/controller_alterar_saida.php */
