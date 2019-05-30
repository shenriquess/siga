<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model que manipulada os dados do menu 'alterar tipo'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
include_once APPPATH . '/models/tabelas/tabela_tipo.php';
include_once APPPATH . '/models/tabelas/tabela.php';

class Model_Alterar_Tipo extends CI_Model
{
    /**
     * Atualiza os dados de um tipo cadastrado no banco de dados.
     *
     * @param $id_tipo Id do tipo.
     * @param $nome Nome do tipo.
     * @param $descricao Descrição do tipo.
     * @return bool Retorna verdadeiro caso a atualização tenha sido realizada com sucesso,
     *              senão retorna falso.
     */
    public function atualizar_tipo($id_tipo, $nome, $descricao)
    {
        $sql = ' UPDATE '
            . Tabela::TIPO
            . ' SET '
            . Tabela::TIPO . '.' . Tabela_Tipo::NOME . ' = ?, '
            . Tabela::TIPO . '.' . Tabela_Tipo::DESCRICAO . ' = ? '
            . ' WHERE '
            . Tabela::TIPO . '.' . Tabela_Tipo::ID_TIPO . ' = ?';

        $this->db->query($sql, array($nome, $descricao, $id_tipo));

        if ($this->db->affected_rows()) {
            return TRUE;
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Checa se um tipo existe.
     *
     * @param $id_tipo Id do tipo.
     * @return bool Retorna verdadeiro caso o tipo exista, se não retorna falso.
     */
    public function checar_tipo($id_tipo)
    {
        $sql = ' SELECT '
            . Tabela::TIPO . '.' . Tabela_Tipo::ID_TIPO
            . ' FROM '
            . Tabela::TIPO
            . ' WHERE '
            . Tabela::TIPO . '.' . Tabela_Tipo::ID_TIPO . ' = ? ';

        $resultado = $this->db->query($sql, array($id_tipo));

        if ($resultado->num_rows() > 0) {
            return TRUE;
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Delete ou exclui um tipo cadastrado no banco de dados.
     *
     * @param $id_tipo ID do tipo.
     * @return bool Retorna verdadeiro caso a exclusão tenha sido realizada com sucesso,
     *              senão retorna falso.
     */
    public function excluir_tipo($id_tipo)
    {
        $this->db->where('id_tipo', $id_tipo);
        $test = $this->db->get('item');
        $sql = ' DELETE FROM '
            . Tabela::TIPO
            . ' WHERE '
            . Tabela::TIPO . '.' . Tabela_Tipo::ID_TIPO . ' = ?';
        if (empty($test->result_array())) {
            $this->db->query($sql, array($id_tipo));
            return TRUE;
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Retorna os dados de um tipo cadastrado no banco de dados.
     *
     * @param $id_tipo Id do tipo.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_tipo($id_tipo)
    {
        $sql = ' SELECT '
            . Tabela::TIPO . '.' . Tabela_Tipo::ID_TIPO . ', '
            . Tabela::TIPO . '.' . Tabela_Tipo::NOME . ', '
            . Tabela::TIPO . '.' . Tabela_Tipo::DESCRICAO
            . ' FROM '
            . Tabela::TIPO
            . ' WHERE '
            . Tabela::TIPO . '.' . Tabela_Tipo::ID_TIPO . ' = ? ';

        $resultado = $this->db->query($sql, array($id_tipo));

        if ($resultado) {
            return $resultado->row_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Retorna os dados de todos os tipos cadastrados no banco de dados.
     *
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_tipos()
    {
        $sql = ' SELECT '
            . Tabela::TIPO . '.' . Tabela_Tipo::ID_TIPO . ', '
            . Tabela::TIPO . '.' . Tabela_Tipo::NOME . ', '
            . Tabela::TIPO . '.' . Tabela_Tipo::DESCRICAO
            . ' FROM '
            . Tabela::TIPO
            . ' ORDER BY '
            . Tabela::TIPO . '.' . Tabela_Tipo::NOME
            . ' ASC ';

        $resultado = $this->db->query($sql);

        if ($resultado) {
            return $resultado->result_array();
        }

        return FALSE;
    }
}

/* Fim do arquivo model_alterar_tipo.php */
/* Localização: ./application/models/painel_editar/configuracoes/model_alterar_tipo.php */
