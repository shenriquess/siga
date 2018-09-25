<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model que manipulada os dados do menu 'alterar entrada'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
include_once APPPATH . '/models/tabelas/tabela_contrato.php';
include_once APPPATH . '/models/tabelas/tabela_entrada.php';
include_once APPPATH . '/models/tabelas/tabela_item.php';
include_once APPPATH . '/models/tabelas/tabela_item_contrato.php';
include_once APPPATH . '/models/tabelas/tabela_saida.php';
include_once APPPATH . '/models/tabelas/tabela_tipo.php';
include_once APPPATH . '/models/tabelas/tabela.php';

class Model_Alterar_Entrada extends CI_Model
{
    /**
     * Atualiza uma entrada cadastrada no banco de dados.
     *
     * @param $id_entrada Id da entrada.
     * @param $numero_nota Numero da nota.
     * @param $valor Valor do item do contrato no momento da entrada.
     * @param $quantidade Quantidade da entrada.
     * @param $data Data de entrada.
     * @return bool Retorna verdadeiro caso a atualização tenha sido realizada com sucesso,
     *              senão retorna falso.
     */
    public function atualiza_entrada($id_entrada, $numero_nota, $quantidade, $data)
    {
        $sql = ' UPDATE '
            . Tabela::ENTRADA
            . ' SET '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::NUMERO_NOTA . ' = ?, '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::QUANTIDADE . ' = ?, '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::DATA . ' = ? '
            . ' WHERE '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::ID_ENTRADA . ' = ? ';

        $this->db->query($sql, array($numero_nota, $quantidade, $data, $id_entrada));

        if ($this->db->affected_rows()) {
            return TRUE;
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Atualiza o campo quantidade_total. (Realizado pois o usuário poderá alterar a quantidade de um item que entrou).
     *
     * @param $id_item
     */
    public function atualiza_quantidade_item($id_item)
    {
        $sql_select_1 = '( '
            . ' SELECT IFNULL('
            . ' SUM(' . Tabela::ENTRADA . '.' . Tabela_Entrada::QUANTIDADE . '), 0) '
            . ' FROM '
            . Tabela::ENTRADA . ', '
            . Tabela::ITEM_CONTRATO
            . ' WHERE '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::ID_ITEM_CONTRATO . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO
            . ' AND '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM . ' = ? ' .
            ' )';

        $sql_select_2 = '( ' .
            ' SELECT IFNULL('
            . ' SUM( ' . Tabela::SAIDA . '.' . Tabela_Entrada::QUANTIDADE . '), 0) '
            . ' FROM '
            . Tabela::SAIDA
            . ' WHERE '
            . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM . '= ? '
            . ' )';

        $sql = ' UPDATE '
            . Tabela::ITEM
            . ' SET '
            . Tabela::ITEM . '.' . Tabela_Item::QUANTIDADE_TOTAL . ' = (' . $sql_select_1 . ' - ' . $sql_select_2 . ') '
            . ' WHERE '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ?';

        $this->db->query($sql, array($id_item, $id_item, $id_item));
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Exclui uma entrada do banco de dados.
     *
     * @param $id_entrada Id da entrada.
     * @return bool Retorna verdadeiro caso a exclusão tenha sido realizada com sucesso,
     *              senão retorna falso.
     */
    public function excluir_entrada($id_entrada)
    {
        $sql = ' DELETE FROM '
            . Tabela::ENTRADA
            . ' WHERE '
            . Tabela::ENTRADA . ' . ' . Tabela_Entrada::ID_ENTRADA . ' = ?';

        $this->db->query($sql, array($id_entrada));

        if ($this->db->affected_rows()) {
            return TRUE;
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê uma entrada do banco de dados.
     *
     * @param $id_entrada Id da entrada.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_entrada($id_entrada)
    {
        $sql = ' SELECT '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO . ', '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::CODIGO . ', '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::ID_ENTRADA . ', '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::NUMERO_NOTA . ', '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::VALOR . ', '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::QUANTIDADE . ', '
            . ' DATE_FORMAT(' . Tabela::ENTRADA . '.' . Tabela_Entrada::DATA . ', "%d/%m/%Y") AS data_entrada, '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ', '
            . Tabela::ITEM . '.' . Tabela_Item::NOME . ' AS nome_item, '
            . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID . ', '
            . Tabela::TIPO . '.' . Tabela_Tipo::ID_TIPO . ', '
            . Tabela::TIPO . '.' . Tabela_Tipo::NOME . ' AS nome_tipo '
            . ' FROM '
            . Tabela::ENTRADA
            . ' INNER JOIN '
            . Tabela::ITEM_CONTRATO
            . ' ON '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ' = ' . Tabela::ENTRADA . '.' . Tabela_Entrada::ID_ITEM_CONTRATO
            . ' INNER JOIN '
            . Tabela::ITEM
            . ' ON '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM
            . ' INNER JOIN '
            . Tabela::CONTRATO
            . ' ON '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_CONTRATO
            . ' INNER JOIN '
            . Tabela::TIPO
            . ' ON '
            . Tabela::TIPO . '.' . Tabela_Tipo::ID_TIPO . ' = ' . Tabela::ITEM . '.' . Tabela_Item::ID_TIPO
            . ' WHERE '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::ID_ENTRADA . ' = ?';

        $resultado = $this->db->query($sql, array($id_entrada));

        if ($resultado) {
            return $resultado->row_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê todas as entradas cadastradas no banco de dados.
     *
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_entradas()
    {
        $sql = ' SELECT '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::CODIGO . ', '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::ID_ENTRADA . ', '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::NUMERO_NOTA . ', '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::VALOR . ', '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::QUANTIDADE . ', '
            . ' DATE_FORMAT(' . Tabela::ENTRADA . '.' . Tabela_Entrada::DATA . ', "%d/%m/%Y") AS data_entrada, '
            . Tabela::ITEM . '.' . Tabela_Item::NOME . ', '
            . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID
            . ' FROM '
            . Tabela::ENTRADA
            . ' INNER JOIN '
            . Tabela::ITEM_CONTRATO
            . ' ON '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ' = ' . Tabela::ENTRADA . '.' . Tabela_Entrada::ID_ITEM_CONTRATO
            . ' INNER JOIN '
            . Tabela::ITEM
            . ' ON '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM
            . ' INNER JOIN '
            . Tabela::CONTRATO
            . ' ON '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_CONTRATO
            . ' ORDER BY '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::DATA
            . ' DESC ';

        $resultado = $this->db->query($sql);

        if ($resultado) {
            return $resultado->result_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê o id de um item do contrato.
     *
     * @param $id_entrada ID da entrada.
     * @return bool Retorna o ID do item do contrato, se não retorna falso.
     */
    public function ler_id_item_contrato($id_entrada)
    {
        $sql = ' SELECT '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO
            . ' FROM '
            . Tabela::ITEM_CONTRATO . ', '
            . Tabela::ENTRADA
            . ' WHERE '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ' = ' . Tabela::ENTRADA . '.' . Tabela_Entrada::ID_ITEM_CONTRATO
            . ' AND '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::ID_ENTRADA . ' = ?';

        $resultado = $this->db->query($sql, array($id_entrada));

        if ($resultado) {
            $formatar = $resultado->row_array();

            return $formatar['id_item_contrato'];
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
     * Lê o id do item, referente a uma entrada.
     *
     * @param $id_entrada ID da entrada.
     * @return bool Caso encontre o id retorna ele, se não retorna falso.
     */
    public function ler_item_entrada($id_entrada)
    {
        $sql = ' SELECT '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM
            . ' FROM '
            . Tabela::ENTRADA
            . ' INNER JOIN '
            . Tabela::ITEM_CONTRATO
            . ' ON '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ' = ' . Tabela::ENTRADA . '.' . Tabela_Entrada::ID_ITEM_CONTRATO
            . ' INNER JOIN '
            . Tabela::ITEM
            . ' ON '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM
            . ' WHERE '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::ID_ENTRADA . ' = ?';

        $resultado = $this->db->query($sql, array($id_entrada));

        if ($resultado) {
            $formatar = $resultado->row_array();

            return $formatar['id_item'];
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

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê a quantidade de itens de uma entrada.
     *
     * @param $id_entrada ID da entrada.
     * @return bool Retorna a quantidade de item de uma entrada, se não retorna falso.
     */
    public function ler_quantidade_entrada($id_entrada)
    {
        $sql = ' SELECT '
            . Tabela::ITEM . '.' . Tabela_Item::NOME . ', '
            . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID . ', '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::QUANTIDADE
            . ' FROM '
            . Tabela::ENTRADA
            . ' INNER JOIN '
            . Tabela::ITEM_CONTRATO
            . ' ON '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ' = ' . Tabela::ENTRADA . '.' . Tabela_Entrada::ID_ITEM_CONTRATO
            . ' INNER JOIN '
            . Tabela::ITEM
            . ' ON '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM
            . ' WHERE '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::ID_ENTRADA . ' = ?';

        $resultado = $this->db->query($sql, array($id_entrada));

        if ($resultado) {
            return $resultado->row_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Verifica a quantidade de itens que restam para completar a quantidade de item contratado.
     *
     * @param int
     * @return bool|int Retorna a quantidade de item que falta para completar o contrato, caso ocorra erros retorna falso.
     */
    public function verifica_quantidade_contrato($id_item_contrato)
    {
        if ($id_item_contrato != 0) {
            // SQL Query 1
            $sql1 = ' SELECT '
                . ' SUM(' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::QUANTIDADE . ') AS quantidade1 '
                . ' FROM '
                . Tabela::ITEM_CONTRATO
                . ' WHERE '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ' = ?';

            $sql2 = ' SELECT '
                . ' SUM(' . Tabela::ENTRADA . ' . ' . Tabela_Entrada::QUANTIDADE . ')  AS quantidade2 '
                . ' FROM '
                . Tabela::ENTRADA
                . ' WHERE '
                . Tabela::ENTRADA . ' . ' . Tabela_Entrada::ID_ITEM_CONTRATO . ' = ?';

            $select1 = $this->db->query($sql1, array($id_item_contrato));
            $select2 = $this->db->query($sql2, array($id_item_contrato));

            $resultado1 = $select1->row_array();
            $resultado2 = $select2->row_array();

            $quantidade1 = $resultado1['quantidade1'];
            $quantidade2 = $resultado2['quantidade2'];

            return ($quantidade1 - $quantidade2);
        }

        return FALSE;
    }
}

/* Fim do arquivo model_alterar_entrada.php */
/* Localização: ./application/models/painel_editar/entrada/model_alterar_entrada.php */