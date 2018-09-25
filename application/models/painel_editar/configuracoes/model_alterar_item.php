<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model que manipulada os dados do menu 'alterar item'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
include_once APPPATH . '/models/tabelas/tabela_item.php';
include_once APPPATH . '/models/tabelas/tabela_tipo.php';
include_once APPPATH . '/models/tabelas/tabela.php';

class Model_Alterar_Item extends CI_Model
{
    /**
     * Atualiza os dados de um item cadastrado no banco de dados.
     *
     * @param $id_item Id do item.
     * @param $id_tipo Id do do tipo do item.
     * @param $nome Nome do item.
     * @param $descricao Descrição do item.
     * @param $unidade_padrao_id Id da unidade padrão do item.
     * @return bool Retorna verdadeiro caso a atualização tenha sido realizada com sucesso,
     *              senão retorna falso.
     */
    public function atualizar_item($id_item, $id_tipo, $nome, $descricao, $unidade_padrao_id)
    {
        $sql = ' UPDATE '
            . Tabela::ITEM
            . ' SET '
            . Tabela::ITEM . '.' . Tabela_Item::ID_TIPO . ' = ?, '
            . Tabela::ITEM . '.' . Tabela_Item::NOME . ' = ?, '
            . Tabela::ITEM . '.' . Tabela_Item::DESCRICAO . ' = ?, '
            . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID . ' = ? '
            . ' WHERE '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ?';

        $this->db->query($sql, array($id_tipo, $nome, $descricao, $unidade_padrao_id, $id_item));

        if ($this->db->affected_rows()) {
            return TRUE;
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Checa se um item existe.
     *
     * @param $id_item Id do item.
     * @return bool Retorna verdadeiro caso o item exista, se não retorna falso.
     */
    public function checar_item($id_item)
    {
        $sql = ' SELECT '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM
            . ' FROM '
            . Tabela::ITEM
            . ' WHERE '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ? ';

        $resultado = $this->db->query($sql, array($id_item));

        if ($resultado->num_rows() > 0) {
            return TRUE;
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Delete ou exclui um item cadastrado no banco de dados.
     *
     * @param $id_item ID do item.
     * @return bool Retorna verdadeiro caso a exclusão tenha sido realizada com sucesso,
     *              senão retorna falso.
     */
    public function excluir_item($id_item)
    {
        $sql = ' DELETE FROM '
            . Tabela::ITEM
            . ' WHERE '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ?';

        if ($this->db->query($sql, array($id_item))) {
            return TRUE;
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Retorna os dados de um item cadastrado no banco de dados.
     *
     * @param $id_item Id do item.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_item($id_item)
    {
        $sql = ' SELECT '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ', '
            . Tabela::ITEM . '.' . Tabela_Item::ID_TIPO . ', '
            . Tabela::ITEM . '.' . Tabela_Item::NOME . ', '
            . Tabela::ITEM . '.' . Tabela_Item::DESCRICAO . ', '
            . Tabela::ITEM . '.' . Tabela_Item::QUANTIDADE_TOTAL . ', '
            . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID . ', '
            . Tabela::TIPO . '.' . Tabela_Tipo::NOME . ' AS nome_tipo '
            . ' FROM '
            . Tabela::ITEM
            . ' INNER JOIN '
            . Tabela::TIPO
            . ' ON '
            . Tabela::TIPO . '.' . Tabela_Tipo::ID_TIPO . ' = ' . Tabela::ITEM . '.' . Tabela_Item::ID_TIPO
            . ' WHERE '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ? ';

        $resultado = $this->db->query($sql, array($id_item));

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
    public function ler_itens()
    {
        $sql = ' SELECT '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ', '
            . Tabela::ITEM . '.' . Tabela_Item::ID_TIPO . ', '
            . Tabela::ITEM . '.' . Tabela_Item::NOME . ', '
            . Tabela::ITEM . '.' . Tabela_Item::DESCRICAO . ', '
            . Tabela::ITEM . '.' . Tabela_Item::QUANTIDADE_TOTAL . ', '
            . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID
            . ' FROM '
            . Tabela::ITEM
            . ' ORDER BY '
            . Tabela::ITEM . '.' . Tabela_Item::NOME
            . ' ASC ';

        $resultado = $this->db->query($sql);

        if ($resultado) {
            return $resultado->result_array();
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
            . Tabela::TIPO . '.' . Tabela_Tipo::NOME
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

/* Fim do arquivo model_alterar_item.php */
/* Localização: ./application/models/painel_editar/configuracoes/model_alterar_item.php */