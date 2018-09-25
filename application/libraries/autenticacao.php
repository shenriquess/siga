<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Classe para armazenar as variáveis das credenciais dos usuários.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
class Autenticacao
{
    /**
     * ID do usuário.
     *
     * @var int $id_usuario
     */
    private $id_usuario;
    /**
     * Se o usuário está ou não logado no sistema.
     *
     * @var bool $logado
     */
    private $logado;
    /**
     * Verifica se o usuário está no modo administrador.
     *
     * @var bool $modo_admin
     */
    private $modo_admin;
    /**
     * Nível de acesso concedio para o usuário.
     *
     * @var string $nivel
     */
    private $nivel;
    /**
     * Nome do usuário.
     *
     * @var string $nome
     */
    private $nome;
    /**
     * Username do usuário.
     *
     * @var string $nome_usuario
     */
    private $nome_usuario;
    /**
     * Senha do usuário.
     *
     * @var string $senha
     */
    private $senha;

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Verifica a autenticação do usuário no sistema.
     */
    public function autentica()
    {
        // Instância CI.
        $CI =& get_instance();

        // Dados da sessão.
        $dados_acesso = $CI->session->all_userdata();

        // Armazenando credenciais.
        if( isset($dados_acesso['logado'])) {
            $this->id_usuario = $dados_acesso['id_usuario'];
            $this->nome = $dados_acesso['nome'];
            $this->nome_usuario = $dados_acesso['nome_usuario'];
            $this->senha = $dados_acesso['senha'];
            $this->nivel = $dados_acesso['nivel'];
            $this->logado = $dados_acesso['logado'];
            $this->modo_admin = $dados_acesso['modo_admin'];
        } else {
            redirect(base_url());
        }

        if (!$this->logado) {
            redirect(base_url());
        }
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Verificar se o usuário tem permissão para acessar a página.
     *
     * @param array $nivel_permissao Array com os níveis de usuários permitidos.
     * @return bool Retorna verdadeiro caso o usuário tenha permissão e falso caso não tenha.
     */
    public function verificar_permissao($nivel_permissao)
    {
        foreach ($nivel_permissao as $nivel) {
            if ($this->nivel == $nivel) {
                return TRUE;
            }
        }
        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Retorna o id do usuário que está logado no sistema.
     *
     * @return int Retorna o id do usuário que está logado no sistema.
     */
    public function get_id_usuario()
    {
        return $this->id_usuario;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Retorna se o usuário está no modo administrador.
     *
     * @return bool Retorna se o usuário está no modo administrador.
     */
    public function get_modo_admin() {
        return $this->modo_admin;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Retorna o nível do usuário que está logado no sistema.
     *
     * @access public
     * @return string Retorna o nível do usuário que está logado no sistema.
     */
    public function get_nivel() {
        return $this->nivel;
    }

    //------------------------------------------------------------------------------------------------------------------
    /**
     * Retorna o nome do usuário que está logado no sistema.
     *
     * @access public
     * @return string Retorna o nome do usuário que está logado no sistema.
     */
    public function get_nome() {
        return $this->nome;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Retorna o nome do usuário que está logado no sistema.
     *
     * @access public
     * @return string Retorna o nome do usuário.
     */
    public function get_nome_usuario()
    {
        return $this->nome_usuario;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Retorna a senha do usuário que está logado no sistema.
     *
     * @access public
     * @return string Retorna a senha do usuário que está logado no sistema.
     */
    public function get_senha() {
        return $this->senha;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Retorna se o usuário está logado no sistema.
     *
     * @access public
     * @return bool Retorna se o usuário está logado no sistema.
     */
    public function get_logado() {
        return $this->logado;
    }
}

/* Fim do arquivo autenicacao.php */
/* Localização: ./application/libraries/autenticacao.php */