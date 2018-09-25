<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model utilizado no menu de relatórios 'Estoque Disponível'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */

include_once APPPATH . '/models/tabelas/tabela_contrato.php';
include_once APPPATH . '/models/tabelas/tabela_fornecedor.php';
include_once APPPATH . '/models/tabelas/tabela_item.php';
include_once APPPATH . '/models/tabelas/tabela_tipo.php';
include_once APPPATH . '/models/tabelas/tabela.php';

class Model_Estoque_Disponivel extends CI_Model
{
    /**
     * Retorna o estoque disponível de itens.
     *
     * @access public
     * @return bool|array Caso houve alguns resultados retornam eles, se não retorna falso.
     */
    public function itens_disponiveis($id_tipo)
    {
        // Caso tenha selecionado um tipo.
        if ($id_tipo != 0) {
            // SQL Query
            $sql = 'SELECT '
                . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ', '
                . Tabela::ITEM . '.' . Tabela_Item::NOME . ' as nome_item, '
                . Tabela::ITEM . '.' . Tabela_Item::QUANTIDADE_TOTAL . ', '
                . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID . ', '
                . Tabela::TIPO . '.' . Tabela_Tipo::ID_TIPO . ','
                . Tabela::TIPO . '.' . Tabela_Tipo::NOME . ' as nome_tipo'
                . ' FROM '
                . Tabela::ITEM . ',' . Tabela::TIPO
                . ' WHERE '
                . Tabela::ITEM . '.' . Tabela_Item::ID_TIPO . '=' . Tabela::TIPO . '.' . Tabela_Tipo::ID_TIPO
                . ' AND '
                . Tabela::ITEM . '.' . Tabela_Item::ID_TIPO . '=?'
                . ' AND '
                . Tabela::ITEM . '.' . Tabela_Item::QUANTIDADE_TOTAL . '>0'
                . ' ORDER BY nome_item';

            $resultado = $this->db->query($sql, array($id_tipo));

            if ($resultado) {
                return $resultado->result_array();
            }
        } // Caso não tenha selecionado um tipo.
        else {
            // SQL Query
            $sql = 'SELECT '
                . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ', '
                . Tabela::ITEM . '.' . Tabela_Item::NOME . ' as nome_item, '
                . Tabela::ITEM . '.' . Tabela_Item::QUANTIDADE_TOTAL . ', '
                . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID . ', '
                . Tabela::TIPO . '.' . Tabela_Tipo::ID_TIPO . ','
                . Tabela::TIPO . '.' . Tabela_Tipo::NOME . ' as nome_tipo'
                . ' FROM '
                . Tabela::ITEM . ',' . Tabela::TIPO
                . ' WHERE '
                . Tabela::ITEM . '.' . Tabela_Item::ID_TIPO . '=' . Tabela::TIPO . '.' . Tabela_Tipo::ID_TIPO
                . ' AND '
                . Tabela::ITEM . '.' . Tabela_Item::QUANTIDADE_TOTAL . '>0'
                . ' ORDER BY nome_item';

            $resultado = $this->db->query($sql);

            if ($resultado) {
                return $resultado->result_array();
            }
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê um tipo do banco de dados de acordo com o ID informado.
     *
     * @param $id_tipo ID do tipo.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_tipo($id_tipo)
    {
        if ($id_tipo != NULL) {
            // SQL Query
            $sql = ' SELECT '
                . Tabela::TIPO . '.' . Tabela_Tipo::ID_TIPO . ', '
                . Tabela::TIPO . '.' . Tabela_Tipo::NOME
                . ' FROM '
                . Tabela::TIPO
                . ' WHERE '
                . Tabela::TIPO . '.' . Tabela_Tipo::ID_TIPO . ' = ?'
                . ' ORDER BY '
                . Tabela::TIPO . '.' . Tabela_Tipo::NOME;

            $resultado = $this->db->query($sql, array($id_tipo));

            if ($resultado) {
                return $resultado->row_array();
            }
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Pega todos os tipos cadastrados no banco de dados.
     *
     * @access public
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_tipos()
    {
        // SQL Query
        $sql = ' SELECT '
            . Tabela::TIPO . '.' . Tabela_Tipo::ID_TIPO . ', '
            . Tabela::TIPO . '.' . Tabela_Tipo::NOME
            . ' FROM '
            . Tabela::TIPO
            . ' ORDER BY '
            . Tabela::TIPO . '.' . Tabela_Tipo::NOME;
        $resultado = $this->db->query($sql);

        if ($resultado) {
            return $resultado->result_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Verifica a quantidade de itens cadastrado no sistema.
     *
     * @access public
     * @return bool|array Caso tenha alguma item cadastrado retorna resultado, se não retorna falso.
     */
    public function quantidade_itens()
    {
        // SQL Query.
        $sql = 'SELECT COUNT(*) as quantidade_itens FROM ' . Tabela::ITEM;

        $resultado = $this->db->query($sql);

        return $resultado->row();
    }

}

/* Fim do arquivo model_estoque_disponivel.php */
/* Localização: ./application/models/painel/saida/model_estoque_disponivel.php */