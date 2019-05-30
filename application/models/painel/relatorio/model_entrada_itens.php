<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model do menu de relatórios 'Entrada de Itens'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */

include_once APPPATH . '/models/tabelas/tabela_contrato.php';
include_once APPPATH . '/models/tabelas/tabela_fornecedor.php';
include_once APPPATH . '/models/tabelas/tabela_entrada.php';
include_once APPPATH . '/models/tabelas/tabela_item.php';
include_once APPPATH . '/models/tabelas/tabela_item_contrato.php';
include_once APPPATH . '/models/tabelas/tabela_tipo.php';
include_once APPPATH . '/models/tabelas/tabela.php';

class Model_Entrada_Itens extends CI_Model
{
    /**
     * Lê todos os fornecedores e seu respetivos contratos.
     *
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_fornecedores_contratos()
    {
        // TODO considerar a data atual.
        // SQL Query
        $sql = 'SELECT '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO . ', '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::CODIGO . ', '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::ID_FORNECEDOR. ', '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::NOME
            . ' FROM '
            . Tabela::CONTRATO . ', '
            . Tabela::FORNECEDOR
            . ' WHERE '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_FORNECEDOR . '=' . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::ID_FORNECEDOR
            . ' ORDER BY '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::NOME
            . ' ASC, '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::DATA_FIM
            . ' ASC ';
        $resultado = $this->db->query($sql);

        if ($resultado->num_rows() > 0) {
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
        // SQL Query
        $sql = 'SELECT '
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
     * Lê as entradas, filtrando-as de acordo com data de inicio e data de fim que foram inseridos.
     *
     * @param $data_inicio Data de inicio.
     * @param $data_fim Data de fim.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_entradas_data($data_inicio, $data_fim)
    {
        // SQL Query
        $sql = ' SELECT '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::CODIGO . ' AS codigo_contrato, '
            . Tabela::ITEM . '.' . Tabela_Item::NOME . ' AS nome_item, '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::QUANTIDADE . ' AS quantidade_entrada, '
            . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID . ' AS unidade_padrao_id, '
            . ' DATE_FORMAT(' . Tabela::ENTRADA . '.' . Tabela_Entrada::DATA . ', "%d/%m/%Y") AS data_entrada, '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::NUMERO_NOTA . ' AS numero_nota '
            . ' FROM '
            . Tabela::ENTRADA . ', '
            . Tabela::FORNECEDOR . ', '
            . Tabela::CONTRATO . ', '
            . Tabela::ITEM_CONTRATO
            . ' INNER JOIN '
            . Tabela::ITEM
            . ' ON '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM
            . ' WHERE '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::ID_FORNECEDOR . ' = ' . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_FORNECEDOR
            . ' AND '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_CONTRATO
            . ' AND '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ' = ' . Tabela::ENTRADA . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO
            . ' AND '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::DATA
            . ' BETWEEN ? AND ?'
            . ' ORDER BY '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::DATA
            . ' DESC ';

        $resultado = $this->db->query($sql, array($data_inicio, $data_fim));

        if ($resultado) {
            return $resultado->result_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê as entradas, filtrando-as de acordo com data de inicio, data de fim e id do contrato que foram inseridos.
     *
     * @param $data_inicio Data de inicio.
     * @param $data_fim Data de fim.
     * @param $id_contrato Id do contrato.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_entradas_data_contrato($data_inicio, $data_fim, $id_contrato)
    {

        $sql = ' SELECT '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::CODIGO . ' AS codigo_contrato, '
            . Tabela::ITEM . '.' . Tabela_Item::NOME . ' AS nome_item, '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::QUANTIDADE . ' AS quantidade_entrada, '
            . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID . ' AS unidade_padrao_id, '
            . ' DATE_FORMAT(' . Tabela::ENTRADA . '.' . Tabela_Entrada::DATA . ', "%d/%m/%Y") AS data_entrada, '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::NUMERO_NOTA . ' AS numero_nota '
            . ' FROM '
            . Tabela::ENTRADA . ', '
            . Tabela::FORNECEDOR . ', '
            . Tabela::CONTRATO . ', '
            . Tabela::ITEM_CONTRATO
            . ' INNER JOIN '
            . Tabela::ITEM
            . ' ON '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM
            . ' WHERE '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::ID_FORNECEDOR . ' = ' . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_FORNECEDOR
            . ' AND '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_CONTRATO
            . ' AND '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ' = ' . Tabela::ENTRADA . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO
            . ' AND '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::DATA
            . ' BETWEEN ? AND ? '
            . ' AND '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO . ' = ? '
            . ' ORDER BY '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::DATA
            . ' DESC ';
        $resultado = $this->db->query($sql, array($data_inicio, $data_fim, $id_contrato));

        if ($resultado) {
            return $resultado->result_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê as entradas, filtrando-as de acordo com data de inicio, data de fim, id do contrato e
     * id do tipo que foram inseridos.
     *
     * @param $data_inicio Data de inicio.
     * @param $data_fim Data de fim.
     * @param $id_contrato Id do contrato.
     * @param $id_tipo Id do tipo.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_entradas_data_contrato_tipo($data_inicio, $data_fim, $id_contrato, $id_tipo)
    {
        $sql = ' SELECT '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::CODIGO . ' AS codigo_contrato, '
            . Tabela::ITEM . '.' . Tabela_Item::NOME . ' AS nome_item, '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::QUANTIDADE . ' AS quantidade_entrada, '
            . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID . ' AS unidade_padrao_id, '
            . ' DATE_FORMAT(' . Tabela::ENTRADA . '.' . Tabela_Entrada::DATA . ', "%d/%m/%Y") AS data_entrada, '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::NUMERO_NOTA . ' AS numero_nota '
            . ' FROM '
            . Tabela::ENTRADA . ', '
            . Tabela::FORNECEDOR . ', '
            . Tabela::CONTRATO . ', '
            . Tabela::TIPO . ', '
            . Tabela::ITEM_CONTRATO
            . ' INNER JOIN '
            . Tabela::ITEM
            . ' ON '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM
            . ' WHERE '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::ID_FORNECEDOR . ' = ' . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_FORNECEDOR
            . ' AND '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_CONTRATO
            . ' AND '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ' = ' . Tabela::ENTRADA . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO
            . ' AND '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::DATA
            . ' BETWEEN ? AND ? '
            . ' AND '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO . ' = ? '
            . ' AND '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM . ' = ' . Tabela::ITEM. '.' . Tabela_Item::ID_ITEM
            . ' AND '
            . Tabela::TIPO . '.' . Tabela_Tipo::ID_TIPO . ' = ? '
            . ' ORDER BY '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::DATA
            . ' DESC ';
        $resultado = $this->db->query($sql, array($data_inicio, $data_fim, $id_contrato, $id_tipo));

        if ($resultado) {
            return $resultado->result_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê as entradas, filtrando-as de acordo com data de inicio, data de fim, id do contrato, id do tipo
     * e id do item que foram inseridos.
     *
     * @param $data_inicio Data de inicio.
     * @param $data_fim Data de fim.
     * @param $id_contrato Id do contrato.
     * @param $id_tipo Id do tipo.
     * @param $id_item Id do item.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_entradas_data_contrato_tipo_item($data_inicio, $data_fim, $id_contrato, $id_tipo, $id_item)
    {
        $sql = ' SELECT '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::CODIGO . ' AS codigo_contrato, '
            . Tabela::ITEM . '.' . Tabela_Item::NOME . ' AS nome_item, '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::QUANTIDADE . ' AS quantidade_entrada, '
            . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID . ' AS unidade_padrao_id, '
            . ' DATE_FORMAT(' . Tabela::ENTRADA . '.' . Tabela_Entrada::DATA . ', "%d/%m/%Y") AS data_entrada, '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::NUMERO_NOTA . ' AS numero_nota '
            . ' FROM '
            . Tabela::ENTRADA . ', '
            . Tabela::FORNECEDOR . ', '
            . Tabela::CONTRATO . ', '
            . Tabela::TIPO . ', '
            . Tabela::ITEM_CONTRATO
            . ' INNER JOIN '
            . Tabela::ITEM
            . ' ON '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM
            . ' WHERE '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::ID_FORNECEDOR . ' = ' . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_FORNECEDOR
            . ' AND '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_CONTRATO
            . ' AND '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ' = ' . Tabela::ENTRADA . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO
            . ' AND '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::DATA
            . ' BETWEEN ? AND ? '
            . ' AND '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO . ' = ? '
            . ' AND '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM . ' = ' . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM
            . ' AND '
            . Tabela::TIPO . '.' . Tabela_Tipo::ID_TIPO . ' = ? '
            . ' AND '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM . '= ?'
            . ' ORDER BY '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::DATA
            . ' DESC ';
        $resultado = $this->db->query($sql, array($data_inicio, $data_fim, $id_contrato, $id_tipo, $id_item));

        if ($resultado) {
            return $resultado->result_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê as entradas, filtrando-as de acordo com data de inicio, data de fim e id do fornecedor,
     * que foram inseridos.
     *
     * @param $data_inicio Data de inicio.
     * @param $data_fim Data de fim.
     * @param $id_fornecedor Id do fornecedor.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_entradas_data_fornecedor($data_inicio, $data_fim, $id_fornecedor)
    {
        // SQL Query
        $sql = ' SELECT '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::CODIGO . ' AS codigo_contrato, '
            . Tabela::ITEM . '.' . Tabela_Item::NOME . ' AS nome_item, '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::QUANTIDADE . ' AS quantidade_entrada, '
            . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID . ' AS unidade_padrao_id, '
            . ' DATE_FORMAT(' . Tabela::ENTRADA . '.' . Tabela_Entrada::DATA . ', "%d/%m/%Y") AS data_entrada, '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::NUMERO_NOTA . ' AS numero_nota '
            . ' FROM '
            . Tabela::ENTRADA . ', '
            . Tabela::FORNECEDOR . ', '
            . Tabela::CONTRATO . ', '
            . Tabela::ITEM_CONTRATO
            . ' INNER JOIN '
            . Tabela::ITEM
            . ' ON '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM
            . ' WHERE '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::ID_FORNECEDOR . ' = ' . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_FORNECEDOR
            . ' AND '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_CONTRATO
            . ' AND '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ' = ' . Tabela::ENTRADA . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO
            . ' AND '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::DATA
            . ' BETWEEN ? AND ?'
            . ' AND '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::ID_FORNECEDOR . ' = ?'
            . ' ORDER BY '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::DATA
            . ' DESC ';

        $resultado = $this->db->query($sql, array($data_inicio, $data_fim, $id_fornecedor));

        if ($resultado) {
            return $resultado->result_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê as entradas, filtrando-as de acordo com data de inicio, data de fim, id do fornecedor,
     * e id do item que foram inseridos.
     *
     * @param $data_inicio Data de inicio.
     * @param $data_fim Data de fim.
     * @param $id_fornecedor Id do fornecedor.
     * @param $id_tipo Id do tipo.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_entradas_data_fornecedor_tipo($data_inicio, $data_fim, $id_fornecedor, $id_tipo)
    {
        // SQL Query
        $sql = ' SELECT '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::CODIGO . ' AS codigo_contrato, '
            . Tabela::ITEM . '.' . Tabela_Item::NOME . ' AS nome_item, '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::QUANTIDADE . ' AS quantidade_entrada, '
            . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID . ' AS unidade_padrao_id, '
            . ' DATE_FORMAT(' . Tabela::ENTRADA . '.' . Tabela_Entrada::DATA . ', "%d/%m/%Y") AS data_entrada, '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::NUMERO_NOTA . ' AS numero_nota '
            . ' FROM '
            . Tabela::ENTRADA . ', '
            . Tabela::FORNECEDOR . ', '
            . Tabela::CONTRATO . ', '
            . Tabela::ITEM_CONTRATO
            . ' INNER JOIN '
            . Tabela::ITEM
            . ' ON '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM
            . ' WHERE '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::ID_FORNECEDOR . ' = ' . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_FORNECEDOR
            . ' AND '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_CONTRATO
            . ' AND '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ' = ' . Tabela::ENTRADA . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO
            . ' AND '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::DATA
            . ' BETWEEN ? AND ? '
            . ' AND '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::ID_FORNECEDOR . ' = ? '
            . ' AND '
            . Tabela::ITEM . '.' . Tabela_Item::ID_TIPO . ' = ? '
            . ' ORDER BY '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::DATA
            . ' DESC ';

        $resultado = $this->db->query($sql, array($data_inicio, $data_fim, $id_fornecedor, $id_tipo));

        if ($resultado) {
            return $resultado->result_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê as entradas, filtrando-as de acordo com data de inicio, data de fim, id do fornecedor,
     * id do tipo e id do item que foram inseridos.
     *
     * @param $data_inicio Data de inicio.
     * @param $data_fim Data de fim.
     * @param $id_fornecedor Id do fornecedor.
     * @param $id_tipo Id do tipo.
     * @param $id_item Id do item.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_entradas_data_fornecedor_tipo_item($data_inicio, $data_fim, $id_fornecedor, $id_tipo, $id_item)
    {
        $sql = ' SELECT '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::CODIGO . ' AS codigo_contrato, '
            . Tabela::ITEM . '.' . Tabela_Item::NOME . ' AS nome_item, '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::QUANTIDADE . ' AS quantidade_entrada, '
            . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID . ' AS unidade_padrao_id, '
            . ' DATE_FORMAT(' . Tabela::ENTRADA . '.' . Tabela_Entrada::DATA . ', "%d/%m/%Y") AS data_entrada, '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::NUMERO_NOTA . ' AS numero_nota '
            . ' FROM '
            . Tabela::ENTRADA . ', '
            . Tabela::FORNECEDOR . ', '
            . Tabela::CONTRATO . ', '
            . Tabela::ITEM_CONTRATO
            . ' INNER JOIN '
            . Tabela::ITEM
            . ' ON '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM
            . ' WHERE '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::ID_FORNECEDOR . ' = ' . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_FORNECEDOR
            . ' AND '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_CONTRATO
            . ' AND '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ' = ' . Tabela::ENTRADA . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO
            . ' AND '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::DATA
            . ' BETWEEN ? AND ? '
            . ' AND '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::ID_FORNECEDOR . ' = ? '
            . ' AND '
            . Tabela::ITEM . '.' . Tabela_Item::ID_TIPO . '= ?'
            . ' AND '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ? '
            . ' ORDER BY '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::DATA
            . ' DESC ';
        $resultado = $this->db->query($sql, array($data_inicio, $data_fim, $id_fornecedor, $id_tipo, $id_item));

        if ($resultado) {
            return $resultado->result_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê as entradas, filtrando-as de acordo com data de inicio, data de fim e id do tipo que foram inseridos.
     *
     * @param $data_inicio Data de inicio.
     * @param $data_fim Data de fim.
     * @param $id_tipo Id do tipo.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_entradas_data_tipo($data_inicio, $data_fim, $id_tipo)
    {
        // SQL Query
        $sql = ' SELECT '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::CODIGO . ' AS codigo_contrato, '
            . Tabela::ITEM . '.' . Tabela_Item::NOME . ' AS nome_item, '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::QUANTIDADE . ' AS quantidade_entrada, '
            . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID . ' AS unidade_padrao_id, '
            . ' DATE_FORMAT(' . Tabela::ENTRADA . '.' . Tabela_Entrada::DATA . ', "%d/%m/%Y") AS data_entrada, '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::NUMERO_NOTA . ' AS numero_nota '
            . ' FROM '
            . Tabela::ENTRADA . ', '
            . Tabela::FORNECEDOR . ', '
            . Tabela::CONTRATO . ', '
            . Tabela::ITEM_CONTRATO
            . ' INNER JOIN '
            . Tabela::ITEM
            . ' ON '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM
            . ' WHERE '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::ID_FORNECEDOR . ' = ' . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_FORNECEDOR
            . ' AND '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_CONTRATO
            . ' AND '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ' = ' . Tabela::ENTRADA . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO
            . ' AND '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::DATA
            . ' BETWEEN ? AND ?'
            . ' AND '
            . Tabela::ITEM . '.' . Tabela_Item::ID_TIPO . ' = ?'
            . ' ORDER BY '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::DATA
            . ' DESC ';

        $resultado = $this->db->query($sql, array($data_inicio, $data_fim, $id_tipo));

        if ($resultado) {
            return $resultado->result_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê as entradas, filtrando-as de acordo com data de inicio, data de fim, id do tipo
     * e id do item que foram inseridos.
     *
     * @param $data_inicio Data de inicio.
     * @param $data_fim Data de fim.
     * @param $id_tipo Id do tipo.
     * @param $id_item Id do item.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_entradas_data_tipo_item($data_inicio, $data_fim, $id_tipo, $id_item)
    {
        // SQL Query
        $sql = ' SELECT '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::CODIGO . ' AS codigo_contrato, '
            . Tabela::ITEM . '.' . Tabela_Item::NOME . ' AS nome_item, '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::QUANTIDADE . ' AS quantidade_entrada, '
            . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID . ' AS unidade_padrao_id, '
            . ' DATE_FORMAT(' . Tabela::ENTRADA . '.' . Tabela_Entrada::DATA . ', "%d/%m/%Y") AS data_entrada, '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::NUMERO_NOTA . ' AS numero_nota '
            . ' FROM '
            . Tabela::ENTRADA . ', '
            . Tabela::FORNECEDOR . ', '
            . Tabela::CONTRATO . ', '
            . Tabela::ITEM_CONTRATO
            . ' INNER JOIN '
            . Tabela::ITEM
            . ' ON '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM
            . ' WHERE '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::ID_FORNECEDOR . ' = ' . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_FORNECEDOR
            . ' AND '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_CONTRATO
            . ' AND '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ' = ' . Tabela::ENTRADA . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO
            . ' AND '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::DATA
            . ' BETWEEN ? AND ?'
            . ' AND '
            . Tabela::ITEM . '.' . Tabela_Item::ID_TIPO . ' = ?'
            . ' AND '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ?'
            . ' ORDER BY '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::DATA
            . ' DESC ';

        $resultado = $this->db->query($sql, array($data_inicio, $data_fim, $id_tipo, $id_item));

        if ($resultado) {
            return $resultado->result_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê todos os fornecedores cadastrados no banco de dados.
     *
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_fornecedores()
    {
        // SQL Query
        $sql = 'SELECT '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::ID_FORNECEDOR . ', '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::NOME
            . ' FROM '
            . Tabela::FORNECEDOR
            . ' ORDER BY '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::NOME
            . ' ASC';

        $resultado = $this->db->query($sql);

        if ($resultado) {
            return $resultado->result_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê todos os itens cadatrados no banco de dados.
     *
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
     * Lê o nome de um fornecedor cadastrado no banco de dados.
     *
     * @param null $id_fornecedor Id do fornecedor.
     * @return bool|string Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_nome_fornecedor($id_fornecedor = NULL)
    {
        if ($id_fornecedor != NULL) {
            // SQL Query
            $sql = ' SELECT '
                . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::NOME
                . ' FROM '
                . Tabela::FORNECEDOR
                . ' WHERE '
                . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::ID_FORNECEDOR . ' = ?';

            $resultado = $this->db->query($sql, array($id_fornecedor));

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
     * @param null $id_item Id do item.
     * @return bool|string Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_nome_item($id_item = NULL)
    {
        if ($id_item != NULL) {
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
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê o nome de um tipo cadastrado no banco de dados.
     *
     * @param $id_tipo Id do tipo.
     * @return bool|string Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_nome_tipo($id_tipo)
    {
        // SQL Query.
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
     * Lê o nome do fornecedor e o código do contrato, de um contrato cadastrado no banco de dados.
     * @param $id_contrato Id do contrato.
     * @return bool|string Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_nome_fornecedor_contrato($id_contrato)
    {
        // SQL Query
        $sql = ' SELECT '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::NOME . ', '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::CODIGO
            . ' FROM '
            . Tabela::CONTRATO . ', '
            . Tabela::FORNECEDOR
            . ' WHERE '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO . ' = ?'
            . ' AND '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::ID_FORNECEDOR . ' = ' . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::ID_FORNECEDOR;

        $resultado = $this->db->query($sql, array($id_contrato));

        if ($resultado->num_rows() > 0) {
            $formatar = $resultado->row_array();
            return $formatar['nome'] . ' - ' . $formatar['codigo'];
        }

        return FALSE;
    }
}

/* Fim do arquivo: model_entrada_itens.php */
/* Localização: ./application/models/painel/relatorio/model_entrada_itens.php */
