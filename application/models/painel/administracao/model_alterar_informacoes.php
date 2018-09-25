<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model utilizado no menu 'Alterar Informações'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
include_once APPPATH . '/models/tabelas/tabela_usuario.php';
include_once APPPATH . '/models/tabelas/tabela.php';

class Model_Alterar_Informacoes extends CI_Model
{
    /**
     * Verifica o usuário no banco de dados. Caso exista pega as informações do usuário.
     *
     * @param $nome_usuario Login do usuário.
     * @param $senha Senha do usuário em MD5.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_usuario($nome_usuario, $senha)
    {
        if ($nome_usuario != NULL && $senha != NULL) {
            // SQL Query
            $sql = 'SELECT * FROM ' . Tabela::USUARIO
                . ' WHERE '
                . Tabela_Usuario::NOME_USUARIO . ' =? '
                . ' AND '
                . Tabela_Usuario::SENHA . '=?';
            $resultado = $this->db->query($sql, array($nome_usuario, $senha));

            if ($resultado->num_rows() > 0) {
                return $resultado->row_array();
            }
        }

        return FALSE;
    }
}

/* Fim do arquivo model_login.php */
/* Localização: ./application/models/model_login.php */