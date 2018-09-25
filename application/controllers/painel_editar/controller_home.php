<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
class Controller_Home extends CI_Controller
{
    /**
     * Construtor padrão.
     *
     *      Verifica se o usuário está logado no sistema, caso não,
     *      retorna para a tela de login.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function home() {
        $this->load->view('painel_editar/home/view_index.php');
    }

}
