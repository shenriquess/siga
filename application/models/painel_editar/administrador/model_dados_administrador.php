<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model que manipulada os dados do menu 'dados administrador'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
include_once APPPATH . '/models/tabelas/tabela_usuario.php';
include_once APPPATH . '/models/tabelas/tabela.php';

class Model_Dados_Administrador extends CI_Model
{
    /**
     * Atualiza os dados do administrador cadastrado no banco de dados, sem considerando a senha
     *
     * @param $id_administrador Id do administrador.
     * @param $nome Nome completo do administrador.
     * @return bool Retorna verdadeiro caso a atualização tenha sido realizada com sucesso,
     *              senão retorna falso.
     */
    public function atualizar_administrador($id_administrador, $nome)
    {
        $sql = ' UPDATE '
            . Tabela::USUARIO
            . ' SET '
            . Tabela::USUARIO . '.' . Tabela_Usuario::NOME . ' = ? '
            . ' WHERE '
            . Tabela::USUARIO . '.' . Tabela_Usuario::ID_USUARIO . ' = ?';

        $this->db->query($sql, array($nome, $id_administrador));

        if ($this->db->affected_rows()) {
            return TRUE;
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Atualiza os dados do administrador cadastrado no banco de dados, considerando a senha
     *
     * @param $id_administrador Id do administrador.
     * @param $nome Nome completo do administrador.
     * @param $senha Senha do administrador.
     * @return bool Retorna verdadeiro caso a atualização tenha sido realizada com sucesso,
     *              senão retorna falso.
     */
    public function atualizar_administrador_senha($id_administrador, $nome, $senha)
    {
        $sql = ' UPDATE '
            . Tabela::USUARIO
            . ' SET '
            . Tabela::USUARIO . '.' . Tabela_Usuario::NOME . ' = ?, '
            . Tabela::USUARIO . '.' . Tabela_Usuario::SENHA . ' = MD5(?) '
            . ' WHERE '
            . Tabela::USUARIO . '.' . Tabela_Usuario::ID_USUARIO . ' = ?';

        $this->db->query($sql, array($nome, $senha, $id_administrador));

        if ($this->db->affected_rows()) {
            return TRUE;
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Retorna os dados de um usuário cadastrado no banco de dados.
     *
     * @param $id_administrador Id do usuário.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_usuario($id_administrador)
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

        $resultado = $this->db->query($sql, array($id_administrador));

        if ($resultado) {
            return $resultado->row_array();
        }

        return FALSE;
    }
}

/* Fim do arquivo model_dados_administrador.php */
/* Localização: ./application/models/painel_editar/administrador/model_dados_administrador.php */