<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model do menu de relatórios 'Saída de Itens'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */

include_once APPPATH . '/models/tabelas/tabela.php';
include_once APPPATH . '/models/tabelas/tabela_destino.php';
include_once APPPATH . '/models/tabelas/tabela_item.php';
include_once APPPATH . '/models/tabelas/tabela_saida.php';
include_once APPPATH . '/models/tabelas/tabela_tipo.php';
include_once APPPATH . '/models/tabelas/tabela_item_contrato.php';
include_once APPPATH . '/models/tabelas/tabela_contrato.php';

class Model_Saida_Itens extends CI_Model
{
    /**
     * Lê todos os destinos cadastrados no banco de dados.
     *
     * @access public
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_destinos()
    {
        // SQL Query
        $sql = 'SELECT '
            . Tabela::DESTINO . '.' . Tabela_Destino::ID_DESTINO . ', '
            . Tabela::DESTINO . '.' . Tabela_Destino::NOME
            . ' FROM '
            . Tabela::DESTINO
            . ' ORDER BY '
            . Tabela::DESTINO . '.' . Tabela_Destino::NOME
            . ' ASC ';

        $resultado = $this->db->query($sql);

        if ($resultado) {
            return $resultado->result_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê todos os itens cadastrados no banco de dados.
     *
     * @access public
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_itens()
    {
        // SQL Query
        $sql = 'SELECT '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ', '
            . Tabela::ITEM . '.' . Tabela_Item::ID_TIPO . ', '
            . Tabela::ITEM . '.' . Tabela_Item::NOME
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
     * Lê todos os tipos cadastrados no banco de dados.
     *
     * @access public
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

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê o nome de um destino cadastrado no banco de dados.
     *
     * @access public
     * @param null $id_destino Id do destino.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_nome_destino($id_destino = NULL)
    {
        if ($id_destino != NULL) {
            // SQL Query
            $sql = ' SELECT '
                . Tabela::DESTINO . '.' . Tabela_Destino::NOME
                . ' FROM '
                . Tabela::DESTINO
                . ' WHERE '
                . Tabela::DESTINO . '.' . Tabela_Destino::ID_DESTINO . ' = ?';

            $resultado = $this->db->query($sql, array($id_destino));

            if ($resultado->num_rows() > 0) {
                $formatar = $resultado->row_array();

                return $formatar['nome'];
            }
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê o nome de um item cadastrado no banco de dados.
     *
     * @access public
     * @param null $id_item Id do item.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_nome_item($id_item)
    {
        // SQL Query
        $sql = ' SELECT '
            . Tabela::ITEM . '.' . Tabela_Item::NOME
            . ' FROM '
            . Tabela::ITEM
            . ' WHERE '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ?';

        $resultado = $this->db->query($sql, array($id_item));

        if ($resultado->num_rows() > 0) {
            $formatar = $resultado->row_array();

            return $formatar['nome'];
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê o nome de um tipo cadastrado no banco de dados.
     *
     * @param $id_tipo Id do tipo.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_nome_tipo($id_tipo)
    {
        // SQL Query
        $sql = ' SELECT '
            . Tabela::TIPO . '.' . Tabela_Tipo::NOME
            . ' FROM '
            . Tabela::TIPO
            . ' WHERE '
            . Tabela::TIPO . '.' . Tabela_Tipo::ID_TIPO . ' = ?';

        $resultado = $this->db->query($sql, array($id_tipo));

        if ($resultado->num_rows() > 0) {
            $formatar = $resultado->row_array();

            return $formatar['nome'];
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê as saidas cadastradas no banco de dados, filtrando-as pela data de incio e data de fim.
     *
     * @param $data_inicio Data de início.
     * @param $data_fim Data de fim.
     * @param $soma_quantidade Soma as quantidades de cada item.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_saidas_data($data_inicio, $data_fim, $soma_quantidade)
    {
        if (!$soma_quantidade) {
            // SQL Query
            $sql = 'SELECT '
                . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ' AS nome_destino, '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_SAIDA . ' AS id_saida, '
                . 'DATE_FORMAT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ', "%d/%m/%Y") AS data_saida, '
                . Tabela::SAIDA . '.' . Tabela_Saida::QUANTIDADE . ' AS quantidade_saida, '
                . Tabela::ITEM . '.' . Tabela_Item::NOME . ' AS nome_item, '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::VALOR . ' AS valor_item_contrato, '
                . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID . ' AS unidade_padrao_id '
                . ' FROM '
                . Tabela::SAIDA
                . ' INNER JOIN '
                . Tabela::ITEM
                . ' ON '
                . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM
                . ' INNER JOIN '
                . Tabela::DESTINO
                . ' ON '
                . Tabela::DESTINO . '.' . Tabela_Destino::ID_DESTINO . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_DESTINO
                . ' INNER JOIN '
                . Tabela::ITEM_CONTRATO
                . ' ON '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM_CONTRATO
                . ' WHERE '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ' BETWEEN ? AND ?'
                . ' AND '
                . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM
                . ' ORDER BY '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA
                . ' DESC ';



        }else{
          // SQL Query
          $sql = 'SELECT '
              . ' IF(COUNT(DISTINCT(' . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ')) = 1,  ' . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ', "Vários Destinos") AS nome_destino, '
              . Tabela::SAIDA . '.' . Tabela_Saida::ID_SAIDA . ' AS id_saida, '
              . ' IF(COUNT(DISTINCT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ')) = 1, DATE_FORMAT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ', "%d/%m/%Y"), "Várias Datas") AS data_saida, '
              . ' SUM(' . Tabela::SAIDA . '.' . Tabela_Saida::QUANTIDADE . ') AS quantidade_saida, '
              . Tabela::ITEM . '.' . Tabela_Item::NOME . ' AS nome_item, '
              . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::VALOR . ' AS valor_item_contrato, '
              . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID . ' AS unidade_padrao_id '
              . ' FROM '
              . Tabela::SAIDA
              . ' INNER JOIN '
              . Tabela::ITEM
              . ' ON '
              . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM
              . ' INNER JOIN '
              . Tabela::DESTINO
              . ' ON '
              . Tabela::DESTINO . '.' . Tabela_Destino::ID_DESTINO . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_DESTINO
              . ' INNER JOIN '
              . Tabela::ITEM_CONTRATO
              . ' ON '
              . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM_CONTRATO
              . ' WHERE '
              . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ' BETWEEN ? AND ?'
              . ' GROUP BY '
              . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM_CONTRATO
              . ' ORDER BY '
              . Tabela::SAIDA . '.' . Tabela_Saida::DATA
              . ' DESC ';
        }

        $resultado = $this->db->query($sql, array($data_inicio, $data_fim));

        if ($resultado) {
            return $resultado->result_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê as saidas cadastradas no banco de dados, filtrando-as pela data de incio, data de fim e id do destino.
     *
     * @param $data_inicio Data de início.
     * @param $data_fim Data de fim.
     * @param $id_destino Id do destino.
     * @param $soma_quantidade Soma as quantidades de cada item.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_saidas_data_destino($data_inicio, $data_fim, $id_destino, $soma_quantidade)
    {
        if (!$soma_quantidade) {
            // SQL Query
            $sql = 'SELECT '
                . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ' AS nome_destino, '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_SAIDA . ' AS id_saida, '
                . 'DATE_FORMAT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ', "%d/%m/%Y") AS data_saida, '
                . Tabela::SAIDA . '.' . Tabela_Saida::QUANTIDADE . ' AS quantidade_saida, '
                . Tabela::ITEM . '.' . Tabela_Item::NOME . ' AS nome_item, '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::VALOR . ' AS valor_item_contrato, '
                . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID . ' AS unidade_padrao_id '
                . ' FROM '
                . Tabela::SAIDA
                . ' INNER JOIN '
                . Tabela::ITEM
                . ' ON '
                . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM
                . ' INNER JOIN '
                . Tabela::DESTINO
                . ' ON '
                . Tabela::DESTINO . '.' . Tabela_Destino::ID_DESTINO . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_DESTINO
                . ' INNER JOIN '
                . Tabela::ITEM_CONTRATO
                . ' ON '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM_CONTRATO
                . ' WHERE '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ' BETWEEN ? AND ?'
                . ' AND '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_DESTINO . ' = ?'
                . ' ORDER BY '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA
                . ' DESC ';
        } else {
                // SQL Query
                $sql = 'SELECT '
                . ' IF(COUNT(DISTINCT(' . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ')) = 1,  ' . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ', "Vários Destinos") AS nome_destino, '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_SAIDA . ' AS id_saida, '
                . ' IF(COUNT(DISTINCT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ')) = 1, DATE_FORMAT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ', "%d/%m/%Y"), "Várias Datas") AS data_saida, '
                . ' SUM(' . Tabela::SAIDA . '.' . Tabela_Saida::QUANTIDADE . ') AS quantidade_saida, '
                . Tabela::ITEM . '.' . Tabela_Item::NOME . ' AS nome_item, '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::VALOR . ' AS valor_item_contrato, '
                . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID . ' AS unidade_padrao_id '
                . ' FROM '
                . Tabela::SAIDA
                . ' INNER JOIN '
                . Tabela::ITEM
                . ' ON '
                . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM
                . ' INNER JOIN '
                . Tabela::DESTINO
                . ' ON '
                . Tabela::DESTINO . '.' . Tabela_Destino::ID_DESTINO . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_DESTINO
                . ' INNER JOIN '
                . Tabela::ITEM_CONTRATO
                . ' ON '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM_CONTRATO
                . ' WHERE '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ' BETWEEN ? AND ?'
                . ' AND '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_DESTINO . ' = ?'
                . ' GROUP BY '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM_CONTRATO
                . ' ORDER BY '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA
                . ' DESC ';
        }

        $resultado = $this->db->query($sql, array($data_inicio, $data_fim, $id_destino));

        if ($resultado) {
            return $resultado->result_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê as saidas cadastradas no banco de dados, filtrando-as pela data de incio, data de fim, id do destino e
     * id do tipo.
     *
     * @param $data_inicio Data de início.
     * @param $data_fim Data de fim.
     * @param $id_destino Id do destino.
     * @param $id_tipo Id do tipo.
     * @param $soma_quantidade Soma as quantidades de cada item.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_saidas_data_destino_tipo($data_inicio, $data_fim, $id_destino, $id_tipo, $soma_quantidade)
    {
        if (!$soma_quantidade) {
            // SQL Query
            $sql = 'SELECT '
                . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ' AS nome_destino, '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_SAIDA . ' AS id_saida, '
                . 'DATE_FORMAT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ', "%d/%m/%Y") AS data_saida, '
                . Tabela::SAIDA . '.' . Tabela_Saida::QUANTIDADE . ' AS quantidade_saida, '
                . Tabela::ITEM . '.' . Tabela_Item::NOME . ' AS nome_item, '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::VALOR . ' AS valor_item_contrato, '
                . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID . ' AS unidade_padrao_id '
                . ' FROM '
                . Tabela::SAIDA
                . ' INNER JOIN '
                . Tabela::ITEM
                . ' ON '
                . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM
                . ' INNER JOIN '
                . Tabela::DESTINO
                . ' ON '
                . Tabela::DESTINO . '.' . Tabela_Destino::ID_DESTINO . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_DESTINO
                . ' INNER JOIN '
                . Tabela::ITEM_CONTRATO
                . ' ON '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM_CONTRATO
                . ' WHERE '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ' BETWEEN ? AND ?'
                . ' AND '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_DESTINO . ' = ?'
                . ' AND '
                . Tabela::ITEM . '.' . Tabela_Item::ID_TIPO . ' = ?'
                . ' ORDER BY '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA
                . ' DESC ';

        } else {

            // SQL Query
            $sql = 'SELECT '
                . ' IF(COUNT(DISTINCT(' . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ')) = 1,  ' . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ', "Vários Destinos") AS nome_destino, '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_SAIDA . ' AS id_saida, '
                . ' IF(COUNT(DISTINCT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ')) = 1, DATE_FORMAT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ', "%d/%m/%Y"), "Várias Datas") AS data_saida, '
                . ' SUM(' . Tabela::SAIDA . '.' . Tabela_Saida::QUANTIDADE . ') AS quantidade_saida, '
                . Tabela::ITEM . '.' . Tabela_Item::NOME . ' AS nome_item, '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::VALOR . ' AS valor_item_contrato, '
                . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID . ' AS unidade_padrao_id '
                . ' FROM '
                . Tabela::SAIDA
                . ' INNER JOIN '
                . Tabela::ITEM
                . ' ON '
                . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM
                . ' INNER JOIN '
                . Tabela::ITEM_CONTRATO
                . ' ON '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM_CONTRATO
                . ' INNER JOIN '
                . Tabela::DESTINO
                . ' ON '
                . Tabela::DESTINO . '.' . Tabela_Destino::ID_DESTINO . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_DESTINO
                . ' WHERE '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ' BETWEEN ? AND ?'
                . ' AND '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_DESTINO . ' = ?'
                . ' AND '
                . Tabela::ITEM . '.' . Tabela_Item::ID_TIPO . ' = ?'
                . ' GROUP BY '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM_CONTRATO
                . ' ORDER BY '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA
                . ' DESC ';
        }

        $resultado = $this->db->query($sql, array($data_inicio, $data_fim, $id_destino, $id_tipo));

        if ($resultado) {
            return $resultado->result_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê as saidas cadastradas no banco de dados, filtrando-as pela data de incio, data de fim, id do destino,
     * id do tipo e id do item.
     *
     * @param $data_inicio Data de início.
     * @param $data_fim Data de fim.
     * @param $id_destino Id do destino.
     * @param $id_tipo Id do tipo.
     * @param $id_item Id do item.
     * @param $soma_quantidade Soma as quantidades de cada item.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_saidas_data_destino_tipo_item($data_inicio, $data_fim, $id_destino, $id_tipo, $id_item, $soma_quantidade)
    {
        if (!$soma_quantidade) {
            // SQL Query
            $sql = 'SELECT '
                . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ' AS nome_destino, '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_SAIDA . ' AS id_saida, '
                . 'DATE_FORMAT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ', "%d/%m/%Y") AS data_saida, '
                . Tabela::SAIDA . '.' . Tabela_Saida::QUANTIDADE . ' AS quantidade_saida, '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::VALOR . ' AS valor_item_contrato, '
                . Tabela::ITEM . '.' . Tabela_Item::NOME . ' AS nome_item, '
                . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID . ' AS unidade_padrao_id '
                . ' FROM '
                . Tabela::SAIDA
                . ' INNER JOIN '
                . Tabela::ITEM
                . ' ON '
                . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM
                . ' INNER JOIN '
                . Tabela::DESTINO
                . ' ON '
                . Tabela::DESTINO . '.' . Tabela_Destino::ID_DESTINO . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_DESTINO
                . ' INNER JOIN '
                . Tabela::ITEM_CONTRATO
                . ' ON '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM_CONTRATO
                . ' WHERE '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ' BETWEEN ? AND ? '
                . ' AND '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_DESTINO . ' = ? '
                . ' AND '
                . Tabela::ITEM . '.' . Tabela_Item::ID_TIPO . ' = ? '
                . ' AND '
                . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ? '
                . ' ORDER BY '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA
                . ' DESC ';
        }else{
            // SQL Query
            $sql = 'SELECT '
                . ' IF(COUNT(DISTINCT(' . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ')) = 1,  ' . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ', "Vários Destinos") AS nome_destino, '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_SAIDA . ' AS id_saida, '
                . ' IF(COUNT(DISTINCT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ')) = 1, DATE_FORMAT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ', "%d/%m/%Y"), "Várias Datas") AS data_saida, '
                . ' SUM(' . Tabela::SAIDA . '.' . Tabela_Saida::QUANTIDADE . ') AS quantidade_saida, '
                . Tabela::ITEM . '.' . Tabela_Item::NOME . ' AS nome_item, '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::VALOR . ' AS valor_item_contrato, '
                . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID . ' AS unidade_padrao_id '
                . ' FROM '
                . Tabela::SAIDA
                . ' INNER JOIN '
                . Tabela::ITEM
                . ' ON '
                . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM
                . ' INNER JOIN '
                . Tabela::ITEM_CONTRATO
                . ' ON '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM_CONTRATO
                . ' INNER JOIN '
                . Tabela::DESTINO
                . ' ON '
                . Tabela::DESTINO . '.' . Tabela_Destino::ID_DESTINO . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_DESTINO
                . ' WHERE '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ' BETWEEN ? AND ? '
                . ' AND '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_DESTINO . ' = ? '
                . ' AND '
                . Tabela::ITEM . '.' . Tabela_Item::ID_TIPO . ' = ? '
                . ' AND '
                . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ? '
                  . ' GROUP BY '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM_CONTRATO
                . ' ORDER BY '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA
                . ' DESC ';
        }

        $resultado = $this->db->query($sql, array($data_inicio, $data_fim, $id_destino, $id_tipo, $id_item));

        if ($resultado) {
            return $resultado->result_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê as saidas cadastradas no banco de dados, filtrando-as pela data de incio, data de fim e id do tipo.
     *
     * @param $data_inicio Data de início.
     * @param $data_fim Data de fim.
     * @param $id_tipo Id do tipo.
     * @param $soma_quantidade Soma as quantidades de cada item.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_saidas_data_tipo($data_inicio, $data_fim, $id_tipo, $soma_quantidade)
    {
        if (!$soma_quantidade) {
            // SQL Query
            $sql = 'SELECT '
                . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ' AS nome_destino, '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_SAIDA . ' AS id_saida, '
                . 'DATE_FORMAT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ', "%d/%m/%Y") AS data_saida, '
                . Tabela::SAIDA . '.' . Tabela_Saida::QUANTIDADE . ' AS quantidade_saida, '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::VALOR . ' AS valor_item_contrato, '
                . Tabela::ITEM . '.' . Tabela_Item::NOME . ' AS nome_item, '
                . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID . ' AS unidade_padrao_id '
                . ' FROM '
                . Tabela::SAIDA
                . ' INNER JOIN '
                . Tabela::ITEM
                . ' ON '
                . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM
                . ' INNER JOIN '
                . Tabela::DESTINO
                . ' ON '
                . Tabela::DESTINO . '.' . Tabela_Destino::ID_DESTINO . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_DESTINO
                . ' INNER JOIN '
                . Tabela::ITEM_CONTRATO
                . ' ON '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM_CONTRATO
                . ' WHERE '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ' BETWEEN ? AND ?'
                . ' AND '
                . Tabela::ITEM . '.' . Tabela_Item::ID_TIPO . ' = ?'
                . ' ORDER BY '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA
                . ' DESC ';
        } else {
            // SQL Query
            $sql = 'SELECT '
                . ' IF(COUNT(DISTINCT(' . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ')) = 1,  ' . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ', "Vários Destinos") AS nome_destino, '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_SAIDA . ' AS id_saida, '
                . ' IF(COUNT(DISTINCT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ')) = 1, DATE_FORMAT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ', "%d/%m/%Y"), "Várias Datas") AS data_saida, '
                . ' SUM(' . Tabela::SAIDA . '.' . Tabela_Saida::QUANTIDADE . ') AS quantidade_saida, '
                . Tabela::ITEM . '.' . Tabela_Item::NOME . ' AS nome_item, '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::VALOR . ' AS valor_item_contrato, '
                . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID . ' AS unidade_padrao_id '
                . ' FROM '
                . Tabela::SAIDA
                . ' INNER JOIN '
                . Tabela::ITEM
                . ' ON '
                . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM
                . ' INNER JOIN '
                . Tabela::DESTINO
                . ' ON '
                . Tabela::DESTINO . '.' . Tabela_Destino::ID_DESTINO . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_DESTINO
                . ' INNER JOIN '
                . Tabela::ITEM_CONTRATO
                . ' ON '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM_CONTRATO
                . ' WHERE '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ' BETWEEN ? AND ?'
                . ' AND '
                . Tabela::ITEM . '.' . Tabela_Item::ID_TIPO . ' = ?'
                . ' GROUP BY '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM_CONTRATO
                . ' ORDER BY '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA
                . ' DESC ';
        }

        $resultado = $this->db->query($sql, array($data_inicio, $data_fim, $id_tipo));

        if ($resultado) {
            return $resultado->result_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê as saidas cadastradas no banco de dados, filtrando-as pela data de incio, data de fim, id do tipo e
     * id do item.
     *
     * @param $data_inicio Data de início.
     * @param $data_fim Data de fim.
     * @param $id_tipo Id do tipo.
     * @param $id_item Id do item.
     * @param $soma_quantidade Soma as quantidades de cada item.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_saidas_data_tipo_item($data_inicio, $data_fim, $id_tipo, $id_item, $soma_quantidade)
    {
        if (!$soma_quantidade) {
            // SQL Query
            $sql = 'SELECT '
                . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ' AS nome_destino, '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_SAIDA . ' AS id_saida, '
                . 'DATE_FORMAT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ', "%d/%m/%Y") AS data_saida, '
                . Tabela::SAIDA . '.' . Tabela_Saida::QUANTIDADE . ' AS quantidade_saida, '
                . Tabela::ITEM . '.' . Tabela_Item::NOME . ' AS nome_item, '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::VALOR . ' AS valor_item_contrato, '
                . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID . ' AS unidade_padrao_id '
                . ' FROM '
                . Tabela::SAIDA
                . ' INNER JOIN '
                . Tabela::ITEM
                . ' ON '
                . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM
                . ' INNER JOIN '
                . Tabela::DESTINO
                . ' ON '
                . Tabela::DESTINO . '.' . Tabela_Destino::ID_DESTINO . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_DESTINO
                . ' INNER JOIN '
                . Tabela::ITEM_CONTRATO
                . ' ON '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM_CONTRATO
                . ' WHERE '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ' BETWEEN ? AND ?'
                . ' AND '
                . Tabela::ITEM . '.' . Tabela_Item::ID_TIPO . ' = ?'
                . ' AND '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM . ' = ?'
                . ' ORDER BY '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA
                . ' DESC ';
        } else {
            // SQL Query
            $sql = 'SELECT '
                . ' IF(COUNT(DISTINCT(' . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ')) = 1,  ' . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ', "Vários Destinos") AS nome_destino, '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_SAIDA . ' AS id_saida, '
                . ' IF(COUNT(DISTINCT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ')) = 1, DATE_FORMAT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ', "%d/%m/%Y"), "Várias Datas") AS data_saida, '
                . ' SUM(' . Tabela::SAIDA . '.' . Tabela_Saida::QUANTIDADE . ') AS quantidade_saida, '
                . Tabela::ITEM . '.' . Tabela_Item::NOME . ' AS nome_item, '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::VALOR . ' AS valor_item_contrato, '
                . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID . ' AS unidade_padrao_id '
                . ' FROM '
                . Tabela::SAIDA
                . ' INNER JOIN '
                . Tabela::ITEM
                . ' ON '
                . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM
                . ' INNER JOIN '
                . Tabela::DESTINO
                . ' ON '
                . Tabela::DESTINO . '.' . Tabela_Destino::ID_DESTINO . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_DESTINO
                . ' INNER JOIN '
                . Tabela::ITEM_CONTRATO
                . ' ON '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM_CONTRATO
                . ' WHERE '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ' BETWEEN ? AND ?'
                . ' AND '
                . Tabela::ITEM . '.' . Tabela_Item::ID_TIPO . ' = ?'
                . ' AND '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM . ' = ?'
                . ' GROUP BY '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM_CONTRATO
                . ' ORDER BY '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA
                . ' DESC ';
        }

        $resultado = $this->db->query($sql, array($data_inicio, $data_fim, $id_tipo, $id_item));

        if ($resultado) {
            return $resultado->result_array();
        }

        return FALSE;
    }
}

/* Fim do arquivo: model_saida_itens.php */
/* Localização: ./application/models/painel/relatorio/model_saida_itens.php */
