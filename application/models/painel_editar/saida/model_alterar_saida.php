<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model que manipulada os dados do menu 'alterar saída'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
include_once APPPATH . '/models/tabelas/tabela_destino.php';
include_once APPPATH . '/models/tabelas/tabela_entrada.php';
include_once APPPATH . '/models/tabelas/tabela_item.php';
include_once APPPATH . '/models/tabelas/tabela_item_contrato.php';
include_once APPPATH . '/models/tabelas/tabela_contrato.php';
include_once APPPATH . '/models/tabelas/tabela_saida.php';
include_once APPPATH . '/models/tabelas/tabela_tipo.php';
include_once APPPATH . '/models/tabelas/tabela.php';

class Model_Alterar_Saida extends CI_Model
{
    /**
     * Atualiza uma saída do banco de dados.
     *
     * @param $id_saida Id da saída.
     * @param $id_destino Id do destino.
     * @param $id_item Id do item.
     * @param $data Data da saída (formato aaaa-mm-dd).
     * @param $quantidade Quantidade de itens que saiu.
     * @return bool Retorna verdadeiro caso a atualização tenha sido realizada com sucesso,
     *              senão retorna falso.
     */
    public function atualiza_saida($id_saida, $id_destino, $id_item, $id_item_contrato, $data, $quantidade)
    {
        $sql = ' UPDATE '
            . Tabela::SAIDA
            . ' SET '
            . Tabela::SAIDA . '.' . Tabela_Saida::ID_DESTINO . ' = ?, '
            . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM . ' = ?, '
            . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM_CONTRATO . ' = ?, '
            . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ' = ?, '
            . Tabela::SAIDA . '.' . Tabela_Saida::QUANTIDADE . ' = ? '
            . ' WHERE '
            . Tabela::SAIDA . '.' . Tabela_Saida::ID_SAIDA . ' = ? ';

        $this->db->query($sql, array($id_destino, $id_item, $id_item_contrato, $data, $quantidade, $id_saida));

        if ($this->db->affected_rows()) {
            return TRUE;
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Atualiza o campo quantidade_total. (Realizado pois o usuário poderá alterar a quantidade de um item que saiu).
     *
     * @param $id_item
     */
    public function atualiza_quantidade_item($id_item)
    {
        $sql_select_1 = ' IFNULL( ('
            . ' SELECT '
            . ' SUM(' . Tabela::ENTRADA . '.' . Tabela_Entrada::QUANTIDADE . ') '
            . ' FROM '
            . Tabela::ENTRADA . ', '
            . Tabela::ITEM_CONTRATO
            . ' WHERE '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::ID_ITEM_CONTRATO . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO
            . ' AND '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM . ' = ? ' .
            ' ), 0) ';

        $sql_select_2 = ' IFNULL( (' .
            ' SELECT '
            . ' SUM( ' . Tabela::SAIDA . '.' . Tabela_Entrada::QUANTIDADE . ') '
            . ' FROM '
            . Tabela::SAIDA
            . ' WHERE '
            . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM . '= ? '
            . ' ), 0) ';


        $sql = 'UPDATE '
            . Tabela::ITEM
            . ' SET '
            . Tabela::ITEM . '.' . Tabela_Item::QUANTIDADE_TOTAL . ' = ' . $sql_select_1 . ' - ' . $sql_select_2
            . ' WHERE '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ?';

        $this->db->query($sql, array($id_item, $id_item, $id_item));
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Exclui uma saida do banco de dados.
     *
     * @param $id_saida Id da saída.
     * @return bool Retorna verdadeiro caso a exclusão tenha sido realizada com sucesso,
     *              senão retorna falso.
     */
    public function excluir_saida($id_saida)
    {
        $sql = ' DELETE FROM '
            . Tabela::SAIDA
            . ' WHERE '
            . Tabela::SAIDA . ' . ' . Tabela_Saida::ID_SAIDA . ' = ?';

        $this->db->query($sql, array($id_saida));

        if ($this->db->affected_rows()) {
            return TRUE;
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Le todos os destinos cadastrados no banco de dados.
     *
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_destinos()
    {
        $sql = ' SELECT '
            . Tabela::DESTINO . ' . ' . Tabela_Destino::ID_DESTINO . ', '
            . Tabela::DESTINO . ' . ' . Tabela_Destino::NOME
            . ' FROM '
            . Tabela::DESTINO;

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
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_itens()
    {
        // SQL Query
        $sql = ' SELECT '
            . Tabela::ITEM . ' . ' . Tabela_Item::ID_ITEM . ', '
            . Tabela::ITEM . ' . ' . Tabela_Item::ID_TIPO . ', '
            . Tabela::ITEM . ' . ' . Tabela_Item::NOME . ', '
            . Tabela::ITEM . ' . ' . Tabela_Item::QUANTIDADE_TOTAL . ', '
            . Tabela::ITEM . ' . ' . Tabela_Item::UNIDADE_PADRAO_ID
            . ' FROM '
            . Tabela::ITEM
            . ' ORDER BY ' . Tabela::ITEM . ' . ' . Tabela_Item::NOME . ' ASC ';
        $resultado = $this->db->query($sql);

        if ($resultado) {
            return $resultado->result_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê o id de um item associado a uma saída.
     *
     * @param $id_saida Id da saída.
     * @return bool Caso tenha a saída, retorna o id do item associado a essa saída, se não retorna falso.
     */
    public function ler_id_item_saida($id_saida)
    {
        $sql = ' SELECT '
            . Tabela::SAIDA . '.' . Tabela_Item::ID_ITEM
            . ' FROM '
            . Tabela::SAIDA
            . ' WHERE '
            . Tabela::SAIDA . '.' . Tabela_Saida::ID_SAIDA . ' = ? ';

        $resultado = $this->db->query($sql, array($id_saida));

        if ($resultado) {
            $formatar = $resultado->row_array();

            return $formatar['id_item'];
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê uma saída do banco de dados.
     *
     * @param $id_saida Id da saída.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_saida($id_saida)
    {
        $sql = ' SELECT '
            . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ' AS nome_destino, '
            . Tabela::ITEM . ' . ' . Tabela_Item::ID_ITEM . ', '
            . Tabela::ITEM . ' . ' . Tabela_Item::NOME . ' AS nome_item, '
            . Tabela::ITEM . ' . ' . Tabela_Item::UNIDADE_PADRAO_ID . ', '
            . ' DATE_FORMAT(' . Tabela::SAIDA . ' . ' . Tabela_Saida::DATA . ', "%d/%m/%Y") AS data_saida, '
            . Tabela::SAIDA . ' . ' . Tabela_Saida::ID_DESTINO . ', '
            . Tabela::SAIDA . ' . ' . Tabela_Saida::ID_ITEM_CONTRATO . ', '
            . Tabela::SAIDA . ' . ' . Tabela_Saida::ID_ITEM . ', '
            . Tabela::SAIDA . ' . ' . Tabela_Saida::ID_SAIDA . ', '
            . Tabela::SAIDA . ' . ' . Tabela_Saida::QUANTIDADE . ', '
            . Tabela::TIPO . ' . ' . Tabela_Tipo::ID_TIPO . ', '
            . Tabela::TIPO . ' . ' . Tabela_Tipo::NOME . ' AS nome_tipo '
            . ' FROM '
            . Tabela::SAIDA
            . ' INNER JOIN '
            . Tabela::ITEM
            . ' ON '
            . Tabela::ITEM . ' . ' . Tabela_Item::ID_ITEM . ' = ' . Tabela::SAIDA . ' . ' . Tabela_Saida::ID_ITEM
            . ' INNER JOIN '
            . Tabela::TIPO
            . ' ON '
            . Tabela::TIPO . ' . ' . Tabela_Tipo::ID_TIPO . ' = ' . Tabela::ITEM . ' . ' . Tabela_Item::ID_TIPO
            . ' INNER JOIN '
            . Tabela::DESTINO
            . ' ON '
            . Tabela::DESTINO . '.' . Tabela_Destino::ID_DESTINO . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_DESTINO
            . ' WHERE '
            . Tabela::SAIDA . ' . ' . Tabela_Saida::ID_SAIDA . ' = ? '
            . ' ORDER BY '
            . Tabela::SAIDA . ' . ' . Tabela_Saida::DATA
            . ' ASC ';

        $resultado = $this->db->query($sql, array($id_saida));

        if ($resultado) {
            return $resultado->row_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê o nome, quantidade e a unidade padrão de um item.
     *
     * @param $id_item ID do item.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_quantidade_item($id_item)
    {
        $sql = ' SELECT '
            . Tabela::ITEM . '.' . Tabela_Item::NOME . ', '
            . Tabela::ITEM . '.' . Tabela_Item::QUANTIDADE_TOTAL . ', '
            . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID
            . ' FROM '
            . Tabela::ITEM
            . ' WHERE '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ?';

        $resultado = $this->db->query($sql, array($id_item));

        if ($resultado) {
            return $resultado->row_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê a quantidade de item de uma saida
     *
     * @param $id_saida ID da saída.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_quantidade_saida($id_saida)
    {
        $sql = ' SELECT '
            . Tabela::SAIDA . '.' . Tabela_Saida::QUANTIDADE
            . ' FROM '
            . Tabela::SAIDA
            . ' WHERE '
            . Tabela::SAIDA . '.' . Tabela_Saida::ID_SAIDA . ' = ?';

        $resultado = $this->db->query($sql, array($id_saida));

        if ($resultado) {
            $formatar = $resultado->row_array();

            return $formatar['quantidade'];
        }

        return FALSE;
    }



    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê todos os tipos cadastrados no banco de dados.
     *
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_tipos()
    {
        $sql = ' SELECT '
            . Tabela::TIPO . ' . ' . Tabela_Tipo::ID_TIPO . ', '
            . Tabela::TIPO . ' . ' . Tabela_Tipo::NOME
            . ' FROM '
            . Tabela::TIPO
            . ' ORDER BY '
            . Tabela::TIPO . ' . ' . Tabela_Tipo::NOME
            . ' ASC ';

        $resultado = $this->db->query($sql);

        if ($resultado) {
            return $resultado->result_array();
        }

        return FALSE;
    }

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

    public function ler_contratos()
    {
        // SQL Query
        $sql = ' SELECT '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM . ', '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ', '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO . ', '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::CODIGO . ', '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_CONTRATO
            . ' FROM '
            . Tabela::ITEM_CONTRATO
            . ' INNER JOIN '
            . Tabela::CONTRATO
            . ' ON '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_CONTRATO

            . ' ORDER BY ' . Tabela::CONTRATO . '.' . Tabela_Contrato::DATA_INICIO . ' DESC ';
        $resultado = $this->db->query($sql);

        if ($resultado) {
            return $resultado->result_array();
        }

        return FALSE;
    }

    public function ler_saidas_data($data_inicio, $data_fim, $soma_quantidade)
    {
        if (!$soma_quantidade && $data_inicio >= '2018-09-21') {
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



        } else if (!$soma_quantidade && $data_inicio < '2018-09-21') {

              $sql = 'SELECT '
              . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ' AS nome_destino, '
              . Tabela::SAIDA . '.' . Tabela_Saida::ID_SAIDA . ' AS id_saida, '
              . 'DATE_FORMAT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ', "%d/%m/%Y") AS data_saida, '
              . Tabela::SAIDA . '.' . Tabela_Saida::QUANTIDADE . ' AS quantidade_saida, '
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
              . ' WHERE '
              . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ' BETWEEN ? AND ?'
              . ' ORDER BY '
              . Tabela::SAIDA . '.' . Tabela_Saida::DATA
              . ' DESC ';

        }else if($soma_quantidade && $data_inicio >= '2018-09-21'){
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
        }else{
              // SQL Query
              $sql = 'SELECT '
              . ' IF(COUNT(DISTINCT(' . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ')) = 1,  ' . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ', "Vários Destinos") AS nome_destino, '
              . Tabela::SAIDA . '.' . Tabela_Saida::ID_SAIDA . ' AS id_saida, '
              . ' IF(COUNT(DISTINCT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ')) = 1, DATE_FORMAT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ', "%d/%m/%Y"), "Várias Datas") AS data_saida, '
              . ' SUM(' . Tabela::SAIDA . '.' . Tabela_Saida::QUANTIDADE . ') AS quantidade_saida, '
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
              . ' WHERE '
              . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ' BETWEEN ? AND ?'
              . ' GROUP BY '
              . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM
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
        if (!$soma_quantidade && $data_inicio >= '2018-09-21') {
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
        } else if (!$soma_quantidade && $data_inicio < '2018-09-21') {
                $sql = 'SELECT '
                . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ' AS nome_destino, '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_SAIDA . ' AS id_saida, '
                . 'DATE_FORMAT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ', "%d/%m/%Y") AS data_saida, '
                . Tabela::SAIDA . '.' . Tabela_Saida::QUANTIDADE . ' AS quantidade_saida, '
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
                . ' WHERE '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ' BETWEEN ? AND ?'
                . ' AND '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_DESTINO . ' = ?'
                . ' ORDER BY '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA
                . ' DESC ';

        }else if ($soma_quantidade && $data_inicio >= '2018-09-21'){
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
        }else{
                // SQL Query
                $sql = 'SELECT '
                . ' IF(COUNT(DISTINCT(' . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ')) = 1,  ' . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ', "Vários Destinos") AS nome_destino, '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_SAIDA . ' AS id_saida, '
                . ' IF(COUNT(DISTINCT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ')) = 1, DATE_FORMAT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ', "%d/%m/%Y"), "Várias Datas") AS data_saida, '
                . ' SUM(' . Tabela::SAIDA . '.' . Tabela_Saida::QUANTIDADE . ') AS quantidade_saida, '
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
                . ' WHERE '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ' BETWEEN ? AND ?'
                . ' AND '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_DESTINO . ' = ?'
                . ' GROUP BY '
                . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM
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
        if (!$soma_quantidade && $data_inicio >= '2018-09-21') {
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
        } else if (!$soma_quantidade && $data_inicio < '2018-09-21') {
            // SQL Query
            $sql = 'SELECT '
                . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ' AS nome_destino, '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_SAIDA . ' AS id_saida, '
                . 'DATE_FORMAT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ', "%d/%m/%Y") AS data_saida, '
                . Tabela::SAIDA . '.' . Tabela_Saida::QUANTIDADE . ' AS quantidade_saida, '
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
                . ' WHERE '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ' BETWEEN ? AND ?'
                . ' AND '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_DESTINO . ' = ?'
                . ' AND '
                . Tabela::ITEM . '.' . Tabela_Item::ID_TIPO . ' = ?'
                . ' ORDER BY '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA
                . ' DESC ';

        } else if ($soma_quantidade && $data_inicio >= '2018-09-21') {

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
        }else{
            // SQL Query
            $sql = 'SELECT '
                . ' IF(COUNT(DISTINCT(' . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ')) = 1,  ' . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ', "Vários Destinos") AS nome_destino, '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_SAIDA . ' AS id_saida, '
                . ' IF(COUNT(DISTINCT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ')) = 1, DATE_FORMAT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ', "%d/%m/%Y"), "Várias Datas") AS data_saida, '
                . ' SUM(' . Tabela::SAIDA . '.' . Tabela_Saida::QUANTIDADE . ') AS quantidade_saida, '
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
                . ' WHERE '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ' BETWEEN ? AND ?'
                . ' AND '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_DESTINO . ' = ?'
                . ' AND '
                . Tabela::ITEM . '.' . Tabela_Item::ID_TIPO . ' = ?'
                . ' GROUP BY '
                . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM
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
        if (!$soma_quantidade && $data_inicio >= '2018-09-21') {
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
        } else if (!$soma_quantidade && $data_inicio < '2018-09-21'){
            // SQL Query
            $sql = 'SELECT '
                . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ' AS nome_destino, '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_SAIDA . ' AS id_saida, '
                . 'DATE_FORMAT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ', "%d/%m/%Y") AS data_saida, '
                . Tabela::SAIDA . '.' . Tabela_Saida::QUANTIDADE . ' AS quantidade_saida, '
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

        } else if ($soma_quantidade && $data_inicio >= '2018-09-21'){
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
        } else {
            // SQL Query
            $sql = 'SELECT '
                . ' IF(COUNT(DISTINCT(' . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ')) = 1,  ' . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ', "Vários Destinos") AS nome_destino, '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_SAIDA . ' AS id_saida, '
                . ' IF(COUNT(DISTINCT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ')) = 1, DATE_FORMAT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ', "%d/%m/%Y"), "Várias Datas") AS data_saida, '
                . ' SUM(' . Tabela::SAIDA . '.' . Tabela_Saida::QUANTIDADE . ') AS quantidade_saida, '
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
                . ' WHERE '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ' BETWEEN ? AND ? '
                . ' AND '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_DESTINO . ' = ? '
                . ' AND '
                . Tabela::ITEM . '.' . Tabela_Item::ID_TIPO . ' = ? '
                . ' AND '
                . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ? '
                . ' GROUP BY '
                . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM
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
        if (!$soma_quantidade && $data_inicio >= '2018-09-21') {
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
        } else if (!$soma_quantidade && $data_inicio < '2018-09-21') {
          // SQL Query
            $sql = 'SELECT '
                . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ' AS nome_destino, '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_SAIDA . ' AS id_saida, '
                . 'DATE_FORMAT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ', "%d/%m/%Y") AS data_saida, '
                . Tabela::SAIDA . '.' . Tabela_Saida::QUANTIDADE . ' AS quantidade_saida, '
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
                . ' WHERE '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ' BETWEEN ? AND ?'
                . ' AND '
                . Tabela::ITEM . '.' . Tabela_Item::ID_TIPO . ' = ?'
                . ' ORDER BY '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA
                . ' DESC ';

        } else if ($soma_quantidade && $data_inicio >= '2018-09-21') {
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
        } else {
          // SQL Query
            $sql = 'SELECT '
                . ' IF(COUNT(DISTINCT(' . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ')) = 1,  ' . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ', "Vários Destinos") AS nome_destino, '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_SAIDA . ' AS id_saida, '
                . ' IF(COUNT(DISTINCT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ')) = 1, DATE_FORMAT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ', "%d/%m/%Y"), "Várias Datas") AS data_saida, '
                . ' SUM(' . Tabela::SAIDA . '.' . Tabela_Saida::QUANTIDADE . ') AS quantidade_saida, '
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
                . ' WHERE '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ' BETWEEN ? AND ?'
                . ' AND '
                . Tabela::ITEM . '.' . Tabela_Item::ID_TIPO . ' = ?'
                . ' GROUP BY '
                . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM
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
        if (!$soma_quantidade && $data_inicio >= '2018-09-21') {
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
        } else if (!$soma_quantidade && $data_inicio < '2018-09-21') {
            // SQL Query
            $sql = 'SELECT '
                . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ' AS nome_destino, '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_SAIDA . ' AS id_saida, '
                . 'DATE_FORMAT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ', "%d/%m/%Y") AS data_saida, '
                . Tabela::SAIDA . '.' . Tabela_Saida::QUANTIDADE . ' AS quantidade_saida, '
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
                . ' WHERE '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ' BETWEEN ? AND ?'
                . ' AND '
                . Tabela::ITEM . '.' . Tabela_Item::ID_TIPO . ' = ?'
                . ' AND '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM . ' = ?'
                . ' ORDER BY '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA
                . ' DESC ';
        } else if ($soma_quantidade && $data_inicio >= '2018-09-21') {
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
        } else {
            // SQL Query
            $sql = 'SELECT '
                . ' IF(COUNT(DISTINCT(' . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ')) = 1,  ' . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ', "Vários Destinos") AS nome_destino, '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_SAIDA . ' AS id_saida, '
                . ' IF(COUNT(DISTINCT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ')) = 1, DATE_FORMAT(' . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ', "%d/%m/%Y"), "Várias Datas") AS data_saida, '
                . ' SUM(' . Tabela::SAIDA . '.' . Tabela_Saida::QUANTIDADE . ') AS quantidade_saida, '
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
                . ' WHERE '
                . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ' BETWEEN ? AND ?'
                . ' AND '
                . Tabela::ITEM . '.' . Tabela_Item::ID_TIPO . ' = ?'
                . ' AND '
                . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM . ' = ?'
                . ' GROUP BY '
                . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM
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

/* Fim do arquivo model_alterar_saida.php */
/* Localização: ./application/models/painel_editar/saida/model_alterar_saida.php */
