<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model que manipulada os dados do menu 'cadastrar usuário'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
include_once APPPATH . '/models/tabelas/tabela_usuario.php';
include_once APPPATH . '/models/tabelas/tabela.php';

class Model_Cadastrar_Usuario extends CI_Model
{
    /**
     * Insere um usuário no banco de dados.
     *
     * @param string $nome Nome do usuário.
     * @param string $nome_usuario Login do usuário.
     * @param string $senha Senha do usuário.
     * @param int $nivel Nível de permissão do usuário. (0 - admin, 1 - Nível 1, 2 - Nível 2)
     * @return bool|array   Retorna verdadeiro caso a inserção tenha sido realizada com sucesso, e falso
     *                      caso houve algum problema no momento da inserção.
     */
    public function inserir_usuario($nome, $nome_usuario, $senha, $nivel)
    {
        if ($nome != NULL && $nome_usuario != NULL && $senha != NULL && $nivel >= 0) {
            // SQL Query
            $sql = ' INSERT INTO '
                . Tabela::USUARIO
                . ' ('
                . Tabela_Usuario::NOME . ', '
                . Tabela_Usuario::NOME_USUARIO . ', '
                . Tabela_Usuario::SENHA . ', '
                . Tabela_Usuario::NIVEL
                . ') '
                . 'VALUES (?, ?, MD5(?), ?)';
            $this->db->query($sql, array($nome, $nome_usuario, $senha, $nivel));

            if ($this->db->affected_rows()) {
                return $this->db->insert_id();
            }
        }

        return FALSE;
    }
}

/* Fim do arquivo model_cadastrar_usuario.php */
/* Localização: ./application/models/painel/configuracoes/model_cadatrar_usuario.php */