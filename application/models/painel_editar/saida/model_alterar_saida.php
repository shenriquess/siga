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
     * Lê todas as saídas cadastradas no banco de dados.
     *
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_saidas()
    {
        $sql = ' SELECT '
            . Tabela::SAIDA . ' . ' . Tabela_Saida::ID_DESTINO . ', '
            . Tabela::SAIDA . ' . ' . Tabela_Saida::ID_ITEM . ', '
            . Tabela::SAIDA . ' . ' . Tabela_Saida::ID_ITEM_CONTRATO . ', '
            . Tabela::SAIDA . '.' . Tabela_Saida::ID_SAIDA . ', '
            . ' DATE_FORMAT(' . Tabela::SAIDA . ' . ' . Tabela_Saida::DATA . ', "%d/%m/%Y") AS data_saida, '
            . Tabela::SAIDA . ' . ' . Tabela_Saida::QUANTIDADE . ', '
            . Tabela::ITEM . ' . ' . Tabela_Item::NOME
            . ' FROM '
            . Tabela::SAIDA
            . ' INNER JOIN '
            . Tabela::ITEM
            . ' ON '
            . Tabela::ITEM . ' . ' . Tabela_Item::ID_ITEM . ' = ' . Tabela::SAIDA . ' . ' . Tabela_Saida::ID_ITEM
            . ' ORDER BY '
            . Tabela::SAIDA . ' . ' . Tabela_Saida::DATA_ATUALIZACAO
            . ' DESC ';

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
}

/* Fim do arquivo model_alterar_saida.php */
/* Localização: ./application/models/painel_editar/saida/model_alterar_saida.php */
