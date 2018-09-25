<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Controller responsável por manipular o menu 'cadastrar item'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
class Controller_Cadastrar_Item extends CI_Controller
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
     * Página de configurações para cadastrar um item no sistema.
     *
     * url - {root}/painel/configuracoes/cadastraritem/cadastrar
     */
    public function cadastrar()
    {
        // Carregando Model do Menu Cadastrar Item;
        $this->load->model('painel/configuracoes/model_cadastrar_item', 'model_cadastrar_item');

        // Criando regras de validação.
        $this->form_validation->set_rules('formTipo', 'TIPO', 'xss_clean|required');
        $this->form_validation->set_rules('formItem', 'ITEM', 'xss_clean|required|is_unique[item.nome]');
        $this->form_validation->set_rules('formUnidadePadrao', 'UNIDADE PADRÃO', 'xss_clean|required');
        $this->form_validation->set_rules('formDescricao', 'DESCRIÇÃO', 'xss_clean');

        // Inicializando variáveis.
        $dados['sucesso'] = 0;
        $dados['erro'] = 0;

        // Validando os dados do formulário.
        if ($this->form_validation->run()) {
            $form_tipo = $this->input->post('formTipo', TRUE);
            $form_item = $this->input->post('formItem', TRUE);
            $form_unidade_padrao = $this->input->post('formUnidadePadrao', TRUE);
            $form_descricao = $this->input->post('formDescricao', TRUE);

            // Verificando inserção no banco de dados.
            if ($this->model_cadastrar_item->inserir_item($form_tipo, $form_item, $form_unidade_padrao, $form_descricao)) {
                $dados['sucesso'] = 1;
            } else {
                $dados['erro'] = 1;
                $dados['erro_mensagem'] = 'Houve um erro no momento da inserção do <b>Item</b> no banco de dados.<br/>'
                    . 'Por favor, tente novamente';
            }
        } else {
            $dados['erro'] = 1;
            $dados['erro_mensagem'] = validation_errors();
        }

        // Pega as unidades padrão previamente cadastradas em (libraries/unidades.php).
        $this->load->library('unidades');
        $dados['unidades_padrao'] = $this->unidades->ler_unidades_padrao();

        // Pegando os tipos cadastrados no banco de dados.
        $resultado = $this->model_cadastrar_item->ler_todos_tipos();
        if ($resultado) {

            //tranferi para o final deste if
            //$tipos = "";
            foreach ($resultado as $linha) {
                $tipos[$linha['id_tipo']] = $linha['nome'];
            }
            $dados['tipos'] = $tipos;
            // aqui
            $tipos = "";

        } else {
            $dados['erro'] = 1;
            $dados['erro_mensagem'] = 'Por favor, cadastre um <b>Tipo</b> primeiro.';
        }

        // Pegando nome do usuario (username).
        $dados['nome_usuario'] = $this->nome_usuario;
        $this->load->view('painel/configuracoes/cadastrar_item/view_cadastrar.php', $dados);
    }
}

/* Fim do arquivo controller_cadastrar_item.php */
/* Localização: ./application/controllers/painel/controller_cadastrar_item.php */
