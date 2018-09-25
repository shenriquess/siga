<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model que manipulada os dados do menu 'alterar usuário'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
include_once APPPATH . '/models/tabelas/tabela_usuario.php';
include_once APPPATH . '/models/tabelas/tabela.php';

class Model_Alterar_Usuario extends CI_Model
{
    /**
     * Atualiza os dados de um usuário cadastrado no banco de dados, sem considerar a senha.
     *
     * @param $id_usuario Id do usuário
     * @param $nome Nome completo do usuário.
     * @param $nome_usuario Nome de usuário ou username.
     * @param $nivel Nivel.
     * @return bool Retorna verdadeiro caso a atualização tenha sido realizada com sucesso,
     *              senão retorna falso.
     */
    public function atualizar_usuario($id_usuario, $nome, $nome_usuario, $nivel)
    {
        $sql = ' UPDATE '
            . Tabela::USUARIO
            . ' SET '
            . Tabela::USUARIO . '.' . Tabela_Usuario::NOME . ' = ?, '
            . Tabela::USUARIO . '.' . Tabela_Usuario::NOME_USUARIO . ' = ?, '
            . Tabela::USUARIO . '.' . Tabela_Usuario::NIVEL . ' = ? '
            . ' WHERE '
            . Tabela::USUARIO . '.' . Tabela_Usuario::ID_USUARIO . ' = ?';

        $this->db->query($sql, array($nome, $nome_usuario, $nivel, $id_usuario));

        if ($this->db->affected_rows()) {
            return TRUE;
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Atualiza os dados de um usuário cadastrado no banco de dados, incluindo a senha deste usuário.
     *
     * @param $id_usuario Id do usuário
     * @param $nome Nome completo do usuário.
     * @param $nome_usuario Nome de usuário ou username.
     * @param $senha Senha.
     * @param $nivel Nivel.
     * @return bool Retorna verdadeiro caso a atualização tenha sido realizada com sucesso,
     *              senão retorna falso.
     */
    public function atualizar_usuario_senha($id_usuario, $nome, $nome_usuario, $senha, $nivel)
    {
        $sql = ' UPDATE '
            . Tabela::USUARIO
            . ' SET '
            . Tabela::USUARIO . '.' . Tabela_Usuario::NOME . ' = ?, '
            . Tabela::USUARIO . '.' . Tabela_Usuario::NOME_USUARIO . ' = ?, '
            . Tabela::USUARIO . '.' . Tabela_Usuario::SENHA . ' = MD5(?), '
            . Tabela::USUARIO . '.' . Tabela_Usuario::NIVEL . ' = ? '
            . ' WHERE '
            . Tabela::USUARIO . '.' . Tabela_Usuario::ID_USUARIO . ' = ?';

        $this->db->query($sql, array($nome, $nome_usuario, $senha, $nivel, $id_usuario));

        if ($this->db->affected_rows()) {
            return TRUE;
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Checa se um usuário existe.
     *
     * @param $id_usuario Id do tipo.
     * @return bool Retorna verdadeiro caso o usuário exista, se não retorna falso.
     */
    public function checar_usuario($id_usuario)
    {
        $sql = ' SELECT '
            . Tabela::USUARIO . '.' . Tabela_Usuario::ID_USUARIO
            . ' FROM '
            . Tabela::USUARIO
            . ' WHERE '
            . Tabela::USUARIO . '.' . Tabela_Usuario::ID_USUARIO . ' = ? ';

        $resultado = $this->db->query($sql, array($id_usuario));

        if ($resultado->num_rows() > 0) {
            return TRUE;
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Deleta ou exclui um usuário cadastrado no banco de dados.
     *
     * @param $id_usuario ID do usuário.
     * @return bool Retorna verdadeiro caso a exclusão tenha sido realizada com sucesso,
     *              senão retorna falso.
     */
    public function excluir_usuario($id_usuario)
    {
        $sql = ' DELETE FROM '
            . Tabela::USUARIO
            . ' WHERE '
            . Tabela::USUARIO . '.' . Tabela_Usuario::ID_USUARIO . ' = ?';

        if ($this->db->query($sql, array($id_usuario))) {
            return TRUE;
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Retorna os dados de um usuário cadastrado no banco de dados.
     *
     * @param $id_usuario Id do usuário.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_usuario($id_usuario)
    {
        $sql = ' SELECT '
            . Tabela::USUARIO . '.' . Tabela_Usuario::ID_USUARIO . ', '
            . Tabela::USUARIO . '.' . Tabela_Usuario::NOME . ', '
            . Tabela::USUARIO . '.' . Tabela_Usuario::NOME_USUARIO . ', '
            . Tabela::USUARIO . '.' . Tabela_Usuario::SENHA . ', '
            . Tabela::USUARIO . '.' . Tabela_Usuario::NIVEL
            . ' FROM '
            . Tabela::USUARIO
            . ' WHERE '
            . Tabela::USUARIO . '.' . Tabela_Usuario::ID_USUARIO . ' = ? ';

        $resultado = $this->db->query($sql, array($id_usuario));

        if ($resultado) {
            return $resultado->row_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Retorna os dados de todos os usuários cadastrados no banco de dados.
     *
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_usuarios()
    {
        $sql = ' SELECT '
            . Tabela::USUARIO . '.' . Tabela_Usuario::ID_USUARIO . ', '
            . Tabela::USUARIO . '.' . Tabela_Usuario::NOME . ', '
            . Tabela::USUARIO . '.' . Tabela_Usuario::NOME_USUARIO . ', '
            . Tabela::USUARIO . '.' . Tabela_Usuario::SENHA . ', '
            . Tabela::USUARIO . '.' . Tabela_Usuario::NIVEL
            . ' FROM '
            . Tabela::USUARIO
            . ' WHERE '
            . Tabela::USUARIO . '.' . Tabela_Usuario::NIVEL . ' > 0 '
            . ' ORDER BY '
            . Tabela::USUARIO . '.' . Tabela_Usuario::NOME;

        $resultado = $this->db->query($sql);

        if ($resultado) {
            return $resultado->result_array();
        }

        return FALSE;
    }
}

/* Fim do arquivo model_alterar_usuario.php */
/* Localização: ./application/models/painel_editar/configuracoes/model_alterar_usuario.php */