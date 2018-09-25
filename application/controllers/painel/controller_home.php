<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller responsável por manipular as telas iniciais do painel.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
class Controller_Home extends CI_Controller
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
     * Página inicial do painel.
     *
     * url - {root}/painel/index
     * @access public
     */
    public function index()
    {
        $dados['nome_usuario'] = $this->nome_usuario;
        $this->load->view('painel/home/view_index.php', $dados);
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Página inicial do painel.
     *
     * url - {root}/painel/home
     * @access public
     */
    public function home()
    {
        $dados['nome_usuario'] = $this->nome_usuario;
        $this->load->view('painel/home/view_index.php', $dados);
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Redireciona para a página de login do sistema.
     *
     * url - {root}/painel/login
     * @access public
     */
    public function login()
    {
        redirect(base_url());
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Realiza o logout do sistema.
     *
     * url - {root}/painel/login
     * @access public
     */
    public function logout()
    {
        $this->session->unset_userdata($this->session->all_userdata());
        redirect(base_url());
    }
}

